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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

use Mmoreram\ControllerExtraBundle\Annotation\CreateForm;

use Beloop\Component\User\Entity\Abstracts\AbstractUser;

/**
 * Class PasswordController
 *
 * @Route(
 *      path = "/password",
 * )
 */
class PasswordController extends Controller
{
    /**
     * Remember password
     *
     * @param Form    $passwordRememberForm Password remember form
     * @param boolean $isValid              Is valid
     *
     * @return Response Response
     *
     * @Template
     *
     * @Route(
     *      path = "/remember",
     *      name = "beloop_password_remember",
     *      methods = {"GET", "POST"}
     * )
     *
     * @CreateForm(
     *      class         = "Beloop\Web\UserBundle\Form\Type\RememberPasswordType",
     *      handleRequest = true,
     *      name          = "passwordRememberForm",
     *      validate      = "isValid"
     * )
     */
    public function rememberAction(Form $passwordRememberForm, $isValid)
    {
        if ($isValid) {
            $email = $passwordRememberForm
                ->get('email')
                ->getData();

            $emailFound = $this
                ->get('beloop.manager.password')
                ->rememberPasswordByEmail(
                    $this->get('beloop.repository.user'),
                    $email,
                    'beloop_password_recover'
                );

            if ($emailFound) {
                return $this->redirectToRoute('beloop_password_recover_sent');
            }
        }

        return [
            'form' => $passwordRememberForm->createView(),
        ];
    }

    /**
     * Recover password
     *
     * @param Form    $passwordRecoverForm Password recover form
     * @param string  $hash                Hash
     * @param boolean $isValid             Is valid
     *
     * @return Response Response
     *
     * @Route(
     *      path = "/recover/{hash}",
     *      name = "beloop_password_recover",
     *      requirements = {
     *          "hash" = "[\dA-Fa-f]+"
     *      },
     *      methods = {"GET", "POST"}
     * )
     *
     * @Template
     *
     * @CreateForm(
     *      class         = "Beloop\Web\UserBundle\Form\Type\RecoverPasswordType",
     *      handleRequest = true,
     *      name          = "passwordRecoverForm",
     *      validate      = "isValid"
     * )
     */
    public function recoverAction(Form $passwordRecoverForm, $isValid, $hash)
    {
        if ($isValid) {
            $customer = $this
                ->get('beloop.repository.user')
                ->findOneBy([
                    'recoveryHash' => $hash,
                ]);

            if ($customer instanceof AbstractUser) {
                $password = $passwordRecoverForm
                    ->get('password')
                    ->getData();

                $this
                    ->get('beloop.manager.password')
                    ->recoverPassword($customer, $hash, $password);

                return $this->redirectToRoute('beloop_login');
            }
        }

        return [
            'form' => $passwordRecoverForm->createView(),
        ];
    }

    /**
     * Recover password sent action
     *
     * @return Response Response
     *
     * @Template
     *
     * @Route(
     *      path = "/sent",
     *      name = "beloop_password_recover_sent",
     *      methods = {"GET"}
     * )
     */
    public function sentAction()
    {
        /**
         * If user is already logged, go to redirect url
         */
        if ($this->isGranted('ROLE_DEMO')) {
            return $this->redirectToRoute('beloop_public_courses');
        }

        return [];
    }
}
