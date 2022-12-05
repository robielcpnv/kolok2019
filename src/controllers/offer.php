<?php
  include(BASE_DIR . "/src/models/offer.php");

  $offer_id = $_GET['id'];
  $offer = findOffer($offer_id);
  if (!$offer) {
    throw new Exception("Cette proposition n'existe pas!", 404);
  }
