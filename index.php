<!DOCTYPE html>
<html>
	<head lang = 'ru'> 
		<meta charset = 'UTF-8'>
		<title>MainPageScore</title>
		<style type = 'text/css'>
			body {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
			}
			
			<!--#name, #score, #screenshot {
				margin-bottom: 5px;
			}
			
			label {
			display: block;
			float: left;
			width: 125px;
			height: 10px;
			}--> 

            .highscore {
                border: 1px blue solid;
                font-size: 30px;
                color: white;
                background-color: black;
                width: 300px;
                height: 70px;
                padding: 5px;
                text-align: center;
            }
		</style>
	</head>
	
	<body>
		<h2>Гитарные войны.<br> Список рейтингов.</h2>
		<p>Добро пожаловать, гитарный воин! Твой рейтинг бьет рекорд,<br>
		   зарегистрированный в этом списке рейтингов? Если так, просто <br>
		   <a href = 'addscore.php'><b>добавь свой рейтинг</b></a> в список.</p>
        <hr />
	<?php
		require_once("appvars.php");
        require_once("connectvars.php");

		//define("GW_UPLOADPATH", "C:/xampp/htdocs/homework/PHP_MYSQL/Cp5/images/");
		//$unver = 'C:/xampp/htdocs/homework/PHP_MYSQL/Cp5/images/' . 'unverified.gif';
		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		mysqli_set_charset($dbc, 'utf8');
		
		$query = "SELECT * FROM guitarwars ORDER BY score DESC, data ASC";
		$result = mysqli_query($dbc, $query);
		
		echo '<table>';

		/*while($row = mysqli_fetch_array($result)) {

            echo '<span class = "score">' . $row['score'] . '</span><br>';
			echo '<b>Имя:</b> ' . $row['name'] . '<br>';
			echo '<b>Дата:</b> ' . $row['data'] . '<br>';
			if ((is_file((GW_UPLOADPATH . $row['screenshot'])) && filesize((GW_UPLOADPATH . $row['screenshot']))) > 0) {
				echo '<img src = "' . GW_UPLOADPATH . $row['screenshot'] . '" alt = "Подтверждено" ><br><br>';
			}	else {
					echo '<img src = "' . GW_UPLOADPATH . $row['screenshot'] . '" alt = "Неподтверждено"><br><br>';
			}
		}*/

        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result);
                if ($i == 0) {
                    echo '<div class = "highscore">Наивысший рейтинг:<br>' . $row['score'] . '</div><hr><br>';
                }
            echo '<span class = "score">' . $row['score'] . '</span><br>';
            echo '<b>Имя:</b> ' . $row['name'] . '<br>';
            echo '<b>Дата:</b> ' . $row['data'] . '<br>';
            if ((is_file((GW_UPLOADPATH . $row['screenshot'])) && filesize((GW_UPLOADPATH . $row['screenshot']))) > 0) {
                echo '<img src = "' . GW_UPLOADPATH . $row['screenshot'] . '" alt = "Подтверждено" ><br><br>';
            }	else {
                echo '<img src = "' . GW_UPLOADPATH . $row['screenshot'] . '" alt = "Неподтверждено"><br><br>';
            }
        }
		echo '</table>';
		mysqli_close($dbc);
	?>
	</body>
</html>