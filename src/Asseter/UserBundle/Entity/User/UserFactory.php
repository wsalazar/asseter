<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/21/14
 * Time: 5:12 PM
 */

namespace Asseter\UserBundle\Entity\User;

use Asseter\UserBundle\Entity\User;

class UserFactory
{

    /**
     * @param array $user
     * @return User
     */
    public function create($user = array())
    {
        return new User(
            isset($user['firstName']) ? trim($user['firstName']) : null,
            isset($user['lastName']) ? trim($user['lastName']) : null,
            isset($user['email']) ? trim($user['email']) : null,
            isset($user['encoded_passcode']) ? $user['encoded_passcode'] : null,
            $user['verification_code'] = uniqid(''),
            $user['role'] = 'ROLE_USER'
        );
    }
} 