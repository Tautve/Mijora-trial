<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('zipCode', TextType::class, $this->getFieldOptions('ZIP kodas'))
            ->add('name', TextType::class, $this->getFieldOptions('Pavadinimas'))
            ->add('address', TextType::class, $this->getFieldOptions('Adresas'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'method' => 'GET',
        ]);
    }

    private function getFieldOptions(string $label): array
    {
        return [
            'label' => $label,
            'required' => false,
            ];
    }
}
