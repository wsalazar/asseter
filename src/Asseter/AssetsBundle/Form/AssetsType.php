<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/22/14
 * Time: 11:21 PM
 */

namespace Asseter\AssetsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AssetsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attachment', 'file',[
                'required'      =>  true,
//                'placeholder'   =>  'Upload Asset'
            ])
            ->add('file_label', 'text', [
                'constraints' => [
                    new Length([
                        'min'   =>  5,
                        'max'   =>  25,
                    ])
                ],
            ])
//            ->add('firstName', 'text', [
//                'constraints' => [
//                    new Length([
//                        'min'   =>  1,
//                        'max'   =>  50,
//                    ])
//                ],
//            ])
//            ->add('lastName', 'text', [
//                'constraints' => [
//                    new Length([
//                        'min'   =>  1,
//                        'max'   =>  50,
//                    ])
//                ],
//            ])
//            ->add('verificationCode', 'text', [
//                'constraints' => [
//                    new Length([
//                        'min'   =>  1,
//                        'max'   =>  20,
//                    ])
//                ],
//            ])
            ->add('login', 'submit', ['attr'=>['class'=>'fa fa-arrow-right']]);
//            ->add('register', 'submit', ['attr'=>['class'=>'fa fa-arrow-right']]);
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'assets'
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'assets';
    }

} 