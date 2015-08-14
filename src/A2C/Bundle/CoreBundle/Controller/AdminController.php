<?php

namespace A2C\Bundle\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}