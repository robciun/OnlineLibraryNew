<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/30/2017
 * Time: 3:35 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\ChangePassword;
use AppBundle\Entity\User;
use AppBundle\Form\Type\ChangePasswordType;
use AppBundle\Form\Type\RegistrationType;
use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            $user->setDateRegistered(new \DateTime('now'));
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );

//            return $this->redirectToRoute('home', [
//                //'flash' => $flash
//            ]);
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

    /**
     * @Route("/userList", name="user_list")
     * @param Request $request
     * @return Response
     */
    public function userList()
    {
        $em = $this->getDoctrine()->getManager();
        $usersList = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('@App/all_users_list.html.twig', [
            'user_list' => $usersList,
        ]);
    }

    /**
     * @Route("/userEdit/{id}", name="user_edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $em->find(User::class, $id);

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('@App/user_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/userDelete/{entityId}", name="user_delete")
     * @param Request $request
     * @param $entityId
     * @return Response
     */
    public function deleteAction(Request $request, $entityId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->find('AppBundle:User', $entityId);

        if ($user) {
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_list');
    }

    /**
     * @Route("/changePassword", name="change_pw")
     * @param Request $request
     * @return Response
     */
    public function changePasswordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $changePassword = new ChangePassword();
        $form = $this->createForm(ChangePasswordType::class, $changePassword);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $em->persist($changePassword);
            return $this->redirectToRoute('user_login');
        }

        return $this->render('@App/change_pw.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}