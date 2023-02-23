<section class="page" id="calendar">
  <section class="calendar-holder">
    <div class="calendar-header">
      <!-- left button -->
      <svg id="previous-month-selector" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12l4.58-4.59m-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12l4.58-4.59Z"/></svg>

      <!-- month -->
      <h1 class="month-head" id="selected-month">January 2023</h1>
      <!-- right button -->
      <svg id="next-month-selector" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M5.59 7.41L7 6l6 6l-6 6l-1.41-1.41L10.17 12L5.59 7.41m6 0L13 6l6 6l-6 6l-1.41-1.41L16.17 12l-4.58-4.59Z"/></svg>
      
      <span id="present-month-selector">Back to today</span>
    </div>
    <div class="calendar-grid">
      <ol id="days-of-week" class="days-of-week"></ol>
      <ol id="calendar-days" class="calendar-days"></ol>
    </div>
  </section>

  <section class="card panel">

    <header class="with-arrow">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12l4.58-4.59m-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12l4.58-4.59Z"/></svg>
      <h2 class="date" id="calendar_todo_date">12 January 2023</h2>
    </header>

    <div class="panel-content">
      <ul id="calendar_todo_list" class="todo-list">
        <li class="todo">
          <input type="checkbox">
          <input type="text" placeholder="To-do">
        </li>
        <li class="todo todo-tag">
          <div>
            <input type="checkbox">
            <input type="text" placeholder="To-do">
          </div>
          <div class="tags">
            <span class="tag">chores</span>
          </div>
        </li>
      </ul>

      <form class="add-todo" onsubmit="addTodo(event)">
        <input id="add_todo" type="text" name="todo" placeholder="Type your to-do">
        <input class="btn" type="submit" value="Add todo">
      </form>
    </div>
  </section>
</section>

<script>
dayjs.extend(window.dayjs_plugin_weekOfYear)
dayjs.extend(window.dayjs_plugin_weekday)

const WEEKDAYS = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
const TODAY = dayjs().format("YYYY-MM-DD");

const INITIAL_YEAR = dayjs().format("YYYY");
const INITIAL_MONTH = dayjs().format("M");

let selectedMonth = dayjs(new Date(INITIAL_YEAR, INITIAL_MONTH - 1, 1));
let currentMonthDays;
let previousMonthDays;
let nextMonthDays;

let selectedDay;

const daysOfWeekElement = document.getElementById("days-of-week");

WEEKDAYS.forEach((weekday) => {
  const weekDayElement = document.createElement("li");
  daysOfWeekElement.appendChild(weekDayElement);
  weekDayElement.innerText = weekday;
});

createCalendar();
initMonthSelectors();

function createCalendar(year = INITIAL_YEAR, month = INITIAL_MONTH) {
  const calendarDaysElement = document.getElementById("calendar-days");

  document.getElementById("selected-month").innerText = dayjs(
    new Date(year, month - 1)
  ).format("MMMM YYYY");

  removeAllDayElements(calendarDaysElement);

  currentMonthDays = createDaysForCurrentMonth(
    year,
    month,
    dayjs(`${year}-${month}-01`).daysInMonth()
  );

  previousMonthDays = createDaysForPreviousMonth(year, month);

  nextMonthDays = createDaysForNextMonth(year, month);

  const days = [...previousMonthDays, ...currentMonthDays, ...nextMonthDays];

  days.forEach((day) => {
    appendDay(day, calendarDaysElement);
  });

  if (currentMonthDays.find(day => day.date == TODAY) === undefined) {
    document.getElementById('present-month-selector').style.display = 'block'
  }
  else {
    document.getElementById('present-month-selector').style.display = 'none'
  }
}

function appendDay(day, calendarDaysElement) {
  const dayElement = document.createElement("li");
  const dayElementClassList = dayElement.classList;
  dayElementClassList.add("calendar-day");

  dayElement.addEventListener('click', (event) => {
    console.log('day clicked')
    // remove class from selected day
    if (selectedDay)  {
      selectedDay.classList.remove('calendar-day--selected')
    }
      // overwrite selected day value
    selectedDay = dayElement

    let todayDayOfMonth = TODAY.split('-')[2]
    let selectedDayOfMonth = selectedDay.children[0].innerText

    if (selectedDayOfMonth !== todayDayOfMonth) {
      // add class to selected day
      selectedDay.classList.add('calendar-day--selected')
    }

    getTodos()
  })

  const dayOfMonthElement = document.createElement("span");
  dayOfMonthElement.innerText = day.dayOfMonth;
  dayElement.appendChild(dayOfMonthElement);
  calendarDaysElement.appendChild(dayElement);

  if (!day.isCurrentMonth) {
    dayElementClassList.add("calendar-day--not-current");
  }

  if (day.date === TODAY) {
    dayElementClassList.add("calendar-day--today");
  }
}

function removeAllDayElements(calendarDaysElement) {
  let first = calendarDaysElement.firstElementChild;

  while (first) {
    first.remove();
    first = calendarDaysElement.firstElementChild;
  }
}

function getNumberOfDaysInMonth(year, month) {
  return dayjs(`${year}-${month}-01`).daysInMonth();
}

function createDaysForCurrentMonth(year, month) {
  return [...Array(getNumberOfDaysInMonth(year, month))].map((day, index) => {
    return {
      date: dayjs(`${year}-${month}-${index + 1}`).format("YYYY-MM-DD"),
      dayOfMonth: index + 1,
      isCurrentMonth: true
    };
  });
}

