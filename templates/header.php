<?php

use mimilun\models\Users\UserAuthService;

?>
<!doctype html>
<html lang="ru" class="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <title><?= $title ?? '' ?></title>
</head>
<body>
<div class="container-xxl bg-light">
  <header class="header mb-1">
    <div class="row align-items-center">
      <div class="col-2 text-center">
        <a href="/" class="fs-1 text-success">LOGO</a>
      </div>
      <nav class="col-8 navbar navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-wight" id="navbarNav">
          <ul class="navbar-nav justify-content-around nav-wight">
            <li class="nav-item">
              <a class="nav-link" href="/articles">Статьи</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/about">Обо мне</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contacts">Контакты</a>
            </li>
          </ul>
        </div>
      </nav>
        <?php if ($user): ?>
          <div class="col-2 text-center">
            <h6>Привет, <?= $user->getNickName() ?>!</h6>
            <a class="nav-link text-success" href="/users/logout">Выход</a>
          </div>
        <?php else: ?>
          <div class="col-2 text-center">
            <a class="nav-link text-success" href="/users/login">Вход</a>
            <a class="nav-link text-success" href="/users/register">Регистрация</a>
          </div>
        <?php endif; ?>
    </div>
    <div class="horizontal-line "></div>
  </header>
  <main>
    <section>
      <div class="row">
        <aside class="col-2">
          <p>Левая Колонка</p>
          <div class="left-column">
          </div>
        </aside>
        <div class="col-8 mt-4 mb-5">
          <h1 class="card-title text-center mb-5"><?= $title ?? '' ?></h1>