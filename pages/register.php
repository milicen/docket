<link rel="stylesheet" href="../styles/login.css">


<section class="page" id="register">
  <form class="card credentials">
    <div class="credentials__head">
      <h1>Register</h1>
      <a onclick="location.href = location.origin + location.pathname + '?page=login'">Login</a>
    </div>

    <div class="input-labeled">
      <label for="email">Email</label>
      <input type="email" name="email" id="email">
    </div>

    <div class="input-labeled">
      <label for="username">Username</label>
      <input type="text" name="username" id="username">
    </div>

    <div class="input-labeled">
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
    </div>

    <div class="input-labeled">
      <label for="confirm-password">Confirm Password</label>
      <input type="password" name="confirm-password" id="confirm-password">
    </div>

    <button class="btn btn-big" type="submit">Register</button>
  </form>
</section>