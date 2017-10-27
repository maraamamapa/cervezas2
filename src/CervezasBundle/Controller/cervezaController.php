<?php

namespace CervezasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class cervezaController extends Controller
{
    public function cervezaAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('CervezasBundle:cervezas');
        // find *all* cervezas
        $cervezas = $repository->findById($id);
        return $this->render('CervezasBundle:CarpetaCerveza:cerveza.html.twig',array('TablaCervezas' => $cervezas ));
    }
}
