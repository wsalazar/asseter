<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/21/14
 * Time: 5:01 PM
 */

namespace Asseter\UserBundle\Entity;

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
    protected $email;
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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var $verificationCode string
     */
    protected $verificationCode;
    /**
     * @ORM\Column(type="integer")
     * @var integer $active
     */
    protected $active;

    /**
     * @ORM\Column(type="string")
     * @var string $role
     */
    protected $role;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $passcode
     * @param string $verificationCode
     * @param $role
     * @throws \InvalidArgumentException
     */
    public function __construct($firstName, $lastName, $email, $passcode, $verificationCode, $role)
    {
        if ( is_null($firstName) ) {
            throw new \InvalidArgumentException('First Name must not be empty');
        }
        $this->setFirstName($firstName);
        if ( is_null($lastName) ) {
            throw new \InvalidArgumentException('Last Name must not be empty');
        }
        $this->setLastName($lastName);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Not a valid email address.');
        }
        if ( is_null($email) ) {
            throw new \InvalidArgumentException('Email must not be empty.');
        }
        $this->setEmail($email);
        if ( is_null($passcode) ) {
            throw new \InvalidArgumentException('Password must not be empty');
        }
        if ( strlen($passcode) < 5 ) {
            throw new \InvalidArgumentException('Password must be longer than 5 characters');
        }
        $this->setEncodedPasscode($passcode);
        $this->setVerificationCode($verificationCode);
        $this->setActive(0);
        $this->role = $role;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->role;
    }

    /**
     * @param string $encodedPasscode
     */
    public function setEncodedPasscode($encodedPasscode)
    {
        $this->encodedPasscode = $encodedPasscode;
    }

    /**
     * @return string
     */
    public function getEncodedPasscode()
    {
        return $this->encodedPasscode;
    }

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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $verificationCode
     */
    public function setVerificationCode($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * @return string
     */
    public function getVerificationCode()
    {
        return $this->verificationCode;
    }


} 