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

namespace Beloop\Web\UserBundle\Controller;

use Mmoreram\ControllerExtraBundle\Annotation\Form as AnnotationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

use Beloop\Component\User\Entity\Interfaces\UserInterface;

class UserController extends Controller
{
    /**
     * User profile page
     *
     * @param Form    $form     Form
     * @param string  $isValid  Is valid
     *
     * @return array
     *
     * @Template("WebUserBundle:User:profile.html.twig")
     *
     * @Route(
     *      path = "/user/profile",
     *      name = "beloop_user_profile",
     *      methods = {"GET", "POST"}
     * )
     *
     * @AnnotationForm(
     *      class         = "Beloop\Web\UserBundle\Form\Type\UserType",
     *      name          = "form",
     *      entity        = "user",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function editAction(
        Form $form,
        $isValid
    ) {
        if ($isValid) {
            $this
                ->get('beloop.object_manager.user')
                ->flush($user);

            $message = $this->get('translator')
                ->trans('beloop.user.profile.save.message_ok');

            $this->addFlash('success', $message);

            return $this->redirect(
                $this->generateUrl('store_user_profile')
            );
        }

        return [
            'section' => 'my-profile',
            'form' => $form,
            'user' => $this->getUser(),
        ];
    }
}