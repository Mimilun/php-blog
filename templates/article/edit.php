<?php include __DIR__ . '/../header.php'; ?>
<?php $title = 'Редактирование статьи' ?>
  <section>
    <div class="row">
      <div class="col">
        <form action="/articles/<?= $article->getId() ?>/edit/" method="post">
          <div class="card">
            <div class="card-header">
              <div class="mb-3">
                <h5 class="card-title">
                  <label for="nameStory" class="form-label">Название статьи:</label>
                  <input type="text" name="nameStory" value="<?= $article->getName() ?>" class="form-control"
                         id="nameStory" placeholder="name">
                </h5>
              </div>
            </div>
            <div class="card-body text-start">
              <div class="mb-3">
                <label for="contentStory" class="form-label">Содержание статьи:</label>
                <textarea name="contentStory" class="form-control" id="contentStory"
                          rows="3"><?= $article->getText() ?></textarea>
              </div>
            </div>
            <button type="submit" name="submit">Сохранить</button>
          </div>
        </form>
      </div>
    </div>
  </section>

<?php include_once __DIR__ . '/../footer.php'; ?>