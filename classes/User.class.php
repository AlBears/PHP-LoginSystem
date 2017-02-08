<?php

class User
{
  public $errors;
  /**
   * Authenticate a user by email and password
   *
   * @param string $email     Email address
   * @param string $password  Password
   * @return mixed            User object if authenticated correctly, null otherwise
   */
  public static function authenticate($email, $password)

  {
    $user = static::findByEmail($email);

    if ($user !== null) {

      if (Hash::check($password, $user->password)) {
        return $user;
      }
    }
  }

  /**
   * Find the user with the specified email address
   *
   * @param string $email  email address
   * @return mixed         User object if found, null otherwise
   */
  public static function findByEmail($email)

  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
      $stmt->execute([':email' => $email]);
      $user = $stmt->fetchObject('User');

      if ($user !== false) {
        return $user;
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }

  /**
   * Find the user with the specified ID
   *
   * @param string $id  ID
   * @return mixed      User object if found, null otherwise
   */
  public static function findByID($id)
  {
    try {

      $db = Database::getInstance();

      $stmt = $db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
      $stmt->execute([':id' => $id]);
      $user = $stmt->fetchObject('User');

      if ($user !== false) {
        return $user;
      }

    } catch(PDOException $exception) {

      error_log($exception->getMessage());
    }
  }

  /**
   * Signup a new user
   *
   * @param array $data  POST data
   * @return User
   */
  public static function signup($data)

  {
    $user = new static();

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->password = $data['password'];

    if ($user->isValid()) {

    try {
      $db = Database::getInstance();

      $stmt = $db->prepare('INSERT INTO users (name, email, password)
                            VALUES (:name, :email, :password)');

      $stmt->bindParam(':name', $data['name']);
      $stmt->bindParam(':email', $data['email']);
      $stmt->bindParam(':password', Hash::make($data['password']));
      $stmt->execute();
    } catch(PDOException $exception) {
      error_log($exception->getMessage());
    }
  }
   return $user;
 }

 public function isValid()

 {
   $this->errors = [];

  /* Name validation */
   if($this->name == '') {
     $this->errors['name'] = 'Please enter a valid email address';
   }
   /* Email validation - email type*/
   if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
     $this->errors['email'] = 'Please enter a valid email address';
   }
   /* Email validation - is email arlready taken?*/
   if ($this->emailExists($this->email)) {
     $this->errors['email'] = 'That email address is already taken';
   }
   /* Password validation - minimum symbols*/
   if (strlen($this->password) < 5) {
     $this->errors['password'] = 'Please enter a longer password';
   }
   /* Check whether errors array is empty and return boolean */
   return empty($this->errors);
 }

 public function emailExists($email)

 {
   try {
     $db = Database::getInstance();

      $stmt = $db->prepare('SELECT COUNT(*) FROM
                        users WHERE email = :email
                        LIMIT 1');

      $stmt->execute([':email' => $this->email]);
      $rowCount = $stmt->fetchColumn();
      return $rowCount == 1;

   } catch (PDOException $exception) {
     error_log($exception->getMessage());
     return false;
   }
 }
}
