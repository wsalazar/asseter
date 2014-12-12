<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\User;
use User\UserBundle\Form\UserType;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
//        $user = new User();
        $loginForm = $this->createForm(new UserType);
        $loginForm->handleRequest($request);
        return $this->render(
                            'UserUserBundle:User:new.html.twig',
                            ['userLogin'=> $loginForm->createView()]
                            );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
//        $user = new User();
        $registerUser = $this->createForm(new UserType);
        $registerUser->handleRequest($request);
        return $this->render(
                        'UserUserBundle:User:register.html.twig',
                        ['register'=> $registerUser->createView()]
                        );
    }

    /**
     * @param Request $request
     */
    public function registerUserAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $user = $request->request->all();
            $createUser = $this->get('user_factory');
            $encoder = $this->get('sha256salted_encoder');
            $createdUser = $createUser->createUser($user['user'], $encoder);
            $db = $this->get('database_manager');
            $createUser->persist($createdUser, $db);
            die();
        }
    }
}
