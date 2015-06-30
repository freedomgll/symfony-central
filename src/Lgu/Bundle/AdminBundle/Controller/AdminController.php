<?php

namespace Lgu\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/login", name="admin_login")
     * @Template()
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
     * @Route("/login_check", name="admin_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
        print("securityCheckAction");
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
        print("logoutAction");
    }

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('LguAdminBundle:Default:index.html.twig', array('name' => 'jjj'));
    }

    /**
     * @Route("/demo")
     * @Template()
     */
    public function demoAction()
    {
        return array();
    }
}
