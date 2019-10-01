@extends('components.layout_admin')

{{-- 
  Section tambahan:
  head : untuk penambahan kode didalam head
  script : untuk penambahan kode didalam script bagian paling bawah halaman
  sidebar : untuk mengatur menu pada sidebar
   --}}

@section('title', 'Peserta')
@section('sidebar_title', 'Peserta')
@section('user_image', 'images/img.jpg')
@section('username', 'Mandan')
@section('content_title', 'Peserta')

@section('content')
	@if($_SESSION['level'] == "Admin")
		<div class="row">
	    <div class="col-sm-2 col-xs-12">
	      <button type="button" onclick="showModalTambah()" class="btn btn-primary">Tambah Peserta</button>
	    </div>
	    <div class="col-sm-2 col-xs-12">
	      <div class="dropdown">
	        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">Cetak Laporan
	        <span class="caret"></span></button>
	        <ul class="dropdown-menu">
	          @foreach($data_program as $d)
	            <li><a href="{{ site_url('laporan/peserta?id_program='.$d['id']) }}" target="_blank">{{ $d['nama_program'] }}</a></li>
	          @endforeach
	        </ul>
	      </div>
	    </div>
	  </div>
	@else
		<?php
  	$bulan = date("m");
  	$tahun = date("Y");
  ?>
  	<div class="row">
      <div class="col-xs-12">
      	<form action="{{ site_url('laporan/peserta') }}" target="_blank">
      		<div class="form-group">
      			<div class="col-xs-2">
      				<label>Pilih Bulan</label>
      				<select class="form-control" name="bulan">
      					<option value="01">Januari</option>
      					<option value="02">Februari</option>
      					<option value="03">Maret</option>
      					<option value="04">April</option>
      					<option value="05">Mei</option>
      					<option value="06">Juni</option>
      					<option value="07">Juli</option>
      					<option value="08">Agustus</option>
      					<option value="09">September</option>
      					<option value="10">Oktober</option>
      					<option value="11">November</option>
      					<option value="12">Desember</option>
      				</select>
      				<script>
      					document.getElementsByName("bulan")[0].value = "<?=$bulan?>";
      				</script>
      			</div>
      			<div class="col-xs-2">
      				<label>Pilih Tahun</label>
      				<input type="number" name="tahun" min="1900" max="2100" class="form-control" placeholder="Tahun" value="<?=$tahun?>" />
      			</div>
      			<div class="col-xs-2">
      				<label>Pilih Program</label>
      				<select class="form-control" name="id_program">
      					<option>-- Pilih Program --</option>
      					  @foreach($data_program as $d)
			              <option value="{{ $d['id'] }}">{{ $d['nama_program'] }}</option>
			            @endforeach
      				</select>
      			</div>
      		</div>
      		<div class="form-group">
      			<button type="submit" class="btn btn-success" style="margin-top: 23px;">Cetak Laporan</button>
      		</div>
      	</form>
      </div>
    </div>
	@endif
  <br>
  <br>
  <div class="table-responsive">
    <div style="overflow:auto; max-height:650px; margin:0px 0 0px 0;">
      <table class="table table-bordered table-stripped">
      	<thead>
        <tr>
          <th>No</th>
          <th>Nama Lengkap</th>
          <th>Nama Panggilan</th>
          <th>Jenis Kelamin</th>
          <th>No Identitas</th>
          <th>Tempat Lahir</th>
          <th>Tanggal Lahir</th>
          <th>Alamat</th>
          <th>Telp Rumah</th>
          <th>Telp Kantor</th>
          <th>NoHP</th>
          <th>Email</th>
          <th>Warga Negara</th>
          <th>Pekerjaan</th>
          <th>Ukuran Baju</th>
          <th>Ahli Waris</th>
          <th>Jenis Kelamin Ahli Waris</th>
          @if($_SESSION['level'] == "Admin")
          <th>Aksi</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @foreach($data_list as $nomor => $data)
          <tr>
            <td>{{ ($nomor+1) }}</td>
            <td>{{ $data['nama_lengkap'] }}</td>
            <td>{{ $data['nama_panggilan'] }}</td>
            <td>{{ $data['jenis_kelamin'] }}</td>
            <td>{{ $data['no_identitas'] }}</td>
            <td>{{ $data['nm_kota'] }}</td>
            <td>{{ $data['tgl_lahir'] }}</td>
            <td>{{ $data['alamat'] }} {{ $data['kel'] }} RT{{ $data['rt'] }} RW{{ $data['rw'] }} {{ $data['kode_pos'] }}</td>
            <td>{{ $data['tlp_rumah'] }}</td>
            <td>{{ $data['tlp_kantor'] }}</td>
            <td>{{ $data['nohp'] }}</td>
            <td>{{ $data['email'] }}</td>
            <td>{{ $data['warga_negara'] }}</td>
            <td>{{ $data['pekerjaan'] }}</td>
            <td>{{ $data['ukuran_baju'] }}</td>
            <td>{{ $data['nama_ahliwaris'] }} ({{ $data['hubungan_ahliwaris'] }})</td>
            <td>{{ $data['jk_ahliwaris'] }}</td>
            @if($_SESSION['level'] == "Admin")
            <td>
              <button type="button" onclick="showModalEdit({{ $nomor }})" class="btn btn-success">Edit</button>
              <button type="button" onclick="showConfirmationDelete('<?=site_url("peserta/hapus?id=".$data['id'])?>')" class="btn btn-danger">Hapus</button>
            </td>
            @endif
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <script>
    var data = <?=json_encode($data_list)?>;
    var tempat_lahir;
    function resetModal()
    {
      elId("form_modal").action = "";
      elId("judul_modal").innerHTML = "Tambah Data Baru";
      elName("id")[0].value = "";
      elName("nama_lengkap")[0].value = "";
      elName("nama_panggilan")[0].value = "";
      elName("jenis_kelamin")[0].value = "";
      elName("id_pengguna")[0].value = "";
      elName("no_identitas")[0].value = "";
      elName("tempat_lahir")[0].value = "";
      elName("tgl_lahir")[0].value = "";
      elName("alamat")[0].value = "";
      elName("kel")[0].value = "";
      elName("tlp_rumah")[0].value = "";
      elName("tlp_kantor")[0].value = "";
      elName("nohp")[0].value = "";
      elName("email")[0].value = "";
      elName("warga_negara")[0].value = "";
      elName("pekerjaan")[0].value = "";
      elName("ukuran_baju")[0].value = "";
      elName("nama_ahliwaris")[0].value = "";
      elName("hubungan_ahliwaris")[0].value = "";
      elName("jk_ahliwaris")[0].value = "";
      elName("kode_pos")[0].value = "";
      elName("rt")[0].value = "";
      elName("rw")[0].value = "";
    }
    
    function closeModal()
    {
      resetModal();
      hideModal("#modal");
    }
    
    function showModalTambah()
    {
      resetModal();
      elId("form_modal").action = "{{ site_url('peserta/tambah') }}";
      showModal("#modal");
    }
    
    function showModalEdit(id)
    {
      elId("judul_modal").innerHTML = "Edit Data";
      resetModal();
      var detail = data[id]; 
      elId("form_modal").action = "{{ site_url('peserta/edit') }}";
      elName("id")[0].value = detail.id;
      elName("nama_lengkap")[0].value = detail.nama_lengkap;
      elName("nama_panggilan")[0].value = detail.nama_panggilan;
      elName("jenis_kelamin")[0].value = detail.jenis_kelamin;
      elName("id_pengguna")[0].value = detail.id_pengguna;
      elName("no_identitas")[0].value = detail.no_identitas;
      tempat_lahir.val(detail.tempat_lahir).trigger('change');
      elName("tgl_lahir")[0].value = detail.tgl_lahir;
      elName("alamat")[0].value = detail.alamat;
      elName("kel")[0].value = detail.ket;
      elName("tlp_rumah")[0].value = detail.tlp_rumah;
      elName("tlp_kantor")[0].value = detail.tlp_kantor;
      elName("nohp")[0].value = detail.nohp;
      elName("email")[0].value = detail.email;
      elName("warga_negara")[0].value = detail.warga_negara;
      elName("pekerjaan")[0].value = detail.pekerjaan;
      elName("ukuran_baju")[0].value = detail.ukuran_baju;
      elName("nama_ahliwaris")[0].value = detail.nama_ahliwaris;
      elName("hubungan_ahliwaris")[0].value = detail.hubungan_ahliwaris;
      elName("jk_ahliwaris")[0].value = detail.jk_ahliwaris;
      elName("kode_pos")[0].value = detail.kode_pos;
      elName("rt")[0].value = detail.rt;
      elName("rw")[0].value = detail.rw;
      showModal("#modal");
    }
  </script>
  
  <div class="modal fade hide-modal" id="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="judul_modal">Judul Modal</h4>
        </div>
        <div class="modal-body">
          <form id="form_modal" method="POST" action="{{ site_url('peserta/tambah') }}">
            <input type="hidden" name="id">
            <div class="row">
      <div class="col-sm-6 col-xs-12">
        @include('components.form.select', ['_data' => [ 'name' => 'id_pengguna', 'value' => '','val' => 'id', 'caption' => 'username', 'class' => 'form-control','label' => 'Username', 'options' => $data_pengguna, 'caption' => 'username']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'nama_lengkap', 'class' => 'form-control', 'max' => 100, 'label' => 'Nama Lengkap']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'nama_panggilan', 'class' => 'form-control', 'max' => 50, 'label' => 'Nama Panggilan']])
        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-control">
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
      
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'no_identitas', 'class' => 'form-control', 'max' => 20, 'label' => 'No Identitas']])
        @include('components.form.select', ['_data' => ['type' => 'text', 'id' => 'tempat_lahir', 'name' => 'tempat_lahir', 'class' => 'form-control', 'label' => 'Tempat Lahir', 'val' => 'nm_kota', 'caption' => 'nm_kota', 'options' => $data_kota]])
        @include('components.form.input', ['_data' => ['type' => 'text', 'id' => 'tgl_lahir','name' => 'tgl_lahir', 'class' => 'form-control', 'max' => 10, 'label' => 'Tanggal Lahir']])
        @include('components.form.textarea', ['_data' => ['type' => 'text', 'name' => 'alamat', 'class' => 'form-control', 'max' => 225, 'label' => 'Alamat']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'kel', 'class' => 'form-control', 'max' => 11, 'label' => 'Kelurahan']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'kode_pos', 'class' => 'form-control', 'max' => 20, 'label' => 'Kode Pos']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'rt', 'class' => 'form-control', 'max' => 10, 'label' => 'RT']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'rw', 'class' => 'form-control', 'max' => 10, 'label' => 'RW']])
      </div>
      <div class="col-sm-6 col-xs-12">
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'tlp_rumah', 'class' => 'form-control', 'max' => 20, 'label' => 'Telepon Rumah']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'tlp_kantor', 'class' => 'form-control', 'max' => 20, 'label' => 'Telepon Kantor']])
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'nohp', 'class' => 'form-control', 'max' => 20, 'label' => 'No Hp']])
        @include('components.form.input', ['_data' => ['type' => 'email', 'name' => 'email', 'class' => 'form-control', 'max' => 20, 'label' => 'Email']])
        @include('components.form.select', ['_data' => ['type' => 'text', 'name' => 'warga_negara', 'class' => 'form-control', 'max' => 50, 'label' => 'Warga negara', 'val' => 'value', 'caption' => 'name', 
          'options' => [
            ['name' => 'WNI', 'value' => 'WNI'],
            ['name' => 'WNA', 'value' => 'WNA'],
          ]
        ]])
        
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'pekerjaan', 'class' => 'form-control', 'max' => 50, 'label' => 'Pekerjaan']])
        
        @include('components.form.select', ['_data' => ['type' => 'text', 'name' => 'ukuran_baju', 'class' => 'form-control', 'label' => 'Ukuran Baju', 'val' => 'value', 'caption' => 'name', 
          'options' => [
            ['name' => 'M', 'value' => 'M'],
            ['name' => 'L', 'value' => 'L'],
            ['name' => 'XL', 'value' => 'XL'],
            ['name' => 'XXL', 'value' => 'XXL'],
            ['name' => 'XXXL', 'value' => 'XXXL']
          ]
        ]])
        
        @include('components.form.input', ['_data' => ['type' => 'text', 'name' => 'nama_ahliwaris', 'class' => 'form-control', 'max' => 50, 'label' => 'Nama Ahli Waris']])
        @include('components.form.select', ['_data' => ['type' => 'text', 'name' => 'hubungan_ahliwaris', 'class' => 'form-control', 'label' => 'Hubungan Ahli Waris', 'val' => 'value', 'caption' => 'name', 
          'options' => [
            ['name' => 'Istri', 'value' => 'Istri'],
            ['name' => 'Suami', 'value' => 'Suami'],
            ['name' => 'Anak Kandung', 'value' => 'Anak Kandung'],
            ['name' => 'Kakak Kandung', 'value' => 'Kakak Kandung'],
            ['name' => 'Adik Kandung', 'value' => 'Adik Kandung']
          ]
        ]]) 
        <div class="form-group">
          <label>Jenis Kelamin Ahli Waris</label>
          <select name="jk_ahliwaris" class="form-control">
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
        
      </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" onclick="closeModal()">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <script src="{{ base_url() }}assets/pikaday/pikaday.js"></script>
  <script>
    var batas = new Date(new Date().setDate(new Date().getDate()-1))
  	var tgl_lahir = new Pikaday({
            field: document.getElementById('tgl_lahir'),
            minDate: new Date("1900-01-01"),
            maxDate: batas,
            format: 'YYYY-MM-DD'
        });
  </script>
@endsection

@section('script')
<script>
$(document).ready(function() {
	document.getElementById("tempat_lahir").style.width = "100%";
  $("#tempat_lahir").select2({
	  tags: true,
    width: "resolve"
	});
	
	tempat_lahir = $('#tempat_lahir');
});
</script>
@endsection