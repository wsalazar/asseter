<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/8/14
 * Time: 11:06 PM
 */

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','email' , ['label' => 'E-Mail: '])
            ->add('passcode','password',['label'=>'Passcode: '])
            ->add('firstName','text' ,['label'=>'First Name: '])
            ->add('lastName','text' ,['label'=>'Last Name: '])
            ->add('login','submit',['label'=>'Login','attr'=>['class'=>'fa fa-arrow-right']])
            ->add('register_user','submit',['label'=>'Register','attr'=>['class'=>'fa fa-arrow-right']]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
} 