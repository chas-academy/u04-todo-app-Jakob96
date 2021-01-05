<?php require_once("head.php"); ?>
  
  <section class="section">
    <div class="container">
      <h1 class="title">
        Skapa ny Att göra-lista
      </h1>

    <form method="POST" action="/addTodoList">
      <div class="field">
       <label class="label">Titel</label>
       <div class="control">
        <input class="input" name="listtitle" type="text" placeholder="Listans namn" required>
        </div>
      </div>
      <div class="field">
        <label class="label">Beskrivning (ej obligatorisk)</label>
        <div class="control">
          <textarea class="textarea" name="listdescription" placeholder="Förklara vad listan innehåller"></textarea>
        </div>
      </div>

      <div class="field">
        <div class="control">
          <button class="button is-primary" type="submit">Spara</button>
          <button class="button is-link" onclick="history.back();">Avbryt</button>
        </div>
      </div>
    </form>
    </div>
  </section>
  <?php require_once("footer.php"); ?>