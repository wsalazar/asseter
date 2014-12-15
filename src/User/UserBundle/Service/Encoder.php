<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/11/14
 * Time: 11:08 PM
 */

namespace User\UserBundle\Service;

use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

/**
 * Class Encoder
 * @package User\UserBundle\Service
 */
class Encoder extends BCryptPasswordEncoder
{

    /**
     * @var string $salt
     */
    protected $salt;

    /**
     * @param int $cost
     */
    public function __construct($cost)
    {
        parent::__construct($cost);
    }

    /**
     * @param string $raw
     * @return bool|string
     */
    public function encode($raw)
    {
        return $this->encodePassword($raw, null);
    }

    /**
     * @param string $encoded
     * @param string $raw
     * @param null   $salt
     * @return bool
     */
    public function isPasswordValid($encoded, $raw, $salt = null)
    {
        return parent::isPasswordValid($encoded, $raw, null);
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
} 