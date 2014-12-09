<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/8/14
 * Time: 10:32 PM
 */

namespace User\UserBundle\Entity;


class Login {
    protected $task;
    protected $dueDate;

    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }
} 