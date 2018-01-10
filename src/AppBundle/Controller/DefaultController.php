<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Media;
use AppBundle\Entity\Note;
use AppBundle\Entity\Search;
use AppBundle\Entity\SearchRepository;
use AppBundle\Form\Type\NoteType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
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

    /**
     * @Route("/shower/{entityId}", name="book_show")
     * @param Request $request
     * @param $entityId
     * @return Response
     */
    public function indexAction(Request $request, $entityId)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->find('AppBundle:Book', $entityId);
        $bookList = $em->getRepository('AppBundle:Book')->findBy(['id' => $book]);

        return $this->render('@App/books_list.html.twig', [
            'book_list' => $bookList,
            'entityId' => $entityId,
        ]);
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

        $form = $this->createFormBuilder()
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/all_books_list.html.twig', [
            'book_list' => $bookList,
            'form' => $form->createView(),
        ]);
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

        $file = $em->find(Book::class, $id);
        $fileData = $file->getBookName();

        return new BinaryFileResponse('C:\xampp\htdocs\symfonyNew\web\uploads' . DIRECTORY_SEPARATOR  . $fileData);
    }

    public function searchBarAction()
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/search_bar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/searchBar", name="search_bar")
     * @param Request $request
     */
    public function handleSearchBar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $filter = $request->get('form')['search'];

        $result = $em->getRepository('AppBundle:Book')->findAllQueryBuilder($filter);

        return $this->render('@App/all_books_list.html.twig', [
            'searchResult' => $result,
            'book_list' => $result
        ]);
    }
}
