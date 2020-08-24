<?php

require_once 'Middleware.php';

/**
 * this checks whether the user has tried too many times and failed
 */
class ThrottlingMiddleware extends Middleware {

    private $requestPerMinute;
    private $request;
    private $currentTime;

    public function __construct(int $requestPerMinute) {
        $this->requestPerMinute = $requestPerMinute;
        $this->currentTime = time();
    }

    public function check(string $username, string $password): bool {
        if (time() > $this->currentTime + 60) {
            $this->request = 0;
            $this->currentTime = time();
        }

        $this->request++;

        if ($this->request > $this->requestPerMinute) {
            echo "Request limit exceeded!\n";
            die();
        }

        return parent::check($username, $password);
    }

}
