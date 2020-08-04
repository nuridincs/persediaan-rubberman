<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('Pdf');

    $this->load->model('M_general');

    $cekUserLogin = $this->session->userdata('status');

    if ($cekUserLogin != 'login') {
      redirect('auth');
    }
  }

  function index()
  {
    $data['content'] = 'content/home';
    $this->load->view('template', $data);
  }

  function listBarang()
  {
    $data['content'] = 'content/list_master_barang';
    $data['barang'] = $this->M_general->getData('app_barang');
    $this->load->view('template', $data);
  }

  function listBarangMasuk()
  {
    $data['content'] = 'content/barang_masuk/list';
    $data['barang'] = $this->M_general->getJoinData('kode_jenis_barang', 'app_barang', 'app_barang_masuk');
    $data['cabang'] = $this->M_general->getData('app_cabang');
    $this->load->view('template', $data);
  }

  function listBarangKeluar()
  {
    $request = $this->input->post();
    $startDate = null;
    $endDate = null;

    if (!empty($request['dateRange'])) {
      $explodeDate = explode(' - ', $request['dateRange']);
      $startDate = $explodeDate[0];
      $endDate = $explodeDate[1];
    }

    $data['content'] = 'content/list_barang_keluar';
    $data['barang'] = $this->M_general->getBarangKeluar($startDate, $endDate);
    $this->load->view('template', $data);
  }

  function laporan()
  {
    $data['content'] = 'content/laporan';
    $data['barang'] = $this->M_general->getLaporan('kode_jenis_barang', 'app_barang_masuk', 'app_barang_keluar');
    // print_r($data['barang']);die;
    $this->load->view('template', $data);
  }

  function listUser()
  {
    $data['content'] = 'content/list_user';
    $data['user'] = $this->M_general->getJoinData('id_users_role', 'app_users', 'app_role');
    $data['role'] = $this->M_general->getData('app_role');
    $this->load->view('template', $data);
  }

  function submitRequestBarang()
  {
    $request = $this->input->post('data');
    $this->M_general->execute('save', 'app_barang_masuk', $request);
  }

  function unserializeForm($request) {
    $get = explode('&', $request);

    foreach ($get as $key => $value) {
      $result[substr($value, 0 , strpos($value, '='))] =  substr(
        $value,
        strpos( $value, '=' ) + 1
      );
    }

    return $result;
  }

  function VerifikasiBarang()
  {
    $request = $this->input->post('data');
    $this->M_general->execute('update', 'verifikasi_barang', $request);
  }

  function SiapkanBarang()
  {
    $request = $this->input->post('data');
    $this->M_general->execute('update', 'siapkan_barang', $request);
  }

  function getDtl()
  {
    $request = $this->input->post('data');
    $result = $this->M_general->getDataByID($request['table'], $request['idName'], $request['id']);

    echo json_encode($result);
  }

  function getDtlBarangMasuk()
  {
    $request = $this->input->post('data');
    $result = $this->M_general->getDataByID($request['table'], $request['idName'], $request['id']);
    $getMasterBarang = $this->M_general->getData('app_barang');
    $getCabang = $this->M_general->getData('app_cabang');

    $_view = '<div class="form-group">';
      $_view .= '<label for="kode_jenis_barang">Kode Jenis Barang</label>';
      $_view .= '<input type="text" value="'.$result['kode_jenis_barang'].'" class="form-control" name="update_kode_jenis_barang_lama" disabled id="update_kode_jenis_barang_lama">';
      // $_view .= '<select name="update_kode_jenis_barang_lama" class="form-control" id="update_kode_jenis_barang_lama">';
      //   foreach($getMasterBarang as $barang) {
      //     if ($result['kode_jenis_barang'] == $barang->kode_jenis_barang) {
      //       $_view .= '<option value="'.$barang->kode_jenis_barang.'" selected>'.$barang->kode_jenis_barang.'</option>';
      //     } else {
      //       $_view .= '<option value="'.$barang->kode_jenis_barang.'">'.$barang->kode_jenis_barang.'</option>';
      //     }
      //   }
      // $_view .= '</select>';
    $_view .= '</div>';

    $_view .= '<div class="form-group">';
      $_view .= '<label for="cabang">Cabang</label>';
      $_view .= '<select name="update_cabang" class="form-control" id="update_cabang">';
        foreach($getCabang as $cabang) {
          if ($result['id_cabang'] == $cabang->id) {
            $_view .= '<option value="'.$cabang->id.'" selected>'.$cabang->nama_cabang.'</option>';
          } else {
            $_view .= '<option value="'.$cabang->id.'">'.$cabang->nama_cabang.'</option>';
          }
        }
      $_view .= '</select>';
    $_view .= '</div>';

    $_view .= '<div class="form-group">';
      $_view .= '<label for="jumlah">Jumlah Barang</label>';
      $_view .= '<input type="number" value="'.$result['jumlah_barang'].'" class="form-control" name="update_jumlah_barang" placeholder="Masukan Jumlah Barang" id="update_jumlah_barang">';
    $_view .= '</div>';

    $_view .= '<div class="form-group">';
      $_view .= '<label for="keterangan">Keterangan</label>';
      $_view .= '<textarea class="form-control" name="update_keterangan" id="update_keterangan">'.$result['keterangan'].'</textarea>';
    $_view .= '</div>';

    echo $_view;
  }

  function generateData($request)
  {
    $data = [
      'nama' => $request['nama'],
      'email' => $request['email'],
      'password' => md5($request['password']),
      'id_users_role' => $request['id_users_role'],
    ];

    return $data;
  }

  function ActionAdd()
  {
    $role = $this->input->post('role');
    $request = $this->input->post('data');
    $table = $this->input->post('table');

    if (!empty($role)) {
      if($role == 'users'){
        $request = $this->generateData($request);
      }

      if ($role == 'master_barang') {
        $cek_kode_barang = $this->M_general->checkKodeBarang('app_barang', 'kode_jenis_barang', $request['kode_jenis_barang']);

        if($cek_kode_barang->num_rows() == 1){
          $result = [
            'status' => 'error',
            'msg' => 'Kode Barang sudah ada!',
          ];
          echo json_encode($result);
          exit;
        }
      }
    }

    $this->M_general->execute('save', $table, $request);

    $result = [
      'status' => 'success',
      'msg' => 'Data Berhasil disimpan',
    ];

    echo json_encode($result);
  }

  function ActionUpdate()
  {
    $request = $this->input->post('data');
    $table = $this->input->post('table');
    $id_name = $this->input->post('id_name');
    $id = $this->input->post('id');

    $data = [
      'id' => $id,
      'request' => $request,
      'table' => $table,
      'id_name' => $id_name,
    ];
    $this->M_general->execute('update', $id_name, $data);
  }

  function ActionDelete()
  {
    $request = $this->input->post('data');
    $table = $this->input->post('table');
    $this->M_general->execute('delete', $table, $request);
  }

  function cetakLaporan()
  {
    $data = $this->M_general->getLaporan('kode_jenis_barang', 'app_barang_masuk', 'app_barang_keluar');

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Inventory Persidiaan Barang');
    $pdf->SetTitle('Laporan');
    $pdf->SetSubject('Laporan');

    //header Data
    $pdf->SetHeaderData('rubberman-logo.jpg',30,'','',array(203, 58, 44),array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica','',14,'',true);

    $pdf->AddPage('L');

    $html=
      '<div>
        <h1 align="center">Laporan Barang</h1>

        <table border="1" width="100" align="center">
          <tr>
            <th style="width:40px" align="center">No</th>
            <th style="width:150px" align="center">Kode Jenis Barang</th>
            <th style="width:150px" align="center">Nama Cabang</th>
            <th style="width:150px" align="center">Tanggal Masuk</th>
            <th style="width:150px" align="center">Tanggal Keluar</th>
            <th style="width:200px" align="center">Jumlah Barang Keluar</th>
            <th style="width:140px" align="center">Sisa Barang</th>
          </tr>';

          $no = 0;
          foreach($data as $item) {
            $no++;
            $html .= '<tr>
              <td>'.$no.'</td>
              <td>'.$item->kode_jenis_barang.'</td>
              <td>'.$item->nama_cabang.'</td>
              <td>'.date('Y-m-d', strtotime($item->tanggal_masuk)).'</td>
              <td>'.$item->tanggal_keluar.'</td>
              <td>'.$item->jumlah_barang_keluar.'</td>
              <td>'.$item->sisa_barang.'</td>
            </tr>';
        }

        $html .='
            </table>
            <h6>Mengetahui</h6><br>
            <h6>Manager</h6>
          </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('report.pdf', 'I');
  }

  function cetakInvoice($id)
  {
    $data = $this->M_general->getInvoiceData($id);

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // document informasi
    $pdf->SetCreator('Invoice');
    $pdf->SetTitle('Invoice Barang Keluar');
    $pdf->SetSubject('Barang Keluar');

    //header Data
    $pdf->SetHeaderData('rubberman-logo.jpg',30,'','',array(203, 58, 44),array(0, 0, 0));
    $pdf->SetFooterData(array(255, 255, 255), array(255, 255, 255));


    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margin
    $pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP + 10,PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM - 5);

    //SET Scaling ImagickPixel
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    //FONT Subsetting
    $pdf->setFontSubsetting(true);

    $pdf->SetFont('helvetica','',14,'',true);

    $pdf->AddPage('L');

    $html=
      '<div>
        <h1 align="center">Invoice Bukti Pengeluaran Barang<br><small>No. Invoice: '.$data->no_invoice.'</small></h1>

        <table border="1">
          <tr>
            <th style="width:40px" align="center">No</th>
            <th style="width:200px" align="center">Kode Jenis Barang</th>
            <th style="width:200px" align="center">Tanggal Masuk</th>
            <th style="width:200px" align="center">Tanggal Keluar</th>
            <th style="width:250" align="center">Jumlah Barang Keluar</th>
          </tr>';
      $no = 0;
      // foreach($data as $item) {
        $no++;
        $html .= '<tr>
          <td align="center">'.$no.'</td>
          <td align="center">'.$data->kode_jenis_barang.'</td>
          <td align="center">'.date('Y-m-d', strtotime($data->tanggal_masuk)).'</td>
          <td align="center">'.$data->tanggal_keluar.'</td>
          <td align="center">'.$data->jumlah_barang_keluar.'</td>
        </tr>';
      // }

      $html .='
          </table>
          <h6>Mengetahui</h6><br>
          <h6>Manager</h6>
        </div>';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);

    $pdf->Output('contoh_report.pdf', 'I');
  }

  public function form($form)
  {
    $data['content'] = 'content/form/'.$form;
    $data['dataBarang'] = $this->M_general->getData('app_barang');
    $this->load->view('template', $data);
  }
}
