<section class="page" id="login">
  <form id="login-form" class="card credentials" onsubmit="login(event)">
    <div class="credentials__head">
      <h1>Login</h1>
      <a onclick="location.href = location.origin + location.pathname + '?page=register'">Register</a>
    </div>

    <div class="input-labeled">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>
    </div>

    <div class="input-labeled">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>
    </div>

    <button class="btn btn-big" type="submit">Login</button>
  </form>
</section>

<div id="snackbar" class="snackbar">Some text some message..</div>


<script>
const snackbar = document.querySelector('#snackbar')

function login(event) {
  event.preventDefault()
  let data = getData(event.target)

  $.ajax({
    type: 'POST',
    url: 'api/login.php',
    data: data,
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      snackbar.innerText = res.message
      snackbar.classList.add('show')
      setTimeout(function(){ snackbar.classList.remove('show') }, 3000);
      if (res.success > 0) {
        localStorage.setItem('user', JSON.stringify(res.user))
        location.href = location.origin + location.pathname + '?page=calendar'
      }
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })

  
}


</script>