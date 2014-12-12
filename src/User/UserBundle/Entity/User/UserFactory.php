<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/11/14
 * Time: 10:40 PM
 */

namespace User\UserBundle\Entity\User;

use User\UserBundle\Entity\User;
use User\UserBundle\Service\Sha256Salted as Encoder;
use User\UserBundle\Service\DatabaseManager;

class UserFactory
{
    /**
     * @param array $user
     * @param Encoder $encoder
     * @return User
     */
    public function createUser($user = array(), Encoder $encoder)
    {
        return new User(
            isset($user['firstName']) ? $user['firstName'] : null,
            isset($user['lastName']) ? $user['lastName'] : null,
            isset($user['username']) ? $user['username'] : null,
            isset($user['passcode']) ? $encoder->encodePassword($user['passcode'], uniqid(mt_rand())) : null
        );
    }

    /**
     * @param User $createdUser
     * @param DatabaseManager $db
     */
    public function persist(User $createdUser, DatabaseManager $db)
    {
        $em = $db->getEntityManager();
        $em->persist($createdUser);
        $em->flush();
    }
} 