<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\User;
use User\UserBundle\Form\UserType;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $loginForm = $this->createForm(new UserType);
        $loginForm->handleRequest($request);
        return $this->render(
                            'UserUserBundle:User:new.html.twig',
                            ['user'=> $loginForm->createView()]
                            );
    }

    public function userSubmitAction(Request $request)
    {
        $form = $this->createForm(new UserType());
        $form->submit($request->request->all());
        if ( $form->isValid() ) {
            $encoder = $this->get('password_encoder');
            if ($userCred = $this->get('user_manager')->fetchUser($form->getData()) ) {
                if ($this->get('user_manager')->verifyPasscode($encoder, $userCred, $form->getData()) ) {
                    echo 'redirect to asseter dashboard';
                } else {
                    $this->get('session')->getFlashBag()->add('notice', 'You just used a different passcode than what we have.');
                }
            } else {
                $this->get('session')->getFlashBag()->add('notice', 'Whoa! That E-mail isn\'t right.');
            }
        }
        if ( $this->getErrorMessages($form) ) {
            foreach ( $this->getErrorMessages($form) as $errors ) {
                foreach ( $errors as $error ) {
                    $this->get('session')->getFlashBag()->add('notice', $error);
                }
            }
        }
        return $this->redirect($this->generateUrl('user_user_homepage'));
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function registerUserAction(Request $request)
    {
        $form = $this->createForm(new UserType());
        $form->submit($request->request->all());
        if ( $form->isValid() ) {
            $encoder = $this->get('password_encoder');
            $userManager = $this->get('user_manager');
            if ($userManager->createUser($form->getData(), $encoder) ) {
                $this->get('session')->getFlashBag()->add('notice', 'You have an asseter account!');
                return $this->redirect($this->generateUrl('user_register'));
            }
        }
        if ( $this->getErrorMessages($form) ) {
            foreach ( $this->getErrorMessages($form) as $errors ) {
                foreach ( $errors as $error ) {
                    $this->get('session')->getFlashBag()->add('notice', $error);
                }
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
