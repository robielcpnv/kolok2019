<?php
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
  
  if (include(BASE_DIR . "/src/controllers/_offer_form.php")) {
    // Store the offer
    if (saveOffer($offer_id, $offer)) {
      // Now move the uploaded images
      $images_dir = offerIdToPath($offer_id) . "/images/";
      foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
        if (empty($tmp_name)) continue;
        
        $name = $_FILES['images']['name'][$index];
        move_uploaded_file($tmp_name, $images_dir . $name);
      }
      
      header("Location: " . BASE_URL ."?page=offer&id=" . $offer_id);
      exit;
    }
    else {
      throw new Exception("Impossible de modifier cette proposition!", 500);
    }
  }
