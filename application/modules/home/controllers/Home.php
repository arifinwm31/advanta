<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MX_Controller
{
    
    public function index()
    {
        $user = $this->session->userdata('user_id');
        if ($user == "") {
            $this->load->view('signin/signin');
        } else {

            // $hak = $this->session->userdata('user_hak_akses');
            // $datamenu = $this->db->select('*')->from('v_menu_role')->where(array(
            //     'menu_role_hak_akses' => $hak,
            //     'menu_status' => 1,
            //     'menu_kategori' => 'induk'
            // ))->order_by('menu_nomor ASC')->get()->result_array();

            // $html = '';
            // foreach ($datamenu as $key => $value) {
            //     $html .= '<li class="nav-item has-treeview">';
            //     $html .= '<a href="javascript:void(0);" data-page=""  class="nav-link">';
            //     $html .= $value['menu_icon'] . ' ' . $value['menu_nama'] . '<i class="fas fa-angle-left right"></i></a>';
            //     $html .= '<ul  class="nav nav-treeview">';
            //     $submenu = $this->db->select('*')->from('v_menu_role')->where(array(
            //         'menu_sub' => $value['menu_id'],
            //         'menu_status' => 1,
            //         'menu_role_hak_akses' => $hak,
            //         'menu_kategori' => 'sub'
            //     ))->order_by('menu_nomor', 'ASC')->get()->result_array();

            //     foreach ($submenu as $keys => $values) {
            //         $html .= '<li class="nav-item" style="padding-left:10px;">';
            //         $html .= '<a href="javascript:void(0);" class="nav-link" data-page="' . $values['menu_link'] . '" onclick="onLoad(this);" id="btn-' . $values['menu_kode'] . '">' . $values['menu_icon'] . ' ' . $values['menu_nama'] . '</a>';
            //         $html .= '</li>';
            //     }
            //     $html .= '</ul>';
            //     $html .= '</li>';
            // }

            $this->load->view('home', array(
                'user' => $user
            ));
        }
    }
    
}
