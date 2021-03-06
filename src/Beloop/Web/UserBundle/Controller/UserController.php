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

use Mmoreram\ControllerExtraBundle\Annotation\LoadEntity;
use Mmoreram\ControllerExtraBundle\Annotation\CreateForm;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;

use Beloop\Component\User\Entity\Interfaces\UserInterface;

class UserController extends Controller
{
    /**
     * User profile page
     *
     * @param UserInterface $user
     *
     * @Template("WebUserBundle:User:profile.html.twig")
     *
     * @return array
     *
     * @Route(
     *      path = "/user/{id}/profile",
     *      name = "beloop_user_view_profile",
     *      methods = {"GET"}
     * )
     *
     * @LoadEntity(
     *      namespace = "beloop.entity.user.class",
     *      factory = {
     *          "class" = "beloop.factory.user",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "user",
     *      mapping = {
     *          "id" = "~id~"
     *      },
     *      mappingFallback = true
     * )
     */
    public function viewAction(UserInterface $user)
    {
        $canView = false;
        $viewer = $this->getUser();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $canView = true;
        } else {
            foreach ($viewer->getCourses() as $course) {
                if ($course->getEnrolledUsers()->contains($user)) {
                    $canView = true;
                }
            }
        }

        if (!$canView) {
            throw $this->createNotFoundException('The user does not exist');
        }

        return [
            'action'  => 'view',
            'profile'    => $user,
            'viewer'    => $viewer,
            'section' => ''
        ];
    }

    /**
     * User profile page
     *
     * @param UserInterface $user
     * @param FormView $formView
     * @param string $isValid Is valid
     *
     * @return array
     *
     * @internal param Form $form Form
     *
     * @Template("WebUserBundle:User:profile.html.twig")
     *
     * @Route(
     *      path = "/user/profile",
     *      name = "beloop_user_profile",
     *      methods = {"GET", "POST"}
     * )
     *
     * @LoadEntity(
     *      namespace = "beloop.entity.user.class",
     *      factory = {
     *          "class" = "beloop.wrapper.user",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "user",
     * )
     *
     * @CreateForm(
     *      class         = "Beloop\Web\UserBundle\Form\Type\ProfileType",
     *      name          = "formView",
     *      entity        = "user",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function editAction(
        UserInterface $user,
        FormView $formView,
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
                $this->generateUrl('beloop_user_profile')
            );
        }

        return [
            'action'  => 'edit',
            'section' => 'my-profile',
            'user'    => $user,
            'viewer'  => $user,
            'form'    => $formView,
        ];
    }

    /**
     * Edit user password
     *
     * @param UserInterface $user
     * @param FormView $formView
     * @param string $isValid Is valid
     *
     * @return array
     *
     * @internal param Form $form Form
     *
     * @Template("WebUserBundle:User:partials/password.html.twig")
     *
     * @Route(
     *      path = "/user/profile/edit_password",
     *      name = "beloop_user_password_update",
     *      methods = {"GET", "POST"}
     * )
     *
     * @LoadEntity(
     *      namespace = "beloop.entity.user.class",
     *      factory = {
     *          "class" = "beloop.wrapper.user",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "user",
     * )
     *
     * @CreateForm(
     *      class         = "Beloop\Web\UserBundle\Form\Type\UserPasswordType",
     *      name          = "formView",
     *      entity        = "user",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function editPasswordAction(
        UserInterface $user,
        FormView $formView,
        $isValid
    ) {
        if ($isValid) {
            $this
                ->get('beloop.object_manager.user')
                ->flush($user);

            $message = $this->get('translator')
                ->trans('beloop.user.password.save.message_ok');

            $this->addFlash('success', $message);

            return $this->redirect(
                $this->generateUrl('beloop_user_profile')
            );
        }

        return [
            'action' => 'edit',
            'section' => 'my-profile',
            'user' => $user,
            'form' => $formView,
        ];
    }

    /**
     * User profile page
     *
     * @param UserInterface $user
     * @param FormView $formView
     * @param string $isValid Is valid
     *
     * @return array
     *
     * @internal param Form $form Form
     *
     * @Template("WebUserBundle:User:partials/avatar.html.twig")
     *
     * @Route(
     *      path = "/user/profile/edit_avatar",
     *      name = "beloop_user_avatar_update",
     *      methods = {"POST"}
     * )
     *
     * @LoadEntity(
     *      namespace = "beloop.entity.user.class",
     *      factory = {
     *          "class" = "beloop.wrapper.user",
     *          "method" = "get",
     *          "static" = false
     *      },
     *      name = "user",
     * )
     *
     * @CreateForm(
     *      class         = "Beloop\Web\UserBundle\Form\Type\AvatarType",
     *      name          = "formView",
     *      entity        = "user",
     *      handleRequest = true,
     *      validate      = "isValid"
     * )
     */
    public function editAvatarAction(
        UserInterface $user,
        FormView $formView,
        $isValid
    ) {
        if ($isValid) {
            $this
                ->get('beloop.object_manager.user')
                ->flush($user);

            $helper = $this->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($user, 'avatarFile');

            $cacheManager = $this->get('liip_imagine.cache.manager');
            $srcPath = $cacheManager->getBrowserPath($path, 'profile_thumb');

            return new JsonResponse(['status' => 'OK', 'path' => $srcPath], JsonResponse::HTTP_OK);
        }

        return [
            'action' => 'edit',
            'section' => 'my-profile',
            'user' => $user,
            'form' => $formView,
        ];
    }
}
