<?php

namespace AppBundle\Controller\Site;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
* @author Adan Felipe Medeiros<adan.grg@gmail.com>
*/
class IndexController extends Controller
{
	/**
	 * @Route("/",name="index_site")
	 * @Method("GET")
     * @Template()
	 */
	public function indexAction()
	{
        return [];
	}
}