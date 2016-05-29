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

namespace Beloop\Web\InstagramBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Beloop\Component\Instagram\Entity\Interfaces\InstagramInterface;
use Beloop\Web\InstagramBundle\Form\Type\InstagramType;

/**
 * Class InstagramController
 *
 * @Route(
 *      path = "/instagram",
 * )
 */
class InstagramController extends Controller
{
    /**
     * List of instagram images
     *
     * @return array
     *
     * @Route(
     *      path = "/list",
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
     * New image modal form
     *
     * @return array
     *
     * @Template("WebInstagramBundle:Instagram:modals/upload_image.html.twig")
     *
     * @Route(
     *      path = "/new",
     *      name = "beloop_instagram_new",
     *      methods = {"GET"}
     * )
     */
    public function newAction() {
        $form = $this->createForm(InstagramType::class);

        return [
            'section' => 'dashboard',
            'form'    => $form->createView()
        ];
    }

    /**
     * Upload image
     *
     * @param Request $request
     *
     * @return array
     *
     * @internal param Form $form Form
     *
     * @Route(
     *      path = "/upload_image",
     *      name = "beloop_instagram_upload_image",
     *      methods = {"POST"}
     * )
     */
    public function uploadImageAction(Request $request) {
        $form = $this->createForm(InstagramType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $image = $form->getData();

            $image->setUser($this->getUser());
            $image->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($image, 'imageFile');

            return new JsonResponse(['status' => 'OK', 'path' => $path], JsonResponse::HTTP_OK);
        }
    }

}