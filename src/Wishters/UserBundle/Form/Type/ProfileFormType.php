<?php
namespace Wishters\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options); // Charge les champs d'origine

        $builder
            ->add('region', 'entity', array('required'=> true,
                'attr'  => array('class' => 'form-control input-sm'),
                'class' => 'WishtersFrontBundle:Region',
                'property' => 'nom',
                'empty_value'=>'Determiner votre Region...'))
            ->add('theword','textarea', array('required' => false, 'label' => 'Un dernier mot'))
            ->add('avatar', new AvatarType())
            ->add('facebook')
            ->add('twitter')
            ->add('googleplus')
        ;
    }



    public function getName()
    {
        return 'wishters_user_profile';
    }
}