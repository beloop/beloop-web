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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Beloop\Component\User\Entity\Interfaces\UserInterface;

class SecurityController extends Controller
{
    /**
     * Login page
     *
     * @param FormView $loginFormView Login form view
     *
     * @return array
     *
     * @Route(
     *      path = "/",
     *      name = "beloop_login",
     *      methods = {"GET", "POST"}
     * )
     * @Template
     *
     * @CreateForm(
     *      class = "Beloop\Web\UserBundle\Form\Type\LoginType",
     *      name  = "loginFormView"
     * )
     */
    public function loginAction(FormView $loginFormView)
    {
        /**
         * If user is already logged, go to redirect url
         */
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('beloop_dashboard');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return [
            'form' => $loginFormView,
            'error' => $error,
            'lastUsername' => $lastUsername,
        ];
    }

    /**
     * Register page
     *
     * @param UserInterface $user
     * @param FormView $registerFormView Register form view
     * @param $isValid
     * @return array
     *
     * @Route(
     *      path = "/register/new-user",
     *      name = "beloop_register",
     *      methods = {"GET", "POST"}
     * )
     *
     * @Template
     *
     * @LoadEntity(
     *     namespace = "beloop.entity.user.class",
     *     factory = {
     *          "class" = "beloop.factory.user",
     *          "method" = "create",
     *          "static" = false
     *      },
     *      name = "user",
     *      persist = false
     * )
     *
     * @CreateForm(
     *      class = "Beloop\Web\UserBundle\Form\Type\RegisterType",
     *      entity = "user",
     *      handleRequest = true,
     *      name = "registerFormView",
     *      validate = "isValid"
     * )
     */
    public function registerAction(
        UserInterface $user,
        FormView $registerFormView,
        $isValid
    )
    {
        $error = false;

        /**
         * If user is already logged, go to redirect url
         */
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('beloop_dashboard');
        }

        if ($isValid) {
            $userExists = $this
                ->get('beloop.repository.user')
                ->findOneBy([
                    'email' => $user->getEmail(),
                ]);

            if ($userExists instanceof UserInterface) {
                $error = 'register.error.user_exists';
            } else {
                $user->addRole('ROLE_DEMO');
                $this->get('beloop.director.user')->save($user);

                // TODO: dispatch an onCustomerRegisteredEvent for notification emails, etc
                $token = new UsernamePasswordToken($user, null, "web_area", $user->getRoles());
                $this->get("security.token_storage")->setToken($token);

                return $this->redirectToRoute('beloop_public_courses');
            }
        }

        return [
            'form' => $registerFormView,
            'error' => $error,
        ];
    }
}
