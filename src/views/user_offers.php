<?php
  include(BASE_DIR . "/src/models/offer.php");
  
  $user = isset($_GET['user']) ? findUser($_GET['user']) : $current_user;
  if (!$user) $user = $current_user;
  
  $detail_page = ($user == $current_user) ? 'update_offer' : 'offer';
?>
<div class="row">
  <div class="col-md-12">
    <h1>Propositions de <?= htmlspecialchars($user['name']) ?></h1>
    <div class="row">
    <?php foreach (findUserOffers($user['username']) as $id => $offer): ?>
      <div class="col-md-3 col-sm-4 col-xs-6">
        <div class="thumbnail offer-item">
          <a href="<?= BASE_URL;?>?page=<?= $detail_page ?>&id=<?= $id ?>"><img class="img-responsive" src="<?= htmlspecialchars($offer['images'][0]) ?>" /></a>
          <div class="caption text-center">
            <h3>Dès le <span class="available_date"><?= $offer['available_on'] ?></span></h3>
            <?php if ($user == $current_user): ?>
              <form action="<?= BASE_URL;?>?page=destroy_offer&id=<?= $id ?>" method="POST">
              <button type="submit" class="btn btn-danger">Supprimer</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
