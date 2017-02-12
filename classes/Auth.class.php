<?php

class Auth

{
  private static $_instance;

  private $_currentUser;

  public static function init()
  {
    session_start();
  }

  public static function getInstance()
  {
    if (static::$_instance === NULL) {
      static::$_instance = new Auth();
    }

    return static::$_instance;
  }

  /**
  * Logout a user
  * @return void
  */
  public function logout()
  {
    if (isset($_COOKIE['remember_token'])) {

      $this->getCurrentUser()->forgetLogin(sha1($_COOKIE['remember_token']));

      //time in the past will cause cookie to be erased
      setcookie('remember_token', '', time() - 3600);
    }
    $_SESSION = array();
    session_destroy();
  }

  /**
  * Login a user
  *
  * @param string $email     Email address
  * @param string $password  Password
  * @param boolean $remember_me Remember flag
  * @return boolean          true if the new user record was saved successfully, false otherwise
  */
  public function login($email, $password, $remember_me)

  {
    $user = User::authenticate($email, $password);

    if ($user !== null) {
      $this->_currentUser = $user;

      $this->_loginUser($user);

      //Remember the login
      if ($remember_me) {
        $expiry = time() + 60 * 60 * 24 * 30; //30 days from now
        $token = $user->rememberLogin($expiry);

        if ($token !== false) {
          setcookie('remember_token', $token, $expiry);
        }
      }

      return true;
    }

    return false;
  }

  /**
   * Get the current logged in user
   * @return mixed  User object if logged in, null otherwise
   */
  public function getCurrentUser()
  {
    if ($this->_currentUser === null) {
      if (isset($_SESSION['user_id'])) {

        // Cache the object so that in a single request the data is loaded from the database only once.
        $this->_currentUser = User::findByID($_SESSION['user_id']);

      } else {
        //if session user id is not set we retrieve data from cookie
        $this->_currentUser = $this->_loginFromCookie();

      }
    }

    return $this->_currentUser;
  }

  /**
   * Boolean indicator of whether the user is logged in or not
   * @return boolean
   */
  public function isLoggedIn()
  {
    return $this->getCurrentUser() !== null;
  }

  /**
   * Redirect to the login if user is not logged in
   * @return void
   */
   public function requireLogin()
   {
     if (! $this->isLoggedIn()) {

       //we save page user tried to view to Session
       $url = $_SERVER['REQUEST_URI'];
       if (! empty($url)) {
         $_SESSION['return_to'] = $url;
       }

       Util::redirect('/login.php');
     }
   }

   public function requireGuest()
   {
     if ($this->isLoggedIn()) {
       Util::redirect('/index.php');
     }
   }

  /**
  * Send the user password reset email
  * @param string $email  Email address
  * @return void
  */
 public function sendPasswordReset($email)
 {
   $user = User::findByEmail($email);

   if ($user !== null) {

     if ($user->startPasswordReset()) {

       // Note hardcoded protocol
       $url = 'http://'.$_SERVER['HTTP_HOST'].'/reset_password.php?token=' . $user->password_reset_token;

       $body = <<<EOT

<p>Please click on the following link to reset your password.</p>

<p><a href="$url">$url</a></p>

EOT;

       Mail::send($user->name, $user->email, 'Password reset', $body);
     }
   }
 }

 /**
 * Wheterr user is logged in and has admin rights
 * @return boolean
 */

 public function isAdmin()
 {
   return $this->isLoggedIn() && $this->getCurrentUser()->is_admin;
 }

 private function _loginFromCookie()
   {
     if (isset($_COOKIE['remember_token'])) {

     $user = User::findByRememberToken(sha1($_COOKIE['remember_token']));
     if ($user !== null) {
       $this->_loginUser($user);

       return $user;
     }
   }
   }
   /**
   * Login the user to the session
   * @param User $user  User object
   * @return void
   */
   private function _loginUser($user)
   {
     $_SESSION['user_id'] = $user->id;

     session_regenerate_id();
   }

}
