let newButton = document.getElementById("newButton");
let ft_list = document.getElementById("ft_list");

newButton.addEventListener("click", () => {
    let taskText = prompt("Enter your new TO DO:");
    if (taskText && taskText.trim() !== "") {
        let newTask = document.createElement("div");
        newTask.textContent = taskText;

        ft_list.insertBefore(newTask, ft_list.firstChild);

        saveTasks();

        addRemoveListener(newTask);
    }
});

function addRemoveListener(taskDiv) {
    taskDiv.addEventListener("click", () => {
        let confirmDelete = confirm("Are you sure?");
        if(confirmDelete) {
            taskDiv.remove();
            saveTasks();
        }
    });
}

function saveTasks() {
    let tasks = [];
    ft_list.querySelectorAll("div").forEach(taskDiv => {
        tasks.push(taskDiv.textContent);
    });
    document.cookie = "tasks=" + encodeURIComponent(JSON.stringify(tasks)) + ";path=/"; 
}

function loadTasks() {
    let cookies = document.cookie.split("; ");
    let tasksCookie = cookies.find(row => row.startsWith("tasks="));

    if(tasksCookie) {
        let tasks = JSON.parse(decodeURIComponent(tasksCookie.split("=")[1]));
        tasks.forEach(taskText => {
            let taskDiv = document.createElement("div");
            taskDiv.textContent = taskText;
            ft_list.appendChild(taskDiv);
            addRemoveListener(taskDiv);
        });
    }
}

loadTasks();