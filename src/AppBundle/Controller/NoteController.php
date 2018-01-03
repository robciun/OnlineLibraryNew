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
//        $note->setNote('Enter your note');

        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {

//        $form = $this->createFormBuilder($note)
//            ->add('note', TextType::class)
//            ->add('save', SubmitType::class, array('label' => 'Add Note'))
//            ->getForm();

            $note->setUsername($this->container->get('security.token_storage')->getToken()->getUser()->getName());
            $note->setCreated(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();
        }

        return $this->render('@App/note.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}