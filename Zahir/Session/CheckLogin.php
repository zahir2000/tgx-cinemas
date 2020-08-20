<?php

require_once 'SessionHelper.php';

if(!SessionHelper::check('username')){
    SessionHelper::destroy();
    header('Location:/Assignment/Simran/loginPage.php');
}

SessionHelper::login_session();