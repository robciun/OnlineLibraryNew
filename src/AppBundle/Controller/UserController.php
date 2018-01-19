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
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            $user->setDateRegistered(new \DateTime('now'));
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
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
//        $usersList = $em->getRepository('AppBundle:User')->findAll();
        $usersList = $em->getRepository('AppBundle:User')->listExceptAdmin();

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

            return $this->redirectToRoute('home');
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

    public function searchBarAction()
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/search_user_bar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/searchUserBar", name="search_user_bar")
     * @param Request $request
     */
    public function handleSearchBar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $filter = $request->get('form')['search'];

        $result = $em->getRepository('AppBundle:User')->findAllQueryBuilder($filter);

        return $this->render('@App/all_users_list.html.twig', [
            'searchResult' => $result,
            'user_list' => $result
        ]);
    }

}