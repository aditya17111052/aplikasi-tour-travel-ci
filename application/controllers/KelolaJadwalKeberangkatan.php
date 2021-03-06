<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class KelolaJadwalKeberangkatan extends MY_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model("ModelJenisProgram", "program");
    $this->load->model("ModelJadwalKeberangkatan", "jadwal_keberangkatan");
    $this->load->model("ModelKeberangkatan", "jadwal");
  }
  
  //  Method untuk menampilkan data
	public function daftar()
	{
    $this->_dts['data_list'] = $this->jadwal_keberangkatan->ambilData();  // Proses pengambilan data dari database
		$this->view('admin.jadwalkeberangkatan.daftar', $this->_dts); // Oper data dari database ke view
	}
  
  public function daftarJadwalKeberangkatan()
  {
    $this->_dts['data_list'] = $this->jadwal_keberangkatan->ambilData();  // Proses pengambilan data dari database
		$this->view('member.jadwalkeberangkatan.daftar', $this->_dts); // Oper data dari database ke view
  }
  
  // Method untuk menampilkan form tambah data
  public function tambahData()
  {
    $this->_dts['data_program'] = $this->program->ambilData();
    $this->view('admin.jadwalkeberangkatan.tambah', $this->_dts); // Langsung tampilkan view tambah data
  }
  
  // Method untuk memproses penambahan data
  // Method diakses dalam metode POST
  public function prosesTambah()
  {
    $this->jadwal_keberangkatan->tambahData($this->input->post(NULL, TRUE));
    header("Location: ".site_url("jadwalkeberangkatan")); // Arahkan kembali user ke halaman daftar
  }
  
  // Method untuk menampilkan form edit
  public function ubahData()
  {
    $this->_dts['data_program'] = $this->program->ambilData();
    $this->_dts['detail'] = $this->jadwal_keberangkatan->ambilData($this->input->get('id_jadwal')); // Ambil data yang akan diedit berdasarkan ID
    $this->view('admin.jadwalkeberangkatan.edit', $this->_dts); // Oper data ke view
  }
  
  // Method untuk memproses data yang akan diedit
  public function prosesEdit()
  {
    $this->jadwal_keberangkatan->ubahData($this->input->post("id_jadwal"), $this->input->post(NULL, TRUE));
    header("Location: ".site_url("jadwalkeberangkatan")); // Arahkan user kembali ke halaman daftar
  }
  
  // Method untuk menghapus data
  public function prosesHapus()
  {
    $this->jadwal_keberangkatan->hapusData($this->input->get('id_jadwal')); // Proses hapus data
    header("Location: ".site_url("jadwalkeberangkatan")); // // Arahkan user kembali ke halaman daftar
  }
  
  public function pesertaKeberangkatan()
  {
    $this->_dts['detail_jadwal'] = $this->jadwal_keberangkatan->ambilData($this->input->get('id_jadwal')); // Proses hapus data
    $this->_dts['data_list'] = $this->jadwal->pesertaKeberangkatan($this->input->get('id_jadwal')); // Proses hapus data
    $this->view('member.jadwalkeberangkatan.pesertakeberangkatan', $this->_dts);
  }
  
  public function kelolaPesertaKeberangkatan()
  {
    $this->_dts['detail_jadwal'] = $this->jadwal_keberangkatan->ambilData($this->input->get('id_jadwal')); // Proses hapus data
    $this->_dts['data_list'] = $this->jadwal->pesertaKeberangkatan($this->input->get('id_jadwal')); // Proses hapus data
    $this->view('admin.jadwalkeberangkatan.pesertakeberangkatan', $this->_dts);
  }
  
  public function hapusPesertaKeberangkatan()
  {
    $this->jadwal->hapusData($this->input->get('id_keberangkatan'));
    header("Location: ".site_url("jadwalkeberangkatan/peserta?id_jadwal=".$this->input->get('id_jadwal')));
  }
}
