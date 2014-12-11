<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\User;
use User\UserBundle\Form\UserType;

class UserController extends Controller
{

    public function loginAction(Request $request)
    {
        $user = new User();
        $loginForm = $this->createForm(new UserType, $user);
        $loginForm->handleRequest($request);
        return $this->render(
                            'UserUserBundle:User:new.html.twig',
                            ['userLogin'=> $loginForm->createView()]
                            );
    }

    public function registerAction(Request $request)
    {
        $user = new User();
        $registerUser = $this->createForm(new UserType, $user);
        $registerUser->handleRequest($request);
        return $this->render(
                        'UserUserBundle:User:register.html.twig',
                        ['register'=> $registerUser->createView()]
                        );
    }
}
