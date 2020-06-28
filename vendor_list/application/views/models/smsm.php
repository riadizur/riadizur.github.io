<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Smsm extends CI_Model {

	function  sendsms($MENU='',$BULAN='',$TAHUN='',$ID_LANG='',$ALAMAT_LANG='',$NO_TUJUAN='',$RPTAG=''){
		
		if($MENU == "pemutusan"){
			
			$pesan2[] = "[SMS KE 2 DARI 2 SMS] Pada bulan $BULAN. Oleh sebab itu, akan segera dilakukan pemutusan aliran listrik. Mohon dilakukan pembayaran. Terima Kasih";
			
			$p1 = $this->db->query("INSERT INTO smsd.outbox (DestinationNumber, TextDecoded, CreatorID) 
						VALUES ('$NO_TUJUAN','".$pesan2[0]."', 'ilham') ");
			
			$pesan1[] = "[SMS KE 1 DARI 2 SMS] Plg Yth. ID Lang $ID_LANG Lokasi ".substr($ALAMAT_LANG,0,20)."..... telah melewati batas akhir pembayaran tagihan rekening listrik";
			
			if($p1){
				$this->db->query("INSERT INTO smsd.outbox (DestinationNumber, TextDecoded, CreatorID) 
						VALUES ('$NO_TUJUAN','".$pesan1[0]."', 'ilham') ");
			}
			
			echo "SMS PEMUTUSAN DIKIRIM KE:	".$NO_TUJUAN."<br>";
		}else{
			
			$pesan1[] = "Plg Yth. ID Lang $ID_LANG Lokasi ".substr($ALAMAT_LANG,0,20)."..... ,tagihan untuk rek.bln $BULAN $TAHUN Rp.$RPTAG . Terimakasih";
			
			$this->db->query("INSERT INTO smsd.outbox (DestinationNumber, TextDecoded, CreatorID) 
					VALUES ('$NO_TUJUAN','".$pesan1[0]."', 'ilham') ");
			
			
			echo "SMS INVOICE DIKIRIM KE:	".$NO_TUJUAN."<br>".$pesan1[0];
		}
		
		/*switch ($MENU) {
			case "pemutusan":
				$pesan2[] = "[SMS KE 2 DARI 2 SMS] Pada bulan $BULAN. Oleh sebab itu, akan segera dilakukan pemutusan aliran listrik. Mohon dilakukan pembayaran. Terima Kasih";
			
				$p1 = $this->db->query("INSERT INTO smsd.outbox (DestinationNumber, TextDecoded, CreatorID) 
							VALUES ('$NO_TUJUAN','".$pesan2[0]."', 'ilham') ");
				
				$pesan1[] = "[SMS KE 1 DARI 2 SMS] Plg Yth. ID Lang $ID_LANG Lokasi ".substr($ALAMAT_LANG,0,20)."..... telah melewati batas akhir pembayaran tagihan rekening listrik";
				
				if($p1){
					$this->db->query("INSERT INTO smsd.outbox (DestinationNumber, TextDecoded, CreatorID) 
							VALUES ('$NO_TUJUAN','".$pesan1[0]."', 'ilham') ");
				}
				
				echo "SMS PEMUTUSAN DIKIRIM KE:	".$NO_TUJUAN."<br>";
				break;
			case "pemutusankedua":
				echo "on the way";
				break;
			case "pembongkaran":
				echo "on the way";
				break;
			case "invoice":
				$pesan2[] = "[SMS KE 2 DARI 2 SMS] Pada bulan $BULAN. Oleh sebab itu, akan segera dilakukan pemutusan aliran listrik. Mohon dilakukan pembayaran. Terima Kasih";
			
				$p1 = $this->db->query("INSERT INTO smsd.outbox (DestinationNumber, TextDecoded, CreatorID) 
							VALUES ('$NO_TUJUAN','".$pesan2[0]."', 'ilham') ");
				
				$pesan1[] = "[SMS KE 1 DARI 2 SMS] Plg Yth. ID Lang $ID_LANG Lokasi ".substr($ALAMAT_LANG,0,20)."..... telah melewati batas akhir pembayaran tagihan rekening listrik";
				
				if($p1){
					$this->db->query("INSERT INTO smsd.outbox (DestinationNumber, TextDecoded, CreatorID) 
							VALUES ('$NO_TUJUAN','".$pesan1[0]."', 'ilham') ");
				}
				
				echo "SMS INVOICE DIKIRIM KE:	".$NO_TUJUAN."<br>";
				break;
		}*/

		
		
	}

}