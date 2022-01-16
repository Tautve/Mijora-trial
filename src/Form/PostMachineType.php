<?php

namespace App\Form;

use App\Entity\Omniva;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostMachineType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('zipCode', TextareaType::class,
                $this->getFieldOptions('Pašto kodas'))
            ->add('name', TextareaType::class,
                $this->getFieldOptions('Pavadinimas'))
            ->add('type', TextareaType::class, $this->getFieldOptions('Tipas'))
            ->add('a0Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 1'))
            ->add('a1Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 2'))
            ->add('a2Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 3'))
            ->add('a3Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 4'))
            ->add('a4Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 5'))
            ->add('a5Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 6'))
            ->add('a6Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 7'))
            ->add('a7Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 8'))
            ->add('a8Name', TextareaType::class,
                $this->getFieldOptions('Adreso dalis 9'))
            ->add('xCoordinate', TextareaType::class,
                $this->getFieldOptions('X koordinatė'))
            ->add('yCoordinate', TextareaType::class,
                $this->getFieldOptions('Y koordinatė'))
            ->add('serviceHours', TextareaType::class,
                $this->getFieldOptions('Aptarnavimo valandos'))
            ->add('tempServiceHours', TextareaType::class,
                $this->getFieldOptions('Laikino aptarnavimo valandos 1'))
            ->add('tempServiceHoursUntil', TextareaType::class,
                $this->getFieldOptions('Laikino aptarnavimo valandos (iki) 1'))
            ->add('tempServiceHours2', TextareaType::class,
                $this->getFieldOptions('Aptarnavimo valandos 2'))
            ->add('tempServiceHours2Until', TextareaType::class,
                $this->getFieldOptions('Laikino aptarnavimo valandos (iki) 2'))
            ->add('commentEst', TextareaType::class,
                $this->getFieldOptions('komentaras (EST)'))
            ->add('commentEng', TextareaType::class,
                $this->getFieldOptions('komentaras (EN)'))
            ->add('commentRus', TextareaType::class,
                $this->getFieldOptions('komentaras (RU)'))
            ->add('commentLav', TextareaType::class,
                $this->getFieldOptions('komentaras (LV)'))
            ->add('commentLit', TextareaType::class,
                $this->getFieldOptions('komentaras (LT)'))
            ->add('modified', DateType::class,
            array_merge(
            [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd'
            ], $this->getFieldOptions('Modifikavimo data'))
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Omniva::class,
            'empty_data' => '-'
        ]);
    }

    private function getFieldOptions(string $label): array
    {
        return [
            'label' => $label,
            'disabled' => true,
            'empty_data' => '-'
        ];
    }
}
