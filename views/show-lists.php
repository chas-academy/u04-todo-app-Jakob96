<?php require_once("head.php"); ?>
  <section class="section">
    <div class="container">
      <h1 class="title">
        Mina listor
      </h1>
      <p class="subtitle">
      Här visas alla dina listor.
      </p>

      <ul class="lists">
        <?php if ($lists) {
          foreach($lists as $list) { ?>
          <li id="<?php echo "list".$list["ID"]; ?>"><div class="buttons is-right">
            <a class="button is-active is-rounded" href="<?php echo "/edit-list?listid=".$list["ID"]; ?>" aria-label="Ändra listan">
              <i class="far fa-edit"></i>
            </a>
            <button class="button is-danger is-rounded listDelete" value="<?php echo $list["ID"]; ?>" aria-label="Ta bort listan">
              <i class="fas fa-trash"></i>
          </button>
          </div>
            <h3 class="subtitle is-3"><a href="<?php echo "/edit-list?listid=".$list["ID"];  ?>"><?php echo $list["title"]; ?></a></h3>
            <p><?php echo nl2br($list["description"]); ?></p>
          </li>
       <?php }
        }
        else {
          echo "<p class=\"has-text-centered mb-3\">Du har inga listor ännu.</p>";
        }  ?>
      </ul>
    </div>
  </section>
  <?php require_once("footer.php"); ?>