<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 10/21/2017
 * Time: 8:39 PM
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SecurityController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller
{
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}