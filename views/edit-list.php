<?php require_once("head.php"); ?>
  <section class="section">
    <div class="container">
      <h1 class="title">
        <?php if (!empty($list)) { echo $list["title"]; } ?>
      </h1>
      <p class="subtitle">
      <?php if (!empty($list)) { echo $list["description"]; } ?>
      <div class="buttons is-right">
      <button class="button is-info allTasksDone" value="<?php echo $list["ID"]; ?>">Klarmarkera alla aktiviteter</button>
      <button class="button is-warning deleteDoneTasks" value="<?php echo $list["ID"]; ?>">Ta bort klara aktiviteter</button>
      <button class="button is-danger listDelete" value="<?php echo $list["ID"]; ?>" aria-label="Ta bort listan">
              <i class="fas fa-trash mr-1"></i>Ta bort listan
      </button>
  </div>
      </p>

      <ul class="tasks">
        <?php if ($tasks) {
          foreach($tasks as $task) { ?>
          <li id="<?php echo "task".$task["ID"]; ?>"><div class="buttons is-right">
            <a class="button is-active is-rounded" href="<?php echo "/edit-task?taskid=".$task["ID"] . "&listid=".$_GET["listid"]; ?>" aria-label="Ändra denna aktivitet">
              <i class="far fa-edit"></i>
            </a>
            <button class="button is-danger is-rounded taskDelete" value="<?php echo $task["ID"]; ?>" aria-label="Ta bort denna aktivitet">
              <i class="fas fa-trash"></i>
          </button>
          </div>
            <h3 class="subtitle is-3"><?php echo $task["title"]; ?></h3>
            <p><?php echo nl2br($task["description"]); ?></p>
            <time datetime="<?php echo $task["dueDate"]; ?>">Måldatum: <?php echo $task["dueDate"]; ?></time>

            <div class="is-divider"></div>
            <div class="field">
              <input id="switch<?php echo $task["ID"]; ?>" type="checkbox" value="<?php echo $task["ID"]; ?>" name="switch<?php echo $task["ID"]; ?>" class="switch toggleDone" <?php echo ($task["done"] == 1) ? "checked" : ""; ?>>
              <label for="switch<?php echo $task["ID"]; ?>">Markera som klar</label>
          </div>
          </li>
       <?php }
        }
        else {
          echo "<p class=\"has-text-centered mb-3\">Du har inga aktiviteter ännu.</p>";
        }  ?>
      </ul>
      <div class="buttons is-centered">
      <a class="button is-primary " href="<?php echo "/add-task?listid=" . $_GET["listid"]; ?>"><i class="fas fa-plus mr-1"></i> Lägg till ny aktivitet</a>
      </div>
    </div>
  </section>
  </body>
</html>