<?php

namespace AppBundle\Security;

use AppBundle\Form\Type\LoginType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/30/2017
 * Time: 12:30 PM
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    private $formFactory;
    private $em;
    private $router;
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router, UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {

        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');

//        if ($isLoginSubmit) {
//
//            $req = $request->request->get('login_form');
//
//            return [
//                '_username' => $req['_username'],
//                '_password' => $req['_password'],
//            ];
//        }

        if (!$isLoginSubmit) {

            return null;
        }

        $form = $this->formFactory->create(LoginType::class);
        $form->handleRequest($request);

        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];

//        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
//            return true;
//        }

//        if ($password == 'user') {
//            return true;
//        }
        return true;
//        $dbPassword = $this->em->getRepository('AppBundle:User')->findOneBy(['plainPassword' => $password]);
//
//        if ($password == $dbPassword) {
//            return true;
//        }
//        return false;
        //return $this->em->getRepository('AppBundle:User')->findOneBy(['password' => $password]);
    }

//    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
//    {
//        // TODO: Implement onAuthenticationFailure() method.
//    }
//
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $response = new RedirectResponse($this->router->generate('home'));

        return $response;
        //return $this->router->generate('home');
        //return null;
    }

//    public function supportsRememberMe()
//    {
//        // TODO: Implement supportsRememberMe() method.
//    }

    protected function getLoginUrl()
    {
        return $this->router->generate('user_login');
    }

}