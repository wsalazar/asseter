<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\Login;

class UserController extends Controller
{

    public function loginAction(Request $request)
    {
        $userLogin = new Login();
        $userLogin->setEmail('');
        $userLogin->setPasscode('');

        $loginForm = $this->createFormBuilder($userLogin)
                            ->add('email','email')
                            ->add('passcode','password')
                            ->add('save','input',['label'=>'Login','attr'=>['class'=>'fa fa-arrow-right']])
                            ->add('register','input',['label'=>'Register'])
                            ->getForm();
//        background: none repeat scroll 0 0 #448df6;
//    border: 3px solid #448df6;
//    color: #14c65e;
//    float: left;
//    margin-right: 10px;
        $loginForm->handleRequest($request);
        return $this->render(
                            'UserUserBundle:User:new.html.twig',
                            ['userLogin'=> $loginForm->createView()]
                            );
    }
}
