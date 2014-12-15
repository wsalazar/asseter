<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/15/14
 * Time: 12:07 AM
 */

namespace User\UserBundle\Tests\Controller;


class UserControllerTest {

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
} 