<?php 

require_once("head.php"); ?>
  
  <section class="section">
    <div class="container">
      <h1 class="title">
        <?php echo $pageTitle; ?>
      </h1>

    <form method="POST" action="/addTodoListTask">
    <input type="hidden" name="listid" value="<?php echo $_GET["listid"]; ?>" />
      <div class="field">
       <label class="label">Titel</label>
       <div class="control">
        <input class="input" name="tasktitle" type="text" placeholder="Aktivitetens namn" required>
        </div>
      </div>
      <div class="field">
        <label class="label">Beskrivning (ej obligatorisk)</label>
        <div class="control">
          <textarea class="textarea" name="taskdescription" placeholder="Beskriv aktiviteten i detalj om du vill"></textarea>
        </div>
      </div>
      <div class="field">
        <label class="label">Måldatum</label>
        <div class="control">
        <input type="date" value="<?php echo date('Y-m-d'); ?>">
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