function createDaysForPreviousMonth(year, month) {
  const firstDayOfTheMonthWeekday = getWeekday(currentMonthDays[0].date);

  const previousMonth = dayjs(`${year}-${month}-01`).subtract(1, "month");

  // Cover first day of the month being sunday (firstDayOfTheMonthWeekday === 0)
  const visibleNumberOfDaysFromPreviousMonth = firstDayOfTheMonthWeekday
    ? firstDayOfTheMonthWeekday - 1
    : 6;

  const previousMonthLastMondayDayOfMonth = dayjs(currentMonthDays[0].date)
    .subtract(visibleNumberOfDaysFromPreviousMonth, "day")
    .date();

  return [...Array(visibleNumberOfDaysFromPreviousMonth)].map((day, index) => {
    return {
      date: dayjs(
        `${previousMonth.year()}-${previousMonth.month() + 1}-${
          previousMonthLastMondayDayOfMonth + index
        }`
      ).format("YYYY-MM-DD"),
      dayOfMonth: previousMonthLastMondayDayOfMonth + index,
      isCurrentMonth: false
    };
  });
}

function createDaysForNextMonth(year, month) {
  const lastDayOfTheMonthWeekday = getWeekday(
    `${year}-${month}-${currentMonthDays.length}`
  );

  const nextMonth = dayjs(`${year}-${month}-01`).add(1, "month");

  const visibleNumberOfDaysFromNextMonth = lastDayOfTheMonthWeekday
    ? 7 - lastDayOfTheMonthWeekday
    : lastDayOfTheMonthWeekday;

  return [...Array(visibleNumberOfDaysFromNextMonth)].map((day, index) => {
    return {
      date: dayjs(
        `${nextMonth.year()}-${nextMonth.month() + 1}-${index + 1}`
      ).format("YYYY-MM-DD"),
      dayOfMonth: index + 1,
      isCurrentMonth: false
    };
  });
}

function getWeekday(date) {
  return dayjs(date).weekday();
}

function initMonthSelectors() {
  document
    .getElementById("previous-month-selector")
    .addEventListener("click", function () {
      selectedMonth = dayjs(selectedMonth).subtract(1, "month");
      createCalendar(selectedMonth.format("YYYY"), selectedMonth.format("M"));
    });

  document
    .getElementById("present-month-selector")
    .addEventListener("click", function () {
      selectedMonth = dayjs(new Date(INITIAL_YEAR, INITIAL_MONTH - 1, 1));
      createCalendar(selectedMonth.format("YYYY"), selectedMonth.format("M"));
      selectedDay = document.querySelector('.calendar-day--today')
      getTodos()
    });

  document
    .getElementById("next-month-selector")
    .addEventListener("click", function () {
      selectedMonth = dayjs(selectedMonth).add(1, "month");
      createCalendar(selectedMonth.format("YYYY"), selectedMonth.format("M"));
    });
}

</script>

<script>
const todoList = document.querySelector('#calendar_todo_list')
const calendarTodoDate = document.querySelector('#calendar_todo_date')

window.addEventListener('load', e => {
  selectedDay = document.querySelector('.calendar-day--today')
  console.log(selectedDay)
  getTodos()
})


function getTodos() {
  let dayOfMonth = parseInt(selectedDay.children[0].innerText)
  let date = currentMonthDays.find(day => day.dayOfMonth === dayOfMonth).date
  let user = JSON.parse(localStorage.getItem('user'))[0]
  $.ajax({
    type: 'GET',
    url: 'api/get_todos_by_date.php',
    data: {
      date: date,
      user_id: user.user_id
    },
    success: (data) => {
      let res = JSON.parse(data)
      // alert(res.message)
      console.log(res.data)
      if (res.success > 0) {
        let todos = res.data
        calendarTodoDate.innerText = date
        todoList.innerHTML = ''
        if (todos.length > 0) {
          todos.forEach(todo => {
            todoList.innerHTML += `
              <li class="todo" data-todo="${todo.todo_id}">
                <input type="checkbox" ${todo.is_finished ? 'checked' : ''} onchange="updateTodo(event,${todo.todo_id})">
                <input type="text" placeholder="To-do" value="${todo.todo}" oninput="updateTodo(event,${todo.todo_id})">
              </li>
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

function addTodo(event) {
  event.preventDefault()
  let target = getData(event.target)
  console.log(target)
  let dayOfMonth = parseInt(selectedDay.children[0].innerText)
  let date = currentMonthDays.find(day => day.dayOfMonth === dayOfMonth).date
  let user = JSON.parse(localStorage.getItem('user'))[0]
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
        todoList.innerHTML += `
          <li class="todo" data-todo="${res.data[0].todo_id}">
            <input type="checkbox" onchange="updateTodo(event,${res.data[0].todo_id})">
            <input type="text" placeholder="To-do" value="${target.todo}" oninput="updateTodo(event,${res.data[0].todo_id})">
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

function updateTodo(event, todoId) {
  let todosEl = Array.from(document.querySelectorAll('.todo'))
  let changedTodo = todosEl.find(todo => parseInt(todo.dataset.todo) === todoId)
  let isChecked = changedTodo.children[0].checked
  let todoVal = changedTodo.children[1].value
  let user = JSON.parse(localStorage.getItem('user'))[0]
  
  if(todoVal == '') {
    deleteTodo(changedTodo, user, todoId)
    return
  }

  $.ajax({
    type: 'POST',
    url: 'api/update_todo.php',
    data: {
      todo_id: todoId,
      user_id: user.user_id,
      todo: todoVal,
      todo_finished: isChecked ? 1 : 0
    },
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

function deleteTodo(changedTodo, user, todoId) {
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