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
                            ->add('email','text')
                            ->add('passcode','password')
                            ->add('save','submit',['label'=>'Login'])
                            ->add('register','submit',['label'=>'Register'])
                            ->getForm();
        $loginForm->handleRequest($request);
        return $this->render(
                            'UserUserBundle:User:new.html.twig',
                            ['userLogin'=> $loginForm->createView()]
                            );
    }
}
