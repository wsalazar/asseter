<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/12/14
 * Time: 12:21 AM
 */

namespace User\UserBundle\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class DatabaseManager
 * @package User\UserBundle\Service
 */
class DatabaseManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

}