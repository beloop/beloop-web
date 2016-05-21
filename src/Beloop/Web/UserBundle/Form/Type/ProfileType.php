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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProfileType extends AbstractType
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
            ->add('biography', TextareaType::class, [
                'required'   => true,
                'label'      => 'profile.form.fields.biography.label',
                'help_label' => 'profile.form.fields.biography.help',
            ])
            ->add('website', UrlType::class, [
                'required'   => false,
                'label'      => 'profile.form.fields.website.label',
                'help_label' => 'profile.form.fields.website.help',
                'attr'       => [
                    'placeholder' => 'http://www.aialahernando.com/',
                ]
            ])
            ->add('instagram', TextType::class, [
                'required'   => false,
                'label'      => 'profile.form.fields.instagram.label',
                'help_label' => 'profile.form.fields.instagram.help',
                'attr'       => [
                    'placeholder' => 'aialahernando'
                ]
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
        return 'beloop_user_form_type_user';
    }

    /**
     * Return unique name for this form
     *
     * @deprecated Deprecated since Symfony 2.8, to be removed from Symfony 3.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}