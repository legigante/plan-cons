<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Tasklist;
use App\Form\Type\TasklistType;
use App\Entity\User;

class ListsController extends Controller
{

    /**
     * @Route("/tasklist/index", name="index_tasklist")
     * @param AuthorizationCheckerInterface $authChecker
     * @param Request $request
     * @return Response
     */
    public function lists (Request $request)
    {

        // todo: ajouter trier par/ filtrer par
        $filter = [];
        $sort = [];

        // data tasks
        $repTasklist = $this->getDoctrine()->getRepository(Tasklist::class);
        $tasklists = $repTasklist->getLists();

        dump($tasklists);

        return $this->render('tasklist/index.html.twig', [
            'tasks' => $tasklists
        ]);
    }


    /**
     * @Route("/tasklist/add", name="add_tasklist", methods={"GET"})
     * @return Response
     */
    public function addAction(){
        $tasklist = new Tasklist();
        $form = $this->createForm(TasklistType::class, $tasklist);

        return $this->render('tasklist/add.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/tasklist/add", name="create_tasklist", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request){

        $tasklist = new Tasklist();
        $form = $this->createForm(TasklistType::class, $tasklist);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // on stock en base
            $em->persist($tasklist);
            $em->flush();

            // on retourne à l'accueil
            return $this->redirectToRoute('index_tasklist');

        }else{
            // on affiche les erreurs
            return $this->render('task/add.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }




}
