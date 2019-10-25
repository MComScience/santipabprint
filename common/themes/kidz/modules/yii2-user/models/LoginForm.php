<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn Phompak
 * Date: 21/10/2562
 * Time: 20:22
 */
namespace kidz\user\models;

use dektrium\user\models\LoginForm as BaseLoginForm;

class LoginForm extends BaseLoginForm
{
    public function getUser(){
        return $this->user;
    }
}