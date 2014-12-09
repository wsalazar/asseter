<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\Login;

class DefaultController extends Controller
{

    public function loginAction(Request $request)
    {
        $userLogin = new Login();
        $userLogin->setTask('Write a blog post');
        $userLogin->setDueDate(new \DateTime('tomorrow'));

        $loginForm = $this->createFormBuilder($userLogin)
                            ->add('user_login',null,['label'=>'User'])
                            ->add('user_pass',null,['label'=>'Password'])
                            ->add('save',null,['label'=>'Login'])
                            ->add('register',null,['label','Register'])
                            ->getForm();
        $loginForm->handleRequest($request);
        return $this->render(
                            'Default/login.html.twig',
                            ['form'=> $loginForm->createView()]
                            );
    }
}
