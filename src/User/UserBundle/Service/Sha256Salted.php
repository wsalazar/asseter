<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/11/14
 * Time: 11:08 PM
 */

namespace User\UserBundle\Service;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class Sha256Salted implements PasswordEncoderInterface
{
    /**
     * @param $raw
     * @param $salt
     * @return bool|string
     */
    public function encodePassword($raw, $salt)
    {
        return hash('sha256', $salt . $raw); // Custom function for password encrypt
    }

    /**
     * @param $encoded
     * @param $raw
     * @param $salt
     * @return bool
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded === $this->encodePassword($raw, $salt);
    }
} 