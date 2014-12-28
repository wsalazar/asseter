<?php

namespace Asseter\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Asseter\UserBundle\Form\UserType;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserController extends Controller
{
//    /**
//     * @Route("/hello/{name}")
//     * @Template()
//     */
//    public function indexAction($name)
//    {
//        return array('name' => $name);
//    }

    /**
     * @Route("/register/verification-code/{verification_code}", name="user_register_verification")
     * @param $verification_code
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerVerificationCodeAction($verification_code, Request $request)
    {
        $emailVerify = ['verificationCode'=>$verification_code];
        $loginVerify = $request->request->all();
        $form = $this->createForm(new UserType());
        if (count($loginVerify)) {
            if ($this->get('user_manager')->activateUser($loginVerify)) {
                $user = $this->get('user_manager')->fetchUserByEmail($loginVerify);
                $token = new UsernamePasswordToken($loginVerify['email'], null, "main", [$user[0]['role']]);
                $this->get('security.token_storage')->setToken($token);

                return $this->redirect($this->generateUrl('user_dashboard',$loginVerify));
            } else {
                $this->get('session')->getFlashBag()->add('notice', 'Nope! Verification is not right. Are you using someone else\'s?.');
                $verificationCode = $this->get('user_manager')->getVerificationCodeByEmail($loginVerify);
                return $this->render('AsseterUserBundle:User:verification.html.twig',
                    [
                        'email'             =>$loginVerify['email'],
                        'verification_code' =>$verificationCode,
                        'verification'      => $form->createView()
                    ]);
            }
        } else {
            if($this->get('user_manager')->activateUser($emailVerify)) {
                $user = $this->get('user_manager')->fetchEmailRoleByVerificationCode($emailVerify);
                $token = new UsernamePasswordToken($user[0]['email'], null, "main", [$user[0]['role']]);
                $this->get('security.token_storage')->setToken($token);

                return $this->redirect($this->generateUrl('user_dashboard',$emailVerify));
            } else {
                $flashMessage = "Whoa!! Something went wrong. Please contact our nerds <a href='mailto:will.a.salazar@gmail.com'>Asseter Nerds</a>. Provide your Verification Code.";
                $this->get('session')->getFlashBag()->add('notice', $flashMessage);

                return $this->redirect($this->generateUrl('user_user_homepage'));
            }
        }
    }

    /**
     * @Route("/login/submit", name="user_submit")
     */
    public function userSubmitLoginAction(Request $request)
    {
        $userLogin = $this->createForm(new UserType);
        $userLogin->handleRequest($request);
        $userLogin->submit($request->request->all());
        if ( $userLogin->isValid() ) {
            $encoder = $this->get('password_encoder');
            if ($this->get('user_manager')->isActive($userLogin->getData())) {
                if ($userCred = $this->get('user_manager')->fetchUser($userLogin->getData()) ) {
                    if ($this->get('user_manager')->verifyPasscode($encoder, $userCred, $userLogin->getData()) ) {
                        $token = new UsernamePasswordToken($userCred[0]['email'], null, "main", [$userCred[0]['role']]);
                        $this->get('security.token_storage')->setToken($token);


                        return $this->redirect($this->generateUrl('user_dashboard',$userCred[0]['email']));
                    } else {
                        $this->get('session')->getFlashBag()->add('notice', 'You just used a different passcode than what we have.');
                    }
                } else {
                    $this->get('session')->getFlashBag()->add('notice', 'Whoa! That E-mail isn\'t right.');
                }
            } else {
                $verificationCode = $this->get('user_manager')->getVerificationCodeByEmail($userLogin->getData());

                return $this->render('AsseterUserBundle:User:verification.html.twig',
                    [
                        'email'=>$userLogin->getData()['email'],
                        'verification_code'=>$verificationCode,
                        'verification'=> $userLogin->createView()
                    ]);
            }
        }
        if ( $this->getErrorMessages($userLogin) ) {
            foreach ($this->getErrorMessages($userLogin) as $errors) {
                if (!is_array($errors) || !is_object($errors)) {
                    $this->get('session')->getFlashBag()->add('notice', $errors);
                } else {
                    foreach ($errors as $error) {
                        $this->get('session')->getFlashBag()->add('notice', $error);
                    }
                }
            }
        }
        return $this->redirect($this->generateUrl('user_user_homepage'));
    }

    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $registerUser = $this->createForm(new UserType);
        $registerUser->handleRequest($request);

        return $this->render('AsseterUserBundle:User:register.html.twig', ['user'=> $registerUser->createView()]);
    }

    /**
     * @Route("/register/user", name="user_register_submit")
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
                $parts = ['user'=>$createdUser,'mailer'=>$this->container->getParameter('mailer_user'), 'host'=>$request->headers->get('host')];
                $emailParts = $this->get('user_register_email')->prepareFields($parts);
                $body = $this->renderView('AsseterUserBundle:User:email.html.twig', $emailParts['body']);
                $message = $this->get('user_register_email')->setFields($emailParts, $body);
                $this->get('mailer')->send($message);
                $flashMessage = "Congratulations " . $form->getData()['firstName'] . ", you have an Asseter account!\n Check your email to activate.";
                $this->get('session')->getFlashBag()->add('notice', $flashMessage);

                return $this->redirect($this->generateUrl('user_register'));
            }
        }
        if ( $this->getErrorMessages($form) ) {
            foreach ($this->getErrorMessages($form) as $errors) {
                if (!is_array($errors) || !is_object($errors)) {
                    $this->get('session')->getFlashBag()->add('notice', $errors);
                } else {
                    foreach ($errors as $error) {
                        $this->get('session')->getFlashBag()->add('notice', $error);
                    }
                }
            }
        }
        return $this->redirect($this->generateUrl('user_register'));
    }
    /**
     * @Route("/login", name="user_user_homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $loginForm = $this->createForm(new UserType);
        $loginForm->handleRequest($request);
        return $this->render(
            'AsseterUserBundle:User:index.html.twig',
            ['user'=> $loginForm->createView()]
        );
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
