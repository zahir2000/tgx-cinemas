<?php

require_once 'SessionHelper.php';
require_once '../Database/DatabaseConnection.php';

$db = DatabaseConnection::getInstance();
    
    $username = SessionHelper::get('username');

    $query = "SELECT token FROM usertoken WHERE username = ?";
    $stmt = $db->getDb()->prepare($query);
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $dbToken = $result['token'];
        
        if(SessionHelper::get('user_token') != $dbToken){
            SessionHelper::destroy();
            header('Location:/Assignment/Simran/loginPage.php?duplicate=user');
        }
    }
