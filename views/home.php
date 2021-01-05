<?php 

require_once("head.php"); ?>
  
  <section class="section">
    <div class="container">

      <h1 class="title">
        <?php echo $pageTitle; ?>
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
    </div>
  </section>
  <?php 
  
  require_once("footer.php"); ?>