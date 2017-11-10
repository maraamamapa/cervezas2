<?php

namespace CervezasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class cervezasType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
                ->add('pais')
                ->add('poblacion')
                ->add('tipo')
                ->add('importacion')
                ->add('tamano')
                ->add('fechaAlmacen')
                ->add('cantidad')
                ->add('foto')
                ->add($options['boton_insert'],SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CervezasBundle\Entity\cervezas',
            'boton_insert' => 'Enviar'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cervezasbundle_cervezas';
    }


}
