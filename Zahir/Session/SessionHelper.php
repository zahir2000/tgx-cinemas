<?php

require_once 'Token.php';
require_once 'CustomException.php';

/**
 * <p><b>Session Helper</b> is a class dedicated for session management.</P>
 * @author Zahir
 */
class SessionHelper {

    const MAX_LIFE = 3600; //1 HOUR
    const PERIODIC_LIFE = 300;
    const TOKEN_LIFE = 900;

    public static function add($key, $value) {

        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* Update last action time for inactivity */
        $_SESSION['last_action'] = time();

        /* Create the session */
        $_SESSION[$key] = $value;

        /* Return value */
        return $value;
    }

    private static function checkTimeout() {
        if (self::timeout()) {
            self::regenerate_session();
        }
    }

    public static function get($key, $key2 = null) {

        if (self::check($key, $key2)) {
            if ($key2 != null) {
                return $_SESSION[$key][$key2];
            }

            return $_SESSION[$key];
        }

        return null;
    }

    public static function check($key, $key2 = null) {

        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* Update last action time for inactivity */
        $_SESSION['last_action'] = time();

        /* Check if session key exists */
        if (isset($_SESSION[$key])) {

            /* If the session is multidimensional */
            if ($key2 != null) {
                if (isset($_SESSION[$key][$key2])) {
                    return true;
                }

                return false;
            }

            return true;
        }

        /* In case the session key does not exist, return false */
        return false;
    }

