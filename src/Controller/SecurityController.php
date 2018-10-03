<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login", methods={"GET"})
     * @param AuthenticationUtils $authenticationUtils
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function loginAction(AuthorizationCheckerInterface $authChecker, AuthenticationUtils $authenticationUtils)
    {

        // si déjà authentifié => home
        if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // formulaire de connexion
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


    /**
     * @route("/profile", name="see_profile", methods={"GET"})
     */
    public function seeProfileAction(){
        return $this->render('security/profile.html.twig', array(
            "error"=>''
        ));
    }

    /**
     * @route("/profile", name="change_password", methods={"POST"})
     */
    public function changePasswordAction(Request $request, UserPasswordEncoderInterface $encoder){

        $currentPassword = $request->request->get('_current_password');
        $newPassword = $request->request->get('_new_password');

        // check si user a bien tapé deux fois le même mot de passe
        if($newPassword != $request->request->get('_confirm_password')){
            $error = 'login.change_pwd_err.bad_confirm';
        }else{

            // check password format
            if(strlen($newPassword) < 8 && strlen($newPassword) > 55){
                $error = 'login.change_pwd_err.bad_format';
            }else{

                // check si user s'est bien authentifié
                $user = $this->get('security.token_storage')->getToken()->getUser();
                if(password_verify($currentPassword,$user->getPassword())){

                    // on change le mot de passe
                    $entityManager = $this->getDoctrine()->getManager();
                    $newHashedPassword = $encoder->encodePassword($user, $newPassword);
                    $user->setPassword($newHashedPassword);

                    // on update database
                    $entityManager->persist($user);
                    $entityManager->flush();

                }else{
                    $error = 'login.change_pwd_err.bad_auth';
                }
            }
        }
        if(isset($error)){
            return $this->render('security/profile.html.twig', array(
                "error"=>$error
            ));
        }else{
            return $this->redirectToRoute('logout');
        }
    }

    /**
     * @Route("/login", name="login_check", methods={"POST"})
     */
    public function loginCheckAction()
    {
        // tout se passe dans l'interface
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // tout se passe dans l'interface
    }

}
