document.addEventListener("DOMContentLoaded", function() {
const addTaskBtn = document.querySelector("#addTaskBtn");
const deleteTaskBtn = document.querySelector("#deleteTaskBtn");
const deleteAllBtn = document.querySelector("#deletAllBtn");
const TaskList = document.querySelector("ul");
const inputTask = document.querySelector("#addTask");

let taskCount  = 1;

loadTask();

function createElement(taskText,id) {
const newTask = document.createElement("li");

const checkbox = document.createElement("input");
checkbox.type = "checkbox";

const span = document.createElement("span");
span.className = "list-point-decor";
span.textContent = `Task ${id} : `;

const textNode = document.createTextNode(taskText);

newTask.appendChild(checkbox);
newTask.appendChild(span);
newTask.appendChild(textNode);

return newTask;
}


//add button
addTaskBtn.addEventListener("click", function() {
    const taskText = inputTask.value.trim();

    if(taskText === "") {
     alert("Please enter a task.");
     return;
    }

    const newTask = createElement(taskText,taskCount++);
    TaskList.appendChild(newTask);
    saveToStorage(taskText);

    inputTask.value = "";

    alert("Task added successfully!");
});

//delete button
deleteTaskBtn.addEventListener("click", function() {
    const checkedTasks = document.querySelectorAll("input[type='checkbox']:checked");

    if(checkedTasks.length === 0) {
        alert("Please select at least one task to delete.");
        return;
    }

    checkedTasks.forEach(function(checkbox) {
        const taskText = TaskList.parentElement.textContent;
        TaskList.removeChild(checkbox.parentElement);
        removeFromStorage(taskText);
    });
});

//delete all button
deleteAllBtn.addEventListener("click", function() {
    if(TaskList.children.length === 0) {
        alert("No any task exist to delete.");
        return;
    }

    TaskList.innerHTML = "";
    localStorage.removeItem("tasks");
});

//local storage functions
function saveToStorage(tasktext){
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks.push(tasktext);
    localStorage.setItem("tasks",JSON.stringify(tasks));
}

function removeFromStorage() {
    let tasks = JSON.parse(localStorage.getItem(tasks)) || [];
    tasks = tasks.filter(task => task !== taskText);
    localStorage.setItem("tasks",JSON.stringify(tasks));
}

function loadTask() {
let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
tasks.forEach((task,index) => {
const newTask = createElement(task, index + 1);
TaskList.appendChild(newTask);
taskCount = index + 2;
})
}

});