<?php
require_once 'DB/connect_db.php';
require_once 'php/add_counterparty.php';
require_once 'Db/DBRegistrationData.php';

$db = new MyDB();
//$db->show_all_method_Class_DB(); - показывает все свойства класса
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>CRQ <?= $db->get_crq() ?></title>
</head>

<body>
	<a href="index.php">К списку тех карт</a>
	<form action="detail.php" method="get" name="crq">
		<?php
		$db->show_CRQ();
		?>
		<input name="load" type="submit" value="Загрузить CRQ">
		<input name="add" type="submit" value="Добавить CRQ">
		<input name="update" type="submit" value="Обновить CRQ">
		<!-- </form>-->
		<hr>
		<!-- <form action="#" method="get">-->
		<p><a href="pages\add_counterparty.php">Добавить контрагента</a></p>
		<?php
		show_counerparty();
		echo get_idByName('fol_counterparty', 'name', $_REQUEST['counterparty']);
		?>
	</form>
	<hr>
	<form action="#" method="post">
		<h2>Этапы согласования ТК</h2>
		<table>
			<tr>
				<th>Этап</th>
				<th>Дата/время получения согласования</th>
				<th>Отправлена на доработку</th>
			</tr>
			<tr>
				<td>
					<p>Получена в ГУиМ</p>
				</td>
				<td><input type="date" name="" id=""></td>
				<td><input type="checkbox" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласование в МУС Энергетики</td>
				<td><input type="date" name="" id=""></td>
				<td><input type="checkbox" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласование в ФСК</td>
				<td><input type="date" name="" id=""></td>
				<td><input type="checkbox" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласование в МТС</td>
				<td><input type="date" name="" id=""></td>
				<td><input type="checkbox" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласование в РТК</td>
				<td><input type="date" name="" id=""></td>
				<td><input type="checkbox" name="" id=""></td>
			</tr>
		</table>
		<p>Тех карта согласована: <input type="checkbox" name="" id=""></p>
		<input type="submit" value="Зарегестрировать">
	</form>
	<hr>
	<h2>Этапы согласования заявки ВОЛС</h2>
	<form action="#" method="post">
		<table>
			<tr>
				<td>Получена в ГУиМ</td>
				<td><input type="date" name="" id=""></td>
			</tr>
			<tr>
				<td>Отправлена всем</td>
				<td><input type="date" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласована МУСЭ</td>
				<td><input type="date" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласована ФСК</td>
				<td><input type="date" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласована МТС</td>
				<td><input type="date" name="" id=""></td>
			</tr>
			<tr>
				<td>Согласована РТК</td>
				<td><input type="date" name="" id=""></td>
			</tr>
		</table>
		<p>Заявка в АСУ РЭО: <input type="number" name="" id=""></p>
		<input type="submit" value="Обновить">
	</form>

	<hr>
	<form action="#" method="post">
		<p>Отмена работ: <input type="checkbox" name="" id=""></p>
		<p>Информирование об отмене <input type="checkbox" name="" id=""></p>
		<input type="submit" value="Обновить">
	</form>
</body>

</html>