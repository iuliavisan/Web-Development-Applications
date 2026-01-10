<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

if (isset($_POST['add_task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $_SESSION['tasks'][] = ['text' => $task, 'completed' => false];
    }
}

if (isset($_GET['delete'])) {
    unset($_SESSION['tasks'][$_GET['delete']]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
}

if (isset($_GET['complete'])) {
    $_SESSION['tasks'][$_GET['complete']]['completed'] = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <style>
        .completed { text-decoration: line-through; color: gray; }
    </style>
</head>
<body>
    <h1>Todo List</h1>
    <a href="home.php">Back Home</a>
    <br><br>
    
    <form method="post">
        <input type="text" name="task" placeholder="New task...">
        <button type="submit" name="add_task">Add</button>
    </form>

    <ul>
    <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
        <li class="<?php echo $task['completed'] ? 'completed' : ''; ?>">
            <?php echo htmlspecialchars($task['text']); ?>
            <?php if (!$task['completed']): ?>
                <a href="?complete=<?php echo $index; ?>">[Complete]</a>
            <?php endif; ?>
            <a href="?delete=<?php echo $index; ?>">[Delete]</a>
        </li>
    <?php endforeach; ?>
    </ul>
</body>
</html>