<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="index.css">
	<title>ВОЛС</title>
</head>

<body>
	<header>
		<p class='logo'>ОТС Сибири Droid</p>
		<p>Привет</p>
	</header>
	<aside>

	</aside>
	<main>
		<?php

		include_once 'DB.php';

		$t = new MyDBClass;
		$t->connect();

		?>

		<h1>Согласование работ на ВОЛС</h1>
		<button><a href="detail.php">Создать тех карту</a></button>
		<table>
			<tr>
				<th>№ CRQ</th>
				<th>Наименование работы по ТК</th>
				<th>Работы выполнены</th>
				<th>Работы согласованы</th>
				<th>Дата проведения работ</th>
			</tr>
			<?php
			foreach ($t->table as $value) {
				//Достаем значения полей текущей записи и раскладываем их по переменным
				$CRQ = $value['CRQ'];
				$name = $value['name'];
				if ($value['compleate'] == 1) $compleate = 'checked';
				else $compleate = '';
				if ($value['agreed'] == 1) $agreed = 'checked';
				else $agreed = '';
				$date_of_work = $value['date_of_work'];
				//Отрисовка записи
				echo
					'<tr class="red">
            <td>
            ' . $CRQ . '
            </td>
            <td><a href="detail.php?crq='.$CRQ.'">
			' . $name . '
			</a>
            </td>
            <td>
            <input type="checkbox" name="" id="" ' . $compleate . '>
            </td>
            <td>
            <input type="checkbox" name="" id="" ' . $agreed . ' disabled>
            </td>
            <td>
            <input type="date" value = "' . $date_of_work . '"></td>
            </tr>';
			}
			?>
		</table>
	</main>
	<footer>Все права защищены &copy; Ковчин П.В.</footer>
</body>

</html>