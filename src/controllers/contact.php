<?php
  include(BASE_DIR . "/src/models/offer.php");
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $offer = findOffer($_POST['id']);
    if (!$offer) {
      throw new Exception("Cette proposition n'existe pas!", 404);
    }

    $target_user = findUser($offer['author_username']);
    if (!$offer) {
      throw new Exception("L'auteur s'est désinscrit!", 404);
    }

    $message = $_POST['msg'];
    if (empty(trim($message))) {
      throw new Exception("Vous devez remplir un message!", 400);
    }

    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    if (!$token || $token !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    } else {
      $body = "Bonjour {$target_user['name']},\n\nVoici un message concernant votre annonce: {$offer['address']} - {$offer['available_on']}\n\n{$message}";
      $headers = "From: no-reply@kolok.com\r\n";
      if ($current_user) {
        $headers .= "Reply-To: {$current_user['email']}\r\n";
      }
  
      mail($target_user['email'], "Demande de contact pour votre annonce chez kolok", $body, $headers);
      
      header("Location: /");
      exit;
    }
    
   
  }
