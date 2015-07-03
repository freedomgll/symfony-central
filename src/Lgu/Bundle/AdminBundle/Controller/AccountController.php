<?php

namespace Lgu\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Lgu\Bundle\AdminBundle\Entity\User;

/**
 * @Route("/account")
 */
class AccountController extends Controller
{
    /**
     * @Route("/login", name="account_login")
     * @Template("LguAdminBundle:Admin:login.html.twig")
     */
    public function loginAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * @Route("/loginregister", name="account_loginregister" )
     * @Template("LguAdminBundle:Admin:register.html.twig")
     */
    public function loginRegisterAction()
    {
        return array('user' => new User());
    }

    /**
     * @Route("/register", name="account_register")
     */
    public function registerAction(Request $request)
    {
        $username = $request->request->get('_username');
        $email = $request->request->get('_email');
        $password = $request->request->get('_password');
        $passwordConfirm = $request->request->get('_passwordConfirm');

        $error = array();
        //very basic validation
        if($username ==''){
            $error[] = 'Please enter the username.';
        }

        if($password ==''){
            $error[] = 'Please enter the password.';
        }

        if($passwordConfirm ==''){
            $error[] = 'Please confirm the password.';
        }

        if($password != $passwordConfirm){
            $error[] = 'Passwords do not match.';
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->addRoles(array());

        if(count($error) == 0){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->autoLogin($user);
            return $this->redirect($this->generateUrl('lgu_admin_welcome_index'));
        }

        #return array('errors' => $error, 'user' => $user);
        return $this->render('LguAdminBundle:Admin:register.html.twig',array('errors'=>$error,'user'=>$user));
    }

    public function autoLogin(User $user) {
        $token = new UsernamePasswordToken($user, null, 'admin_secured_area', $user->getRoles());
        $this->get('security.context')->setToken($token);
        $this->get('session')->set('_security_admin_secured_area',serialize($token));
    }
}
