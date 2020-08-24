<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/BookingConnection.php';

if (SessionHelper::check('username')) {
    $db = BookingConnection::getInstance();

    $username = SessionHelper::get('username');
    $result = $db->getUserToken($username);
    $dbToken = $result['token'];

    if (SessionHelper::get('user_token') != $dbToken) {
        SessionHelper::remove();
        SessionHelper::removeToken('logout');
        SessionHelper::destroy();

        header('Location:/tgx-cinemas/Simran/loginPage.php?duplicate=user');
    }
}
