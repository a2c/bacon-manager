<?php

namespace A2C\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

abstract class AdminController extends Controller
{
    /**
     * @return \Knp\Component\Pager\Paginator
     */
    protected function getPagination($query,$page,$perPage)
    {
        return $this->get('knp_paginator')->paginate(
            $query,
            $page,
            $perPage
        );
    }

    /**
     * @return \A2C\Bundle\CoreBundle\Twig\Extension\BreadcrumbsExtension
     */
    protected function getBreadcrumbs()
    {
        return $this->get('a2c_breadcrumbs');
    }

    /**
     * Cria um formulário para deletar um registro da base de dados.
     *
     * @return Form
     */
    public function createDeleteForm()
    {
        return $this->createFormBuilder()->add('id', 'hidden')->getForm();
    }
}