const DoneButtons = document.querySelectorAll(".toggleDone");
const TaskDeleteButtons = document.querySelectorAll("ul.tasks .taskDelete");
const ListDeleteButtons = document.querySelectorAll("ul.lists .listDelete");
const ListDeleteBtn = document.querySelector(".listDelete");
const allTasksDoneBtn = document.querySelector(".allTasksDone");
const deleteDoneTasksBtn = document.querySelector(".deleteDoneTasks");

function sendData(data, url) {
  let req = new XMLHttpRequest();
  req.open("POST", url);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  req.onload = function () {
    console.log(this.responseText);
  };

  req.send(data);
}

if (deleteDoneTasksBtn) {
  deleteDoneTasksBtn.addEventListener("click", function (e) {
    deleteTasksDone(e);
  });
}

if (allTasksDoneBtn) {
  allTasksDoneBtn.addEventListener("click", function (e) {
    allTasksDone(e);
  });
}

if (ListDeleteBtn) {
  ListDeleteBtn.addEventListener("click", function (e) {
    removeList(e);
  });
}

if (DoneButtons) {
  DoneButtons.forEach((button) =>
    button.addEventListener("click", function (e) {
      toggleDone(e);
    })
  );
}

if (ListDeleteButtons) {
  ListDeleteButtons.forEach((button) =>
    button.addEventListener("click", function (e) {
      removeList(e);
    })
  );
}

if (TaskDeleteButtons) {
  TaskDeleteButtons.forEach((button) =>
    button.addEventListener("click", function (e) {
      removeTask(e);
    })
  );
}

function toggleDone(e) {
  sendData("taskid=" + e.currentTarget.value, "/taskDoneToggle");
}

function removeTask(e) {
  let result = confirm("Är du säker på att du vill ta bort aktiviteten?");

  if (result) {
    sendData("taskid=" + e.currentTarget.value, "/deleteTask");
    document.querySelector("li#task" + e.currentTarget.value).remove();
  }
}

function removeList(e) {
  console.log(e.currentTarget.value);
  let result = confirm("Är du säker på att du vill ta bort listan?");

  if (result) {
    sendData("listid=" + e.currentTarget.value, "/deleteList");

    if (location.pathname == "/edit-list") {
      location.href = "/";
    } else {
      document.querySelector("li#list" + e.currentTarget.value).remove();
    }
  }
}

function allTasksDone(e) {
  sendData("listid=" + e.currentTarget.value, "/allTasksDone");
  location.reload();
}

function deleteTasksDone(e) {
  let result = confirm("Vill du ta bort alla klara aktiviteter?");

  if (result) {
    sendData("listid=" + e.currentTarget.value, "/deleteTasksDone");
    location.reload();
  }
}
