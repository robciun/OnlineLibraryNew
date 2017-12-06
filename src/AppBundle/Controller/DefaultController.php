<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Media;
use AppBundle\Entity\Note;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/shower/{entityId}", name="book_show")
     * @param Request $request
     * @param $entityId
     * @return Response
     */
    public function indexAction(Request $request, $entityId)
    {

//        $notes = [
//            'Viena geriausių knygų, kokią tik skaičiau',
//            'Perskaičiau vienu prisėdimu',
//            'Over 9000!'
//        ];

        $em = $this->getDoctrine()->getManager();
        $book = $em->find('AppBundle:Book', $entityId);
        $bookList = $em->getRepository('AppBundle:Book')->findBy(['id' => $book]); //book by id
        //$bookList = $em->getRepository('AppBundle:Book')->findAll(); //all books

        $note = $em->find('AppBundle:Note', $entityId);
        if ($note) {
            $note->getNote();
        }
        //$notesList = $em->getRepository('AppBundle:Note')->findBy(['id' => $note]);
        $notesList = $em->getRepository('AppBundle:Note')->findAll();
        //$notesList = $em->getRepository(Note::class)->getValuesList($note);
       //$noteRep = $em->getRepository('AppBundle:Note')->getValuesList($entity);

        return $this->render('@App/books_list.html.twig', [
            'book_list' => $bookList,
            'entityId' => $entityId,
//            'notes' => $notes,
            'book_notes' => $notesList,
        ]);
//        return $this->render('books_list.html.twig', [
//
//         ]);
        //return new Response('You are lucky');
        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
//        ]);
    }

    /**
     * @Route("/showList", name="book_list")
     * @param Request $request
     * @return Response
     */
    public function bookList()
    {
        $em = $this->getDoctrine()->getManager();
        $bookList = $em->getRepository('AppBundle:Book')->findAll();

        return $this->render('@App/all_books_list.html.twig', [
            'book_list' => $bookList,
        ]);
    }

    /**
     * @Route("/shower/{entityId}/notes", name="book_notes")
     * @Method("GET")
     * @param $entityId
     */
    public function getNotesAction($entityId)
    {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Very interesting book', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'nice book', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];
//        $em = $this->getDoctrine()->getManager();
//        $note = $em->find('AppBundle:Note', $entityId);
//        $note->getNote();
//        $notesList = $em->getRepository('AppBundle:Note')->findBy(['id' => $note]);

        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
//        return $this->render('@App/books_list.html.twig', [
//            'book_notes' => $notesList,
//            'entityId' => $entityId,
//        ]);
    }

    /**
     * @Route("/fileuploadhandler", name="fileuploadhandler")
     */
    public function fileUploadHandler(Request $request) {
        $output = array('uploaded' => false);

        $file = $request->files->get('file');

        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
        if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        if ($file->move($uploadDir, $fileName)) {

            $em = $this->getDoctrine()->getManager();

            $mediaEntity = new Media();
            $mediaEntity->setFileName($fileName);

            $em->persist($mediaEntity);
            $em->flush();
            $output['uploaded'] = true;
            $output['fileName'] = $fileName;
        }
        return new JsonResponse($output);
    }

//    /**
//     * @Route("/deletefileresource", name="deleteFileResource")
//     */
//    public function deleteResource(Request $request){
//        $output = array('deleted' => false, 'error' => false);
//        $mediaID = $request->get('id');
//        $fileName = $request->get('fileName');
//        $em = $this->getDoctrine()->getManager();
//        $media = $em->find('AppBundle:Media', $mediaID);
//        if ($fileName && $media && $media instanceof Media) {
//            $uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
//            $output['deleted'] = unlink($uploadDir.$fileName);
//            if ($output['deleted']) {
//                // delete linked mediaEntity
//                $em = $this->getDoctrine()->getManager();
//                $em->remove($media);
//                $em->flush();
//            }
//        } else {
//            $output['error'] = 'Missing/Incorrect Media ID and/or FileName';
//        }
//        return new JsonResponse($output);
//    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function homeAction(Request $request)
    {
        return $this->render('@App/home.html.twig');
    }
}
