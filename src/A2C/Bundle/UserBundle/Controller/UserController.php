<?php

namespace A2C\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use A2C\Bundle\CoreBundle\Controller\AdminController;
use A2C\Bundle\UserBundle\Entity\User;
use A2C\Bundle\UserBundle\Form\Type\UserFormType;
use A2C\Bundle\UserBundle\Form\Handler\UserFormHandler;

/**
 * User controller.
 *
 * @Route("/admin/user")
 */
class UserController extends AdminController
{

    /**
     * Lists all User entities.
     *
     * @Route("/",defaults={"page"=1, "sort"="id", "direction"="asc"}, name="admin_user")
     * @Route("/page/{page}/sort/{sort}/direction/{direction}/", defaults={"page"=1, "sort"="id", "direction"="asc"}, name="admin_user_pagination")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function indexAction($page, $sort, $direction)
    {
        $breadcumbs = $this->container->get('a2c_breadcrumbs');

        $breadcumbs->addItem(array(
            'title' => 'User',
            'route' => '',
        ));

        $breadcumbs->addItem(array(
            'title' => 'List',
            'route' => '',
        ));

        if ($this->get('session')->has('user_search_session')) {
            $objSerialize = $this->get('session')->get('user_search_session');
            $entity = unserialize($objSerialize);
            $query = $this->getDoctrine()->getRepository('A2CUserBundle:User')->getQueryPagination($entity, $sort, $direction);
        } else {
            $entity = new User();
            $query = $this->getDoctrine()->getRepository('A2CUserBundle:User')->getQueryPagination($entity, $sort, $direction);
        }

        $paginator = $this->getPagination($query, $page, User::PER_PAGE);
        $paginator->setUsedRoute('admin_user_pagination');

        $form = $this->createForm(new UserFormType(), $entity, array(
            'search' => true,
        ));

        return array(
            'pagination' => $paginator,
            'form_search' => $form->createView(),
            'form_delete' => $this->createDeleteForm()->createView(),
        );
    }

    /**
     * Search filter User entities.
     *
     * @Route("/search", name="admin_user_search")
     * @Method({"POST","GET"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function searchAction(Request $request)
    {

        if ($request->getMethod() === Request::METHOD_POST) {

            $form = $this->createForm(new UserFormType(),new User(),array(
                'search' => true,
            ));

            $form->handleRequest($request);

            $this->get('session')->set('user_search_session',serialize($form->getData()));
        } else {
            $this->get('session')->remove('user_search_session');
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function showAction($id)
    {
        $breadcumbs = $this->container->get('a2c_breadcrumbs');

        $breadcumbs->addItem(array(
            'title' => 'User',
            'route' => 'admin_user',
        ));

        $breadcumbs->addItem(array(
            'title' => 'Details',
            'route' => '',
        ));

        $entity = $this->getDoctrine()->getRepository('A2CUserBundle:User')->find($id);

        if (!$entity) {

            $this->get('session')->getFlashBag()->add('message', array(
                'type' => 'error',
                'message' => 'The registry not Found',
            ));

            return $this->redirect($this->generateUrl('admin_user'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="admin_user_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {

        $handler = new UserFormHandler(
            $this->createDeleteForm(),
            $request,
            $this->get('doctrine')->getManager(),
            $this->get('session')->getFlashBag()
        );


        $entity = $this->getDoctrine()->getRepository('A2CUserBundle:User')->find($id);

        if ($handler->delete($entity)) {
            return $this->redirect($this->generateUrl('admin_user'));
        } else {
            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $id)));
        }
    }
}