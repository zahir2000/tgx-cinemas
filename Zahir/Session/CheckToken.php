<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';

if (SessionHelper::check('username')) {
    $db = DatabaseConnection::getInstance();

    $username = SessionHelper::get('username');

    $query = "SELECT token FROM usertoken WHERE username = ?";
    $stmt = $db->getDb()->prepare($query);
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $dbToken = $result['token'];

        if (SessionHelper::get('user_token') != $dbToken) {
            SessionHelper::remove();
            SessionHelper::removeToken('logout');
            SessionHelper::destroy();
            
            header('Location:/tgx-cinemas/Simran/loginPage.php?duplicate=user');
        }
    }
}
