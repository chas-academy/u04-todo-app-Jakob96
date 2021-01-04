<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulma ToDo App</title>
    <link rel="stylesheet" href="/views/css/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    <script defer src="/views/js/script.js"></script>
  </head>
  <body>
  <nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <?php if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) { ?>
  <div class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="/show-lists">
        Mina listor
      </a>
      <a class="navbar-item" href="/signOut">
        Logga ut
      </a>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary" href="/create-list">
          <i class="fas fa-plus mr-1"></i> <strong>Skapa ny lista</strong>
          </a>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</nav>