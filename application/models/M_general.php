<?php

class M_general extends CI_Model {

  public function getData($table)
  {
    $query = $this->db->get($table);

    return $query->result();
  }

  public function getDataByID($table, $idName, $id) {
    $query = $this->db->select('*')
              ->from($table)
              ->where($idName, $id)
              ->get();

    return $query->result_array()[0];
  }

  public function getInvoiceData($id)
  {
    $query = $this->db->select('*')
            ->from('app_barang_masuk')
            ->join('app_barang_keluar', 'app_barang_keluar.kode_jenis_barang=app_barang_masuk.kode_jenis_barang')
            ->where('app_barang_keluar.id', $id)
            ->get();

    return $query->row();
  }

  public function checkKodeBarang($table, $idName, $id) {
    $query = $this->db->select('*')
              ->from($table)
              ->where($idName, $id)
              ->get();

    // echo $this->db->last_query();die;


    return $query;
  }

  public function getJoinData($uniqid, $table1, $table2)
  {
    $query = $this->db->select('*')
            ->from($table1)
            ->join($table2, $table2.'.'.$uniqid.'='.$table1.'.'.$uniqid)
            ->get();

    return $query->result();
  }

  public function getBarangKeluar($startDate = null, $endDate = null)
  {
    $this->db->select('*');
    $this->db->from('app_barang_masuk');
    $this->db->join('app_barang_keluar', 'app_barang_keluar.kode_jenis_barang=app_barang_masuk.kode_jenis_barang');

    if ($startDate != null) {
      $this->db->where("app_barang_keluar.tanggal_keluar BETWEEN CAST('".$startDate."' AS DATE) AND CAST('".$endDate."' AS DATE)");
    }
    $query = $this->db->get();

    return $query->result();
  }

  public function getLaporan($uniqid, $table1, $table2)
  {
    $query = $this->db->select('app_barang_masuk.kode_jenis_barang, app_barang_masuk.jumlah_barang, app_cabang.nama_cabang, app_barang_masuk.tanggal_masuk, app_barang_keluar.tanggal_keluar, app_barang_keluar.tanggal_keluar, app_barang_keluar.jumlah_barang_keluar, app_barang_keluar.sisa_barang')
            ->from($table1)
            ->join($table2, $table2.'.'.$uniqid.'='.$table1.'.'.$uniqid, 'left')
            ->join('app_cabang', 'app_cabang.id='.$table1.'.id_cabang')
            ->get();

    // echo $this->db->last_query();die;

    return $query->result();
  }

  public function execute($action, $type, $data)
  {
    if($action == 'save') {
      if ($type == 'app_barang_masuk') {
        if ($data['jenis_barang'] == 1) { //update stok barang lama
          $resultBarang = $this->getDataByID($type, 'kode_jenis_barang', $data['kode_jenis_barang_lama']);

          $dataBarang = [
            'kode_jenis_barang' => $data['kode_jenis_barang_lama'],
            'id_cabang' => $data['cabang'],
            'status_permintaan'  => 'verifikasi',
            'jumlah_barang'  => $resultBarang['jumlah_barang'] + $data['jumlah_barang'],
            'status_barang'  => 2,
            'keterangan'  => str_replace('%20', ' ', $data['keterangan']),
          ];

          // print_r($dataBarang);die('barang lama');

          $this->execute('update', $type, $dataBarang);
        } else {
          $dataBarang = [ //insert barang baru
            'kode_jenis_barang' => $data['kode_jenis_barang_baru'],
            'id_cabang' => $data['cabang'],
            'status_permintaan'  => 'verifikasi',
            'jumlah_barang'  => $data['jumlah_barang'],
            'status_barang'  => 2,
            'keterangan'  => str_replace('%20', ' ', $data['keterangan']),
          ];

          // print_r($dataBarang);die('barang baru');

          $this->db->insert('app_barang', array('kode_jenis_barang' => $data['kode_jenis_barang_baru'], 'minimum_stok' => 0));
          $this->db->insert($type, $dataBarang);
        }
      } elseif ($type == 'app_barang_keluar') {
        $this->db->insert($type, $data);
      } elseif ($type == 'app_barang') {
        $dataBarangMasuk = [
          'kode_jenis_barang' => $data['kode_jenis_barang'],
          'id_cabang' => 6,
          'jumlah_barang' => 0,
          'status_barang' => 0,
          'status_permintaan' => 'tidak_tersedia',
        ];

        $this->db->insert($type, $data);
        $this->db->insert('app_barang_masuk', $dataBarangMasuk);
      } else {
        $this->db->insert($type, $data);
      }
    } elseif ($action == 'update') {
      if ($type == 'app_barang_masuk') {
        $this->db->where('kode_jenis_barang', $data['kode_jenis_barang']);
        $this->db->update($type, $data);
      } elseif ($type == 'verifikasi_barang') {
        $this->db->where('kode_jenis_barang', $data);
        $this->db->update('app_barang_masuk', array('status_permintaan' => 'sedang_diproses', 'status_barang' => 3));
      } elseif ($type == 'siapkan_barang') {
        $sql = 'SELECT MAX(id) AS last FROM app_barang_keluar';
        $squence = $this->db->query($sql)->row();
        $last = $squence->last;
        $last++;
        $invoice_number = sprintf('%07d', $last);

        $resultBarang = $this->getDataByID('app_barang_masuk', 'kode_jenis_barang', $data['id']);
        $formData = [
          'status_permintaan' => 'tersedia',
          'status_barang' => 1,
          'jumlah_barang' => $resultBarang['jumlah_barang'] - $data['jumlah_barang'],
        ];

        $barangKeluar = [
          'kode_jenis_barang' => $data['id'],
          'no_invoice' => $invoice_number,
          'jumlah_barang_keluar' => $data['jumlah_barang'],
          'tanggal_keluar' => $data['tanggal_keluar'],
          'sisa_barang' => $resultBarang['jumlah_barang'] - $data['jumlah_barang']
        ];

        $this->execute('save', 'app_barang_keluar', $barangKeluar);

        $this->db->where('kode_jenis_barang', $data['id']);
        $this->db->update('app_barang_masuk', $formData);
      } elseif ($type == 'master_barang') {
        $this->db->where('kode_jenis_barang', $data['id']);
        $this->db->update('app_barang', array('minimum_stok' => $data['minimum_stok']));
      } elseif($data['table'] == 'app_users') {

        $dataUser = [
          'nama' => $data['request']['nama'],
          'email' => $data['request']['email'],
        ];

        if ($data['request']['password'] != '') {
          $dataUser = [
            'nama' => $data['request']['nama'],
            'email' => $data['request']['email'],
            'password' => md5($data['request']['password']),
          ];
        }

        $this->db->where($type, $data['id']);
        $this->db->update($data['table'], $dataUser);
      } else {
        $this->db->where($type, $data['id']);
        $this->db->update($data['table'], $data['request']);
      }
    } elseif ($action == 'delete') {
      if ($type == 'app_barang') {
        $this->db->where('kode_jenis_barang', $data['id']);
        $this->db->delete('app_barang_keluar');

        $this->db->where('kode_jenis_barang', $data['id']);
        $this->db->delete('app_barang_masuk');

        $this->db->where('kode_jenis_barang', $data['id']);
        $this->db->delete('app_barang');
      } else {
        $this->db->where($data['idName'], $data['id']);
        $this->db->delete($type);
      }
    }
  }
}