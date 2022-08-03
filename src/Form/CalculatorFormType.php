<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Locales;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class CalculatorFormType extends AbstractType
{


    public function __construct(
        private TranslatorInterface $translator
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setMethod(Request::METHOD_GET)
            ->add('nationality', CountryType::class, [
                'label' => $this->translator->trans('nationality'),
                'alpha3' => true,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('entry', DateType::class, [
                'label' => $this->translator->trans('entry-date'),
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('exit', DateType::class, [
                'label' => $this->translator->trans('exit-date'),
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
