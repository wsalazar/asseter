<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\User;
use User\UserBundle\Form\UserType;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class UserController
 * @package User\UserBundle\Controller
 */
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function registerVerificationAction(Request $request)
    {
        $verificationCode = $request->get('verification_code');
        if (isset($verificationCode)) {
            var_dump($this->get('user_manager')->activateUser(['verificationCode'=>$verificationCode]));
            die();
//            return 'yes';
//            return $this->redirect($this->generateUrl('user_dashboard'));
        }
//        $verifyUser = $this->createForm(new UserType());
//        $verifyUser->submit($request->request->all());
//        if ( $verifyUser->isValid() ) {
//            if ($this->get('user_manager')->activateUser($verifyUser->getData()) ) {
//
//                return $this->redirect($this->generateUrl('user_dashboard'));
//            }
//        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function userSubmitAction(Request $request)
    {
        $form = $this->createForm(new UserType());
        $form->handleRequest($request);
        $form->submit($request->request->all());
        if ( $form->isValid() ) {
            $encoder = $this->get('password_encoder');
            if ($this->get('user_manager')->isActive($form->getData())) {
                if ($userCred = $this->get('user_manager')->fetchUser($form->getData()) ) {
                    if ($this->get('user_manager')->verifyPasscode($encoder, $userCred, $form->getData()) ) {
                        return 'yes';
                    } else {
                        $this->get('session')->getFlashBag()->add('notice', 'You just used a different passcode than what we have.');
                    }
                } else {
                    $this->get('session')->getFlashBag()->add('notice', 'Whoa! That E-mail isn\'t right.');
                }
            } else {
                $verificationCode = $this->get('user_manager')->getVerificationCodeByUserName($form->getData());
                return $this->render('UserUserBundle:User:verification.html.twig', ['person'=>$form->getData()['email'],'user'=> $form->createView(),'verification_code'=>$verificationCode]);
            }
        }
        if ( $this->getErrorMessages($form) ) {
            foreach ($this->getErrorMessages($form) as $errors) {
                foreach ($errors as $error) {
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

        return $this->render('UserUserBundle:User:register.html.twig', ['user'=> $registerUser->createView()]);
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
            if ($createdUser = $userManager->createUser($form->getData(), $encoder) ) {
                $this->get('session')->getFlashBag()->add('notice', 'You have an asseter account!');
                $parts = ['user'=>$createdUser,'mailer'=>$this->container->getParameter('mailer_user'), 'host'=>$request->headers->get('host')];
                $emailParts = $this->get('user_register_email')->prepareFields($parts);
                $body = $this->renderView(
                    'UserUserBundle:User:email.html.twig',$emailParts['body']);
                $message = $this->get('user_register_email')->setFields($emailParts, $body);
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('user_register'));
            }
        }
        if ( $this->getErrorMessages($form) ) {
            foreach ($this->getErrorMessages($form) as $errors) {
                foreach ($errors as $error) {
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
