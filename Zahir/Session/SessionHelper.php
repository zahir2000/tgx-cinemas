<?php

require_once 'Token.php';
require_once 'CustomException.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Database/BookingConnection.php';

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
     *                 The last action time is set to current time.
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

    /* Description: Retreives the session stored data using the supplied key.
     * Pre-Condition: The variable exists in the session.
     * Post-Condition: None.
     * Return: If the key exists, returns the value of the key. Otherwise, returns null.
     */
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

    /* Description: Checks whether the variable (key) exists in the session.
     * Pre-Condition: The key is not empty and a string.
     * Post-Condition: The last action time is set to current time.
     * Return: Returns true if the key exists, otherwise returns false.
     */
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

    /* Description: Removes all or a specific variable in a session.
     * Pre-Condition: The key is not empty and a string.
     * Post-Condition: The last action time is set to current time.
     * Return: None.
     */
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

    /* Description: Destroys the current session, session data and all CSRF token related cookies.
     * Pre-Condition: The session exists.
     * Post-Condition: The session is destroyed and the CSRF token cookies are deleted.
     * Return: None.
     */
    public static function destroy() {

        /* Ensure the session exists */
        if (session_status() != PHP_SESSION_NONE) {

            /* Destroy the session and the variables */
            session_destroy();

            /* Destroy all cookies related to CSRF Tokens */
            self::destroy_csrf_cookies();
        }
    }

    /* Description: Performs login related session tasks. Generates a new session for user and then stores username, userId, user token, user's protocol, last action and login time to the session. Lastly, updates the user token in the database.
     * Pre-Condition: None.
     * Post-Condition: None.
     * Return: None.
     */
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

    /* Description: Stores the user login token to the database. This token will be used to determine whether the user has a duplicate login.
     * Pre-Condition: None.
     * Post-Condition: None.
     * Return: None.
     */
    private static function updateToken($username) {
        $userToken = self::get('user_token');

        /* Update user token in database */
        $db = BookingConnection::getInstance();
        $db->updateToken($username, $userToken);
    }

    /* Description: Performs regular session checking for user's inactivity. If the user's session is expired, generate a new session for the user.
     * Pre-Condition: The user's ID exists in the session.
     * Post-Condition: None.
     * Return: None.
     */
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

    /* Description: Checks whether the user's session has expired.
     * Pre-Condition: The user's last action and ID must exist in the session.
     * Post-Condition: None.
     * Return: Returns true if the session is expired, otherwise returns false.
     */
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

    /* Description: Performs logout related session activities. Destroys the current session, removes all session variables and deletes logout CSRF token.
     * Pre-Condition: None.
     * Post-Condition: Return the user to the login page.
     * Return: None.
     */
    public static function logout() {

        /* Start the session */
        self::session();

        /* Destroy session and variables */
        self::removeToken('logout');
        self::remove();
        self::destroy();

        /* Redirect to Login Page */
        header('Location:/tgx-cinemas/Simran/loginPage.php?session=dead');
    }

    /* Description: Starts a session. Checks whether the user is valid regarding their IP and agent. If they are not valid, store their new IP and agent to the session.
     * Pre-Condition: The session is not disabled. The session does not exist.
     * Post-Condition: Session is started. Check whether the user's protocol (http/https) is changed.
     * Return: None.
     */
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

    /* Description: Regenerates the session if the user's protocol changes from http to https and vice versa.
     * Pre-Condition: The user's protocol exists in the session.
     * Post-Condition: None.
     * Return: None.
     */
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

    /* Description: Checks whether the user's IP address and agent has been modified. The condition checks IP address and agent as AND tag to ensure even if the user's IP changes, the agent shouldn't normally.
     * Pre-Condition: The IP address and agent of user exists in the session.
     * Post-Condition: None.
     * Return: Returns true if the user is valid, otherwise return false.
     */
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

    /* Description: Regenerates the current session.
     * Pre-Condition: None.
     * Post-Condition: None.
     * Return: None.
     */
    public static function regenerate_session() {
        session_regenerate_id();
    }

    /* Description: Checks for the user's inactivity. The first check is to determine whether the user has been logged in for more than 1 hour, in this case, the user will be logged out of the website and asked to re-authenticate. The second check is to determine whether the user has not performed any actions in the last 30 minutes. If the user did not perform any actions, regenerate their session to prevent any session hijackings. 
     * Pre-Condition: The login and last action time exists in the session.
     * Post-Condition: None.
     * Return: Returns true if the user has been inactive, otherwise returns false
     */
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

    /* Description: Checks whether the supplied key for session variable is not empty and is a string.
     * Pre-Condition: None.
     * Post-Condition: None.
     * Return: If the key is empty or is not a string, throws an exception.
     */
    private static function validateKeyInput($key) {

        /* Validation checking for empty and non-string session variable */
        if (empty($key)) {
            throw new EmptyKeyException('Key cannot be empty!');
        }

        if (!is_string($key)) {
            throw new InvalidKeyException('Key must be a string!');
        }
    }

    /* ------------------- CSRF Prevention ------------------- 
     * This section's functions are all related to CSRF Prevention.
     * It generates a random CSRF token for the session and the cookie.
     * So generation of session and cookie tokens ensures that even if the attacker manages to get hold of the cookie, the session will still not allow them to modify any data.
     * The session token is passed in POST as a hidden input and the next page will check the session token with the postback token and the session stored cookie with the cookie in the header.
     */
    

    /* Description: Generates a CSRF token based on the key supplied. Only generates a new key if the key has not been generated before. This will allow the user to open many tabs at once.
     * Pre-Condition: The supplied key is not empty and is a string.
     * Post-Condition: None.
     * Return: Returns the token value for the session.
     */
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

    /* Description: Retrieves the CSRF token stored on the session based on the key supplied.
     * Pre-Condition: None.
     * Post-Condition: None.
     * Return: Returns the value of the CSRF token.
     */
    private static function getToken($key) {

        /* Retreive the token stored in session */
        return self::get('csrf_token', $key);
    }

    /* Description: Retreives the cookie stored in the request header. When a CSRF-token is supplied to a page, it will also generate CSRF-cookies for that page. Those cookies will be present on the header of the receive page.
     * Pre-Condition: The key is not empty and is a string.
     * Post-Condition: None.
     * Return: If the cookie that matches the key is present, returns the cookie value. Otherwise, returns empty string.
     */
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

    /* Description: Creates a session and cookie token based on the key supplied. For the token values, uses a random character algorithm. The token expiry time is set to 10 minutes so after ten minutes, the same token cannot be used anymore and a new one will be generated for the user.
     * Pre-Condition: None.
     * Post-Condition: The token is stored in the session.
     * Return: Returns the token object.
     */
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

    /* Description: Creates a random character name for the csrf token cookie.
     * Pre-Condition: The key is not empty and is a string.
     * Post-Condition: None.
     * Return: Returns the generated cookie name.
     */
    private static function generateCookieName($key) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Return cookie name generated on random algorithm */
        return 'csrf_token-' . sha1(base64_encode($key));
    }

    /* Description: Verifies whether the supplied key matches with the one stored in the session. It first retrieves the CSRF session token sent in the POST method. If this is empty, the verification fails. The key supplied for the token in the previous page must match with the key supplied in this page. The token is retrieved from the session by supplying the key and if it not empty. The expiry time of the token is checked to ensure it still is valid. If it has expired, the token is removed from the sesison and the process fails. If the key is valid, there will be two hash compares.
     * First hash value comparison is done between the POST session token and the session token value stored in the session. 
     * Second hash value comparison is done between the request header CSRF cookie token and the cookie token stored in the session.
     * If both these hash values match, the process is successful and the user may proceed to the next page. Otherwise, the process fails and the user is redirected to the Home page. 
     * Pre-Condition: The key is not empty and is a string.
     * Post-Condition: None.
     * Return: Returns true if successfully verified, otherwise, returns false.
     */
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

    /* Description: Compares hash values of two supplied inputs.
     * Pre-Condition: None.
     * Post-Condition: None.
     * Return: True if the hash value matches, otherwise returns false.
     */
    private static function compareHash($token1, $token2) {

        /* Compare hash values of two tokens */
        return hash_equals($token1, $token2);
    }

    /* Description: Removes a token from the browser cookies based on the key supplied.
     * Pre-Condition: The key is not empty and is a string.
     * Post-Condition: The CSRF cookie is deleted.
     * Return: None.
     */
    public static function removeToken($key) {

        /* Validate for empty and non-string key */
        self::validateKeyInput($key);

        /* Start the session */
        self::session();

        /* Remove the cookie */
        unset($_COOKIE[self::generateCookieName($key)], $_SESSION['csrf_token'][$key]);
    }

    /* Description: Deletes all CSRF related cookies from the browser.
     * Pre-Condition: None.
     * Post-Condition: None.
     * Return: All CSRF cookies are deleted.
     */
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
