<section class="page" id="register">
  <form id="register-form" class="card credentials" onsubmit="register(event)">
    <div class="credentials__head">
      <h1>Register</h1>
      <a onclick="location.href = location.origin + location.pathname + '?page=login'">Login</a>
    </div>

    <div class="input-labeled">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>
    </div>

    <div class="input-labeled">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>
    </div>

    <div class="input-labeled">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>
    </div>

    <div class="input-labeled">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm-password" required>
    </div>

    <button class="btn btn-big" type="submit">Register</button>
  </form>
</section>

<script>
function register(event) {
  event.preventDefault()
  let data = getData(event.target)

  $.ajax({
    type: 'POST',
    url: 'api/register.php',
    data: data,
    success: (data) => {
      let res = JSON.parse(data)
      alert(res.message)
      if(res.success > 0) {
        location.href = location.origin + location.pathname + '?page=login'
      }
    },
    error: (xhr, status, error) => {
      console.log(xhr);
      console.log(status);
      console.log(error);
    }
  })
}
</script>