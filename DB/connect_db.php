<?php

require_once 'DBRegistrationData.php';



class MyDB
{
    private $connect;                   //соединение с БД\

    private $arr_counterparty;          //Массив организаций arr[id][name|email|phone] формируется из таблицы fol_counterparty
    private $arr_system_flag;           //Массив состояния хода работ берется из таблицы fol_system_flag arr[name] (номер элемента массива это id)
    private $arr_All_Open_CRQ;          //Массив всех открытых инцидентов
    private $arr_work;                  //Массив хода работ по номеру CRQ 
    /*
    Поле flag таблицы fol_working_process от этого флага зависит логика парсинга массива $arr_work
    1 - Инициатор
    2 - Согласование ТК
    3 - Согласование заявки ВОЛС
    4 - Рассылка на всех
    5 - Отправлена на доработку
    6 - Вариант согласован
    7 - Информирование об отмене
    */
    //База fol_list     
    private $id_crq;                    //id CRQ
    private $crq;                       //номер CRQ
    private $crq_value;                 //название CRQ
    private $date_of_work;              //дата проведения работ

    //конструктор класса инициализирует все методы

    public function __construct()
    {
        $this->connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->connect == false) {
            echo 'Не удалось подключиться к базе данных';
            echo mysqli_connect_error();
            exit();
        }
        echo '<hr>Вы успешно подключились к базе данных ' . DB_NAME . '<hr>';
        $this->initialization_of_class_methods($_REQUEST['crq']);
        return $this->connect;
        exit();
    }

    //инициализация свойств класса
    private function initialization_of_class_methods($crq)
    {
        /*==================================
        Формирование полей из базы fol_list
        ==================================*/
        $temp = mysqli_query($this->connect, "SELECT * FROM `fol_list`");
        while ($record = mysqli_fetch_assoc($temp)) {
            if ($record['CRQ'] == $crq) {
                $this->id_crq = $record['id'];
                $this->crq = $record['CRQ'];
                $this->crq_value = $record['name'];
                $this->date_of_work = $record['date_of_work'];
            }
        }
        $this->AllOpenCRQ = mysqli_query($this->connect, "SELECT `CRQ` FROM `fol_list` WHERE `compleate` = 0");
        /*==================================
        //Формирование массива всх открытых инцидентов
        ==================================*/
        $temp = mysqli_query($this->connect, "SELECT `CRQ` FROM `fol_list` WHERE `compleate` = 0");
        while ($record = mysqli_fetch_assoc($temp)) {
            $this->arr_All_Open_CRQ[] = $record['CRQ'];
        }
        /*==================================
        Формирование массива из базы fol_counterparty
        ==================================*/
        $temp = mysqli_query($this->connect, "SELECT * FROM `fol_counterparty`");
        while ($record = mysqli_fetch_assoc($temp)) {
            $this->arr_counterparty[$record['id']] = array(
                'name' => $record['name'],
                'email' => $record['email'],
                'phone' => $record['phone']
            );
        }
        /*==================================
        Формирование массива из таблицы fol_system_flag
        ==================================*/
        $temp = mysqli_query($this->connect, "SELECT * FROM `fol_system_flag`");
        while ($record = mysqli_fetch_assoc($temp)) {
            $this->arr_system_flag[$record['id']] = $record['name'];
        }
        /*==================================
        Формирование полей из базы fol_working_process
        ==================================*/
        if (isset($_REQUEST['CRQ'])){

            $temp = mysqli_query($this->connect, "SELECT * FROM `fol_working_process` WHERE `id_crq` = $this->id_crq");
            while ($record = mysqli_fetch_assoc($temp)) {
                $this->arr_work[$this->arr_system_flag[$record['flag']]][] = array(
                    'id' => $record['id'],
                    'id_counterparty' => $record['id_counterparty'],
                    'data' => $record['data']
                );
            }
        }
    }

    /*==================================
    Метод выводящий все свойства класса (для отладки)
    ==================================*/

    public function show_all_method_Class_DB()
    {

        echo '<hr> <h1> Действующие методы класса DB <hr>';
        echo '<h2>Массив $arr_counterparty</h2>';
        $this->show_arr($this->arr_counterparty);
        echo '<h2>Массив $arr_system_flag</h2>';
        $this->show_arr($this->arr_system_flag);
        echo '<h2>Массив $arr_work</h2>';
        $this->show_arr($this->arr_work);
        echo '<h2>Массив $arr_All_Open_CRQ</h2>';
        $this->show_arr($this->arr_All_Open_CRQ);
        if (isset($_REQUEST['CRQ'])){
        echo '<br /> <b>id_crq</b> = ' . $this->id_crq . '<br />';
        echo '<br /> <b>crq</b> = ' . $this->crq . '<br />';
        echo '<br /> <b>crq_name</b> = ' . $this->crq_value . '<br />';
        echo '<br /> <b>date_of_work</b> = ' . $this->date_of_work . '<br />';
        }
        echo '<hr>';
    }
    /*==================================
    Метод выводит на экран массив (для отладки)
    ==================================*/

    private function show_arr($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    //=======================
    //отображает все элементы массива что возвращает команда query (для отладки)
    //=======================

    private function show_rows($rows)
    {
        echo '<pre>';
        while ($record = mysqli_fetch_assoc($rows)) {
            print_r($record);
        }
        echo '</pre>';
    }

    //возвращает текущее crq

    public function get_crq()
    {
        return $this->crq;
    }

    //отрисовывает на основании данных класса форму CRQ

    public function show_CRQ()
    {
        ?>
        <table>
            <tr>
                <td>
                    <p>CRQ:</p>
                </td>
                <td>
                    <?php $this->show_AllOpenCRQ(); ?>
                </td>
            </tr>
            <td>
                <p>Название работ: </p>
            </td>
            <td>
                <textarea name="crq_value" rows="3" cols="20"><?= $this->crq_value ?></textarea>;
            </td>
            <tr>
                <td>
                    <p>Дата проведения работ: </p>
                </td>
                <td>
                    <?php $this->show_date_of_work(); ?>
                </td>
            </tr>
        </table>
    <?php
    }

    //Метод запрашивает все открытые CRQ и выводит этот список в виде ниспадающего списка оставля фокус на текущем открытом CRQ

    private function show_AllOpenCRQ()
    {
        if (isset($_REQUEST['crq'])){
            echo '<select name="crq">';
            for ($i=0; $i < count($this->arr_All_Open_CRQ);$i++){
                if ($this->arr_All_Open_CRQ[$i] == $this->crq)
                echo '<option selected>'.$this->arr_All_Open_CRQ[$i].'</option>';
                else 
                    echo '<option>' . $this->arr_All_Open_CRQ[$i] . '</option>';
            }
            echo '</select>';
        }
        else 
            echo '<input type="text" name="crq" placeholder="Номер CRQ">';
    }

    //Метод выводит дату проведения работ

    private function show_date_of_work()
    {
        echo "<input name='date_of_work' type='date' value = " . $this->date_of_work . ">";
    }
}
