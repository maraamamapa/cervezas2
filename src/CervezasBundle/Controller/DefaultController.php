<?php

namespace CervezasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($id)
    {
        return $this->render('CervezasBundle:Default:index.html.twig',array('ID' => $id ));
    }
}
