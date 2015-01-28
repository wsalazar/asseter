<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/21/14
 * Time: 5:19 PM
 */

namespace Asseter\UserBundle\Service;

use Asseter\UserBundle\Entity\User;

/**
 * Class EmailRegisterService
 * @package Asseter\UserBundle\Service
 */

class EmailRegisterService
{
    /**
     * @param array $parts
     * @return array
     */
    public function prepareFields($parts = array())
    {
        $from = $parts['mailer'];
        $to = $parts['user']->getEmail();
        $subject = $parts['user']->getFirstName() . ', you have registered an account with Asseter.';
        $verificationCode = $parts['user']->getVerificationCode();
        $body = ['first_name'=>$parts['user']->getFirstName(), 'verification_code'=>$verificationCode, 'host'=>$parts['host'], 'my_email'=>$from];
        return ['from'=>$from,'to'=>$to,'subject'=>$subject,'body'=>$body];
    }
    /**
     * @param array $parts
     * @param array $body
     * @return \Swift_Mime_SimpleMimeEntity
     */
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