<?php
/**
 * @author Zahiriddin Rustamov
 */
require_once 'SessionHelper.php';

if(!SessionHelper::check('username')){
    SessionHelper::destroy();
    header('Location:/tgx-cinemas/Simran/loginPage.php');
}