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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login')
            ->add('save','submit');
    }

    public function getName()
    {
        return 'user';
    }
} 