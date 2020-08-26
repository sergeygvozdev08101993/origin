<!DOCTYPE html>
<html>
<head lang = 'ru'>
    <meta charset = 'UTF-8'>
    <title>AdminPage</title>
</head>

<body>
    <h1>Гитарные войны.<br>Администрирование рейтингов.</h1>
    <p>Ниже приведен список рейтингов приложения.<br>
        Используйте эту страницу, если Вам <br> необходимо удалить один или несколько рейтингов.</p>
    <hr>
<?php
    require_once("appvars.php");
    require_once("connectvars.php");

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_set_charset($dbc, 'utf8');

    $query = "SELECT * FROM guitarwars ORDER BY score DESC, data ASC";
    $result = mysqli_query($dbc, $query);

    echo '<table>';

    while($row = mysqli_fetch_array($result)) {
        echo '<tr class = "scorerow"><td><b>' . $row['name'] . '</b></td>';
        echo '<td>' . $row['data'] . '</td>';
        echo '<td>' . $row['score'] . '</td>';
        echo '<td><a href = "removescore.php?id=' . $row['id'] . '&amp;data=' . $row['data'] . '&amp;
              name=' . $row['name'] . '&amp;score=' . $row['score'] . '&amp;
              screenshot=' . $row['screenshot'] . '">Удалить</a></td></tr>';

    }
    echo '</table>';

    mysqli_close($dbc);
?>

</body>
</html>