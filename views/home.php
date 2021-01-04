<?php require_once("head.php"); ?>
  
  <section class="section">
    <div class="container">

    <?php if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) { ?>
      <h1 class="title">
        Mina aktiviteter
      </h1>

      <h2 class="subtitle">
        Idag
      </h2>
      <ul class="tasks">
     
        <?php if ($tasks) {
          foreach($todayTasks as $task) { ?>
          <li>
            <h3 class="subtitle is-3"><?php echo $task["title"]; ?></h3>
            <p><?php echo nl2br($task["description"]); ?></p>
          </li>
       <?php }
        }
        else {
          echo "<p class=\"has-text-centered mb-3\">Du har inga aktiviteter ännu.</p>";
        }  ?>
      </ul>
     
      <?php } else {  ?>

      <h1 class="title">
        Logga in
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
      <?php } ?>
    </div>
  </section>
  </body>
</html>