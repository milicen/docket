<section class="card panel">
  <?php
  if ($page == "calendar") {
    include('comps/todo-panel-header-arrow.php');
  }
  else {
    include('comps/todo-panel-header.php');
  }
  ?>

  <div class="panel-content">
    <ul class="todo-list">
      <?php
      for($i = 0; $i < 3; $i++) {
        include('comps/todo.php');
      }
      ?>
      <?php
      include('comps/todo-tag.php');
      ?>
    </ul>


    <form class="add-todo">
      <input type="text" placeholder="Type your to-do">
      <input class="btn" type="submit" value="Add todo">
    </form>
  </div>
</section>