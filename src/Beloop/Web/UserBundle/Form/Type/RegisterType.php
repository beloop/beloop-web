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

namespace Beloop\Web\UserBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegisterType extends AbstractType
{
    /**
     * Build form function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('firstname', TextType::class, [
                'required' => true,
                'label'    => 'profile.form.fields.firstname.label',
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label'    => 'profile.form.fields.lastname.label',
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label'    => 'profile.form.fields.email.label',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'profile.form.fields.password.label',
                ],
                'second_options' => [
                    'label' => 'profile.form.fields.repeat_password.label',
                ],
                'required' => true,
            ])
            ->add('language', EntityType::class, [
                'required' => true,
                'class'    => 'Beloop\Component\Language\Entity\Language',
                'choice_label' => 'name',
                'label'    => 'profile.form.fields.language.label',
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
        return 'beloop_user_form_type_register';
    }
}
