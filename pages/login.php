<section class="page" id="login">
  <form class="card credentials">
    <div class="credentials__head">
      <h1>Login</h1>
      <a onclick="location.href = location.origin + location.pathname + '?page=register'">Register</a>
    </div>

    <div class="input-labeled">
      <label for="username">Username</label>
      <input type="text" name="username" id="username">
    </div>

    <div class="input-labeled">
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
    </div>

    <button class="btn btn-big" type="submit">Login</button>
  </form>
</section>