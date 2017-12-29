<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Media;
use AppBundle\Entity\Note;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller
{
    use \Sideclick\BootstrapModalBundle\Controller\ControllerTrait;

    public function thisActionWillRedirect(Request $request)
    {
        return $this->redirectWithAjaxSupport($request, '/new/url');
    }

//    public function thisActionWillReload(Request $request)
//    {
//        return $this->reloadWithAjaxSupport($request);
//    }

    public function thisActionWillReload(Request $request)
    {
        return $this->redirectToRouteWithAjaxSupport($request,'terms',['parameters'=>$parameters]);
    }

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
    public function bookList(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $bookList = $em->getRepository('AppBundle:Book')->findAll();
        $book = $em->getRepository('AppBundle:Book')->sortBooksByTitleAsc();

        $filter = $request->query->get('filter');

        $qb = $em->getRepository('AppBundle:Book')->findAllQueryBuilder($filter);

        $form = $this->createFormBuilder()
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/all_books_list.html.twig', [
            'book_list' => $bookList,
            'bookAsc' => $book,
            'form' => $form->createView(),
            'filter' => $qb
        ]);
    }

    /**
     * @Route("/search/{id}", name="handleSearch")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function handleSearch (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $book = $em->find(Book::class, $id);


        $em->persist($book);
        $em->flush();

            //return $this->redirectToRoute('book_list');

//        var_dump($request->request);
//        die();
        return $this->render('base.html.twig', [
            'book' => $book
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
            $mediaEntity->setDateCreated(new \DateTime('now'));

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

    /**
     * @Route("/fileList/{id}", name="files_list")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function findFile($id)
    {
        $em = $this->getDoctrine()->getManager();
        $filesList = $em->getRepository('AppBundle:Media')->getValuesList();
//        VarDumper::dump($filesList);
        $finder = new Finder();
        $fileContent = $finder->files()->in('C:\xampp\htdocs\symfonyNew\web\uploads')/*->name('ef7d9937179949d98b83eb9729a10f4f.pdf')*/;
//        foreach ($filesList as $file) {
//            $getValues = array_values($file);
////            return $getValues;
////            VarDumper::dump(array_values($getValues));
//            foreach ($getValues as $result) {
//                return new BinaryFileResponse('C:\xampp\htdocs\symfonyNew\web\uploads' . DIRECTORY_SEPARATOR . $result);
//            }
//        }
//        VarDumper::dump(array_values($filesList));
//        VarDumper::dump(array_values($filesList));
//        $anotherArray = [];
//        foreach ($filesList as $key => $value) {
//            VarDumper::dump($anotherArray[$key]);
//        }
//        $fileContent = $finder->files()->in('C:\xampp\htdocs\symfonyNew\web\uploads');
//        $getFiles = [$filesList];
//        VarDumper::dump($filesList[0]["file_name"]);

        $file = $em->find(Book::class, $id);
        $fileData = $file->getBookName();
//        $finalResult = $fileData["file_name"];

//        $getResults = $filesList["file_name"];
//        $dynamicFiles = array_values($filesList);

//        foreach ($filesList as $x => $xValue) {
//            VarDumper::dump(array_values($xValue));
//        }
//        VarDumper::dump(array_values($dynamicFiles[1]));
//        $firsReplace = str_replace("[","", json_encode(array_values($dynamicFiles[0])));
////        VarDumper::dump($firsReplace);
//        $secodReplace = str_replace("]","", $firsReplace);
////        VarDumper::dump($secodReplace);
//        $thirdReplace = str_replace('"',"", $secodReplace);
//        VarDumper::dump($thirdReplace);
//        VarDumper::dump(str_replace(['[', '""'], [']', '""'], json_encode(array_values($dynamicFiles[0]))));
        $staticFiles = ['08d9a86a7032960f71fc11b8d7bdf073.pdf', '50e2c05c927f9afe169476b7b2018533.pdf', 'ef7d9937179949d98b83eb9729a10f4f.pdf', '127aaa70dbe8d2dacc9d2f993f40b61d.pdf', '8d3631c458e6561dff980667202f03b7.pdf'];
//        VarDumper::dump($staticFiles[1]);
//        $response = new Response($fileContent);
//////
//        $disposition = $response->headers->makeDisposition(
//            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
//            'ef7d9937179949d98b83eb9729a10f4f.pdf'
//        );
//
//        $response->headers->set('Content-Disposition', $disposition);
//
//        return $response->headers->set('Content-Disposition', $disposition);
//        $file = 'C:\xampp\htdocs\symfonyNew\web\uploads\3cc9e7cdf77bd3b5f94f699a87a86d42.png';
//        $response = new BinaryFileResponse($file);
        //$contents = $finder->getContents();

//        foreach ($finder as $file) {
//            $contents = $file->getContents();
//        }

//        return $this->render('@App/files_list.html.twig', [
//            'files_list' => $filesList,
//        ]);
//        foreach ($filesList as $file) {
////            return new BinaryFileResponse('C:\xampp\htdocs\symfonyNew\web\uploads'  .$file);
//            return new Response($file);
//        }

//        return new BinaryFileResponse('C:\xampp\htdocs\symfonyNew\web\uploads\08d9a86a7032960f71fc11b8d7bdf073.pdf');
//        $filesList = ['ef7d9937179949d98b83eb9729a10f4f.pdf', '45f7949c9774a608e73ab10a67cdccb7.png'];
//        $id = 0;
        return new BinaryFileResponse('C:\xampp\htdocs\symfonyNew\web\uploads' . DIRECTORY_SEPARATOR  . $fileData);
//        return $this->render('@App/home.html.twig');
//        return new Response('1');
    }

    /**
     * @Route("/terms", name="terms")
     * @param Request $request
     * @return Response
     */
    public function getTerms()
    {
        return $this->render('@App/terms.html.twig');
    }

    /**
     * @Route("/summer", name="summernote")
     * @param Request $request
     * @return Response
     */
    public function summerNote()
    {
        return $this->render('@App/summernote.html.twig');
    }
}
