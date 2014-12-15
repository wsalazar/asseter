<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/8/14
 * Time: 10:32 PM
 */

namespace User\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity @ORM\Table(name="users")
 */

class User
{

    /**
     * @ORM\id @ORM\Column(type="integer") @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @var string $firstName
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var $lastName string
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var $email string
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var $passcode string
     */
    protected $encodedPasscode;

    /**
     * @var $salt string
     */
    protected $salt;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $username
     * @param string $passcode
     * @throws \InvalidArgumentException
     */
    public function __construct($firstName, $lastName, $username, $passcode)
    {
        if ( is_null($firstName) ) {
            throw new \InvalidArgumentException('First Name must not be empty');
        }
        $this->setFirstName($firstName);
        if ( is_null($lastName) ) {
            throw new \InvalidArgumentException('Last Name must not be empty');
        }
        $this->setLastName($lastName);
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Not a valid email address.');
        }
        if ( is_null($username) ) {
            throw new \InvalidArgumentException('Email must not be empty.');
        }
        $this->setUsername($username);
        if ( is_null($passcode) ) {
            throw new \InvalidArgumentException('Password must not be empty');
        }

        if ( strlen($passcode) < 5 ) {
            throw new \InvalidArgumentException('Password must be longer than 5 characters');
        }
        $this->setEncodedPasscode($passcode);
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string firstName
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
    public function setEncodedPasscode($passcode)
    {
        $this->encodedPasscode = $passcode;
    }

    /**
     * @return string
     */
    public function getEncodedPasscode()
    {
        return $this->encodedPasscode;
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