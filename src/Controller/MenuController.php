<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class MenuController extends Controller
{





    /**
     * @Route("/", name="home")
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function index (AuthorizationCheckerInterface $authChecker)
    {
        // page principale = Gantt
        if ($authChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('frise');
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/about", name="about")
     * @return Response
     */
    public function about ()
    {
        return $this->render('menu/about.html.twig');
    }

    /**
     * @Route("/todo", name="todo")
     * @return Response
     */
    public function todo (AuthorizationCheckerInterface $authChecker)
    {

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->render('menu/todo.html.twig');
        }else{
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/language/{code}", name="language", requirements={"code"="fr|en|es"})
     * @return Response
     */
    public function language (Request $request, $code)
    {
        // on redirigera vers là où on était
        $lastRoad = $request->headers->get('referer');

        // on set session serveur
        $this->get('session')->set('_locale', $code);

        // on set cookie client et on redirige vers accueil
        $response = new Response('',307);
        $response->headers->setCookie(new Cookie('locale', $code, strtotime('now + 2 weeks')));
        $response->headers->set('location',$lastRoad);
        return $response;

    }
}
