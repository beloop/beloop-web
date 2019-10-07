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

namespace Beloop\Admin\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormView;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Mmoreram\ControllerExtraBundle\Annotation\LoadEntity;
use Mmoreram\ControllerExtraBundle\Annotation\CreateForm;
use Mmoreram\ControllerExtraBundle\Annotation\CreatePaginator;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;

use Beloop\Admin\CommonBundle\Controller\Abstracts\AbstractAdminController;
use Beloop\Component\User\Entity\Interfaces\UserInterface;

/**
 * Class Controller for User
 *
 * @Route(
 *      path = "/user",
 * )
 */
class UserController extends AbstractAdminController
{
    /**
     * Users list
     *
     * @return array
     *
     * @Route(
     *      path = "/list/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_user_list",
     *      methods = {"GET"},
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "createdAt",
     *          "orderByDirection" = "ASC",
     *      }
     * )
     *
     * @Template
     *
     * @CreatePaginator(
     *      attributes = "paginatorAttributes",
     *      entityNamespace = "beloop.entity.user.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      }
     * )
     */
    public function listAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    ) {
        $userDirector = $this->get('beloop.director.user');

        $users = $userDirector->findBy(
            [],
            [$orderByField => $orderByDirection],
            $limit,
            ($page - 1) * $limit
        );

        return [
            'user'             => $this->getUser(),
            'users'            => $users,
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * Create, Edit and save user
     *
     * @param FormView        $formView
     * @param CourseInterface $user
     * @param boolean         $isValid
     *
     * @return array
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_user_new",
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "/edit/{id}",
     *      name = "admin_user_edit",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"GET"}
     * )
     *
     * @Route(
     *      path = "/update/{id}",
     *      name = "admin_user_update",
     *      requirements = {
     *          "id" = "\d+",
     *      },
     *      methods = {"POST"}
     * )
     *
     * @Route(
     *      path = "/new/update",
     *      name = "admin_user_save",
     *      methods = {"POST"}
     * )
     *
     * @Template
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
     *      mappingFallback = true,
     *      persist = true
     * )
     *
     * @CreateForm(
     *      class = "Beloop\Admin\UserBundle\Form\Type\UserType",
     *      name  = "formView",
     *      entity = "user",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function editAction(
        FormView $formView,
        UserInterface $user,
        $isValid
    ) {
        if ($isValid) {
            $this->flush($user);

            $this->addFlash('success', 'admin.user.saved');

            return $this->redirectToRoute('admin_user_edit', ['id' => $user->getId()]);
        }

        return [
            'user' => $this->getUser(),
            'user' => $user,
            'form' => $formView,
        ];
    }
}
