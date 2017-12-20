<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:15 PM
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\User;
use AppBundle\Form\Type\BookType;
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

class BookController extends Controller
{

    /**
     * @Route("/show/{entityId}", name="book_show")
     * @param Request $request
     * @param $entityId
     * @return Response
     */
    public function showAction(Request $request, $entityId)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->find('AppBundle:Book', $entityId);
        $bookList = $em->getRepository('AppBundle:Book')->findBy(['id' => $book]);

        return $this->render('@App/books_list.html.twig', [
            'book_list' => $bookList,
            'entityId' => $entityId
        ]);
    }

    /**
     * @Route("/new", name="book_new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

//        $author = [$this->container->get('security.token_storage')->getToken()->getUser()->getName(), $this->container->get('security.token_storage')->getToken()->getUser()->getSurname()];
////        $author = '';
//
//        $form = $this->createFormBuilder()
//            ->add('author', ChoiceType::class, [
//                'choices' => $author,
//                'required' => false,
//                'placeholder' => ''
//            ])
//            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

//            $file = $book->getUploadBook();
//
//            $fileName = md5(uniqid()).'.'.$file->guessExtension();
//
//            $file->move($this->getParameter('books_directory'));
//
//            $book->setUploadBook($fileName);

            $book->setUserEmail($this->container->get('security.token_storage')->getToken()->getUser()->getEmail());
            $book->setAuthor($this->container->get('security.token_storage')->getToken()->getUser()->getName());

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
     * @Route("/edit/{id}", name="book_edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $book = $em->find(Book::class, $id);

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_list');
        }

        return $this->render('@App/new.html.twig', [
            'form' => $form->createView(),
        ]);
//        return $this->render('@App/all_books_list.html.twig', array(
//            'form' => $form->createView(),
//            'actionRoute' => 'book_edit',
//            'recordId' => $id,
//            'recordEntity' => 'book',
//            'recordIsSaved' => $recordIsSaved
//        ));
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

        if ($book->getUserEmail() != $this->getUser()->getEmail() && $this->getUser()->getRole() != 'ROLE_ADMIN') {
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

    /**
     * @Route("/sort", name="books_sort")
     * @param Request $request
     * @return Response
     */
    public function sortBooks()
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('AppBundle:Book')->sortBooksByTitleAsc();

        return $this->render('base.html.twig',[
           'booksAsc' => $book
        ]);
    }
}