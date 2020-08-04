<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Laporan</title>
</head>
<body>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Laporan</h1>
            <a href="cetakLaporan" class="btn btn-info btn-sm mt-3">Cetak Laporan</a>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <!-- <button class="btn btn-dark btn-sm mb-3" data-toggle="modal" data-target="#modalTambah">Tambah</button> -->
              <table id="example2" class="table table-hover text-nowrap">
                <thead>
                <tr>
                  <th>Nomor</th>
                  <th>Kode Jenis Barang</th>
                  <th>Nama Cabang</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Keluar</th>
                  <th>Jumlah Barang Keluar</th>
                  <th>Sisa Barang</th>
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
                  <td><?= $data->nama_cabang ?></td>
                  <td><?= date('Y-m-d', strtotime($data->tanggal_masuk)); ?></td>
                  <td><?= $data->tanggal_keluar ?></td>
                  <td><?= $data->jumlah_barang_keluar ?></td>
                  <td><span class="badge badge-danger"><?= $data->sisa_barang ?></span></td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <input type="hidden" name="idselected" id="idselected" class=form-control"">

    <!-- Modal Tambah User -->
    <div class="modal" id="modalTambah">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Tambah Users</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan Nama" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Masukan Email" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Masukan Password" required>
            </div>
            <div class="form-group">
              <label for="role">Role</label>
              <select name="id_users_role" class="form-control" id="id_users_role">
                <?php foreach($role as $role) { ?>
                  <option value="<?= $role->id_users_role; ?>"><?= $role->kategori; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="actionadd">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal Update Users -->
    <div class="modal" id="modalUpdate">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Update User</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

            <!-- Modal body -->
            <div class="modal-body">
              <form id="form_data_update">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="update_nama" id="update_nama" placeholder="Masukan Nama" required>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="update_email" id="update_email" required>
                </div>
                <!-- <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="update_password" id="update_password" required>
                </div> -->
                <!-- <div class="form-group">
                  <label for="update_role">Role</label>
                  <select name="update_id_users_role" class="form-control" id="update_id_users_role">
                    <?php //foreach($role as $role) { ?>
                      <option value="<?//= $role->id_users_role; ?>"><?//= $role->kategori; ?></option>
                    <?php //} ?>
                  </select>
                </div> -->
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="actionupdate">Submit</button>
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
            <h4 class="modal-title">Hapus Users</h4>
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
    $('#actionadd').click(function() {
      const nama = $('#nama').val();
      const email = $('#email').val();
      const password = $('#password').val();
      const id_users_role = $('#id_users_role').val();

      if (nama === '') {
        alert('Nama Wajib diisi');

        return;
      }

      if (email === '') {
        alert('Email Wajib diisi');

        return;
      }

      if (password === '') {
        alert('Passowrd Wajib diisi');

        return;
      }

      const formData = {
        data: {
          nama: nama,
          email: email,
          password: password,
          id_users_role: id_users_role,
        },
        table: 'app_users',
        role: 'users',
      }

      $.post("ActionAdd", formData, function( data ) {
        window.location.reload();
      });
    })

    $('#actionupdate').click(function() {
      const id = $("#idselected").val();
      const nama = $('#update_nama').val();
      const email = $('#update_email').val();
      const password = $('#update_password').val();
      const id_users_role = $('#update_id_users_role').val();

      const formData = {
        data: {
          nama: nama,
          email: email,
        },
        id: id,
        table: 'app_users',
        id_name: 'id',
      }

      $.post("ActionUpdate", formData, function( data ) {
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
        table: 'app_users',
      }

      $.post("ActionDelete", formData, function( data ) {
        window.location.reload();
      });
    })
  });

  function getID(id)
  {
    $('#idselected').val(id);
  }

  function getDtl(id)
  {
    $('#idselected').val(id);

    const formData = {
      data: {
        id: id,
        table: 'app_users',
        idName: 'id',
      }
    }

    $.post("getDtl", formData, function( data ) {
      const result = JSON.parse(data);
      $('#update_nama').val(result.nama);
      $('#update_email').val(result.email);
      $('#update_password').val(result.password);
      // $('#update_email').val(result.email);

      // const password = $('#update_password').val();
      // const id_users_role = $('#update_id_users_role').val();
    });
  }
</script>