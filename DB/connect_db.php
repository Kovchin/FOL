<?php

require_once 'DBRegistrationData.php';



class MyDB
{
    private $connect;       //соединение с БД
    //База fol_list
    private $crq;           //номер CRQ
    private $crq_value;     //название CRQ
    private $AllOpenCRQ;    //все открытые CRQ
    private $date_of_work;  //дата проведения работ
    //База fol_counterparty
    private $id_master;     //ID инициатора работ
    private $name_master;     //Имя инициатора работ
    private $email_master;     //Почта инициатора работ
    private $phone_master;     //Телефон инициатора работ
    //База fol_worcing_process
    //
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
        $temp = mysqli_query($this->connect, "SELECT * FROM `fol_list`");
        while ($record = mysqli_fetch_assoc($temp)) {
            if ($record['CRQ'] == $crq) {
                $this->crq = $record['CRQ'];
                $this->crq_value = $record['name'];
                $this->date_of_work = $record['date_of_work'];
            }
        }
        $this->AllOpenCRQ = mysqli_query($this->connect, "SELECT `CRQ` FROM `fol_list` WHERE `compleate` = 0");
    }

    //=======================
    //отображает все элементы массива что возвращает команда query
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

    //Функция запрашивает все открытые CRQ и выводит этот список в виде ниспадающего списка

    private function show_AllOpenCRQ()
    {
        if (isset($_REQUEST['crq'])) {
            echo '<select name="crq">';
            while ($crq = mysqli_fetch_assoc($this->AllOpenCRQ)) {
                if ($crq['CRQ'] == $this->crq)
                    echo '<option selected>' . $crq['CRQ'] . '</option>';
                else {
                    echo '<option>' . $crq['CRQ'] . '</option>';
                }
            }
            echo '</select>';
        } else {
            echo '<input type="text" name="crq" placeholder="Номер CRQ">';
        }
    }

    //показывает дату проведения работ

    private function show_date_of_work()
    {
        echo "<input name='date_of_work' type='date' value = " . $this->date_of_work . ">";
    }
}
