<?php

class check{
    public function check_phone($string)
    {
        if(preg_match('/d+/',$string))
        {
            return true;
        }
        else 
        {
            return false;
        }   
    }
}