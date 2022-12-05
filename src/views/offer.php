<div class="row">
  <div class="col-md-6">
    <h1><?= $offer['available_on'] ?></h1>
    <div class="panel panel-default">
      <div class="panel-body infos">
        <span><span class="glyphicon glyphicon-map-marker"></span> <?= $offer['address'] ?></span>
        <span class="pull-right"><span class="glyphicon glyphicon-user"></span> <a href="<?= BASE_URL;?>?page=user_offers&user=<?= $offer['author_username'] ?>"><?= $offer['author_username'] ?></a></span>
      </div>
    </div>
    <p class="description lead bg-info alert"><?= nl2br($offer['description']) ?></p>
  </div>
  <div class="col-md-6">
    <h2>Contacter l'auteur</h2>
    <form class="" action="<?= BASE_URL;?>?page=contact&id=<?= $offer_id ?>" method="POST">
      <div class="form-group">
        <textarea class="form-control" rows="8" placeholder="Votre message" name="msg"></textarea>
      </div>
      <input type="hidden" name="id" value="<?= $offer_id ?>">
      <p>N'oubliez pas d'indiquer vos coordonnées dans le message</p>
      <button type="submit" class="btn btn-default btn-primary">Envoyer</button>
    </form>
  </div>
</div>
<div class="row">
  <?php foreach ($offer['images'] as $image): ?>
    <a href="<?= $image ?>" data-toggle="lightbox" data-gallery="offer-gallery" class="col-md-2 col-sm-3 col-xs-4">
      <img class="img-responsive img-thumbnail" src="<?= $image ?>" />
    </a>
  <?php endforeach; ?>
</div>
