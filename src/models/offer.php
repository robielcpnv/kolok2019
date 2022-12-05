<?php

include(BASE_DIR . "/src/libs/file.php");

/**
 ** Offer:
 **   (published_on:     string    Date of publication formatted YYYY-MM-DD)
 **   address:          string    Address of the room
 **   description:      string    Description of the offer
 **   available_on:     string    Date of room availability formatted the locale way
 **   author_username:  string    `username` of the offer author
 **   images:           string[]  Relative paths of images for the offer
 **
 **/

// Returns an assoc, each key is the offer id, the value is the offer `object` (structure above)
function findAllOffers() {
  return findUserOffers("*");
}

// Returns an assoc, each key is the offer id, the value is the offer `object` (structure above)
function findUserOffers($username) {
  // Glob all offers directories
  $offers_dirs = glob(BASE_DIR . "/data/users/" . $username . "/offers/*");

  // Sort by most recent publication date (the dir names are the publication date!)
  usort($offers_dirs, function($a, $b) { return strcmp(basename($b), basename($a)); });

  // Create the array of `offer` objects
  $offers = [];
  foreach ($offers_dirs as $dir) {
    $id = offerPathToId($dir);

    // Push to the offers collection by its id
    $offers[$id] = findOffer($id);
  }
  
  return $offers;
}

// function to find a specific offer, returns null if not found
function findOffer($id) {
  try {
    $dir = offerIdToPath($id);
    
    // Read the offer base data
    $offer = json_decode(file_get_contents($dir . "/data.json"), true);

    // Extract the author name from $dir
    preg_match("~/users/(.+?)/offers/~", $dir, $matches);
    $offer['author_username'] = $matches[1];

    // Grab all images
    $offer['images'] = array_map(function($item) { return substr($item, strlen(BASE_DIR)); }, glob($dir . "/images/*"));
    
    return $offer;
  }
  catch (Exception $e) {
    // Any error leads to 'not found'
    return null;
  }
}

// Create a new offer
// @return the offer id or FALSE if failed.
function createOffer($offer) {
  $today = date('Y-m-d');
  $id = "{$offer['author_username']}/offers/{$today}";
  if (!saveOffer($id, $offer)) {
    return false;
  }
  return $id;
}

// Save the offer (it's fields)
function saveOffer($id, $offer) {
  try {
    $dir = offerIdToPath($id);
    if (!is_dir($dir . "/images")) {
      mkdir($dir . "/images", 0777, true);
    }
    return file_put_contents($dir . "/data.json", json_encode($offer));
  }
  catch (Exception $e) {
    return false;
  }
}

// Destroys an offer, no way back!
// @return bool true if destroyed, false if not.
function destroyOffer($id) {
  try {
    return deleteDir(offerIdToPath($id));
  }
  catch (Exception $e) {
    return false;
  }
}

// Transforms an offer id to its path
function offerIdToPath($id) {
  return BASE_DIR . "/data/users/" . $id;
}

// Transforms an offer path to its id
function offerPathToId($dir) {
  preg_match("~/users/(.+)$~", $dir, $matches);
  return $matches[1];
}
