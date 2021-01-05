<?php 

require_once("head.php"); ?>
  
  <section class="section">
    <div class="container">

      <h1 class="title">
        <?php echo $pageTitle; ?>
      </h1>

      <form method="POST" action="/signIn">
      <div class="notification is-primary">
        <p>Ange din email-adress för att få tillgång till dina listor.</p>
        <p><strong>Ny användare?</strong> Ange din email så skapas ett nytt konto.</p>
      </div>

      <div class="field">
        <label class="label">Email</label>
        <div class="control">
          <input type="email" required name="email" class="input" placeholder="mail@gmail.com">
        </div>
      </div>

      <button class="button is-primary" type="submit">Logga in</button>
      </form>
    </div>
  </section>
  <?php 
  
  require_once("footer.php"); ?>