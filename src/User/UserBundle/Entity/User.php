<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/8/14
 * Time: 10:32 PM
 */

namespace User\UserBundle\Entity;


class User {

    /**
     * @var $firstName string
     */
    protected $firstName;

    /**
     * @var $lastName string
     */
    protected $lastName;

    /**
     * @var $email string
     */
//    protected $email;
    protected $username;

    /**
     * @var $passcode string
     */
    protected $passcode;

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $passcode
     */
    public function setPasscode($passcode)
    {
        $this->passcode = $passcode;
    }

    /**
     * @return string
     */
    public function getPasscode()
    {
        return $this->passcode;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }


} 