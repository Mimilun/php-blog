<?php include __DIR__ . '/../header.php'; ?>

  <section>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title"><?= $article->getName() ?></h5>
          </div>
          <div class="card-body text-start">
              <?= $article->getText() ?>
          </div>
          <div class="card-footer text-start">
              <?= 'Автор: ' . $article->getAuthor()
                                      ->getNickName() ?>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php include_once __DIR__ . '/../footer.php'; ?>