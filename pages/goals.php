<section class="page" id="goals">
  <div class="grid">
    <button onclick="addGoal()">+ New Goal</button>
    
  </div>
</section>

<script>

const grid = document.querySelector('#goals .grid')

window.addEventListener('load', (e) => {
  getGoals()
})

function getGoals() {
  let user = JSON.parse(localStorage.getItem('user'))[0]
  $.ajax({
    type: 'GET',
    url: 'api/get_goals.php',
    data: {
      user_id: user.user_id
    },
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      console.log(res.data)
      if (res.success > 0) {
        let goals = res.data
        if (goals.length > 0) {
          goals.forEach(goal => {
            grid.innerHTML += `
              <div class="card goal" onclick="location.href = location.origin + location.pathname + '?page=goal-details&g=${goal.goal_id}'">
                <section>
                  <span class="tag">${goal.tag}</span>
                  <span class="counter">0/12</span>
                  <h2 class="goal-title">${goal.goal_title}</h2>
                  <small class="dates">Due by ${goal.due_date}</small>
                </section>
                <section>
                  <p class="description">${goal.goal_description}</p>
                </section>
              </div>
            `
            
          })
        }
      }
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}

function addGoal() {
  let user = JSON.parse(localStorage.getItem('user'))[0]
  $.ajax({
    type: 'POST',
    url: 'api/add_goal.php',
    data: {
      user_id: user.user_id
    },
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      console.log(res.data)
      if (res.success > 0) {
        location.href = location.origin + location.pathname + `?page=goal-details&g=${res.data.goal_id}`
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