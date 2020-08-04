<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Barang Masuk</title>
</head>
<body>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Barang Masuk</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <button class="btn btn-primary btn-sm m-3" data-toggle="modal" data-target="#modalPP">Buat Permintaan</button>
              <table id="example2" class="table table-hover text-nowrap">
                <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Kode Jenis Barang</th>
                  <th>Jumlah Barang</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $no = 0;
                  foreach($barang as $data) {
                    $no++;

                    // $status_barang = '<span class="badge badge-danger">Tidak Tersedia</span><br><button class="btn btn-primary btn-sm badge" data-toggle="modal" onClick="getID(\''.$data->kode_jenis_barang.'\')" data-target="#modalPP">Buat Permintaan</button>';
                    $status_barang = '<span class="badge badge-danger">Tidak Tersedia</span>';
                    if ($data->status_barang == 1) {
                      $status_barang = '<span class="badge badge-success">Tersedia</span><br><button class="btn btn-primary btn-sm badge" onClick="getID(\''.$data->kode_jenis_barang.'\', \''.$data->minimum_stok.'\', \''.$data->jumlah_barang.'\')" data-toggle="modal" data-target="#modalSiapkanBarang">Siapkan Barang</button>';
                    }

                    if ($data->status_barang == 2) {
                      $status_barang = '<span class="badge badge-warning">Pending</span><br><button class="btn btn-success btn-sm badge" data-toggle="modal" onClick="getID(\''.$data->kode_jenis_barang.'\')" data-target="#modalVerifikasiBarang">Verifikasi</button>';
                    }

                    if ($data->status_barang == 3) {
                      $status_barang = '<span class="badge badge-success">Tersedia</span><br><button class="btn btn-primary btn-sm badge" onClick="getID(\''.$data->kode_jenis_barang.'\', \''.$data->minimum_stok.'\', \''.$data->jumlah_barang.'\')" data-toggle="modal" data-target="#modalSiapkanBarang">Siapkan Barang</button>';
                    }

                    if ($data->minimum_stok >= $data->jumlah_barang) {
                      // $status_barang = '<span class="badge badge-danger">Tidak Tersedia</span><br><button class="btn btn-primary btn-sm badge" data-toggle="modal" onClick="getID(\''.$data->kode_jenis_barang.'\')" data-target="#modalPP">Buat Permintaan</button>';
                      $status_barang = '<span class="badge badge-danger">Tidak Tersedia</span>';
                    }
                ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= $data->kode_jenis_barang ?></td>
                  <td><?= $data->jumlah_barang ?></td>
                  <td><?= $status_barang ?></td>
                  <td>
                    <?php if ($data->minimum_stok <= $data->jumlah_barang) { ?>
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdatePP" onClick="getDtlBarang('<?= $data->id ?>')">Edit</button>
                      |
                    <?php } ?>
                  
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <input type="hidden" name="idselected" id="idselected" class="form-control">
    <input type="hidden" name="minimum_stok" id="minimum_stok" class="form-control">
    <input type="hidden" name="jumlah_stok_barang" id="jumlah_stok_barang" class="form-control">

    <!-- Modal Buat Permintaan -->
    <div class="modal" id="modalPP">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Buat Permintaan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form id="form_data">
              <div class="form-group">
                <label for="jenis_barang">Jenis Barang</label>
                <select name="jenis_barang" class="form-control" id="jenis_barang">
                  <option value="1">Barang Lama</option>
                  <option value="2">Barang Baru</option>
                </select>
              </div>
              <div class="form-group">
                <label for="kode_jenis_barang">Kode Jenis Barang</label>
                <input type="text" class="form-control" placeholder="Masukan Kode Jenis Barang" required="required" name="kode_jenis_barang_baru" id="kode_jenis_barang_baru">
                <!-- <input type="text" class="form-control" name="kode_jenis_barang_lama" disabled id="kode_jenis_barang_lama"> -->
                <select name="kode_jenis_barang_lama" class="form-control" id="kode_jenis_barang_lama">
                  <?php foreach($barang as $barang) { ?>
                    <option value="<?= $barang->kode_jenis_barang; ?>"><?= $barang->kode_jenis_barang; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="cabang">Cabang</label>
                <select name="cabang" class="form-control select2 w-100" id="cabang">
                  <?php foreach($cabang as $cabang) { ?>
                    <option value="<?= $cabang->id; ?>"><?= $cabang->nama_cabang; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah Barang</label>
                <input type="number" class="form-control" name="jumlah_barang" placeholder="Masukan Jumlah Barang" id="jumlah_barang">
              </div>
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" name="keterangan" placeholder="Masukan keterangan" id="keterangan"></textarea>
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="submitpp">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal Edit Permintaan -->
    <div class="modal" id="modalUpdatePP">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Edit Data</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form id="form_data_update_barang_masuk">
              <div id="content"></div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="updatepp">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal Verifikasi Barang -->
    <div class="modal" id="modalVerifikasiBarang">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Verifikasi Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <h3>Apakah barang sudah sesuai ?</h3>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="submitverifikasibarang">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Siapkan Barang -->
    <div class="modal" id="modalSiapkanBarang">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Apakah barang sudah sesuai ?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <!-- Date range -->
            <div class="form-group">
              <label>Tanggal Keluar:</label>
              <input data-date-format="yyyy-mm-dd" class="form-control" name="tanggal_keluar" id="tanggal_keluar">
            </div>
            <div class="form-group">
              <label for="jumlah">Jumlah Barang</label>
              <input type="number" class="form-control" placeholder="Masukan Jumlah Barang" required="required" id="jumlah_siapkan_barang">
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="submitsiapkanbarnag">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Delete Barang Masuk -->
    <div class="modal" id="modalDelete">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Hapus Barang Masuk</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <h3>Apakah Anda yakin ingin menghapus data ini ?</h3>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="actiondelete">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>
</html>

<script>
  $(function() {
    $('#tanggal_keluar').datepicker("setDate", new Date());

    $('#tanggal_keluar').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#kode_jenis_barang_baru').hide();

    $('#jenis_barang').change(function(){
        if($('#jenis_barang').val() == 2) {
          $('#kode_jenis_barang_lama').hide();
          $('#kode_jenis_barang_baru').show();
        } else {
          $('#kode_jenis_barang_lama').show();
          $('#kode_jenis_barang_baru').hide();
        }
    });

    $('#submitpp').click(function() {
      const jenis_barang = $('#jenis_barang').val();
      const kode_jenis_barang_lama = $('#kode_jenis_barang_lama').val();
      const kode_jenis_barang_baru = $('#kode_jenis_barang_baru').val();
      const cabang = $('#cabang').val();
      const jumlah_barang = $('#jumlah_barang').val();
      const keterangan = $('#keterangan').val();

      const formData = {
        data: {
          jenis_barang: jenis_barang,
          kode_jenis_barang_lama: kode_jenis_barang_lama,
          kode_jenis_barang_baru: kode_jenis_barang_baru,
          cabang: cabang,
          jumlah_barang: jumlah_barang,
          keterangan: keterangan,
        }
      }

      if (jenis_barang === '2' && kode_jenis_barang_baru === '') {
        alert('Kode Barang Wajib diisi');

        return;
      }

      if (jumlah_barang === '') {
        alert('Jumlah Barang Wajib diisi');

        return;
      }

      $.post("submitRequestBarang", formData, function( data ) {
        window.location.reload();
      });
    })

    $('#updatepp').click(function() {
      const id = $("#idselected").val();
      const kode_jenis_barang = $('#update_kode_jenis_barang_lama').val();
      const cabang = $('#update_cabang').val();
      const jumlah_barang = $('#update_jumlah_barang').val();
      const keterangan = $('#update_keterangan').val();

      const data = {
        data: {
          kode_jenis_barang: kode_jenis_barang,
          id_cabang: cabang,
          jumlah_barang: jumlah_barang,
          keterangan: keterangan,
        },
        id: id,
        table: 'app_barang_masuk',
        id_name: 'id',
      }

      $.post("ActionUpdate", data, function( data ) {
        window.location.reload();
      });
    })

    $('#actiondelete').click(function() {
      const id = $("#idselected").val();

      const formData = {
        data: {
          id: id,
          idName: 'id',
        },
        table: 'app_barang_masuk',
      }

      $.post("ActionDelete", formData, function( data ) {
        window.location.reload();
      });
    })

    $('#submitverifikasibarang').click(function() {
      const id = $("#idselected").val();

      $.post("VerifikasiBarang", { data: id }, function( data ) {
        window.location.reload();
      });
    })

    $('#submitsiapkanbarnag').click(function() {
      const id = $("#idselected").val();
      const minimum_stok = $("#minimum_stok").val();
      const jumlah_siapkan_barang = $('#jumlah_siapkan_barang').val();
      const jumlah_stok_barang = $('#jumlah_stok_barang').val();
      const tanggal_keluar = $('#tanggal_keluar').val();
      const calculate_stok = parseInt(jumlah_stok_barang) - parseInt(minimum_stok);

      // console.log('minimum_stok', minimum_stok);
      // console.log('calculate_stok', calculate_stok);
      // console.log('jumlah_siapkan_barang', jumlah_siapkan_barang);
      // console.log('jumlah_stok_barang', jumlah_stok_barang);

      // if (jumlah_stok_barang <= minimum_stok) {
      //   alert('1 Jumlah Stok Barang yang Anda inginkan dalam batas limit, silahkan lakukan PO');
      //   return
      // }

      // if (jumlah_stok_barang <= jumlah_siapkan_barang) {
      //   alert('2 Jumlah Stok Barang yang Anda inginkan dalam batas limit, silahkan lakukan PO');
      //   return
      // }

      if (calculate_stok < jumlah_siapkan_barang) {
        alert('Jumlah Stok Barang yang Anda inginkan dalam batas limit, silahkan lakukan PO');
        return
      }

      if (jumlah_siapkan_barang === '') {
        alert('Jumlah Barang Wajib diisi');

        return;
      }

      const formData = {
        data: {
          id: id,
          jumlah_barang: jumlah_siapkan_barang,
          tanggal_keluar: tanggal_keluar,
        }
      }

      $.post("SiapkanBarang", formData, function( data ) {
        window.location.reload();
      });
    })
  });

  function getID(id, minimum_stok = 0, jumlah_barang = 0)
  {
    $('#kode_jenis_barang_lama').val(id);
    $('#idselected').val(id);
    $('#minimum_stok').val(minimum_stok);
    $('#jumlah_stok_barang').val(jumlah_barang);
  }

  function getDtlBarang(id)
  {
    $("#idselected").val(id);
    const formData = {
      data: {
        id: id,
        table: 'app_barang_masuk',
        idName: 'id',
      }
    }

    $.post("getDtlBarangMasuk", formData, function( data ) {
      const result = data;
      $('#content').html(result);
    });
  }
</script>