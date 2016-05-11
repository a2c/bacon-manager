<?php

namespace Bacon\Custom\RestBundle\Controller\Rest;

use Bacon\Bundle\CoreBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Uecode\Bundle\ApiKeyBundle\Util\ApiKeyGenerator;

class AuthRestController extends BaseController
{

    /**
     * Rest Login
     *
     * @Post("/login", name="test_update")
     */
    public function loginAction(Request $request)
    {
        $username = $request->get('username',NULL);
        $password = $request->get('password',NULL);

        if (!isset($username) || !isset($password)){

            $return = array(
                'type' => 'error',
                'message' => "You must pass username and password fields"
            );

            return $this->view($return, 400);
        }

        $um = $this->get('fos_user.user_manager');
        $user = $um->findUserByUsernameOrEmail($username);

        if (!$user instanceof \Bacon\Custom\UserBundle\Entity\User) {

            $return = array(
                'type' => 'error',
                'message' => "No matching user account found"
            );

            return $this->view($return, 404);
        }

        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $bool = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? true : false;
        if (!$bool) {

            $return = array(
                'type' => 'error',
                'message' => "Password does not match password on record"
            );

            return $this->view($return, 400);
        }

        $user->setApiKey(ApiKeyGenerator::generate());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();

        $return = array(
            "type" => "success",
            "apiKey" => $user->getApiKey()
        );

        return $this->view($return, 200);
    }



}
