<?php
  // Process POST request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = trim($_POST['username']);
    $password  = $_POST['password'];

    // Validate fields
    if (empty($username)) {
      $username_error = "Votre identifiant ne doit pas être vide";
    }
    if (!preg_match("/^\w+$/", $username)) {
      $username_error = "Votre identifiant ne doit contenir que des caractères alphanumériques";
    }
    if (empty($password)) {
      $password_error = "Votre mot de passe ne doit pas être vide";
    }

    // Valid?
    if (!isset($username_error) && !isset($password_error)) {
      // Yep, login the user
      if (loginUser($username, $password)) {
        header('Location: /');
        exit;
      }
      $login_error = "Votre identifiant et/ou mot de passe sont erronés";
    }
  }
