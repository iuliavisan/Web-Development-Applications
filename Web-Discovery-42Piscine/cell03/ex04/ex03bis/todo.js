$(document).ready(function() {
    console.log("Document ready");

    let $newButton = $("#New");
    let $ft_list = $("#ft_list");

    $newButton.on("click", function() {
        console.log("Button clicked");
        let taskText = prompt("Enter task: ");
        console.log("Task entered:", taskText);

        if(taskText && taskText.trim() != "") {
            let $newTask = $("<div></div>").text(taskText.trim());

            $ft_list.prepend($newTask);

            saveTasks();

            addRemoveListener($newTask);
        }
    });
        

    function addRemoveListener($taskDiv) {
        $taskDiv.on("click", function() {
            console.log("Task clicked");
            let confirmDelete = confirm("Are you sure?");
            if (confirmDelete) {
                $taskDiv.remove();
                saveTasks();
            }
        });
    }

    function saveTasks() {
        let tasks = [];
        $ft_list.children("div").each(function() {
            tasks.push($(this).text());
        });
        console.log("Saving tasks:", tasks);
        document.cookie = "tasks=" + encodeURIComponent(JSON.stringify(tasks)) + ";path=/"; 
    }

    function loadTasks() {
        console.log("Loading tasks from cookie");
        let cookies = document.cookie.split("; ");
        let tasksCookie = cookies.find(row => row.startsWith("tasks="));
        console.log("Found cookie:", tasksCookie);

        if (tasksCookie) {
            let tasks = JSON.parse(decodeURIComponent(tasksCookie.split("=")[1]));
            console.log("Parsed tasks:", tasks);
            tasks.forEach(taskText => {
                let $taskDiv = $("<div></div>").text(taskText);
                $ft_list.append($taskDiv);
                addRemoveListener($taskDiv);
            });
        }
    }

    loadTasks();
});
