<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/21/14
 * Time: 5:14 PM
 */

namespace Asseter\UserBundle\Entity\User;

use Asseter\UserBundle\Entity\User;
use Asseter\UserBundle\Service\DatabaseManager;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder as PasswordEncoder;
use Asseter\UserBundle\Service\Encoder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

/**
 * Class UserManager
 * @package Asseter\UserBundle\Entity\User
 */

class UserManager
{

    protected $_db;
    /**
     * @var
     */
    protected $_userFactory;
    /**
     * @param DatabaseManager $db
     * @param UserFactory     $userFactory
     */
    public function __construct(DatabaseManager $db, UserFactory $userFactory)
    {
        $this->_db = $db;
        $this->_userFactory = $userFactory;
    }

    /**
     * @param array $user
     * @param \Asseter\UserBundle\Service\Encoder $encoder
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @internal param \User\UserBundle\Entity\User\UserFactory $createUser
     * @internal param \User\UserBundle\Service\DatabaseManager $db
     * @return User                            $createdUser
     */
    public function createUser($user, Encoder $encoder)
    {
        $passcode = $user['passcode'];
        $user['encoded_passcode'] = $encoder->encode($passcode, null);
        unset($user['passcode']);
        $createdUser = $this->_userFactory->create($user);
        if ($this->isUserExists($createdUser)) {
            throw new AlreadySubmittedException(sprintf('User: %s already exists.', $createdUser->getEmail()));
        }
        $em = $this->_db->getEntityManager();
        $em->persist($createdUser);
        $em->flush();
        return $createdUser;
    }
    /**
     * Checks to verify if email already exists.
     * @param User $user
     * @return bool
     */
    private function isUserExists(User $user)
    {
        $em = $this->_db->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('u.email')
            ->from('AsseterUserBundle:User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $user->getEmail())
            ->getQuery();
        return count($query->execute()) > 0 ? true : false ;
    }
    /**
     * @param array $user
     * @return mixed|null
     */
    public function fetchUser($user)
    {
        $em = $this->_db->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('u.encodedPasscode, u.email, u.role')
            ->from('AsseterUserBundle:User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $user['email'])
            ->getQuery();
        return count($query->execute()) > 0 ? $query->execute() : null ;
    }

    /**
     * @param array $user
     * @return mixed|null
     */
    public function fetchUserByEmail($user)
    {
        $em = $this->_db->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('u.role')
            ->from('AsseterUserBundle:User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $user['email'])
            ->getQuery();
        return count($query->execute()) > 0 ? $query->execute() : null ;
    }

    /**
     * @param array $user
     * @return mixed|null
     */
    public function fetchEmailRoleByVerificationCode($user)
    {
        $em = $this->_db->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('u.role, u.email')
            ->from('AsseterUserBundle:User', 'u')
            ->where('u.verificationCode = :verificationCode')
            ->setParameter('verificationCode', $user['verificationCode'])
            ->getQuery();
        return count($query->execute()) > 0 ? $query->execute() : null ;
    }

    /**
     * @param Encoder $encoder
     * @param array   $queriedUser
     * @param array   $submittedUser
     * @return bool
     */
    public function verifyPasscode(Encoder $encoder, $queriedUser, $submittedUser)
    {
        return $encoder->isPasswordValid((string) $queriedUser[0]['encodedPasscode'], (string) trim($submittedUser['passcode']));
    }
    /**
     * @param array $user
     * @internal param $verificationCode
     * @return mixed
     */
    public function activateUser($user = array())
    {
        $em = $this->_db->getEntityManager();
        $activate = $em->createQueryBuilder();
        $activate->update('AsseterUserBundle:User', 'u');
        $activate->set('u.active', 1);
        $verificationCode = trim($user['verificationCode']);
        $email = isset($user['email']) ? $user['email'] : null ;
        if (isset($email) && isset($verificationCode)) {
            $activate->where('u.email = :email ');
            $activate->andWhere('u.verificationCode = :verification_code ');
            $activate->setParameters(
                new ArrayCollection(
                    array(
                        new Parameter('email', $email),
                        new Parameter('verification_code', $verificationCode)
                    )
                )
            );
        } elseif (is_null($email) && isset($verificationCode)) {
            $activate->where('u.verificationCode = :verification_code');
            $activate->setParameter('verification_code', $verificationCode);
        }
        $query = $activate->getQuery();
        return $query->execute();
    }
    /**
     * @param array $user
     * @return bool
     */
    public function isActive($user = array())
    {
        $em = $this->_db->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('u.active')
            ->from('AsseterUserBundle:User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $user['email'])
            ->getQuery();
        return $query->execute()[0]['active'] == 1 ? true : false ;
    }
    /**
     * @param array $user
     * @return mixed
     */
    public function getVerificationCodeByEmail($user = array())
    {
        $em = $this->_db->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('u.verificationCode')
            ->from('AsseterUserBundle:User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $user['email'])
            ->getQuery();
        return $query->execute()[0]['verificationCode'];
    }

} 