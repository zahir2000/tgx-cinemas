<?php
/**
 * @author Zahiriddin Rustamov
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';

if (isset($_GET['a'])) {
    if (SessionHelper::verifyToken('logout')) {
        SessionHelper::removeToken('logout');
        SessionHelper::remove();
        SessionHelper::destroy();
        header('Location:/tgx-cinemas/Simran/loginPage.php');
    } else {
        //echo "Not work";
        header('Location:' . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
    }
}
        
