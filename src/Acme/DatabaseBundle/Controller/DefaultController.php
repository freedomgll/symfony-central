<?php

namespace Acme\DatabaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\DatabaseBundle\Entity\Product;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeDatabaseBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * @Route("/list/{action}",defaults={"action"="action1"})
     */
    public function listAction($action)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AcmeDatabaseBundle:Product');

        $products = $repository->findAll();

        return $this->render('AcmeDatabaseBundle:Default:index.html.php',array('action' => $action, 'products' => $products));
    }

    /**
     * @Route("/add/{name}",defaults={"name"="test"})
     */
    public function addAction($name)
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('Created product id '.$product->getId());
    }
}
