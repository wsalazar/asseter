<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/15/14
 * Time: 10:27 AM
 */

namespace User\UserBundle\Service;

Use User\UserBundle\Entity\User;

/**
 * Class EmailRegisterService
 * @package User\UserBundle\Service
 */
class EmailRegisterService
{

    public function prepareFields($parts = array())
    {
//        User $user, $username
        $from = $parts['mailer'];
        $to = $parts['user']->getUsername();
        $subject = $parts['user']->getFirstName() . ', you have registered an account with Asseter.';
        $verificationCode = $parts['user']->getVerificationCode();
        $body = ['first_name'=>$parts['user']->getFirstName(), 'verification_code'=>$verificationCode, 'host'=>$parts['host']];
        return ['from'=>$from,'to'=>$to,'subject'=>$subject,'verification_code'=>$verificationCode,'body'=>$body];
    }

    public function setFields($parts, $body)
    {
        $message = \Swift_Message::newInstance()
                    ->setSubject($parts['subject'])
                    ->setFrom($parts['from'])
                    ->setTo($parts['to'])
                    ->setContentType('text/html')
                    ->setBody($body);

        return $message;
    }
} 