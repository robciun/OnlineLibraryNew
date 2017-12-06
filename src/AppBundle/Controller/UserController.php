<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/30/2017
 * Time: 3:35 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\Type\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
//            $request->getSession()->getFlashBag()
//                ->add('success', 'Welcome to the Death Star, have a magical day!');
//            $flash = $this->addFlash('success', 'Welcome '.$user->getUsername());

            return $this->redirectToRoute('book_list', [
                //'flash' => $flash
            ]);
//            return $this->get('security.authentication.guard_handler')
//                ->authenticateUserAndHandleSuccess(
//                    $user,
//                    $request,
//                    $this->get('app.security.login_form_authenticator'),
//                    'main');
        }

        return $this->render('@App/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}