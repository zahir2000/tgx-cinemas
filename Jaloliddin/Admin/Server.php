<?php

class Server {

    private $users = [];
    private $middleware;

    /**
     * The client can configure the server with a chain of middleware objects.
     */
    public function setMiddleware(Middleware $middleware): void {
        $this->middleware = $middleware;
    }

    /**
     * The server gets the username and password from the client and sends the
     * authorization request to the middleware.
     */
    public function logIn(string $username, string $password): bool {
        if ($this->middleware->check($username, $password)) {
            return true;
        }
        return false;
    }

    public function register(string $username, string $password): void {
        $this->users[$username] = $password;
    }

    public function hasUsername(string $username): bool {
        return isset($this->users[$username]);
    }

    public function isValidPassword(string $username, string $password): bool {
        return $this->users[$username] === $password;
    }

}
