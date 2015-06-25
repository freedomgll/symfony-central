<?php

namespace Acme\DatabaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Acme\DatabaseBundle\Entity\Product;

use Doctrine\ORM\Query\ResultSetMapping;


class DataBaseController extends Controller
{


    /**
     * @Route("/show/{action}",defaults={"action"="action"})
     */
    public function showAction($action)
    {
        $em = $this->getDoctrine()->getManager();

        $stmt = $em->getConnection()->prepare('show tables');
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $this->render('AcmeDatabaseBundle:DataBase:database.html.twig',array('action' => $action, 'tables' => $result));
    }

}