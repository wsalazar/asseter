<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/15/14
 * Time: 1:04 AM
 */

namespace User\UserBundle\Tests\Form;

use Symfony\Component\Form\Test\TypeTestCase;
use User\UserBundle\Form\UserType;

/**
 * Class UserTypeTest
 * @package User\UserBundle\Tests\Form
 */
class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'test' => 'test',
            'test2' => 'test2',
        );

        $type = new UserType();
        $form = $this->factory->create($type);

        $object = new TestObject();
        $object->fromArray($formData);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
} 