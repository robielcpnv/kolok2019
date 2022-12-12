<?php
include(BASE_DIR . "/src/models/user.php");

function getCurrentUser() {
  return isset($_SESSION['current_user']) ? findUser($_SESSION['current_user']) : null;
}

function loginUser($username, $password) {
  if ($user = findUser($username)) {
    // Check credential
    if (password_verify($password, $user['password'])){
      $_SESSION['current_user'] = $user['username'];
      $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    }else
      $user = null;
  }
  return $user;
}

function logoutUser() {
  unset($_SESSION['current_user']);
}

