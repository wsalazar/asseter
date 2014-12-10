<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/8/14
 * Time: 10:32 PM
 */

namespace User\UserBundle\Entity;


class Login {
    /**
     * @var $email string
     */
    protected $email;

    /**
     * @var $passcode string
     */
    protected $passcode;

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email string
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string $passcode
     */
    public function getPasscode()
    {
        return $this->passcode;
    }

    /**
     * @param $passcode string
     */
    public function setPasscode($passcode)
    {
        $this->passcode = $passcode;
    }
} 