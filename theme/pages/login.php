<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />

  <script src="https://kit.fontawesome.com/718e42f4f3.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

  <!-- SCRIPTS -->
  <script src="<?= assets("/js/jQuery.min.js"); ?>"></script>
  <script src="<?= assets("/js/jquery-ui.min.js"); ?>"></script>
  <script src="<?= assets("/js/login.js"); ?>"></script>
  <script src="<?= assets("/js/dashboard.js"); ?>"></script>

  <!-- STYLES -->
  <link rel="stylesheet" href="<?= assets("/css/login.style.css"); ?>" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet" />

  <title><?= $title ?? 'TotalApps' ?></title>
</head>

<body>
  <div id="message"></div>

  <div class="container">
    <div class="content-login">
      <div class="header">
        Bem Vindo
      </div>
      <div class="body">
        <form action="<?= $router->route("web.authenticate"); ?>" id="login" method="post">
          <div class="row-input">
            <i class="material-icons">email</i>
            <input type="text" placeholder="Email" name="email" id="email" autocomplete="off" required />
          </div>
          <div class="row-input">
            <i class="material-icons">lock</i>
            <input type="password" placeholder="Password" id="password" name="password" required />
          </div>
          <div class="row-input">
            <i class="material-icons">input</i>
            <input type="submit" value="Entrar" />
          </div>
          <div class="row-two-coluns">
            <table>
              <tr>
                <td><a href="#">Não possui uma conta?</a></td>
                <td><a href="#">Esqueceu sua senha?</a></td>
              </tr>
            </table>
          </div>
          <div class="row-input"></div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>