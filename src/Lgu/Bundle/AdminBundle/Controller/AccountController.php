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
     * @Route("/register", name="account_register" )
     * @Template("LguAdminBundle:Admin:register.html.twig")
     */
    public function loginRegisterAction()
    {
        return array('user' => new User());
    }
}
