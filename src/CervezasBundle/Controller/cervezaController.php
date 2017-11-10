<?php

namespace CervezasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CervezasBundle\Entity\cervezas;
use CervezasBundle\Form\cervezasType;
use Symfony\Component\HttpFoundation\Request;

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

    public function crearCervezaFormularioAction(Request $request)
    {
        $cervezas=new cervezas();
        $form= $this->createForm(cervezasType::class,$cervezas,array('boton_insert'=> "Insertar"));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $cervezas = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $DB = $this->getDoctrine()->getManager();
             $DB->persist($cervezas);
             $DB->flush();

             $repository = $this->getDoctrine()->getRepository('CervezasBundle:cervezas');
             $id=$cervezas->getId();
             $mostrar = $repository->find($id);


            return $this->render('CervezasBundle:CarpetaCerveza:ultimoInsertadoCervezas.html.twig',array('ultimoInsertado' => $mostrar) );
        }

        return $this->render('CervezasBundle:CarpetaCerveza:crearCervezaFormulario.html.twig',array('formulario' => $form->createView() ));
    }

    public function actualizarCervezasFormularioAction(Request $request,$id)
    {
      $cerveza = $this->getDoctrine()->getRepository('CervezasBundle:cervezas')->find($id);

     if(!$cerveza){return $this->redirectToRoute('cervezas_muestraTodo');}
     $form = $this->createForm(\CervezasBundle\Form\cervezasType::class, $cerveza,array('boton_insert'=> "Actualizar"));
     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid())
     {
         $em = $this->getDoctrine()->getManager();
         $em->persist($cerveza);
         $em->flush();
         return $this->redirectToRoute('cervezas_update', ["id" => $id]);
     }
     return $this->render("CervezasBundle:CarpetaCerveza:actualizarCervezaFormulario.html.twig", array('form'=>$form->createView() ));
    }

    public function muestraTodoAction()
    {
        $repository = $this->getDoctrine()->getRepository('CervezasBundle:cervezas');
        // find *all* cervezas
        $cervezas = $repository->findAll();
        return $this->render('CervezasBundle:CarpetaCerveza:muestraTodo.html.twig',array('TablaCervezas' => $cervezas ));

    }
}
