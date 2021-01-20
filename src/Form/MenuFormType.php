<?php

namespace App\Form;

use App\Entity\Menu;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class MenuFormType
 * @package App\Form
 */
class MenuFormType extends AbstractType
{
    /**
     * Build menu form.
     *
     * @param FormBuilderInterface $builder Form builder interface.
     * @param array                $options Options.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 100,
                        'maxMessage' => 'The title is too long',
                    ]),
                ],
            ])
            ->add('enabledFrom')
            ->add('enabledUntil')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}