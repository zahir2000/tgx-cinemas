<?php

require_once 'Server.php';
require_once 'ThrottlingMiddleware.php';
require_once 'UserExistsMiddleware.php';
require_once 'RoleCheckMiddleware.php';
require_once '../../Database/DatabaseConnection.php';

$connect = DatabaseConnection::getInstance();
$query = "SELECT * FROM admin";
$stmt = $connect->getDb()->prepare($query);
$stmt->execute();

$server = new Server();

if ($stmt->rowCount() > 0) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $username = $row["username"];
        $password = $row["password"];
        $server->register($username, $password);
    }
} else {
    return null;
}

// All middleware are chained. The client can build various configurations of
// chains depending on its needs.
$middleware = new ThrottlingMiddleware(2);
$middleware
        ->linkWith(new UserExistsMiddleware($server))
        ->linkWith(new RoleCheckMiddleware());

// The server gets a chain from the client code.
$server->setMiddleware($middleware);
