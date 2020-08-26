<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h1>Гитарные войны.<br>Удаление рейтингов.</h1>
    <?php
        require_once("appvars.php");
        require_once("connectvars.php");

        if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['data']) &&
            isset($_GET['score']) && isset($_GET['screenshot'])) {
            $id = $_GET['id'];
            $name = $_GET['name'];
            $data = $_GET['data'];
            $score = $_GET['score'];
            $screenshot = $_GET['screenshot'];
        }   else if (isset($_POST['id']) && isset($_POST['name']) &&
            isset($_POST['score']) && isset($_POST['screenshot'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $score = $_POST['score'];
                $screenshot = $_POST['screenshot'];
        }   else {
                echo '<p class = "error">Извините, но ни одного рейтинга не было выбрано для удаления.</p>';
        }

        if (isset($_POST['submit'])) {
            if ($_POST['confirm'] == 'yes') {
                @unlink(GW_UPLOADPATH . $screenshot);

                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                mysqli_set_charset($dbc, 'utf8');

                $query = "DELETE FROM guitarwars WHERE id = $id LIMIT 1";
                $result = mysqli_query($dbc, $query);

                mysqli_close($dbc);

                echo 'Рейтинг ' . $score . ' пользователя ' . $name .
                     ' был успешно удален из базы данных.<br>';
            }   else {
                    echo '<p class = "error">Рейтинг не был удален.</p>';
            }

        }   else {
                echo '<p>Вы уверены, что хотите удалить этот рейтинг?</p>';
                echo '<form method = "post" action = "removescore.php"><p><b>Имя</b>: ' . $name . '</p>';
                echo '<p><b>Дата</b>: ' . $data . '</p>';
                echo '<p><b>Рейтинг</b>: ' . $score . '</p>';
                echo '<input type = "radio" name = "confirm" value = "yes" >Да';
                echo '<input type = "radio" name = "confirm" value = "no" >Нет<br>' ;
                echo '<input type = "submit" name = "submit" value = "Удалить">';
                echo '<input type = "hidden" name = "id" value = "' . $id . '">';
                echo '<input type = "hidden" name = "name" value = "' . $name . '">';
                echo '<input type = "hidden" name = "score" value = "' . $score . '">';
                echo  '<input type = "hidden" name = "screenshot" value = "' . $screenshot . '"></form>';
        }
    ?>
    <a href = 'admin.php'>&lt;&lt;Назад к странице "Администрирование рейтингов"</a>
</body>
</html>


