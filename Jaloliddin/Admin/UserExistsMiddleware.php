<?php

require_once 'Middleware.php';

/**
 * Description of UserExistsMiddleware
 *
 * @author Jaloliddin
 */

/**
 * This Concrete Middleware checks whether a user with given credentials exists.
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
