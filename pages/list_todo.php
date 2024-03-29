<section class="page" id="list">

</section>

<dialog id="delete-popup">
  <form method="dialog">
    <h1 id="delete-popup__title">Delete Confirmation</h1>
    <p>Are you sure you'd like to delete all plans for this date?</p>
    <div class="buttons">
      <button value="cancel">Cancel</button>
      <button class="danger" value="accept">Yes, I want to delete</button>
    </div>
  </form>

</dialog>

<script>
const user = JSON.parse(localStorage.getItem('user'))[0]
const page = document.querySelector('#list')
const deletePopup = document.querySelector('#delete-popup')

let dateToDelete

deletePopup.addEventListener('close', (e) => {
  if (deletePopup.returnValue === 'accept') {
    deleteAllTodosOn(dateToDelete)
  }
})

window.addEventListener('load', (e) => {
  getAllTodos()
})

function getChangedTodo(todoId) {
  let todos = Array.from(document.querySelectorAll('.todo'))
  let changedTodo = todos.find(todo => parseInt(todo.dataset.todo) === todoId)
  return changedTodo
}

function getAllTodos() {
  $.ajax({
    type: 'GET',
    url: 'api/get_all_todos.php',
    data: {
      user_id: user.user_id
    },
    success: (data) => {
      let res = JSON.parse(data)
      console.log(res.data)
      if (res.success > 0) {
        let todoData = res.data
        let dates = todoData.dates
        let todos = todoData.todos

        console.log(dates)
        console.log(todos)

        if (todos.length < 1 || dates.length < 1) {
          page.innerHTML = `
            <div class="list-blank">
              <img src="assets/blankstate-list.png"></img>
            </div>
          `
          return
        }

        dates.forEach(date => {
          console.log(date)
          let cardPanel = `
          <section class="card panel" data-date="${date.date}">
            <svg class="del-list" onclick="deleteConfirm(event,'${date.date}')" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m0 16H5V5h14v14M17 8.4L13.4 12l3.6 3.6l-1.4 1.4l-3.6-3.6L8.4 17L7 15.6l3.6-3.6L7 8.4L8.4 7l3.6 3.6L15.6 7L17 8.4Z"/></svg>

            <header>
              <h2 class="date">${date.date}</h2>
            </header>

            <div class="panel-content">
              <ul class="todo-list" id="todo-list__${date.date}">
              </ul>
            </div>
            <form class="add-todo" onsubmit="addTodo(event)" data-date="${date.date}">
              <input type="text" name="todo" id="#add-todo" placeholder="Type your to-do">
              <input class="btn" type="submit" value="Add todo">
            </form>
          </section>
          `
          page.innerHTML += cardPanel

        })

        let panels = Array.from(document.querySelectorAll('.card.panel'))

        panels.forEach(panel => {
          let dateTodos = todos.filter(todo => todo.date === panel.dataset.date)
          let todoList = document.querySelector(`#todo-list__${panel.dataset.date}`)

          dateTodos.forEach(todo => {
              if (!todo.tag) {
                todoList.innerHTML += `
                  <li class="todo" data-todo="${todo.todo_id}">
                    <input type="checkbox" ${todo.is_finished ? 'checked' : ''} onchange="updateTodo(event,${todo.todo_id},'todo_finished')">
                    <div class="todo-input" contenteditable placeholder="To-do" onkeyup="updateTodo(event,${todo.todo_id},'todo')">${todo.todo}</div>
                    <button class="icon" onclick="deleteTodo(getChangedTodo(${todo.todo_id}),${todo.todo_id})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#888888" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12M8 9h8v10H8V9m7.5-5l-1-1h-5l-1 1H5v2h14V4h-3.5Z"/></svg>
                      </button>
                  </li>
                `
              }
              else {
                todoList.innerHTML += `
                  <li class="todo todo-tag" data-todo="${todo.todo_id}">
                    <div>
                      <input type="checkbox" ${todo.is_finished ? 'checked' : ''} onchange="updateTodo(event,${todo.todo_id},'todo_finished')">
                      <div class="todo-input" contenteditable placeholder="To-do" onkeyup="updateTodo(event,${todo.todo_id},'todo')">${todo.todo}</div>
                      <button class="icon" onclick="deleteTodo(getChangedTodo(${todo.todo_id}),${todo.todo_id})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#888888" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12M8 9h8v10H8V9m7.5-5l-1-1h-5l-1 1H5v2h14V4h-3.5Z"/></svg>
                      </button>
                    </div>
                    <div class="tags">
                      <span class="tag">${todo.tag}</span>
                    </div>
                  </li>
                `
              }
          })
        })
      }
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
  console.log('event: ', event)
  let date = event.target.dataset.date
  $.ajax({
    type: 'POST',
    url: 'api/add_todo.php',
    data: {
      date: date,
      user_id: user.user_id,
      todo: target.todo
    },
    success: (data) => {
      let res = JSON.parse(data)
      console.log(res.data)
      if (res.success > 0) {
        let todoList = document.querySelector(`#todo-list__${date}`)
        todoList.innerHTML += `
          <li class="todo" data-todo="${res.data[0].todo_id}">
            <input type="checkbox" onchange="updateTodo(event,${res.data[0].todo_id},'todo_finished')">
            <div class="todo-input" contenteditable placeholder="To-do" onkeyup="updateTodo(event,${res.data[0].todo_id},'todo')">${target.todo}</div>
            <button class="icon" onclick="deleteTodo(getChangedTodo(${res.data[0].todo_id}),${res.data[0].todo_id})">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#888888" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12M8 9h8v10H8V9m7.5-5l-1-1h-5l-1 1H5v2h14V4h-3.5Z"/></svg>
            </button>
          </li>
        `
        event.target[0].value = null
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
  let todo, todo_finished
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
        deleteTodo(getChangedTodo(todoId), todoId)
        return
      }
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

function deleteAllTodosOn(date) {
  $.ajax({
    type: 'POST',
    url: 'api/delete_todos_by_date.php',
    data: {
      user_id: user.user_id,
      date: date
    },
    success: (data) => {
      let res = JSON.parse(data)
      console.log(res.data)

      let list = Array.from(document.querySelectorAll('.card.panel'))
      let listToDelete = list.find(li => li.dataset.date === date)
      listToDelete.remove()
    },
    error: (xhr, status, error) => {
      console.log(xhr)
      console.log(status)
      console.log(error)
    }
  })
}

function deleteConfirm(event, date) {
  event.stopPropagation()
  deletePopup.showModal()
  console.log(date)
  dateToDelete = date

  document.querySelector('#delete-popup__title').innerText = `Delete all plans on '${dateToDelete}'?`

}

</script>