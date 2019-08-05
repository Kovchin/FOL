<?php

require_once 'DB/DBRegistrationData.php';

class MyDBClass
{
    //Экземпляр класса базы данных
    private $conn;
    //Массив с выводом данных БД
    private $res_query;
    //Строка запроса
    private $query = 'SELECT * FROM `fol_list`';
    //Вывести на экран строку запроса
    public $table = [];

    public function show_query()
    {
        echo $this->query;
    }
    //Заменить строку запроса
    public function set_query($mystring)
    {
        $this->query = $mystring;
    }
    //Вернуть массив с результатом выполнения запроса к БД
    public function set_result_query()
    {
        //$res_query = $this->conn->query($this->query);
    }
    //Вывести на экран результат выполнения запроса
    public function show_result_query()
    {
        $this->table = [];
        while (($row = $this->res_query->fetch_assoc()) != false) {
            $this->table[] = $row;
        }
        echo '<pre>';
        print_r($this->table);
        echo '</pre>';
    }
    //Подключиться к базе данных исполнить запрос и вернуть результат ответа в массиве table[]
    public function connect()
    {
        $conn = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_errno) exit('Ошибка подключения к БД');
        $conn->set_charset('utf8');
        $this->set_result_query();

        $query = 'SELECT * FROM `fol_list`';
        $res = $conn->query($query);

        $this->table = [];
        while (($row = $res->fetch_assoc()) != false) {
            $this->table[] = $row;
        }
    }
}
