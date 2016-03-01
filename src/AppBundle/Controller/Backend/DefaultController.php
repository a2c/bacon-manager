<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller\Backend
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @Route("/",name="admin_default_route")
     * @Method("GET")
     * @Template()
     * @return Template
     */
    public function indexAction(Request $request)
    {
        return [];
    }
}
