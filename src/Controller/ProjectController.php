<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Project;
use App\Form\Type\ProjectType;
use App\Entity\Task;
use App\Entity\User;
use App\Entity\Tasklist;

class ProjectController extends Controller
{



    /**
     * @Route("/project/index", name="project_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction (Request $request)
    {

        // todo: ajouter trier par/ filtrer par
        $filter = [];
        $sort = [];

        // data projects
        $repProject = $this->getDoctrine()->getRepository(Project::class);
        $projects = $repProject->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects
        ]);
    }


    /**
     * @Route("/project/new", name="project_new", methods={"GET","POST"})
     * @return Response
     */
    public function newAction(Request $request){

        // on récupère les lots par défaut
        $repTasklist = $this->getDoctrine()->getRepository(Tasklist::class);
        $tasklists = $repTasklist->getDefaultTasks();

        // on créé un projet fictif
        $project = new Project();
        foreach($tasklists as $tasklist){
            $task = new Task();
            $task->setTasklist($tasklist);
            foreach($tasklist->getUsers() as $user){
                $task->getUsers()->add($user);
            }
            $project->getTasks()->add($task);
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->add('save', SubmitType::class, [
            'label' => 'entity.Project.new'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $project->setIsArchived(false);

            dump($project);
            exit();


            // on stock en base
            $em->persist($project);
            $em->flush();

            // on retourne à l'accueil
            return $this->redirectToRoute('index_project');
        }

        return $this->render('project/new.html.twig', array(
            'form' => $form->createView()
        ));
    }











    /**
     * @Route("/home", name="frise")
     * @return Response
     */
    public function home (Request $request)
    {

        // todo: ajouter trier par/ filtrer par
        $filter = [];
        $sort = [];

        // data tasks
        $repTask = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $repTask->getFrise();

        // min et max pour la frise
        $minmax = $repTask->getMinMax();

        // couleur
        $colors = [
            'date_rla' => '#2a82ff',
            'date_strat' => '#80217f',
            'date_dpgf' => '#d4d400',
            'date_expected_end' => '#212121',
            'date_recallage' => '#e9881f',
            'date_end' => '#cd1e24',
            'is_closed' => '#0b940e'
        ];

        // pour client
        $jsonheaders = [
            'min' => $minmax['min'],
            'max' => $minmax['max'],
            'colors' => $colors
        ];

        return $this->render('project/frise.html.twig', [
            'sort' => $sort,
            'filter' => $filter,
            'tasks' => $tasks,
            'jsonheaders' => $jsonheaders
        ]);
    }


}
