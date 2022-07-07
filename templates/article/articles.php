<?php $title = 'Статьи' ?>
<?php include __DIR__ . '/../header.php' ?>

<?php foreach ($articles as $article): ?>
  <div>
    <h2 class="ps-3"><a href="/articles/<?= $article->id ?>"><?= $article->name ?></a></h2>
    <p class="ps-2"><?= $article->getDate() ?></p>
    <p><?= mb_substr($article->text, 0, 300) . ' ...........' ?></p>
    <hr>
  </div>
<?php endforeach; ?>

<?php include_once __DIR__ . '/../footer.php' ?>