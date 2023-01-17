<?php
$names = array("alan", "james", "mary");

function addName() {
  $name = $_GET["name"];
  array_push($names, $name);
  return false;
}
?>

<section class="page" id="list">
  <h1>List todo</h1>
  <?php
  for($i = 0; $i < count($names); $i++) {
    echo "<p>
      $names[$i]
    </p>";
  }
  ?>

  <form method="get" onsubmit=" return addName()">
    <input type="text" name="name">
    <input type="submit">

  </form>
</section>