<?php $title = 'Статьи' ?>
<?php include __DIR__ . '/../header.php' ?>

<?php foreach ($articles as $article): ?>
    <div>
        <h2 class="ps-3"><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
        <p><?= mb_substr($article->getText(), 0, 300) . ' ...........' ?></p>
        <hr>
    </div>
<?php endforeach; ?>

<?php include_once __DIR__ . '/../footer.php' ?>