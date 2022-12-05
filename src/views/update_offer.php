<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <h1>Modifier la proposition</h1>
    <?php $submit_caption = "Modifier"; include(BASE_DIR . "/src/views/_offer_form.php"); ?>
    
    <h2>Photos</h2>
    <?php foreach ($offer['images'] as $image): ?>
      <div class="col-md-2 col-sm-3 col-xs-4">
        <div class="thumbnail image-item">
          <img class="img-responsive" src="<?= $image ?>" />
          <form class="caption text-center" action="<?= BASE_URL;?>?page=destroy_image&id=<?= $offer_id ?>&image=<?= $image ?>" method="POST">
          <button type="submit" class="btn btn-danger" <?= count($offer['images']) == 1 ? 'disabled="disabled"' : '' ?>>Supprimer</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
