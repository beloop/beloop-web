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

namespace Beloop\Web\InstagramBundle\Form\Type;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Vich\UploaderBundle\Form\Type\VichImageType;

use Beloop\Component\Core\Factory\Traits\FactoryTrait;

/**
 * Class InstagramType
 */
class InstagramType extends AbstractType
{
    use FactoryTrait;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this
                ->factory
                ->getEntityNamespace(),
        ]);
    }

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
            ->setAction($this->router->generate('beloop_instagram_upload_image'))
            ->add('imageFile', FileType::class, [
                'required' => true
            ])
            ->add('title', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'instagram.placeholder.title.text'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'instagram.placeholder.description.text'
                ]
            ])
            ;

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
        return 'beloop_instagram_form_type_instagram';
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