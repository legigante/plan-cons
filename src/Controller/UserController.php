<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\User;
use App\Form\Type\UserType;

use App\Service\UserService;

class UserController extends Controller
{


    /**
     * @Route("/user/index", name="user_index")
     * @param Request $request
     * @return Response
     */
    public function indexAction (Request $request)
    {

        // todo: ajouter trier par/ filtrer par
        $filter = [];
        $sort = [];

        // data users
        $repUser = $this->getDoctrine()->getRepository(user::class);
        $users = $repUser->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }


    /**
     * @Route("/user/new", name="user_new", methods={"GET","POST"})
     * @param UserService $userService
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(UserService $userService, Request $request){
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->add('save', SubmitType::class, [
            'label' => 'entity.User.new'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // génération du mot de passe
            $user->setCreatedAt(new \DateTime());
            $user->setRoles(['ROLE_USER']);
            $userService->activate($user);


            // todo: send email


            // on stock en base
            $em->persist($user);
            $em->flush();

            // on retourne à l'accueil
            $this->addFlash('success', 'form.flash.add_success');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id){
        $repUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repUser->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->add('save', SubmitType::class, [
            'label' => 'entity.User.edit'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // on stock en base
            $em->persist($user);
            $em->flush();

            // on retourne à l'accueil
            $this->addFlash('success', 'form.flash.edit_success');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }


}
