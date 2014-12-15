<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/15/14
 * Time: 12:07 AM
 */

namespace User\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{

    public function testRegisterUserAction()
    {
        $client = static::createClient();
        $crawler = $client->request(
            'POST',
            '/register/user',
            array(
                "firstName"         => "Alex",
                "lastName"          => "Sapountzis",
                "username"          => "asap@gmail.com",
                "passcode"          => "12345hello",
            ),
            array(),
            array()
        );
        $this->assertEquals('RedirectResponse', $this->getMockBuilder('RedirectResponse'), 'Redirect Reponse Object returned.');
    }
} 