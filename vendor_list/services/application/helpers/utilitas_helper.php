<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('FormatDateToMysql')){
	function FormatDateToMysql($str){
			$tm = explode('/', $str);
			return $tm[2].'-'.$tm[1].'-'.$tm[0];
	}
}

if(!function_exists('FormatDateFromMysql')){
	function FormatDateFromMysql($str){
		if(strlen($str)>=10 && substr($str,4,1)=='-' && substr($str,7,1)=='-'){
			$y = substr($str, 0, 4);
			$m = substr($str, 5, 2);
			$d = substr($str, 8, 2);
			return $d.'/'.$m.'/'.$y;
		}
	}
}

function  tanggal_ind($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $tanggal[1];
        $tahun  =  $tanggal[0];
        return  $tanggal[2].'-'.$bulan.'-'.$tahun;
}
        
function  getBulan($bln){
	switch  ($bln){
		case  1:
			return  "Januari";
			break;
		case  2:
			return  "Februari";
			break;
		case  3:
			return  "Maret";
			break;
		case  4:
			return  "April";
			break;
		case  5:
			return  "Mei";
			break;
		case  6:
			return  "Juni";
			break;
		case  7:
			return  "Juli";
			break;
		case  8:
			return  "Agustus";
			break;
		case  9:
			return  "September";
			break;
		case  10:
			return  "Oktober";
			break;
		case  11:
			return  "November";
			break;
		case  12:
			return  "Desember";
			break;
	}
}

function sel_hari($tgl1,$tgl2){
	$tglx = new DateTime($tgl1);
	$tgly = new DateTime($tgl2);
	$selisih = $tglx->diff($tgly);

	return $selisih->days;
}