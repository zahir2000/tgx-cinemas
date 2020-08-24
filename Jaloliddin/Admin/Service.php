<?php

require_once 'Server.php';
require_once 'ThrottlingMiddleware.php';
require_once 'UserExistsMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/DatabaseConnection.php';

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
        // we can create multiple handlers which handle tasks
        //if they cannot handle a task, the next handler tries to handle, so on.
        $middleware = new ThrottlingMiddleware(2);//check if the user tried too many logins but failed
        $middleware
                ->linkWith(new UserExistsMiddleware($server)); //checks if the user exists, their password matches or not.

        //we supply the chain of handlers to the server
        $server->setMiddleware($middleware);
    }
} else {
    return null;
}

