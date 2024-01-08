<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $token = array(
            $this->security->get_csrf_token_name() => $this->security->get_csrf_hash(),
        );
    }
    public function index()
    {
        $this->load->view('pegawai');
    }
    public function read()
    {
        $table = "pegawai";
        $primaryKey = "pegawai_id";
        $db = array(
            'host'  => $this->db->hostname,
            'db'    => $this->db->database,
            'user'  => $this->db->username,
            'pass'  => $this->db->password,
            'dsn'  => $this->db->dsn,
        );
        $changecolumn = 7;
        $filter = array('pegawai_status = "1"');
        $filterall = array('pegawai_status = "1"');
        $field = array('pegawai_kode',
            'pegawai_kode', 'pegawai_nama', 'pegawai_alamat', 'pegawai_telepon',
            'pegawai_email',
            'pegawai_status', 'pegawai_status'
        );
        $columns = array();
        $i = 0;
        foreach ($field as $key => $value) {
            array_push($columns, array('db' => $value, 'dt' => $i));
            $i++;
        }
        $ssp_data = $this->ssp->complex($_GET, $db, $table, $primaryKey, $columns, $filter, $filterall);
        $data_rendered = array();
        $nomor = $_GET['start'] + 1;
        foreach ($ssp_data['data'] as $key => $value) {
            $record = $this->db->select('*')->from('pegawai')->where(array(
                'pegawai_id' => $value[0]
            ))->get()->result_array();
            $data[0] = $nomor;
            $nomor++;
            $button = '<button data-record="' . base64_encode(json_encode($record)) . '" class="btn  bg-gradient-warning btn-xs" onclick="onEdit(this);">Ubah</button> 
                       <button data-record="' . base64_encode(json_encode($record)) . '" class="btn  bg-gradient-danger btn-xs" onclick="onHapus(this);">Hapus</button>';
            $i = 1;
            unset($value[0]);
            foreach ($value as $k => $v) {
                $data[$i] = $value[$k];
                if ($changecolumn == "") {
                } else {
                    $data[$changecolumn] = $button;
                }
                $i++;
            }
            array_push($data_rendered, $data);
        }
        echo json_encode(array(
            'draw'              => $ssp_data['draw'],
            'recordsFiltered'   => $ssp_data['recordsFiltered'],
            'recordsTotal'      => $ssp_data['recordsTotal'],
            'data'              => $data_rendered,
        ));
    }
}
