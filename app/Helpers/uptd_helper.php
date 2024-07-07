<?php

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

function testHelper() {
    die('Helper is ready');
}

function last_query($result = '') {
    DB::enableQueryLog();

    // and then you can get query log

    dd(DB::getQueryLog());
}

function hitung_umur($tanggal_lahir){
	$birthDate = new DateTime($tanggal_lahir);
	$today = new DateTime("today");
	if ($birthDate > $today) { 
	    // exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	// $m = $today->diff($birthDate)->m;
	// $d = $today->diff($birthDate)->d;
	// return $y." tahun ".$m." bulan ".$d." hari";
    return $y;
}

function getNotif() {
    $data = DB::select('select el.*, em.fullname from emp_leaves as el join employees as em on em.nik = el.emp_nik where approved2 = "X" ');
    return $data;
}

function rupiah($angka) {
    $hasil_rupiah = "Rp " . nip_format($angka, 2, ',', '.');
    echo $hasil_rupiah;
}

if (!function_exists('getMonthName')) {
    function getMonthName($bln) {
        switch ($bln) {
            case '1':
                $bulan = 'Januari';
                break;
            case '2':
                $bulan = 'Februari';
                break;
            case '3':
                $bulan = 'Maret';
                break;
            case '4':
                $bulan = 'April';
                break;
            case '5':
                $bulan = 'Mei';
                break;
            case '6':
                $bulan = 'Juni';
                break;
            case '7':
                $bulan = 'Juli';
                break;
            case '8':
                $bulan = 'Agustus';
                break;
            case '9':
                $bulan = 'September';
                break;
            case '10':
                $bulan = 'Oktober';
                break;
            case '11':
                $bulan = 'November';
                break;
            case '12':
                $bulan = 'Desember';
                break;
            default:
                break;
        }
        return $bulan;
    }
}

// Mendapatkan file script
function getContentScript($isAdmin, $filename) {
    if($isAdmin === true) {
        $filename_script = base_path() . '/public/js/admin-page/' . $filename . '.js';
        if (file_exists($filename_script)) {
            $filename_script = 'js/admin-page/'. $filename;
        } else {
            $filename_script = 'js/admin-page/default_script';
        }
    } else {
        $filename_script = base_path() . '/public/js/user-page/' . $filename . '.js';
        if (file_exists($filename_script)) {
            $filename_script = 'js/user-page/'. $filename;
        } else {
            $filename_script = 'js/admin-page/default_script';
        }
    }
    
    return $filename_script;
}

function getLasNumberAdmin($level = '') {
    
    if($level == 1) {
        $code = 'HR';
    } else if($level == 2) {
        $code = 'DV';
    } else {
        $code = 'XX';
    }
    $lastCode = User::max('nip');

    if($lastCode) {
        $lastCode = substr($lastCode, -4);
        $code_ = sprintf('%04d', $lastCode+1);
        $nipFix = $code.date('Ymd').$code_;
    } else {
        $nipFix = $code.date('Ymd')."0001";
    }

    return $nipFix;
}

function getLasNumberDiv() {
        
    $lastCode = User::max('nip');

    if($lastCode) {
        $lastCode = substr($lastCode, -4);
        $code_ = sprintf('%04d', $lastCode+1);
        $nipFix = "DV".date('Ymd').$code_;
    } else {
        $nipFix = "DV".date('Ymd')."0001";
    }

    return $nipFix;
}

function getLasNumberEmp() {
        
    $lastCode = Employee::max('nik');

    if($lastCode) {
        $lastCode = substr($lastCode, -4);
        $code_ = sprintf('%04d', $lastCode+1);
        $nipFix = "EM".date('Ymd').$code_;
    } else {
        $nipFix = "EM".date('Ymd')."0001";
    }

    return $nipFix;
}

?>