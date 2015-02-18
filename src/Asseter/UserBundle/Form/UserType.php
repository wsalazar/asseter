<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/21/14
 * Time: 5:00 PM
 */

namespace Asseter\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Class UserType
 * @package User\UserBundle\Form
 */

class UserType extends AbstractType
{
    /**
     * @var bool
     */
    private $isRegister;

    /**
     * @param bool $isRegister
     */
    public function __construct($isRegister = false)
    {
        $this->isRegister = $isRegister;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->isRegister) {
            $builder
                ->add('firstName', 'text', [
                    'label'=>'First Name: ',
                    'attr'=>array('class'=>'form-control', 'id'=>'firstName'),
                    'constraints' => [
                        new Length([
                            'min'   =>  1,
                            'max'   =>  50,
                        ])
                    ],
                ])
                ->add('lastName', 'text', [
                    'label'=>'Last Name: ',
                    'attr'=>array('class'=>'form-control', 'id'=>'lastName'),
                    'constraints' => [
                        new Length([
                            'min'   =>  1,
                            'max'   =>  50,
                        ])
                    ],
                ])
                ->add('register', 'submit', array('attr'=>array('class'=>'btn btn-default')));

        }

        $builder
            ->add('email', 'email', array(
                'label' =>  'Email: ',
                'attr'  => array('class'=>'form-control', 'id'=>'email'),
                'constraints' => [
                    new Length([
                        'min'   =>  7,
                    ])
                ],
            ))
            ->add('passcode', 'password', array(
                'mapped'=>false,
//                'type'=>'password',
                'label'=>'Passcode',
                'attr'=>array('class'=>'form-control', 'id'=>'passcode'),
//                'first_options'  => array('label' => 'Password: '),
//                'second_options' => array('label' => 'Repeat Password: '),
                'constraints' => [
                    new Length([
                        'min'   =>  5,
                        'max'   =>  25,
                    ])
                ],
            ));

//            ->add('verificationCode', 'text', [
//                'constraints' => [
//                    new Length([
//                        'min'   =>  1,
//                        'max'   =>  20,
//                    ])
//                ],
//            ])
//            ->add('login', 'submit', array('attr'=>array('class'=>'btn btn-default')));
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'user',
            'data_class'=>'Asseter\UserBundle\Entity\User',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }

} 