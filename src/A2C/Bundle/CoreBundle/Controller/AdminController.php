<?php

namespace A2C\Bundle\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

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
     * Cria um formulário para deletar um registro da base de dados.
     *
     * @return Form
     */
    public function createDeleteForm()
    {
        return $this->createFormBuilder()->add('id', 'hidden')->getForm();
    }
}