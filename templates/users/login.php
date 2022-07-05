<?php $title = 'Вход' ?>
<?php include __DIR__ . '/../header.php'; ?>

  <section>
    <div class="container">
      <div class="row">
        <form action="/users/login" method="post">
          <div class="col-6">
            <div class="mb-3 text-center text-bg-danger"><?= $error ?? '' ?></div>
            <div class="mb-3">
              <label for="login" class="form-label">Login</label>
              <input type="text" name="login" class="form-control" id="login" value="<?= $_POST['login'] ?? '' ?>">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="pass" class="form-control" id="password">
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" name="remember" class="form-check-input"
                     id="remember" <?php if (isset($_POST['remember']))
                  echo 'checked' ?>>
              <label class="form-check-label" for="remember">Запомнить меня</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Войти</button>
        </form>
      </div>
    </div>
  </section>

<?php include_once __DIR__ . '/../footer.php'; ?>