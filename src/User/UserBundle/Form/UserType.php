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
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', [
                                    'constraints' => [
                                        new Length([
                                                     'min'   =>  7,
                                        ])
                                        ],
                                    ])
            ->add('passcode', 'password', [
                                     'constraints' => [
                                         new Length([
                                                      'min'   =>  5,
                                                      'max'   =>  25,
                                         ])
                                        ],
                                    ])
            ->add('firstName', 'text', [
                                    'constraints' => [
                                        new Length([
                                            'min'   =>  1,
                                            'max'   =>  50,
                                        ])
                                        ],
                                    ])
            ->add('lastName', 'text', [
                                    'constraints' => [
                                        new Length([
                                            'min'   =>  1,
                                            'max'   =>  50,
                                        ])
                                    ],
                                    ])
            ->add('verificationCode', 'text', [
                                    'constraints' => [
                                        new Length([
                                            'min'   =>  1,
                                            'max'   =>  20,
                                        ])
                                    ],
                                    ])
            ->add('login', 'submit', ['attr'=>['class'=>'fa fa-arrow-right']])
            ->add('register', 'submit', ['attr'=>['class'=>'fa fa-arrow-right']]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'user'
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