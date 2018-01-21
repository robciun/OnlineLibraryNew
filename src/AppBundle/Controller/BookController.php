<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:15 PM
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Media;
use AppBundle\Entity\Note;
use AppBundle\Entity\User;
use AppBundle\Form\Type\BookType;
use AppBundle\Form\Type\NewRatingType;
use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class BookController extends Controller
{

    /**
     * @Route("/new", name="book_new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $book = new Book();
        $media = $em->getRepository('AppBundle:Media')->getLast();
        $getResults = $media["file_name"];

        $form = $this->createForm(BookType::class, $book);

        if ($this->container->get('security.token_storage')->getToken()->getUser()->getRole() == "ROLE_ADMIN") {
            $form->add('rating', RatingType::class);
        }

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $book->setUserEmail($this->container->get('security.token_storage')->getToken()->getUser()->getEmail());
            if ($this->container->get('security.token_storage')->getToken()->getUser()->getName() !== null) {
                $book->setAuthor($this->container->get('security.token_storage')->getToken()->getUser()->getName());
            } else {
                $book->setAuthor($this->container->get('security.token_storage')->getToken()->getUser()->getUsername());
            }
            $book->setDateCreated(new \DateTime('now'));
            $book->setBookName($getResults);
            $book->setUserId($this->container->get('security.token_storage')->getToken()->getUser()->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('book_list');
        }

        return $this->render('@App/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newRating", name="rating")
     * @param Request $request
     * @return Response
     */
    public function getRating(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(NewRatingType::class, $book);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('book_list');
        }

        return $this->render('@App/rating.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="book_edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $book = $em->find(Book::class, $id);

        if ($book->getUserId() != $this->getUser()->getId() && $this->getUser()->getRole() != 'ROLE_ADMIN') {
            throw $this->createAccessDeniedException(
                'It is not your book!'
            );
        }

        $media = $em->getRepository('AppBundle:Media')->getLast();
        $getResults = $media["file_name"];

        $form = $this->createForm(BookType::class, $book);

        if ($this->container->get('security.token_storage')->getToken()->getUser()->getRole() == "ROLE_ADMIN") {
            $form->add('rating', RatingType::class);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setBookName($getResults);
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render('@App/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{entityId}", name="book_delete")
     * @param Request $request
     * @param $entityId
     * @return Response
     */
    public function deleteAction(Request $request, $entityId)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->find('AppBundle:Book', $entityId);

        if ($book->getUserId() != $this->getUser()->getId() && $this->getUser()->getRole() != 'ROLE_ADMIN') {
            throw $this->createAccessDeniedException(
                'It is not your book!'
            );
        }

        if ($book) {
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('book_list');
    }
}