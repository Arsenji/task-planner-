<!DOCTYPE html>
<html>
<head>
    <title>Список задач</title>
    <link href="style.css" rel="stylesheet">
    <link href="npm i bootstrap@5.3.0" rel="stylesheet">
</head>
<body>
<div>
    <h2 class="title">Task list</h2>
    <form method="post" action="">
        <input type="text" class="task" name="task" placeholder="Введите задачу" required>
        <button type="submit" class="addTask" name="addTask">Добавить</button>
    </form>
    <form method="post" action="" class="form-button">
        <button type="submit" class="removeAll" name="removeAll">Удалить все</button>
        <button type="submit" class="readyAll" name="readyAll">Все выполнено</button>
    </form>
</div>

<div>
    <h2>Список задач</h2>
    <?php
    session_start();

    if (isset($_POST['addTask'])) {
        $task = $_POST['task'];
        $status = 'Не готово';

        $_SESSION['tasks'][] = array('task' => $task, 'status' => $status);
    }

    if (isset($_POST['removeAll'])) {
        unset($_SESSION['tasks']);
    }

    if (isset($_POST['readyAll'])) {
        if (isset($_SESSION['tasks'])) {
            foreach ($_SESSION['tasks'] as &$task) {
                $task['status'] = 'Выполнено';
            }
            unset($task);
        }
    }

    if (isset($_POST['ready'])) {
        $key = $_POST['ready'];
        if (isset($_SESSION['tasks'][$key])) {
            $_SESSION['tasks'][$key]['status'] = 'Выполнено';
        }
    }

    if (isset($_POST['unready'])) {
        $key = $_POST['unready'];
        if (isset($_SESSION['tasks'][$key])) {
            $_SESSION['tasks'][$key]['status'] = 'Не выполнено';
        }
    }

    if (isset($_POST['delete'])) {
        $key = $_POST['delete'];
        if (isset($_SESSION['tasks'][$key])) {
            unset($_SESSION['tasks'][$key]);
        }
    }

    if (isset($_SESSION['tasks'])) {
        foreach ($_SESSION['tasks'] as $key => $task) {
            $task_id = uniqid();
            echo '<div class="task">';
            echo '<p>' . $task['task'] . '</p>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="task_id" value="' . $task_id . '">';

            if ($task['status'] == 'Выполнено') {
                echo '<button type="submit" class="unready" name="unready" value="' . $key . '">Невыполнена</button>';
            } else {
                echo '<button type="submit" name="ready" class="ready" value="' . $key . '">Выполнена</button>';
            }

            echo '<button type="submit" class="delete" name="delete" value="' . $key . '">Удалить</button>';
            echo '<span class="status">' . $task['status'] . '</span>';
            echo '</form>';
            echo '</div>';
        }
    }
    ?>
</div>
</body>
</html>
