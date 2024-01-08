<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Signin extends MX_Controller
{
    public function index()
    {
        $this->load->view('signin');
    }

    function gen_uuid()
    {
        $res_id = $this->db->query('SELECT MD5(UUID()) as ID');
        $gen_id = $res_id->row_array();
        return $gen_id['ID'];
    }

    public function proccess()
    {
        // var_dump($_POST);exit;
        $hasil = $this->db->select('*')->from('user')->where(array(
            'user_name' => $_POST['username'],
            'user_password' => md5($_POST['password']),
        ))->get()->result_array();

        if (empty($hasil)) {
            echo json_encode(false);
        } else {
            foreach ($hasil as $sess) {
                $datauser['user_log_id'] = $this->gen_uuid();
                $datauser['user_log_user'] = $sess['user_id'];
                $datauser['user_log_tanggal'] = date('Y-m-d');

                $datauser['user_log_jam'] = date('H:i:s');
                $datauser['user_log_insert_at'] = date('Y-m-d H:i:s');
                $datauser['user_log_keterangan'] = $this->input->ip_address() . "|" . $this->agent->browser() . "|" . $this->agent->version() . "|" . $this->agent->platform() . "|" . date('Y-m-d H:i:s') . $_POST['username'] . ' Melakukan login pada tanggal ' . date('Y-m-d') . ' Jam ' . date('H:i:s');

                // $this->db->insert('user_log', $datauser);

                $sess_data['user_id'] = $sess['user_id'];
                $sess_data['user_name'] = $sess['user_name'];
                // $sess_data['pegawai_id'] = $sess['pegawai_id'];
                // $sess_data['pegawai_nama'] = $sess['pegawai_nama'];
                $sess_data['pegawai_id'] = $sess['user_id'];
                $sess_data['pegawai_nama'] = $sess['user_nama'];
                // $sess_data['pegawai_nip'] = $sess['pegawai_nip'];
                $sess_data['user_hak_akses'] = $sess['user_hak_akses'];
                // $sess_data['hak_akses_nama'] = $sess['hak_akses_nama'];
                // $sess_data['user_opd'] = $sess['user_opd'];
                $sess_data['user_approval'] = $sess['user_approval'];

                $this->session->set_userdata($sess_data);
            }
        }
    }

    public function destroy()
    {
        $this->session->sess_destroy();
        
    }
}
