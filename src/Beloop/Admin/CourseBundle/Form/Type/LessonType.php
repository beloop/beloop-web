<?php

/*
 * This file is part of the Beloop package.
 *
 * Copyright (c) 2016 AHDO Studio B.V.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Arkaitz Garro <arkaitz.garro@gmail.com>
 */

namespace Beloop\Admin\CourseBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Beloop\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Type for a lesson edit
 */
class LessonType extends AbstractType
{
    use FactoryTrait;

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => function () {
                $this
                    ->factory
                    ->create();
            },
            'data_class' => $this
                ->factory
                ->getEntityNamespace(),
        ]);
    }

    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course', EntityType::class, [
                'required' => true,
                'class' => 'Beloop\Component\Course\Entity\Course',
                'choice_label' => 'name',
                'attr' => [ 'class' => 'hidden' ],
            ])
            ->add('position', HiddenType::class, [
                'required' => true,
            ])
            ->add('name', TextType::class, [
                'required' => true
            ])
            ->add('slug', TextType::class, [
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'required' => true
            ])
            ->add('offsetInDays', ChoiceType::class, [
                'choices' => [
                  0 => 0,
                  3 => 3,
                  7 => 7,
                  10 => 10,
                  14 => 14,
                  17 => 17,
                  21 => 21,
                  24 => 24,
                  28 => 28,
                  31 => 31,
                  35 => 35,
                  38 => 38,
                  42 => 42,
                  45 => 45,
                  49 => 49,
                ],
                'required' => true
            ])
            ->add('demo', CheckboxType::class, [
                'required' => false,
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        return 'beloop_lesson_form_type_course';
    }
}
