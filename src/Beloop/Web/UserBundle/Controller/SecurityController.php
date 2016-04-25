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
use Symfony\Component\Form\FormView;

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
     * @AnnotationForm(
     *      class = "beloop_user_form_type_login",
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
     * @param FormView $registerFormView Register form view
     *
     * @return array
     *
     * @Route(
     *      path = "/register",
     *      name = "beloop_register",
     *      methods = {"GET", "POST"}
     * )
     * 
     * @Template
     *
     * @AnnotationForm(
     *      class = "beloop_user_form_type_register",
     *      name  = "registerFormView"
     * )
     */
    public function registerAction(FormView $registerFormView)
    {
        $customer = $this->get('qbh.core.user.factory.customer')->create();
        $registerForm = $this->createForm('store_user_form_type_register', $customer);

        $registerForm->handleRequest($request);

        if ($registerForm->isValid()) {

            /**
             * @var ManagerProvider $managerProvider
             */
            $managerProvider = $this->get('elcodi.manager_provider');
            $customerManager = $managerProvider->getManagerByEntityParameter('qbh.core.user.entity.customer.class');
            $customerManager->persist($customer);
            $customerManager->flush();

            $this
                ->get('qbh.core.user.service.customer_manager')
                ->register($customer, 'customer_secured_area');

            return $this->redirect($this->generateUrl('store_checkout_shipment.' . $request->getLocale()));
        }

        return $this->render('StoreUserBundle:Security:login.html.twig', [
            'login' => $loginForm->createView(),
            'register' => $registerForm->createView(),
            'panel' => 'register'
        ]);
    }
}