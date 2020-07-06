<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

class Absensi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('absensim');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function absensi()
    {
        if ($this->session->userdata('ket') <> '') {
            $data['prev'] = $this->menum->main_menu();
            $this->load->view('ateh', $data);
            $datax['list_alasan'] = list_dropdown('absensi_alasan', array('kode', 'uraian'), array('1' => 1));
            $this->load->view('absensi/absensi', $datax);
            $this->load->view('bawah');
        } else {
            redirect('welcome/index');
        }
    }

    public function cari_pegawai()
    {
        date_default_timezone_set('Asia/Jakarta');
        $sekarang = date('Y-m-d');
        $wkt_now = date('H:i:s');
        $data = array();
        $nip = $this->input->post('nipp');
        $cek = cek_jlh_data('absensi_pegawai', array('nip' => $nip, 'status_nip' => 1), 'nip');
        if ($cek > 0) {
            # data ada
            if ($wkt_now >= '11:59:59' && $wkt_now <= '23:59:59') {
                #out
                $cek = cek_jlh_data('absensi_data', array('nip' => $nip, 'tanggal' => $sekarang, 'media_out' => 'Mesin FP'), 'nip');
                if ($cek > 0) {
                    # sudah absen via FP
                    $data['status'] = FALSE;
                    $data['informasi'] = 'Anda sudah melakukan absen pulang';
                } else {
                    # belum absen mungkin 
                    $data['status'] = TRUE;
                    $data['informasi'] = '';
                    $data['tombol'] = 'Absen Pulang';
                    $data['nama'] = row_tabel('absensi_pegawai', array('nip' => $nip), 'nama') . ' (' . row_tabel('absensi_pegawai', array('nip' => $nip), 'unit_kerja') . ')';
                }
            } else {
                #in
                $cek = cek_jlh_data('absensi_data', array('nip' => $nip, 'tanggal' => $sekarang, 'media_in' => 'Mesin FP'), 'nip');
                if ($cek > 0) {
                    # sudah absen via FP
                    $data['status'] = FALSE;
                    $data['informasi'] = 'Anda sudah melakukan absen masuk';
                } else {
                    # belum absen mungkin
                    $data['status'] = TRUE;
                    $data['informasi'] = '';
                    $data['tombol'] = 'Absen Masuk';
                    $data['nama'] = row_tabel('absensi_pegawai', array('nip' => $nip), 'nama') . ' (' . row_tabel('absensi_pegawai', array('nip' => $nip), 'unit_kerja') . ')';
                }
            }
        } else {
            # tidak ada
            $data['status'] = FALSE;
            $data['informasi'] = 'Data tidak ditemukan';
        }
        echo json_encode($data);
    }

    public function simpan_absensi()
    {
        $data = array();
        $datax = array();
        $nip = $this->input->post('no_induk');
        $alasan = $this->input->post('alasan');
        $kegiatan = $this->input->post('ket');
        $waktu = waktu_ini();
        $media = 'online';
        $cek = cek_jlh_data('absensi_log', array('nip' => $nip, 'waktu' => $waktu, 'media' => $media), 'nip');
        if ($cek > 0) {
            # datanya ada
            $id = row_tabel('absensi_log', array('nip' => $nip, 'waktu' => $waktu, 'media' => $media), 'id');
            $data['waktu'] = $waktu;
            $data['media'] = $media;
            $data['alasan'] = $alasan;
            $data['kegiatan'] = $kegiatan;
            $this->absensim->update("absensi_log", array("id" => $id), $data);
        } else {
            # tidak ada
            $data['nip'] = $nip;
            $data['waktu'] = $waktu;
            $data['media'] = $media;
            $data['alasan'] = $alasan;
            $data['kegiatan'] = $kegiatan;
            $this->absensim->save("absensi_log", $data);
        }
        $this->absensim->update_absensi_data();
        $datax['status'] = TRUE;
        echo json_encode($datax);
    }

    public function tabel_absensi_sekarang()
    {
        $data = array();
        $i = 1;
        $hasil = result_tabel('v_absensi_data_now', array('1' => 1));
        foreach ($hasil as $r) {
            $ket_in = (!empty($r->ket_in)) ? ' <br/><span style="font-size:10px;">(' . $r->ket_in . ')</span>' : '';
            $ket_out = (!empty($r->ket_out)) ? ' <br/><h6 style="font-size:10px;">(' . $r->ket_out . ')</h6>' : '';
            $row = array();
            $row[] = $i;
            $row[] = $r->nip . ' - ' . $r->nama;
            $row[] = (!empty($r->waktu_in)) ? substr($r->waktu_in, 11, 9) : '-';
            $row[] = $r->media_in . $ket_in;
            $row[] = (!empty($r->waktu_out)) ? substr($r->waktu_out, 11, 9) : '-';
            $row[] = $r->media_out . $ket_out;
            $data[] = $row;
            $i++;
        }

        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function tabel_absensi_belum()
    {
        $data = array();
        $i = 1;
        $hasil = result_tabel('v_absensi_data_now_belum', array('1' => 1));
        foreach ($hasil as $r) {
            $row = array();
            $row[] = $i;
            $row[] = $r->nip;
            $row[] = $r->nama;
            $row[] = $r->unit_kerja;
            $data[] = $row;
            $i++;
        }

        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function waktu_sekarang()
    {
        $datax['tanggal']  = tanggal_ttd_2(substr(waktu_ini(), 0, 10));
        $datax['waktu']  = substr(waktu_ini(), 11, 9);
        echo json_encode($datax);
    }

    public function get_data_absen()
    {
        $data = $this->absensim->get_data_absen();
        echo $data;
    }

    public function cek_data_absen()
    {
        $data = $this->absensim->cek_data_absen();
        echo $data;
    }
}
