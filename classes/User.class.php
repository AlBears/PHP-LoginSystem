<?php

class User
{
  public $errors;

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
