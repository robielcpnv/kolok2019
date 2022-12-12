<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include(BASE_DIR . "/src/models/offer.php");

    // Grab the offer
    $offer_id = $_GET['id'];
    $offer = findOffer($offer_id);
    if (!$offer) {
      throw new Exception("Cette proposition n'existe pas!", 404);
    }

    // Check if authenticated user is the owner
    if ($current_user['username'] != $offer['author_username']) {
      throw new Exception("Vous n'êtes pas l'auteur de cette proposition!", 403);
    }

    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    if (!$token || $token !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    } else {
      // Destroy the offer
      if (!destroyOffer($offer_id)) {
        throw new Exception("La suppression de cette proposition a échouée.", 500);
      }

      
      header("Location: " . BASE_URL ."?page=user_offers&user=" . $current_user['username']);
      exit;
    }  
  }
