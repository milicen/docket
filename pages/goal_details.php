<section class="page" id="goal-details">
  <div class="details">
    <div class="title">
      <a onclick="location.href = location.origin + location.pathname + '?page=goals'">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12l4.58-4.59m-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12l4.58-4.59Z"/></svg>
      </a>
      <h1 contenteditable id="goal-title" onkeyup="updateGoal(event, 'title')">Get better at swimming</h1>
    </div>
    <div class="input-group">
      <label for="tag">Tag:</label>
      <input type="text" name="tag" id="tag" placeholder="Tag" onchange="updateGoal(event, 'tag')">
    </div>
    <div class="input-group">
      <label for="due-date">Due: </label>
      <input type="date" name="due-date" id="due-date" placeholder="Date" onchange="updateGoal(event, 'due')">
    </div>
    <div class="input-group">
      <label for="description">Description: </label>
      <textarea name="description" placeholder="Description" id="goal-description" onkeyup="updateGoal(event, 'description')"></textarea>
    </div>
  </div>
  <div class="line"></div>
  <div class="todos">
    <h2>Planning</h2>
    <div class="todo-container">
      <h3>January 2023</h3>
    </div>
    <form class="add-todo" onsubmit="addTodo(event)">
      <input type="text" name="todo" id="add_todo" placeholder="Type your to-do">
      <input class="btn" type="submit" value="Add todo">
    </form>
  </div>
</section>

<script>
const goalTitle = document.querySelector('#goal-title')
const tag = document.querySelector('#tag')
const dueDate = document.querySelector('#due-date')
const goalDescription = document.querySelector('#goal-description')


const todoList = document.querySelector('.todo-container')

let urlSearch = location.search
let urlParams = new URLSearchParams(urlSearch)
let goalId = urlParams.get('g')
let user = JSON.parse(localStorage.getItem('user'))[0]

window.addEventListener('load', (e) => {
  getGoal()
})

function getGoal() {
  $.ajax({
    type: 'GET',
    url: 'api/get_goal_by_id.php',
    data: {
      goal_id: goalId,
      user_id: user.user_id
    },
    success: (data) => {
      console.log(data)
      let res = JSON.parse(data)
      let goal = res.data.goal
      let todos = res.data.todos
      console.log(res.data)
      if (res.success > 0) {
        goalTitle.innerText = goal.goal_title
        goalDescription.value = goal.goal_description
        tag.value = goal.tag
        dueDate.value = goal.due_date
        
        todos.forEach(todo => {
          todoList.innerHTML += `
            <li class="todo todo-pick-calendar" data-todo="${todo.todo_id}">
              <div>
                <input type="checkbox" onchange="updateTodo(event,${todo.todo_id},'todo_finished')" ${todo.is_finished ? 'checked' : ''}>
                <div class="todo-input" contenteditable placeholder="To-do" onkeyup="updateTodo(event,${todo.todo_id},'todo')">${todo.todo}</div>
                <input type="date" onchange="updateTodo(event,${todo.todo_id},'date')" value="${todo.date}">
              </div>
              <span class="date" data-todo="${todo.todo_id}">${todo.date}</span>
            </li>
          `
        });
      }
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}

function updateGoal(event, part) {
  let title
  let description
  let due
  let tagVal

  let data = {
    user_id: user.user_id,
    goal: goalId
  }

  switch(part) {
    case 'title':
      title = event.target.innerText
      data.goal_title = title
      break
    case 'description':
      description = event.target.value
      data.goal_description = description
      break
    case 'due':
      due = event.target.value
      data.due_date = due
      break
    case 'tag':
      tagVal = event.target.value
      data.tag = tagVal
      break
  }

  updateGoalAjax(data)
}

function updateGoalAjax(updateData) {
  $.ajax({
    type: 'POST',
    url: 'api/update_goal.php',
    data: updateData,
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      console.log(res.message)
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}


function addTodo(event) {
  event.preventDefault()
  let target = getData(event.target)
  console.log(target)
  let date = dayjs().format("YYYY-MM-DD")
  $.ajax({
    type: 'POST',
    url: 'api/add_todo.php',
    data: {
      date: date,
      user_id: user.user_id,
      todo: target.todo,
      goal: goalId,
    },
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      console.log(res.data)
      if (res.success > 0) {
        todoList.innerHTML += `
          <li class="todo todo-pick-calendar" data-todo="${res.data[0].todo_id}">
              <div>
                <input type="checkbox" onchange="updateTodo(event,${res.data[0].todo_id},'todo_finished')">
                <div class="todo-input" contenteditable placeholder="To-do" onkeyup="updateTodo(event,${res.data[0].todo_id},'todo')">${target.todo}</div>
                <input type="date" onchange="updateTodo(event,${res.data[0].todo_id},'date')">
              </div>
              <span class="date" data-todo="${res.data[0].todo_id}">${date}</span>
            </li>
        `
        document.querySelector('#add_todo').value = null
      }
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}


function updateTodo(event, todoId, part) {
  let todo, todo_finished, date
  let updateData = {
    user_id: user.user_id,
    todo_id: todoId
  }

  switch(part) {
    case 'todo':
      todo = event.target.innerText
      updateData.todo = todo

      if (todo == '') {
        console.log('empty')
        let todos = Array.from(document.querySelectorAll('.todo'))
        let changedTodo = todos.find(todo => parseInt(todo.dataset.todo) === todoId)
        deleteTodo(changedTodo, todoId)
        return
      }

      break
    case 'date':
      date = event.target.value
      updateData.date = date
      break
    case 'todo_finished':
      todo_finished = event.target.checked
      updateData.todo_finished = todo_finished ? 1 : 0
      break
  }

  $.ajax({
    type: 'POST',
    url: 'api/update_todo.php',
    data: updateData,
    success: (data) => {
      let res = JSON.parse(data)
      console.log(res.data)
      
      if (date) {
        let dates = Array.from(document.querySelectorAll('.date'))
        let dateToUpdate = dates.find(date => parseInt(date.dataset.todo) === todoId)
        dateToUpdate.innerText = date
      }
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}

function deleteTodo(changedTodo, todoId) {
  $.ajax({
    type: 'POST',
    url: 'api/delete_todo.php',
    data: {
      todo_id: todoId,
      user_id: user.user_id
    },
    success: (data) => {
      let res = JSON.parse(data)
      console.log(res.data)
      // alert(res.message)

      changedTodo.remove()
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}
</script>