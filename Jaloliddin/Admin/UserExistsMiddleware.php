<?php

require_once 'Middleware.php';

/**
 * Description of UserExistsMiddleware
 *
 * @author Jaloliddin
 */

/**
 * this checks if the user has supplied correct login details
 */
class UserExistsMiddleware extends Middleware {

    private $server;

    public function __construct(Server $server) {
        $this->server = $server;
    }

    public function check(string $username, string $password): bool {
        if (!$this->server->hasUsername($username)) {
            return false;
        }

        if (!$this->server->isValidPassword($username, $password)) {
            return false;
        }
        return parent::check($username, $password);
    }

}
