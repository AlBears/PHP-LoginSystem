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
    $_SESSION = array();
    session_destroy();
  }

  /**
  * Login a user
  *
  * @param string $email     Email address
  * @param string $password  Password
  * @return boolean          true if the new user record was saved successfully, false otherwise
  */
  public function login($email, $password)

  {
    $user = User::authenticate($email, $password);

    if ($user !== null) {
      $this->_currentUser = $user;

      //store user id in the session
      $_SESSION['user_id'] = $user->id;

      session_regenerate_id();

      return true;
    }

    return false;
  }


  /**
   * Get the current logged in user
   *
   * @return mixed  User object if logged in, null otherwise
   */
  public function getCurrentUser()
  {
    if ($this->_currentUser === null) {
      if (isset($_SESSION['user_id'])) {

        // Cache the object so that in a single request the data is loaded from the database only once.
        $this->_currentUser = User::findByID($_SESSION['user_id']);
      }
    }

    return $this->_currentUser;
  }

  /**
   * Boolean indicator of whether the user is logged in or not
   *
   * @return boolean
   */
  public function isLoggedIn()
  {
    return $this->getCurrentUser() !== null;
  }

  /**
   * Redirect to the login if user is not logged in
   *
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


}
