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
        $registerUser = $this->createForm(new UserType);
        $registerUser->handleRequest($request);
        return $this->render('UserUserBundle:User:register.html.twig',['user'=> $registerUser->createView()]);
    }

    /**
     * @param Request $request
     */
    public function registerUserAction(Request $request)
    {
        $form = $this->createForm(new UserType());
        $form->submit($request->request->all());
        if ( $form->isValid() ) {
            $createUser = $this->get('user_factory');
            $encoder = $this->get('sha256salted_encoder');
            $db = $this->get('database_manager');
            if ($this->get('user_manager')->createUser($createUser, $form->getData(), $encoder, $db) ) {
                $this->get('session')->getFlashBag()->add('notice', 'You have an asseter account!');
                return $this->redirect($this->generateUrl('user_register'));
            }
        }
        foreach ( $this->getErrorMessages($form) as $errors ) {
            foreach ( $errors as $error ) {
                $this->get('session')->getFlashBag()->add('notice', $error);
            }
        }
        return $this->redirect($this->generateUrl('user_register'));
    }

    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    private function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}
