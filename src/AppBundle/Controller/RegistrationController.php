<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:17 PM
 */
namespace AppBundle\Controller;

use web\Forms\UserType;
use web\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('Successful registration!');

            return $this->redirectToRoute('book_new');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}