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
        $em = $this->getDoctrine()->getManager();
        $book = $em->find('AppBundle:Book', $entityId);
        $bookList = $em->getRepository('AppBundle:Book')->findBy(['id' => $book]); //book by id
        //$bookList = $em->getRepository('AppBundle:Book')->findAll(); //all books

//        $note = $em->getRepository('AppBundle:Note')->getValuesList($entityId);

        $note = $em->find('AppBundle:Note', $entityId);
        if ($note) {
            $note->getNote();
        }
        $notesList = $em->getRepository('AppBundle:Note')->findBy(['id' => $note]);

        return $this->render('@App/books_list.html.twig', [
            'book_list' => $bookList,
            'entityId' => $entityId,
            'book_notes' => $notesList,
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
        $book = $em->getRepository('AppBundle:Book')->sortBooksByTitleAsc();

        $search = new Search();

//        $searchForm = $this->get('form.factory')
//            ->createNamed(
//                '',
//                'search',
//                $search,
//                array(
//                    'action' => $this->generateUrl('book_list'),
//                    'method' => 'GET'
//                )
//            );
//
//        $searchForm->handleRequest($request);
//        $search = $searchForm->getData();

//        $searchManager = $this->container->get('fos_elastica.manager');
//        $results = $em->getRepository('AppBundle:Search')->search($search);

//        $adapter = new ArrayAdapter($results);
//        $pager = new Pagerfanta($adapter);
//        $pager->setMaxPerPage($search->getPerPage());
//        $pager->setCurrentPage($page);


        $filter = $request->request->get('filter');

        $qb = $em->getRepository('AppBundle:Book')->findAllQueryBuilder($filter);

//        $paginatedCollection = $this->get('fos_elastica.paginator.subscriber')
//            ->createCollection($qb, $request, 'api_programmers_collection');

        $form = $this->createFormBuilder()
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/all_books_list.html.twig', [
            'book_list' => $bookList,
            'bookAsc' => $book,
//            'results' => $pager->getCurrentPageResults(),
//            'results' => $results,
//            'searchForm' => $searchForm->createView(),
//            'pager' => $pager,
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

//        $em = $this->getDoctrine()->getManager();
//        $bookNote = $em->getRepository('AppBundle:Book')
//            ->findOneBy(['name' => $book]);

//        $notes = [];
//
//        foreach ($bookNote->getNotes() as $note) {
//            $notes[] = [
//                'id' => $note->getId(),
//                'username' => $note->getAuthor,
//                'note' => $note->getNote(),
//                'date' => $note->created()->format('M d, Y')
//            ];
//            dump($note);
//        }

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
//       var_dump($request);
        $filter = $request->get('form')['search'];

        $result = $em->getRepository('AppBundle:Book')->findAllQueryBuilder($filter);

        return $this->render('@App/all_books_list.html.twig', [
            'searchResult' => $result,
            'book_list' => $result
        ]);
//        return new JsonResponse($result);
//        var_dump($request->request);
//        die();
    }
}
