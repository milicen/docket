<section class="page" id="list">

</section>

<script>
const user = JSON.parse(localStorage.getItem('user'))[0]
const page = document.querySelector('#list')

window.addEventListener('load', (e) => {
  getAllTodos()
})

function getAllTodos() {
  $.ajax({
    type: 'GET',
    url: 'api/get_all_todos.php',
    data: {
      user_id: user.user_id
    },
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      console.log(res.data)
      if (res.success > 0) {
        let todoData = res.data
        let dates = todoData.dates
        let todos = todoData.todos

        console.log(dates)
        console.log(todos)

        dates.forEach(date => {
          console.log(date)
          let cardPanel = `
          <section class="card panel" data-date="${date.date}">
            <header>
              <h2 class="date">${date.date}</h2>
            </header>

            <div class="panel-content">
              <ul class="todo-list" id="todo-list__${date.date}">
              </ul>


              <form class="add-todo" onsubmit="addTodo(event)" data-date="${date.date}">
                <input type="text" name="todo" id="#add-todo" placeholder="Type your to-do">
                <input class="btn" type="submit" value="Add todo">
              </form>
            </div>
          </section>
          `
          page.innerHTML += cardPanel

        })

        let panels = Array.from(document.querySelectorAll('.card.panel'))

        panels.forEach(panel => {
          let dateTodos = todos.filter(todo => todo.date === panel.dataset.date)
          let todoList = document.querySelector(`#todo-list__${panel.dataset.date}`)

          dateTodos.forEach(todo => {
              // todoList.innerHTML += `
              //   <li class="todo" data-todo="${todo.todo_id}">
              //     <input type="checkbox" ${todo.is_finished ? 'checked' : ''} onchange="updateTodo(event,${todo.todo_id})">
              //     <input type="text" placeholder="To-do" value="${todo.todo}" oninput="updateTodo(event,${todo.todo_id})">
              //   </li>
              // `
              todoList.innerHTML += `
                <li class="todo" data-todo="${todo.todo_id}">
                  <input type="checkbox" ${todo.is_finished ? 'checked' : ''} onchange="updateTodo(event,${todo.todo_id},'todo_finished')">
                  <div class="todo-input" contenteditable placeholder="To-do" onkeyup="updateTodo(event,${todo.todo_id},'todo')">${todo.todo}</div>
                </li>
              `
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
      // alert(res.message)
      console.log(res.data)
      if (res.success > 0) {
        let todoList = document.querySelector(`#todo-list__${date}`)
        todoList.innerHTML += `
          <li class="todo" data-todo="${res.data[0].todo_id}">
            <input type="checkbox" onchange="updateTodo(event,${res.data[0].todo_id},'todo_finished')">
            <div class="todo-input" contenteditable placeholder="To-do" onkeyup="updateTodo(event,${res.data[0].todo_id},'todo')">${target.todo}</div>
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
  // console.log('update todo')
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
        let todos = Array.from(document.querySelectorAll('.todo'))
        let changedTodo = todos.find(todo => parseInt(todo.dataset.todo) === todoId)
        deleteTodo(changedTodo, todoId)
        return
      }
      break
    case 'todo_finished':
      todo_finished = event.target.checked
      updateData.todo_finished = todo_finished ? 1 : 0
      break
  }

  // console.log(event.target.innerText)
  // let todosEl = Array.from(document.querySelectorAll('.todo'))
  // let changedTodo = todosEl.find(todo => parseInt(todo.dataset.todo) === todoId)
  // let isChecked = changedTodo.children[0].checked
  // // let todoVal = changedTodo.children[1].value
  // let todoVal = event.target.innerText
  
  // if(todoVal == '') {
  //   deleteTodo(changedTodo, user, todoId)
  //   return
  // }

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

</script>