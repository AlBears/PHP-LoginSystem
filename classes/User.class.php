<?php

class User
{

  public static function signup($data)

  {
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
}
