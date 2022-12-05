<?php
  // Process POST request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address      = trim($_POST['address']);
    $description  = trim($_POST['description']);
    $available_on = trim($_POST['available_on']);

    // Validate fields
    if (empty($address)) {
      $address_error = "L'adresse doit être remplie";
    }
    if (empty($description)) {
      $description_error = "La description doit être remplie";
    }
    if (!preg_match("/^20\d\d-\d\d-\d\d$/", $available_on)) {
      $available_on_error = "La date de disponibilité est invalide";
    }
    else {
      if ($available_on < date('Y-m-d')) {
        $available_on_error = "La date de disponibilité doit être dans le futur";
      }
    }

    // Fill the offer
    $offer['address'] = $address;
    $offer['description'] = $description;
    $offer['available_on'] = $available_on;
    $offer['author_username'] = $current_user['username'];

    // Valid?
    return !(isset($address_error) || isset($description_error) || isset($available_on_error));
  }
  
  // GET request, pass through
  return false;
