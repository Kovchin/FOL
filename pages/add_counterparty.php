<?php
include_once '../DB/DBRegistrationData.php';
include_once '../php/add_counterparty.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <a href="../index.php">К списку CRQ</a>
    <h1>Добавить нового контрагента</h1>
    <form action="#" method="get">
        <table>
            <tr>
                <td>Название компании</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td><input type="tel" name="phone"></td>
            </tr>
            <tr>
                <td>email</td>
                <td><input type="email" name="email"></td>
            </tr>
        </table>
        <input type="submit" value="Добавить">
    </form>
    <?php include_once '../php/add_counterparty.php'; ?>
    <?= $a ?>
</body>

</html>