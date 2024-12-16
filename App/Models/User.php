<?php

namespace App\Models;


class User extends Model
{
  private $user_id;
  private $full_name;
  private $username;
  private $email;
  private $password;
  private $active;
  private $created_at;
  public static function getUserData($id = null)
  { // Fetch user data
    $userData = User::where(['user_id', '=', $id], '*');
    $data = array(
      'user_id' => $userData[0]->user_id,
      'full_name' => $userData[0]->full_name,
      'username' => $userData[0]->username,
      'email' => $userData[0]->email,
    );
    return $data;
  }
}
