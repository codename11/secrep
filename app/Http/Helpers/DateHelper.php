<?php

namespace App\Http\Helpers;
use DateTime;

class DateHelper
{
    private $date;
    function __construct($date) {
        $this->date = $date;
    }

    public function checkIfDate()
    {//Checks the string if it's a date. If true return date, otherwise returns false.

        $mydate = date("Y-m-d", strtotime(str_replace('/', '-', $this->date)));
        $dateTime = DateTime::createFromFormat('Y-m-d', $mydate);
        $errors = DateTime::getLastErrors();
        if (!empty($errors['warning_count'])) {
            return false;
        }
        else{
            return $mydate;
        }

    }

}