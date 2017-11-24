<?php

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 9/23/2017
 * Time: 5:15 PM
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\Type\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends Controller
{
    /**
     * @Route("/new", name="book_new")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $recordIsSaved = false;

        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
        }

        return $this->render('books_list.html.twig', [
            'form' => $form->createView(),
            'recordEntity' => 'book',
            'recordIsSaved' => $recordIsSaved
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
        $recordIsSaved = false;

        $em = $this->getDoctrine()->getManager();

        $book = $em->find(Book::class, $id);

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($book);
            $em->flush();

            return new Response("1");
        }

        return $this->render('books_list.html.twig', array(
            'form' => $form->createView(),
            'actionRoute' => 'book_edit',
            'recordId' => $id,
            'recordEntity' => 'book',
            'recordIsSaved' => $recordIsSaved
        ));
    }

    /**
     * @Route("/delete", name="book_delete")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->find('AppBundle\Entity\Book', $request->get('record_id'));

        if ($book) {
            $em->remove($book);
            $em->flush();
        }

        return new Response('1');
    }
}