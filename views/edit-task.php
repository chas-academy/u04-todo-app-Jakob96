<?php 

require_once("head.php"); ?>
  
  <section class="section">
    <div class="container">
      <h1 class="title">
        <?php echo $pageTitle; ?>
      </h1>

    <form method="POST" action="/updateTodoListTask">
    <input type="hidden" name="listid" value="<?php echo $_GET["listid"]; ?>" />
    <input type="hidden" name="taskid" value="<?php echo $_GET["taskid"]; ?>" />
      <div class="field">
       <label class="label">Titel</label>
       <div class="control">
        <input class="input" name="tasktitle" type="text" placeholder="Aktivitetens namn" value="<?php echo $task[0]["title"]; ?>" required>
        </div>
      </div>
      <div class="field">
        <label class="label">Beskrivning (ej obligatorisk)</label>
        <div class="control">
          <textarea class="textarea" name="taskdescription" placeholder="Beskriv aktiviteten i detalj om du vill"><?php echo $task[0]["description"]; ?></textarea>
        </div>
      </div>
      <div class="field">
        <label class="label">Måldatum</label>
        <div class="control">
        <input type="date" name="dueDate" value="<?php echo $task[0]["dueDate"]; ?>">
        </div>
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Spara</button>
          <a class="button is-link" href="<?php echo "/edit-list?listid=" . $_GET["listid"]; ?>">Avbryt</a>
        </div>
      </div>
    </form>
    </div>
  </section>
  <?php 
  
  require_once("footer.php"); ?>