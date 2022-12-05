<?php

define('USER_DIR', BASE_DIR . "/data/users");
define('USER_DATA_FILENAME', "user.json");

/**
 ** User:
 **   username: string  User identifier
 **   name:     string  Display name 
 **   password: string  Hashed password
 **   email:    string  Email address for contact purpose
 **
 **/

function findUser($username) {
  // Read the user.dat file for the passed $username
  try {
    return json_decode(file_get_contents(USER_DIR . "/$username/" . USER_DATA_FILENAME), true);
  }
  catch (Exception $e) {
    // Any error will return a null object, so asking for a non existant user throws a PATH_NOT_FOUND error thus returns null.
    return null;
  }
}

function saveUser($user) {
  $username = $user['username'];
  mkdir(USER_DIR . "/$username");
  file_put_contents(USER_DIR . "/$username/" . USER_DATA_FILENAME, json_encode($user));
}

function registerUser($user) {
  $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
  return saveUser($user);
}
