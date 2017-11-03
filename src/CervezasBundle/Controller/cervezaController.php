<?php

namespace CervezasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CervezasBundle\Entity\cervezas;

class cervezaController extends Controller
{
    public function cervezaAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('CervezasBundle:cervezas');
        // find *all* cervezas
        $cervezas = $repository->findById($id);
        return $this->render('CervezasBundle:CarpetaCerveza:cerveza.html.twig',array('TablaCervezas' => $cervezas ));
    }

    public function crearCervezaAction($nombre,$pais)
    {
        //-- Nuevo objeto de tipoCerveza --\\
        $tipoCerveza = new cervezas();
        $tipoCerveza->setNombre($nombre);
        $tipoCerveza->setPais($pais);
        $tipoCerveza->setPoblacion('Valencia');
        $tipoCerveza->setTipo('Valencia');
        $tipoCerveza->setImportacion(1);
        $tipoCerveza->setTamano(2);
        $tipoCerveza->setFechaAlmacen(\DateTime::createFromFormat("d/m/Y","24/12/2018"));
        $tipoCerveza->setCantidad(2);
        $tipoCerveza->setFoto('Valencia');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $mangDoct = $this->getDoctrine()->getManager();
        $mangDoct->persist($tipoCerveza);

        // actually executes the queries (i.e. the INSERT query)
        $mangDoct->flush();

        $repository = $this->getDoctrine()->getRepository('CervezasBundle:cervezas');
        $id=$tipoCerveza->getId();
        $cervezas = $repository->findById($id);

        return $this->render('CervezasBundle:CarpetaCerveza:crearCerveza.html.twig',array('TablaCervezas'=>$cervezas ));
    }
}
