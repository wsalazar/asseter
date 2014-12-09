<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/8/14
 * Time: 10:32 PM
 */

namespace User\UserBundle\Entity;


class Login {
    protected $email;
    protected $passcode;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPasscode()
    {
        return $this->passcode;
    }

    public function setPasscode($passcode)
    {
        $this->passcode = $passcode;
    }
} 