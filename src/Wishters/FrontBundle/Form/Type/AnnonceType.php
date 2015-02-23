<?php

namespace Wishters\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnonceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('user')
            ->add('content','textarea', array('label' => 'Contenu de votre annonce', 'attr'=> array('class' => 'form-control input-sm', 'placeholder' => 'Que recherchez vous ?')))
            ->add('price','text', array('label' => 'Votre budget', 'attr'=> array('class' => 'form-control input-sm', 'placeholder' => 'Votre budget')))
            ->add('hashtag','text', array('attr' => array('class' => 'form-control input-sm','placeholder' => 'Ex: smartphone')))
            ->add('title','text', array('label' => 'Titre de l\'annonce' ,'attr' => array('class' => 'form-control input-sm','placeholder' => 'Titre de l\'annonce')))
            ->add('urgent','checkbox', array('label' => false, 'required' => false))
            ->add('negoce','checkbox', array('label' => false, 'required' => false))
            ->add('picture', new AnnoncePictureType(),array('required' => false))
        ;

        $builder->remove('date')->remove('user');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wishters\FrontBundle\Entity\Annonce'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'front_annonce';
    }
}
