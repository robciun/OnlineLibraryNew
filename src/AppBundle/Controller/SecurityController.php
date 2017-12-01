<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 10/21/2017
 * Time: 8:39 PM
 */
namespace AppBundle\Controller;

use AppBundle\Form\Type\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
//    /**
//     * @Route("/login", name="user_login")
//     */
//    public function loginAction(Request $request, AuthenticationUtils $authUtils)
//    {
//        $error = $authUtils->getLastAuthenticationError();
//
//        $lastUsername = $authUtils->getLastUsername();
//
//        return $this->render('@App/login.html.twig', array(
//            'last_username' => $lastUsername,
//            'error'         => $error,
//        ));
//    }

    /**
     * @Route("/login", name="user_login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
            '_username' => $lastUsername
        ]);

        return $this->render(
            '@App/login.html.twig',
            array(
                // last username entered by the user
                'form' => $form->createView(),
                'error' => $error
            )
        );
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction()
    {
        //return $this->redirectToRoute('user_login');
        throw new \Exception('this should not be reached!');
    }
}