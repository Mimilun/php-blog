<?php $title = 'Регистрация'?>
<?php include __DIR__ . '/../header.php';?>

<section>
  <div class="container">
    <div class="row">
      <form action="/users/register" method="post">
        <div class="col-6">
          <div class="mb-3 text-center text-bg-danger"><?= $error ?? '' ?></div>
          <div class="mb-3">
            <label for="exampleInputLogun" class="form-label">Login</label>
            <input type="text" name="name" class="form-control" id="exampleInputLogun" value="<?= $_POST['name'] ?? '' ?>">
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="<?= $_POST['email'] ?? '' ?>">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3">
            <label for="exampleConfirmPassword1" class="form-label">Confirm Password</label>
            <input type="password" name="pass_confirm" class="form-control" id="exampleConfirmPassword1">
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Зарегистрироваться</button>
      </form>
    </div>
  </div>
</section>

<?php include_once __DIR__ . '/../footer.php';?>