    public static function remove($key = "") {

        /* Start the session */
        self::session();

        /* Update last action time for inactivity */
        $_SESSION['last_action'] = time();

        /* Unset the a session date */
        if (empty($key)) {
            session_unset();
        } else {
            self::validateKeyInput($key);
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {

        if (session_status() != PHP_SESSION_NONE) {

            /* Destroy the session and the data */
            session_destroy();
            self::destroy_csrf_cookies();
        }
    }

    public static function login($username, $userId) {

        self::session();
        self::regenerate_session();

        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $userId;
        $_SESSION['user_token'] = self::generateToken('user_token' . base64_encode(random_bytes(5)));
        $_SESSION['last_action'] = time();
        $_SESSION['login_time'] = time();

        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            $_SESSION['is_https'] = "on";
        } else {
            $_SESSION['is_https'] = "off";
        }

        self::updateToken($username);
    }

    private static function updateToken($username) {
        $db = DatabaseConnection::getInstance();

        $userToken = self::get('user_token');

        $tokenQuery = "SELECT * FROM usertoken WHERE username = ?";
        $stmt = $db->getDb()->prepare($tokenQuery);
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $updateToken = "UPDATE usertoken SET token = ? WHERE username = ?";
            $stmt = $db->getDb()->prepare($updateToken);
            $stmt->bindParam(1, $userToken, PDO::PARAM_STR);
            $stmt->bindParam(2, $username, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $updateToken = "INSERT INTO usertoken(username, token) VALUES (?, ?)";
            $stmt = $db->getDb()->prepare($updateToken);
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $userToken, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    public static function login_session() {
        /* Start the session */
        self::session();

        if (isset($_SESSION['userId'])) {
            if (self::isLoginSessionExpired()) {
                self::regenerate_session();
                //self::destroy();
                //header("Location:loginPage.php?return=session_expired");
            }
        }
    }

    private static function isLoginSessionExpired() {
        /* Start the session */
        self::session();

        if (isset($_SESSION['last_action']) && isset($_SESSION['userId'])) {
            if (self::timeout()) {
                return true;
            }
        }

        return false;
    }

    public static function logout() {

        /* Start the session */
        self::session();
        self::removeToken('logout');
        self::remove();
        self::destroy();
        header('Location:/Assignment/Simran/loginPage.php?session=dead');
    }

    private static function session() {

        /* Check if session is disabled */
        if (session_status() == PHP_SESSION_DISABLED) {
            throw new DisabledSessionException('Session is not active on this machine!');
        }

        /* Start the session */
        if (session_status() == PHP_SESSION_NONE) {
            try {
                session_start();
            } catch (Exception $ex) {
                
            }
        }

        if (!self::valid_user()) {
            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            session_regenerate_id();
        }

        self::https();
    }

    private static function https() {
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            $secure = "on";
        } else {
            $secure = "off";
        }

        if (!isset($_SESSION['is_https'])) {
            $_SESSION['is_https'] = $secure;
        }

        if ($_SESSION['is_https'] != $secure) {
            $_SESSION['is_https'] = $secure;
            self::regenerate_session();
        }
    }

    private static function valid_user() {
        if (!isset($_SESSION['ip_address']) || !isset($_SESSION['user_agent'])) {
            return false;
        }

        if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        return true;
    }

    public static function regenerate_session() {
        session_regenerate_id();
    }

    private static function timeout() {

        if(isset($_SESSION['login_time'])){
            $loginTime = time() - $_SESSION['login_time'];
            
            if($loginTime >= self::MAX_LIFE){
                self::logout();
                return;
            }
        }
        
        if (isset($_SESSION['last_action'])) {
            $session_age = $_SESSION['last_action'];

            /* Calculate how long it was inactive for */
            $timeDiff = time() - $session_age;

            /* If the session was inactive for more than [30 minutes] then destroy the session */
            if ($timeDiff >= self::MAX_LIFE) {
                return true;
            }

            //self::regenerate_session_periodically();
        }

        /* If it was not inactive for more than [30 minutes], update the time the session was used to current time */
        $_SESSION['last_action'] = time();

        return false;
    }

    private static function regenerate_session_periodically() {

        self::session();

        if (isset($_SESSION['last_periodic_update'])) {
            $lastUpdate = $_SESSION['last_periodic_update'];
            $timeDiff = time() - $lastUpdate;

            if ($timeDiff >= self::PERIODIC_LIFE) {
                self::regenerate_session();
            }

            $_SESSION['last_periodic_update'] = time();
        }
    }

    private static function validateKeyInput($key) {
        if (empty($key)) {
            throw new EmptyKeyException('Key cannot be empty!');
        }

        if (!is_string($key)) {
            throw new InvalidKeyException('Key must be a string!');
        }
    }

    /* ------------------- CSRF Prevention ------------------- */

    public static function generateToken(string $key) {

        self::validateKeyInput($key);
        self::session();

        /* If a key has already been generated for a page. We do not generate again. */
        if (self::getToken($key) != null) {
            $token = self::getToken($key);
        } else {
            $token = self::createToken($key);
        }

        return $token->getSessionToken();
    }

    private static function getToken(string $key) {
        return self::get('csrf_token', $key);
    }

    private static function getCookie($key) {

        self::validateKeyInput($key);

        $value = self::generateCookieName($key);

        if (!empty(filter_input(INPUT_COOKIE, $value))) {
            return filter_input(INPUT_COOKIE, $value);
        }

        return '';
    }

    private static function createToken($key) {
        $token = new Token($key);
        $token->setExpiryTime(time() + self::TOKEN_LIFE);
        $token->setSessionToken(sha1(base64_encode(random_bytes(32))));
        $token->setCookieToken(sha1(base64_encode(random_bytes(32))));

        setcookie(self::generateCookieName($key), $token->getCookieToken(), $token->getExpiryTime(), NULL, NULL, NULL, true);

        return $_SESSION['csrf_token'][$key] = $token;
    }

    private static function generateCookieName($key) {
        self::validateKeyInput($key);
        return 'csrf_token-' . sha1(base64_encode($key));
    }

    public static function verifyToken($key) {

        self::validateKeyInput($key);
        self::session();

        $requestToken = filter_input(INPUT_POST, 'csrf_token');

        if (is_null($requestToken)) {
            return false;
        }

        self::validateKeyInput($requestToken);

        $token = self::getToken($key);

        if (empty($token) || time() > (int) $token->getExpiryTime()) {
            self::removeToken($key);
            return false;
        }

        if (self::compareHash($token->getSessionToken(), $requestToken) && self::compareHash($token->getCookieToken(), self::getCookie($key))) {
            return true;
        }

        //Re-authenticate here.
        return false;
    }

    private static function compareHash($token1, $token2) {
        return hash_equals($token1, $token2);
    }

    public static function removeToken($key) {

        self::validateKeyInput($key);
        self::session();

        unset($_COOKIE[self::generateCookieName($key)], $_SESSION['csrf_token'][$key]);

        return true;
    }

    private static function destroy_csrf_cookies() {
        foreach ($_COOKIE as $cookieKey => $cookieValue) {
            if (strpos($cookieKey, 'csrf_token') === 0) {
                setcookie($cookieKey, null, -1);
                unset($_COOKIE[$cookieKey]);
            }
        }
    }

}