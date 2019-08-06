<?php

//require_once 'check.php';
//require_once '../DB/DBRegistrationData.php';

$name = $_REQUEST['name'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];

//Подключение к БД
function connect()
{
    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_errno) exit('Ошибка подключения к БД');
    $conn->set_charset('utf8');
    return $conn;
}

//Формирование запроса на добавление записи
if (strlen($name) > 0 && strlen($phone) > 0 && strlen($email)) {
    $sql = "INSERT INTO `fol_counterparty` (`id`, `name`, `email`, `phone`) VALUES (NULL, '" . $name . "', '" . $email . "', '" . $phone . "')";
    $db = connect();
    mysqli_query($db, $sql);
    echo 'Новый контрагент ' . $name . ' добавлен. <br />';
} else
    echo 'Проверьте корректность введенных данных!';

//Функция формирует список select/options на основании запроса $sql по полю $pole

function show_select_option($sql, $pole)
{
    $db = connect();
    $result = mysqli_query($db, $sql);
    echo '<select>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option> ' . $row[$pole] . ' </option>';
    }
    echo '</select>';
}

//Функция формирует список select/options на основании запроса $sql по полю $pole и делает дефолтным значение $selected_record

function show_select_option_def($sql, $pole, $selected_record)
{
    $db = connect();
    $result = mysqli_query($db, $sql);
    echo '<select name="counterparty">';
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row[$pole] == $selected_record)
            echo '<option selected>' . $row[$pole] . '</option>';
        else
            echo '<option> ' . $row[$pole] . ' </option>';
    }
    echo '</select>';
}

function show_counerparty()
{
    echo '<table><tr>';
    echo '<td>Инициатор работ: </td>';
    $check = $_REQUEST['counterparty'];
    echo '<td>' . show_select_option_def("SELECT `name` FROM `fol_counterparty`", "name", $check) . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>email: </td>';
    echo '<td>mmm</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>phone: </td>';
    echo '<td>ppp</td>';
    echo '</tr>';
    echo '</table>';
}

//Вернуть id таблицы $table по полю $pole_name со значением $value

function get_idByName($table, $pole_name, $value)
{
    $db = connect();
    $temp = mysqli_query($db, "SELECT * FROM `$table` WHERE `$pole_name` = '$value'");
    return  mysqli_fetch_assoc($temp)['id'];
}
