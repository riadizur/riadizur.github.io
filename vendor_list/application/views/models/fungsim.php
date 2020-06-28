<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fungsim extends CI_Model {

    function __construct()
    {
        parent::__construct();
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

}