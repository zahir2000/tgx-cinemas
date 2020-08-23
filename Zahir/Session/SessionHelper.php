<?php

require_once 'Token.php';
require_once 'CustomException.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment/Database/BookingConnection.php';

/**
 * <p><b>Session Helper</b> is a class dedicated for session management.</P>
 * @author Zahir
 */
class SessionHelper {

    const MAX_LIFE = 3600; //1 HOUR
    const PERIODIC_LIFE = 1800; //30 MIN
    const TOKEN_LIFE = 600; //10 MIN

    /* Description: 
     * Pre-Condition: 
     * Post-Condition: 
     * Return: 
     */
    
    /* Description: Add a new variable to the session using the key-value supplied.
     * Pre-Condition: The key is not empty and a string.
     * Post-Condition: The key is added to the session.
     * Return: Return the value added to the session.
     */
    public static function add($key, $value) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* Update last action time for inactivity checking */
        $_SESSION['last_action'] = time();

        /* Create the session variable */
        $_SESSION[$key] = $value;

        /* Return value */
        return $value;
    }

    public static function get($key, $key2 = null) {

        /* Pass the key(s) for checking if they exist */
        if (self::check($key, $key2)) {

            /* In case the session variable is multidimensional */
            if ($key2 != null) {
                return $_SESSION[$key][$key2];
            }

            return $_SESSION[$key];
        }

        return null;
    }

    public static function check($key, $key2 = null) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* Update last action time for inactivity checking */
        $_SESSION['last_action'] = time();

        /* Check if session variable exists */
        if (isset($_SESSION[$key])) {

            /* In case the session variable is multidimensional */
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

        /* Update last action time for inactivity checking */
        $_SESSION['last_action'] = time();

        /* Unset the a session variable
         * If the key supplied is empty, remove all session variables */
        if (empty($key)) {
            session_unset();
        } else {
            self::validateKeyInput($key);
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {

        /* Ensure the session exists */
        if (session_status() != PHP_SESSION_NONE) {

            /* Destroy the session and the variables */
            session_destroy();

            /* Destroy all cookies related to CSRF Tokens */
            self::destroy_csrf_cookies();
        }
    }

    public static function login($username, $userId) {

        /* Start the session */
        self::session();

        /* Generate a new session */
        self::regenerate_session();

        /* Save user data to session variables */
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $userId;
        $_SESSION['user_token'] = self::generateToken('user_token' . base64_encode(random_bytes(5)));
        $_SESSION['last_action'] = time();
        $_SESSION['login_time'] = time();

        /* Retreive and store the user protocol (http/https) */
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            $_SESSION['is_https'] = "on";
        } else {
            $_SESSION['is_https'] = "off";
        }

        /* Update login token for duplicate login checking */
        self::updateToken($username);
    }

    private static function updateToken($username) {
        $userToken = self::get('user_token');

        /* Update user token in database */
        $db = BookingConnection::getInstance();
        $db->updateToken($username, $userToken);
    }

    public static function login_session() {

        /* Start the session */
        self::session();

        /* Check if user id exists */
        if (isset($_SESSION['userId'])) {

            /* Check whether the user was inactive */
            if (self::isLoginSessionExpired()) {

                /* Regenerate user session */
                self::regenerate_session();
            }
        }
    }

    private static function isLoginSessionExpired() {

        /* Start the session */
        self::session();

        if (isset($_SESSION['last_action']) && isset($_SESSION['userId'])) {

            /* Check the timeout conditions */
            if (self::timeout()) {
                return true;
            }
        }

        return false;
    }

    public static function logout() {

        /* Start the session */
        self::session();

        /* Destroy session and variables */
        self::removeToken('logout');
        self::remove();
        self::destroy();

        /* Redirect to Login Page */
        header('Location:/Assignment/Simran/loginPage.php?session=dead');
    }

    private static function session() {

        /* Check if session is disabled */
        if (session_status() == PHP_SESSION_DISABLED) {
            throw new DisabledSessionException('Session is not active on this machine!');
        }

        /* Start the session if session does not exist */
        if (session_status() == PHP_SESSION_NONE) {
            try {
                session_start();
            } catch (Exception $ex) {
                
            }
        }

        /* Check if the user is NOT valid */
        if (!self::valid_user()) {

            /* Update user ip and agent */
            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

            /* Regenerate user session */
            session_regenerate_id();
        }

        /* Check whether the protocol (http/https) is changed */
        self::https();
    }

    private static function https() {

        /* Get current protocol */
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            $secure = "on";
        } else {
            $secure = "off";
        }

        /* If the protocol is not found on session */
        if (!isset($_SESSION['is_https'])) {

            /* Store the current protocol in the session */
            $_SESSION['is_https'] = $secure;
        }

        /* Check if the session stored protocol matches the current user protocol */
        if ($_SESSION['is_https'] != $secure) {

            /* Update protocol */
            $_SESSION['is_https'] = $secure;

            /* Regenerate user session */
            self::regenerate_session();
        }
    }

    private static function valid_user() {

        /* If the user IP and agent is not found */
        if (!isset($_SESSION['ip_address']) || !isset($_SESSION['user_agent'])) {
            return false;
        }

        /* If the current IP and agent of user does not match the one stored in session */
        if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        return true;
    }

    public static function regenerate_session() {
        session_regenerate_id();
    }

    private static function timeout() {

        /* Check for the user login time */
        if (isset($_SESSION['login_time'])) {

            /* Calculate how long they are logged in for */
            $loginTime = time() - $_SESSION['login_time'];

            /* If user is logged in for more than MAX_LIFE (1 hour) */
            if ($loginTime >= self::MAX_LIFE) {

                /* Log user out of their account */
                self::logout();
                return;
            }
        }

        /* Check the time user performed last action */
        if (isset($_SESSION['last_action'])) {
            $session_age = $_SESSION['last_action'];

            /* Calculate how long it was inactive for */
            $timeDiff = time() - $session_age;

            /* If the session was inactive for more than [30 minutes] */
            if ($timeDiff >= self::PERIODIC_LIFE) {
                return true;
            }
        }

        /* If it was not inactive for more than [30 minutes], update the time the session was used to current time */
        $_SESSION['last_action'] = time();

        return false;
    }

    private static function validateKeyInput($key) {

        /* Validation checking for empty and non-string session variable */
        if (empty($key)) {
            throw new EmptyKeyException('Key cannot be empty!');
        }

        if (!is_string($key)) {
            throw new InvalidKeyException('Key must be a string!');
        }
    }

    /* ------------------- CSRF Prevention ------------------- */

    public static function generateToken($key) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* If a key has already been generated for a page. We do not generate again to allow for multi-tab access */
        if (self::getToken($key) != null) {

            /* If token exists, retreive it */
            $token = self::getToken($key);
        } else {

            /* Create new token for page */
            $token = self::createToken($key);
        }

        /* Return the session token */
        return $token->getSessionToken();
    }

    private static function getToken($key) {

        /* Retreive the token stored in session */
        return self::get('csrf_token', $key);
    }

    private static function getCookie($key) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Generate random cookie name */
        $value = self::generateCookieName($key);

        /* If the cookie is found on postback */
        if (!empty(filter_input(INPUT_COOKIE, $value))) {
            return filter_input(INPUT_COOKIE, $value);
        }

        /* If the cookie is deleted, return empty string */
        return '';
    }

    private static function createToken($key) {

        /* Create new token for page */
        $token = new Token($key);

        /* Set life of token for 10 minutes */
        $token->setExpiryTime(time() + self::TOKEN_LIFE);

        /* Generate session and cookie token on random algorithm */
        $token->setSessionToken(sha1(base64_encode(random_bytes(32))));
        $token->setCookieToken(sha1(base64_encode(random_bytes(32))));

        /* Create the cookie */
        setcookie(self::generateCookieName($key), $token->getCookieToken(), $token->getExpiryTime(), NULL, NULL, NULL, true);

        /* Store the newly created token in the session */
        return $_SESSION['csrf_token'][$key] = $token;
    }

    private static function generateCookieName($key) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Return cookie name generated on random algorithm */
        return 'csrf_token-' . sha1(base64_encode($key));
    }

    public static function verifyToken($key) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* Check if postback data contains the hidden token */
        $requestToken = filter_input(INPUT_POST, 'csrf_token');

        /* If no token is passed on postback */
        if (is_null($requestToken)) {
            return false;
        }

        /* Validate for empty and non-string key */
        self::validateKeyInput($requestToken);

        /* Retrieve the stored token from database */
        $token = self::getToken($key);

        /* If the token is dead or is empty */
        if (empty($token) || time() > (int) $token->getExpiryTime()) {

            /* Remove the token from session */
            self::removeToken($key);
            return false;
        }

        /* Compare both the session and cookie token */
        if (self::compareHash($token->getSessionToken(), $requestToken) && self::compareHash($token->getCookieToken(), self::getCookie($key))) {
            return true;
        }

        return false;
    }

    private static function compareHash($token1, $token2) {

        /* Compare hash values of two tokens */
        return hash_equals($token1, $token2);
    }

    public static function removeToken($key) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* Remove the cookie */
        unset($_COOKIE[self::generateCookieName($key)], $_SESSION['csrf_token'][$key]);

        return true;
    }

    private static function destroy_csrf_cookies() {

        /* Retreive all cookies */
        foreach ($_COOKIE as $cookieKey) {

            /* Since we set cookie names to csrf_token-[random chars]. We can retrive them all using the identifier */
            if (strpos($cookieKey, 'csrf_token') === 0) {

                /* Set the cookie value to null */
                setcookie($cookieKey, null, -1);

                /* Remove the ccookie */
                unset($_COOKIE[$cookieKey]);
            }
        }
    }

}
