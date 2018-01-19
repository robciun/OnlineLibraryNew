<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/29/2017
 * Time: 11:34 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Note;
use AppBundle\Form\Type\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends Controller
{
    /**
     * @Route("/newNote", name="note_new")
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $note = new Note();

        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

            $note->setUserEmail($this->container->get('security.token_storage')->getToken()->getUser()->getEmail());
            $note->setUsername($this->container->get('security.token_storage')->getToken()->getUser()->getName());
            $note->setCreated(new \DateTime('now'));


            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('note_list');
        }

        return $this->render('@App/note.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editNote/{id}", name="note_edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $note = $em->find(Note::class, $id);

        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('note_list');
        }

        return $this->render('@App/note.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deleteNote/{entityId}", name="note_delete")
     * @param Request $request
     * @param $entityId
     * @return Response
     */
    public function deleteAction(Request $request, $entityId)
    {
        $em = $this->getDoctrine()->getManager();
        $note = $em->find('AppBundle:Note', $entityId);

        if ($note->getUserEmail() != $this->getUser()->getEmail() && $this->getUser()->getRole() != 'ROLE_ADMIN') {
            throw $this->createAccessDeniedException(
                'It is not your note!'
            );
        }

        if ($note) {
            $em->remove($note);
            $em->flush();
        }

        return $this->redirectToRoute('note_list');
    }

    /**
     * @Route("/noteList", name="note_list")
     * @param Request $request
     * @return Response
     */
    public function noteList(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $noteList = $em->getRepository('AppBundle:Note')->findAll();

        return $this->render('@App/comments.html.twig', [
            'note_list' => $noteList,
        ]);
    }

//    public function searchNotesAction()
//    {
//        $form = $this->createFormBuilder(null)
//            ->add('search', TextType::class)
//            ->getForm();
//
//        return $this->render('@App/search_note_bar.html.twig', [
//            'form' => $form->createView()
//        ]);
//    }
//
//    /**
//     * @Route("/searchNoteBar", name="search_note_bar")
//     * @param Request $request
//     */
//    public function handleNotesSearchBar(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $filter = $request->get('form')['search'];
//
//        $result = $em->getRepository('AppBundle:Note')->getNotesFiltered($filter);
//
//        return $this->render('@App/comments.html.twig', [
//            'searchResult' => $result,
//            'note_list' => $result
//        ]);
//    }

    public function searchBarAction()
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/search_note_bar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/searchNoteBar", name="search_note_bar")
     * @param Request $request
     */
    public function handleSearchBar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $filter = $request->get('form')['search'];

        $result = $em->getRepository('AppBundle:Note')->findAllQueryBuilder($filter);

        return $this->render('@App/comments.html.twig', [
            'searchResult' => $result,
            'note_list' => $result
        ]);
    }
}