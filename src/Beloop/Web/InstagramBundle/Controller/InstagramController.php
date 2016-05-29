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

namespace Beloop\Web\DashboardBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;

use Beloop\Web\DashboardBundle\Entity\Interfaces\InstagramInterface;

class InstagramController extends Controller
{
    /**
     * List of instagram images
     *
     * @return array
     *
     * @Route(
     *      path = "/instagram/list",
     *      name = "beloop_instagram_list",
     *      methods = {"GET"}
     * )
     *
     * @Template
     */
    public function listAction()
    {
        $user = $this->getUser();

        $images = $this->get('beloop.repository.instagram')->findByUser($user);

        return [
            'section' => 'dashboard',
            'user' => $user,
            'images' => $images,
        ];
    }

    /**
     * Upload image
     *
     * @param InstagramInterface $image
     * @param FormView $formView
     * @param string $isValid Is valid
     *
     * @return array
     *
     * @Template("DashboardBundle:Instagram:partials/instagram_form.html.twig")
     *
     * @Route(
     *      path = "/instagram/upload_image",
     *      name = "beloop_instagram_upload_image",
     *      methods = {"POST"}
     * )
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "beloop.factory.instagram",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "image",
     * )
     *
     * @AnnotationForm(
     *      class         = "Beloop\Web\DashboardBundle\Form\Type\InstagramType",
     *      name          = "formView",
     *      entity        = "image",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function uploadImageAction(
        InstagramInterface $image,
        FormView $formView,
        $isValid
    ) {
        if ($isValid) {
            $this
                ->get('beloop.object_manager.instagram')
                ->flush($image);

            $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($image, 'imageFile');

            return new JsonResponse(['status' => 'OK', 'path' => $path], JsonResponse::HTTP_OK);
        }

        return [
            'action' => 'edit',
            'section' => 'dashboard',
            'form' => $formView,
        ];
    }
}