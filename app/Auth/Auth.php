<?php

namespace App\Auth;

use App\Models\User;
use App\Models\Flutter;

class Auth
{

  public function user()
  {
    if (isset($_SESSION['user'])) {
      return User::find($_SESSION['user']);
    }
  }

  public function flutter()
  {
    if (isset($_SESSION['flutter'])) {
      return Flutter::all()->where('user_id', $_SESSION['user']);
    }
  }

  public function check()
  {
    $userIsSet = isset($_SESSION['user']);
    $flutterIsSet = isset($_SESSION['flutter']);
    return [$userIsSet, $flutterIsSet];
  }

  public function attemptSignIn($email, $password)
  {
    $user = User::where('email', $email)->first();

    if (!$user) {
      return false;
    }

    if (password_verify($password, $user->password)) {
      $_SESSION['user'] = $user->id;

      return true;
    }

    return false;
  }

  public function signOut()
  {
    unset($_SESSION['user']);
  }
}
