<!DOCTYPE html>
<html>
	<head lang = 'ru'>
		<meta charset = 'UTF-8'>
		<title>AddScore</title>
		<style type = 'text/css'>
			body {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
			}
			
			#name, #score, #screenshot {
				margin-bottom: 5px;
			}
			
			label {
			display: block;
			float: left;
			width: 125px;
			height: 10px;
			}
			
		</style>
	</head>
	
	<body>
		<h2>Гитарные войны.<br> Добавьте свой рейтинг.</h2>
		
		<?php
            require_once("appvars.php");
            require_once("connectvars.php");

			//define("GW_UPLOADPATH", "C:/xampp/htdocs/homework/PHP_MYSQL/Cp5/images/");
			//$upload_path = 'C:/xampp/htdocs/homework/PHP_MYSQL/Cp5/images/';
			
			if (isset($_POST['submit'])) {
				$name = $_POST['name'];
				$score = $_POST['score'];
				$screenshot = $_FILES['screenshot']['name'];
                $screenshot_size = $_FILES['screenshot']['size'];
                $screenshot_type = $_FILES['screenshot']['type'];
				$flag = false;

                //($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE))

				if ((!empty($name)) && (!empty($score)) && (!empty($screenshot))) {
                    if ((($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') ||
                       ($screenshot_type == 'image/pjpeg') || ($screenshot_type ==  'image/png')) &&
                        (($screenshot_size > 0) && ($screenshot_size <= GW_MAXFILESIZE))) {
                         if ($_FILES['screenshot']['error'] == 0) {
                                $target = GW_UPLOADPATH . $screenshot;
                                $temp = $_FILES['screenshot']['tmp_name'];

                                    if(move_uploaded_file($temp, $target)) {

                                        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                        mysqli_set_charset($dbc, 'utf8');

                                        $query = "INSERT INTO guitarwars (data, name, score, screenshot)" .
                                            "VALUES (NOW(), '$name', '$score', '$screenshot')";
                                        $result = mysqli_query($dbc, $query);

                                        echo '<p>Спасибо за то, что добавили свой рейтинг!</p><br>';
                                        echo '<p><b>Имя:</b> ' . $name . '<br>';
                                        echo '<b>Рейтинг:</b> ' . $score . '<br>';
                                        echo '<b>Скриншот рейтинга:</b> ' . '<img src = "' . $target . '" alt = "Скриншот рейтинга" />' . '<br>';
                                        echo '<p><a href = "index.php">&lt;&lt;Назад к списку рейтингов</a></p>';

                                        $name = "";
                                        $score = "";
                                        $screenshot = "";

                                        mysqli_close($dbc);
                                    }
                            }   else {
                                echo '<p class = "error"> Извините, возникла ошибка при загрузке файла изображения.</p>';
                                $flag= true;
                            }
                    }   else {
                        echo '<p class = "error"> Файл, подтверждающий рейтинг, должен быть файлом изображения
                                                  в форматах GIF, PNG, JPEG и его размер не должен превышать 32 Кб.</p>';
                                $flag= true;
                    }
                    //@unlink($_FILES['screenshot']['tmp_name']);
				}   else {
                        echo '<p class = "error"> Введите, пожалуйста, всю информацию для добавления вашего рейтинга.</p>';
						$flag= true;}
			} else
                { $flag= true; }
		?>
		
		<hr />
		<?php 
			if ($flag) {
				?>
            <form enctype = 'multipart/form-data' method = 'post' action = '<?php echo $_SERVER['PHP_SELF']; ?>'>
               <!-- <input type = 'hidden' name = 'MAX_FILE_SIZE' value = '32768'>-->
                <label for = 'name'>Имя:</label>
                <input id = 'name' name = 'name' type = 'text' value = '<?php if(!empty($name)) echo $name; ?>'><br>
                <label for = 'score'>Рейтинг:</label>
                <input id = 'score' name = 'score' type = 'text' value = '<?php if(!empty($score)) echo $score; ?>'><br>
                <label for = 'screenshot'>Скриншот рейтинга:</label>
                <input id = 'screenshot' name = 'screenshot' type = 'file'><br>
		<hr />
			<input type = 'submit' name = 'submit' value = 'Добавить'>
			<?php } ?>			
		</form>
	</body>
</html>