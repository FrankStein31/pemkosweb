
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url("assets/admin");?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/admin");?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/admin");?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sekolah</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Sekolah</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php echo $this->session->flashdata('suces')?>
                            <br>
                            <button type="button"  data-toggle="modal" data-target="#tambah" class="btn btn-light btn-icon-split">
                                        <span class="icon text-gray-600">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text"> &nbsp;Tambah</span>
                                    </button> 
                                    <br><br>
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Aktif</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $no=1; foreach ($pengguna->result() as $key) {
                                        ?>
                                    <tr>
                                    <th><?php echo $no++;?></th>
                                    <td><?php echo $key->nama_sekolah;?></td>
                                    <td><?php echo $key->email;?></td>
                                    <td>
                                    <label class="switch">
  <input type="checkbox" <?php if ($key->status=="aktif")echo "checked"?> onclick="if (event.target.checked)return window.location = '<?= base_url('admin/sekolah/aktifkan/'.$key->id_sekolah)?>';else return window.location = '<?= base_url('admin/sekolah/block/'.$key->id_sekolah)?>';" >
  <span class="slider round"></span>
</label>
                                       
                                        
                                    </td>
                                    
                                    <td>
                                    
                                        <a href="<?php echo site_url('admin/sekolah/edit/'.$key->id_sekolah)?>" class=" btn btn-light btn-circle btn-sm" title="Edit"><i class="fa fa-pen"></i></a>
                                        <a href="<?php echo site_url('admin/sekolah/hapus/'.$key->id_sekolah)?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ?')" class=" btn btn-light btn-circle btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>
                                    </td>
                                    
                                    </tr>
                                    <?php } ?>
                                        
                  
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <div class="container-fluid">



    <div id="tambah" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title">Tambah Data Sekolah</h4>
                    <button type="button" class="close" data-dismiss="modal">x</button>
                </div>
                <form role="form" method="POST" action="<?php echo site_url('admin/sekolah/tambah')?>" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <div class="form-group">
                        <span>Nama Sekolah</span>
                        <input class="form-control" placeholder="Nama sekolah" value="" name="nama" required><br>
                        <span>Nama Kepala Sekolah</span>
                        <input class="form-control" placeholder="Nama kepala sekolah" value="" name="namakepsek" required><br>
                        <span>Email</span>
                        <input class="form-control" type="email" placeholder="Email" name="email" value="" required><br>
                        <span>Password</span>
                        <input class="form-control" type="password" placeholder="Password" name="password" value="" type required><br>
                        
                        <span>Alamat</span>
                        <textarea class="form-control" name="alamat" rows="4" cols="50"  placeholder="Alamat lengkap" ></textarea>
                        <br>
                        <span>Gambar</span>
                        <br>
                        <input type="file" class="btn btn-light" id="foto" name="foto" >
                        <br><br>
                        
                        <div class="modal-footer">
                        <button class="btn btn-light" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" value="Tambah">
                        </div>
                        </div>
                    </div>
               </form> 
            </div>
        </div>


        <script>
  $(function () {
    $("#datatable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": []
    }).buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
    
  });
</script>


<!-- DataTables  & Plugins -->
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url("assets/admin");?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>