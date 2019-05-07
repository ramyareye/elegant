<?php

function jalali_date($separator = '،') {
    $date = new jDateTime(true, true, 'Asia/Tehran');

    return $date->date("l{$separator} j F Y");
}

function jalali_date_format($format = 'l, j F Y') {
    $date = new jDateTime(false, true, 'Asia/Tehran');

    return $date->date($format);
}
