<div class="container-fluid px-4 py-5 my-5 text-center">
  <div class="lc-block col-lg-6 mx-auto">
    <div>
      <p class="lead fw-bold"><?= $translation['title'] ?></p>
    </div>
  </div>
  <div class="lc-block">
    <div>
      <h1 class="fw-bold display-4"><?= $translation['welcome'] ?></h1>
    </div>
  </div>
  <div class="lc-block  mx-auto">
    <div>
      <a href="https://github.com/AbdelrhmanEssam74/MVCStructure/blob/master/README.md" target="_blank"
        class="btn btn-primary btn-lg"><?= $translation['document-btn'] ?></a>
    </div>
  </div>
</div>
<?php include view_path() . 'partials/footer.php' ?>