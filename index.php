<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/main.css">
  <link rel="stylesheet" href="styles/topbar.css">
  <link rel="stylesheet" href="styles/sidenav.css">
  <link rel="stylesheet" href="styles/login-register.css">
  <link rel="stylesheet" href="styles/list.css">
  <link rel="stylesheet" href="styles/goals.css">
  <link rel="stylesheet" href="styles/goal-details.css">


  
  <title>Calendar</title>
</head>

<?php
$page = "calendar";
?>

<?php
if (isset($_GET["page"])) {
  $page = $_GET["page"];
}
else {
  $page = "calendar";
}
?>

<style>
  <?php
  if ($page == "register" || $page == "login") {
    echo '.page#'.$page.' {
      display: grid;
    }';
  }
  else if ($page == "list" || $page == "goal-details") {
    echo '.page#' . $page . ' {
      display: flex;
    }';
  }
  else {
    echo '.page#'.$page.' {
      display: block;
    }';
  }
  ?>
</style>


<body>
  <div class="top-bar">
    <img src="assets/docket.svg" alt="docket">
    <div class="top-bar__links">
      <span class="username">handa geniu</span>
      <a onclick="location.href = location.origin + location.pathname + '?page=login'">Logout</a>
    </div>
  </div>

  <main>
    <nav class="side-nav">
      <a class="<?php if ($page == "calendar") {
        echo "active";}?>" onclick="location.href = location.origin + location.pathname + '?page=calendar'">
        <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9 10v2H7v-2h2m4 0v2h-2v-2h2m4 0v2h-2v-2h2m2-7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h1V1h2v2h8V1h2v2h1m0 16V8H5v11h14M9 14v2H7v-2h2m4 0v2h-2v-2h2m4 0v2h-2v-2h2Z"/></svg>
      </a>
      <a class="<?php if ($page == "list") {
        echo "active";}?>" onclick="location.href = location.origin + location.pathname + '?page=list'">
        <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 4h4v4H3V4m6 1v2h12V5H9m-6 5h4v4H3v-4m6 1v2h12v-2H9m-6 5h4v4H3v-4m6 1v2h12v-2H9"/></svg>
      </a>
      <a class="<?php if ($page == "goals") {
        echo "active";}?>" onclick="location.href = location.origin + location.pathname + '?page=goals'">
        <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10c0-1.16-.21-2.31-.61-3.39l-1.6 1.6c.14.59.21 1.19.21 1.79a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.6 0 1.2.07 1.79.21L15.4 2.6C14.31 2.21 13.16 2 12 2m7 0l-4 4v1.5l-2.55 2.55C12.3 10 12.15 10 12 10a2 2 0 0 0-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2c0-.15 0-.3-.05-.45L16.5 9H18l4-4h-3V2m-7 4a6 6 0 0 0-6 6a6 6 0 0 0 6 6a6 6 0 0 0 6-6h-2a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4V6Z"/></svg>
      </a>
    </nav>  

    <?php
    include('pages/calendar.php');
    include('pages/register.php');
    include('pages/login.php');
    include('pages/list_todo.php');
    include('pages/goals.php');
    include('pages/goal_details.php');
    ?>
    
  </main>
  


</body>
</html>