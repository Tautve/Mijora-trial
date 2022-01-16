<?php

namespace App\Controller;

use App\Form\FilterType;
use App\Form\PostMachineType;
use App\Repository\OmnivaRepository;
use App\Service\OmnivaService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Yectep\PhpSpreadsheetBundle\Factory;

#[Route('/omniva')]
class OmnivaController extends AbstractController
{

    public function __construct(
        private OmnivaRepository $omnivaRepository,
        private OmnivaService $omnivaService
    ) {
    }

    #[Route('/post-machines/show', name: 'post_machines_show')]
    public function showAllPostMachines(
        Request $request
    ): Response {
        [
            $postMachines,
            $filter
        ] = $this->omnivaService->getPostMachines();

        $filterForm = $this->createForm(FilterType::class);
        $filterForm->handleRequest($request);

        return $this->render('show_all_post_machines.html.twig', [
            'omnivaPostMachines' => $postMachines,
            'filterForm' => $filterForm->createView(),
            'filter' => $filter
        ]);
    }

    #[Route('/post-machines/{id}/show', name: 'post_machine_show')]
    public function showPostMachine(
        Request $request,
        string $id
    ): Response {
        $postMachine = $this->omnivaRepository->findOneBy(['id' => $id]);

        $postMachineForm = $this->createForm(PostMachineType::class,
            $postMachine);
        $postMachineForm->handleRequest($request);

        return $this->render('show_post_machine.html.twig', [
            'postMachineForm' => $postMachineForm->createView(),
            'postMachine' => $postMachine
        ]);
    }

    #[Route('/post-machines/export', name: 'post_machines_export')]
    public function exportSelectedPostMachines(Factory $factory, LoggerInterface $logger): Response
    {
        [$postMachines] = $this->omnivaService->getPostMachines();

        try {
            $spreadsheet = $this->omnivaService->prepareSpreadsheet($postMachines);

            $response = $factory->createStreamedResponse($spreadsheet, 'Xls');
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->headers->set('Content-Disposition',
                'attachment;filename="Pastomatu_sarasas.xls"');
            $response->headers->set('Cache-Control', 'max-age=0');

            return $response;
        } catch (Exception $e) {
            $logger->error($e->getMessage());
            $this->addFlash('error', 'Nepavyko sugeneruoti excel failo');

            return $this->redirectToRoute('post_machines_show');
        }
    }
}
