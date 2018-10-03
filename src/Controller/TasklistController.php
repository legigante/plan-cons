<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Tasklist;
use App\Form\Type\TasklistType;
use App\Entity\User;

class TasklistController extends Controller
{

    /**
     * @Route("/tasklist/index", name="tasklist_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction (Request $request)
    {

        // todo: ajouter trier par/ filtrer par
        $filter = [];
        $sort = [];

        // data tasks
        $repTasklist = $this->getDoctrine()->getRepository(Tasklist::class);
        $tasklists = $repTasklist->getLists();

        return $this->render('tasklist/index.html.twig', [
            'tasks' => $tasklists
        ]);
    }


    /**
     * @Route("/tasklist/new", name="tasklist_new", methods={"GET","POST"})
     * @return Response
     */
    public function addAction(Request $request){
        $tasklist = new Tasklist();

        $form = $this->createForm(TasklistType::class, $tasklist);
        $form->add('save', SubmitType::class, [
            'label' => 'entity.Task.new'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // on stock en base
            $em->persist($tasklist);
            $em->flush();

            // on retourne à l'accueil
            $this->addFlash('success', 'form.flash.add_success');
            return $this->redirectToRoute('index_tasklist');

        }

        return $this->render('tasklist/new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/tasklist/{id}/edit", name="tasklist_edit", methods={"GET","POST"})
     * @return Response
     */
    public function editAction(Request $request, $id){
        $repTasklist = $this->getDoctrine()->getRepository(Tasklist::class);
        $tasklist = $repTasklist->find($id);

        $form = $this->createForm(TasklistType::class, $tasklist);
        $form->add('save', SubmitType::class, [
            'label' => 'entity.Task.upd'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // on stock en base
            $em->persist($tasklist);
            $em->flush();

            // on retourne à l'accueil
            $this->addFlash('success', 'form.flash.edit_success');
            return $this->redirectToRoute('index_tasklist');

        }

        return $this->render('tasklist/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }






}
