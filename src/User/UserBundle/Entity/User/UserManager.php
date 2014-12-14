<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/13/14
 * Time: 1:03 AM
 */

namespace User\UserBundle\Entity\User;

use User\UserBundle\Entity\User;
use User\UserBundle\Service\DatabaseManager;
use Symfony\Component\Form\Exception\AlreadySubmittedException;


class UserManager
{
    /**
     * @param UserFactory $createUser
     * @param $user
     * @param $encoder
     * @param DatabaseManager $db
     * @return bool
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     */
    public function createUser(UserFactory $createUser, $user, $encoder, DatabaseManager $db)
    {
        $user = $createUser->create($user,$encoder);
        if( $this->isUserExists($user, $db) ) {
            throw new AlreadySubmittedException(sprintf('User: %s already exists.', $user->getUsername() ) );
        }
        $em = $db->getEntityManager();
        $em->persist($user);
        $em->flush();
        return true;
    }

    /**
     * Checks to verify if username already exists.
     * @param User $user
     * @param DatabaseManager $db
     * @return bool
     */
    private function isUserExists(User $user, DatabaseManager $db)
    {
        $em = $db->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('u.username')
            ->from('UserUserBundle:User','u')
            ->where('u.username = :user_name')
            ->setParameter('user_name',$user->getUsername())
            ->getQuery();
        return count($query->execute()) > 0 ? true : false ;

    }

} 