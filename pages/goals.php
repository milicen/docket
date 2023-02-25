<section class="page" id="goals">
  <div class="grid">
    <button onclick="addGoal()">+ New Goal</button>
    
  </div>
</section>

<dialog id="delete-popup">
  <form method="dialog">
    <h1 id="delete-popup__title">Delete Confirmation</h1>
    <p>Are you sure you'd like to delete this goal and all todos associated with it?</p>
    <div class="buttons">
      <button value="cancel">Cancel</button>
      <button class="danger" value="accept">Yes, I want to delete</button>
    </div>
  </form>

</dialog>

<script>
const user = JSON.parse(localStorage.getItem('user'))[0]
const grid = document.querySelector('#goals .grid')
const deletePopup = document.querySelector('#delete-popup')

let goalToDelete

deletePopup.addEventListener('close', (e) => {
  if (deletePopup.returnValue === 'accept') {
    deleteGoal(goalToDelete)
  }
})


window.addEventListener('load', (e) => {
  getGoals()
})

function getGoals() {
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
          // <div class="card goal" onclick="location.href = location.origin + location.pathname + '?page=goal-details&g=${goal.goal_id}'">
          goals.forEach(goal => {
            grid.innerHTML += `
              <div class="card goal" onclick="location.href = location.origin + location.pathname + '?page=goal-details&g=${goal.goal_id}'" data-goal="${goal.goal_id}">
                <section>
                  <div class="goal-misc">
                    <span class="tag">${goal.tag}</span>
                    <div class="gap"></div>
                    <span class="counter">0/12</span>
                    <svg onclick="deleteConfirm(event,${goal.goal_id}, '${goal.goal_title}')" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m0 16H5V5h14v14M17 8.4L13.4 12l3.6 3.6l-1.4 1.4l-3.6-3.6L8.4 17L7 15.6l3.6-3.6L7 8.4L8.4 7l3.6 3.6L15.6 7L17 8.4Z"/></svg>
                  </div>
                  
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

function deleteGoal(goalId) {
  $.ajax({
    type: 'POST',
    url: 'api/delete_goal.php',
    data: {
      user_id: user.user_id,
      goal: goalId
    },
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      console.log(res)

      let goals = Array.from(document.querySelectorAll('.card.goal'))
      let goalEl = goals.find(goal => parseInt(goal.dataset.goal) === goalId)
      goalEl.remove()

      // if (res.success > 0) {
      //   location.href = location.origin + location.pathname + `?page=goal-details&g=${res.data.goal_id}`
      // }
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}

function deleteConfirm(event, goalId, goalTitle) {
  event.stopPropagation()
  deletePopup.showModal()
  goalToDelete = goalId

  document.querySelector('#delete-popup__title').innerText = `Delete '${goalTitle}'?`

}
</script>