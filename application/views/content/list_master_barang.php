<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Master Barang</title>
</head>
<body>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Master Barang</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-12">
          <button class="btn btn-dark btn-sm mb-3" data-toggle="modal" data-target="#modalTambah">Tambah</button>
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table id="example2" class="table table-hover text-nowrap">
                <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Kode Jenis Barang</th>
                  <th>Minimum stok</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $no = 0;
                  foreach($barang as $data) {
                    $no++;
                ?>
                <tr>
                  <td><?= $no ?></td>
                  <td><?= $data->kode_jenis_barang ?></td>
                  <td><?= $data->minimum_stok ?></td>
                  <td>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUpdate" onClick="getDtlBarang('<?= $data->kode_jenis_barang ?>')">Edit</button>
                    |
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete" onClick="getID('<?= $data->kode_jenis_barang ?>')">Delete</button>
                  </td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <input type="hidden" name="idselected" id="idselected" class=form-control"">

    <!-- Modal Tambah Barang -->
    <div class="modal" id="modalTambah">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form id="form_data">
              <div class="form-group">
                <label for="kode_jenis_barang">Kode Jenis Barang</label>
                <input type="text" class="form-control" name="kode_jenis_barang" id="kode_jenis_barang" placeholder="Masukan Kode Barang">
                <small id="check_kode_barang" class="alert-danger">Kode Barang sudah ada!</small>
              </div>
              <div class="form-group">
                <label for="minimum_stok">Minimum Stok</label>
                <input type="number" class="form-control" name="minimum_stok" id="minimum_stok" placeholder="Masukan Minimum Stok">
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="addbarang">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal Update Barang -->
    <div class="modal" id="modalUpdate">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Update Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form id="form_data_update">
                <div class="form-group">
                  <label for="kode_jenis_barang">Kode Jenis Barang</label>
                  <input type="text" class="form-control" name="update_kode_jenis_barang" id="update_kode_jenis_barang" disabled placeholder="Masukan Jumlah Barang" required>
                </div>
                <div class="form-group">
                  <label for="minimum_stok">Minimum Stok</label>
                  <input type="number" class="form-control" name="update_minimum_stok" id="update_minimum_stok" required>
                </div>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="updatebarang">Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
      </div>
    </div>

    <!-- Modal Delete Barang -->
    <div class="modal" id="modalDelete">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Hapus Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <h3>Apakah Anda yakin ingin menghapus data ini ?</h3>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="deletebarang">Submit</button>
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
    $('#kode_jenis_barang_baru').hide();

    $('#check_kode_barang').hide();

    $('#jenis_barang').change(function(){
        if($('#jenis_barang').val() == 2) {
          $('#kode_jenis_barang_lama').hide();
          $('#kode_jenis_barang_baru').show();
        } else {
          $('#kode_jenis_barang_lama').show();
          $('#kode_jenis_barang_baru').hide();
        }
    });

    $('#addbarang').click(function() {
      const kode_jenis_barang = $('#kode_jenis_barang').val();
      const minimum_stok = $('#minimum_stok').val();

      if (kode_jenis_barang === '') {
        alert('Kode Jenis Wajib diisi');

        return;
      }

      if (minimum_stok === '') {
        alert('Minimum Stok Wajib diisi');

        return;
      }

      const formData = {
        data: {
          kode_jenis_barang: kode_jenis_barang,
          minimum_stok: minimum_stok,
        },
        table: 'app_barang',
        role: 'master_barang',
      }

      $.post("ActionAdd", formData, function( data ) {
        const result = JSON.parse(data);

        if(result.status == 'error') {
          $('#check_kode_barang').show();
        } else {
          $('#check_kode_barang').hide();
          window.location.reload();
        }
      });
    })

    $('#updatebarang').click(function() {
      const id = $("#idselected").val();
      const update_minimum_stok = $('#update_minimum_stok').val();

      const formData = {
        data: {
          minimum_stok: update_minimum_stok,
        },
        id: id,
        table: 'app_barang',
        id_name: 'kode_jenis_barang',
      }

      $.post("ActionUpdate", formData, function( data ) {
        window.location.reload();
      });
    })

    $('#deletebarang').click(function() {
      const id = $("#idselected").val();

      const formData = {
        data: {
          id: id,
          idName: 'kode_jenis_barang',
        },
        table: 'app_barang',
      }

      $.post("ActionDelete", formData, function( data ) {
        window.location.reload();
      });
    })

    $('#submitsiapkanbarnag').click(function() {
      const id = $("#idselected").val();
      const jumlah_siapkan_barang = $('#jumlah_siapkan_barang').val();
      const formData = {
        data: {
          id: id,
          jumlah_barang: jumlah_siapkan_barang
        }
      }

      $.post("SiapkanBarang", formData, function( data ) {
        window.location.reload();
      });
    })
  });

  function getID(id)
  {
    $('#idselected').val(id);
  }

  function getDtlBarang(id)
  {
    $('#idselected').val(id);

    const formData = {
      data: {
        id: id,
        table: 'app_barang',
        idName: 'kode_jenis_barang',
      }
    }

    $.post("getDtl", formData, function( data ) {
      const result = JSON.parse(data);
      $('#update_kode_jenis_barang').val(result.kode_jenis_barang);
      $('#update_minimum_stok').val(result.minimum_stok);
    });
  }
</script>