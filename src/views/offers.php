<?php include(BASE_DIR . "/src/models/offer.php"); ?>
<div class="row">
  <div class="col-md-12">
    <h1>Propositions actuelles</h1>
    <div class="row">
    <?php foreach (findAllOffers() as $id => $offer): ?>
      <div class="col-md-3 col-sm-4 col-xs-6">
        <div class="thumbnail offer-item">
          <a href="<?= BASE_URL;?>?page=offer&id=<?= $id ?>"><img class="img-responsive" src="<?= $offer['images'][0] ?>" /></a>
          <div class="caption text-center">
            <h3>Dès le <span class="available_date"><?= htmlspecialchars($offer['available_on']) ?></span></h3>
            <p><span class="user"><span class="glyphicon glyphicon-user"></span> <a href="<?= BASE_URL;?>?page=user_offers&user=<?= htmlspecialchars($offer['author_username']) ?>"><?= htmlspecialchars($offer['author_username']) ?></a></span></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
</div>
