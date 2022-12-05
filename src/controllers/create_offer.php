<?php
  include(BASE_DIR . "/src/models/offer.php");

  // Create an empty offer
  $offer = ['available_on' => '', 'address' => '', 'description' => ''];
  
  if (include(BASE_DIR . "/src/controllers/_offer_form.php")) {
    // Validate images count
    if (0 == array_reduce($_FILES['images']['tmp_name'], function($memo, $name) { return $memo + empty($name) ? 0 : 1; }, 0)) {
      $images_error = "Vous devez joindre au minimum une photo";
      return;
    }
    
    // Store the offer
    if ($id = createOffer($offer)) {
      // Now move the uploaded images
      $images_dir = offerIdToPath($id) . "/images/";
      foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
        if (empty($tmp_name)) continue;
        
        $name = $_FILES['images']['name'][$index];
        move_uploaded_file($tmp_name, $images_dir . $name);
      }
      
      header("Location: " . BASE_URL ."?page=offer&id=" . $id);
      exit;
    }
    else {
      throw new Exception("Impossible d'ajouter la nouvelle proposition!", 500);
    }
  }
