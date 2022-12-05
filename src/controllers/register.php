<?php
  // Process POST request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = trim($_POST['username']);
    $name      = trim($_POST['name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];

    // Validate fields
    if (strlen($username) < 3) {
      $username_error = "Votre identifiant doit contenir au moins 3 caractères";
    }
    if (!preg_match("/^\w+$/", $username)) {
      $username_error = "Votre identifiant ne doit contenir que des caractères alphanumériques";
    }
    if (findUser($username)) {
      $username_error = "Votre identifiant est déjà pris";
    }
    if (!preg_match("/^\S+@\S+$/", $email)) {
      $email_error = "Votre adresse email doit être valide";
    }
    if (strlen($password) < 8) {
      $password_error = "Votre mot de passe doit contenir au moins 8 caractères";
    }
    if (strlen($name) < 3) {
      $name_error = "Votre nom doit contenir au moins 3 caractères";
    }

    // Valid?
    if (!isset($username_error) && !isset($password_error) && !isset($name_error)) {
      // Yep, setup the user and register it
      $user = [
        'username' => $username,
        'password' => $password,
        'name'     => $name
      ];
      registerUser($user);
      
      // Directly login the user
      loginUser($username, $password);
      
      header('Location: /');
      exit;
    }
  }
