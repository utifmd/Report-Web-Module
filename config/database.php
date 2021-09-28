<?php session_start();
    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $mysqli = new Mysqli("localhost", "root", "9809poiiop", "rsia", 3306); //$mysqli = new Mysqli("192.168.1.54", "online", 123456, "fadhila", 3306); 
    $list_month = array("Pilih Bulan", "Januari", "Februari", "Maret", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"); // date('F', mktime(0, 0 ,0 , $i, 1, date('Y')));
    $list_institute = array("Pilih Institusi", "BPJS", "UMUM");
    $app_name = "RSIA Fadhila Batusangkar";
    $var_date_length = 31;
    $total_summary = 0; ?>