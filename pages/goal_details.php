<section class="page" id="goal-details">
  <div class="details">
    <div class="title">
      <a onclick="location.href = location.origin + location.pathname + '?page=goals'">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12l4.58-4.59m-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12l4.58-4.59Z"/></svg>
      </a>
      <h1>Get better at swimming</h1>
    </div>
    <div class="input-group">
      <label for="tag">Tag:</label>
      <input type="text" name="tag" placeholder="Tag">
    </div>
    <div class="input-group">
      <label for="start-date">Start:</label>
      <input type="date" name="start-date" placeholder="Date">
    </div>
    <div class="input-group">
      <label for="due-date">Due: </label>
      <input type="date" name="due-date" placeholder="Date">
    </div>
    <div class="input-group">
      <label for="description">Description: </label>
      <textarea name="description" placeholder="Description"></textarea>
    </div>
  </div>
  <div class="line"></div>
  <div class="todos">
    <h2>Planning</h2>
    <div class="todo-container">
      <h3>January 2023</h3>
      <?php
      include('comps/todo-pick-calendar.php');
      include('comps/todo-pick-calendar.php');
      include('comps/todo-pick-calendar.php');
      include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      // include('comps/todo-pick-calendar.php');
      ?>
    </div>
    <form class="add-todo">
      <input type="text" placeholder="Type your to-do">
      <input class="btn" type="submit" value="Add todo">
    </form>
  </div>
</section>