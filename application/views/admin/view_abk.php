
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
            <h1>Anak Berkebutuhan Khusus</h1>
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
                <h3 class="card-title">Data Anak Berkebutuhan Khusus</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php echo $this->session->flashdata('suces')?>

                <br>

                <div class="row">
                  <div class="col-md-2 col-sm-4">
                    <form method="POST" action="<?php echo site_url('admin/abk')?>">
                      <select class="form-control"  name="filtersekolah" required  id="filtersekolah">
                          <option value="" disabled selected hidden>Filter Sekolah</option>
                          <?php 
                          $id = $this->input->post('filtersekolah');
                          foreach($sekolah->result() as $row){
                            echo "<option value='$row->id_sekolah' ";
                            if($row->id_sekolah == $id) echo "selected";
                            echo " >$row->nama_sekolah</option>";
                          }
                          ?>
                          
                        </select>

                    </form>
                  </div>
                  <div class="col-md-2 col-sm-4">
                    <button type="button"  data-toggle="modal" data-target="#tambah" class="btn btn-light btn-icon-split">
                      <span class="icon text-gray-600">
                        <i class="fas fa-plus"></i>
                      </span>
                      <span class="text"> &nbsp;Tambah</span>
                    </button> 
                  </div>
                  <div class="col-md-8 col-sm-4 text-right">
                  <form method="GET" action="<?php echo site_url('admin/abk/exportpdf/'.$id)?>">
                    <button type="submit"  class="btn btn-light btn-icon-split">
                        <span class="icon text-gray-600"><i class="fas fa-file-pdf"></i></span>
                        <span class="text">Export PDF</span>
                    </button>
                  </form> 
                  </div>
                </div>
                  

                <br><br>
                <table id="datatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>NIS</th>
                      <th>Sekolah</th>
                      <th>Opsi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $no=1; foreach ($abk->result() as $key) {
                                        ?>
                                    <tr>
                                    <th><?php echo $no++;?></th>
                                    <td><?php echo $key->nama;?></td>
                                    <td><?php echo $key->nis;?></td>
                                    <td><?php echo $key->nama_sekolah;?></td>
                                    
                                    <td>
                                    
                                        <a href="<?php echo site_url('admin/abk/edit/'.$key->id_abk)?>" class=" btn btn-light btn-circle btn-sm" title="Edit"><i class="fa fa-pen"></i></a>
                                        <a href="<?php echo site_url('admin/abk/hapus/'.$key->id_abk)?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ?')" class=" btn btn-light btn-circle btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>
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
                    
                    <h4 class="modal-title">Tambah Data ABK</h4>
                    <button type="button" class="close" data-dismiss="modal">x</button>
                </div>
                <form role="form" method="POST" action="<?php echo site_url('admin/abk/tambah')?>" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <div class="form-group">
                        <span>Nama Lengkap</span>
                        <input class="form-control" placeholder="Nama sekolah" value="" name="nama" required><br>
                        <span>Sekolah</span>
                        <select class="form-control"  name="sekolah" required>
                          <option value="" disabled selected hidden>Pilih sekolah</option>
                          <?php 
                          foreach($sekolah->result() as $row){
                            echo "<option value='$row->id_sekolah'>$row->nama_sekolah</option>";
                          }
                          ?>
                          
                        </select><br>
                        <span>Nomor Induk Siswa</span>
                        <input class="form-control" placeholder="Nomor Induk Siswa" value="" name="nis" required><br>
                        <span>Jenis Kelamin</span>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" id="customRadio1" name="gender" value="L"  required>
                          <label class="form-check-label" for="customRadio1" >Laki - laki</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="customRadio2" value="P" name="gender" >
                          <label class="form-check-label" for="customRadio2" >Perempuan</label>
                        </div>
                        <br>
                        <span>Tempat Lahir</span>
                        <input class="form-control" placeholder="Tempat lahir" value="" name="tempat" required><br>
                        <span>Tanggal Lahir</span>
                        <input class="form-control" placeholder="Tanggal lahir" value="" type="date" name="tanggal" required><br>
                        <span>Kontak</span>
                        <input class="form-control" placeholder="Kontak" value="" name="kontak" required><br>
                        <span>Alamat</span>
                        <textarea class="form-control" name="alamat" rows="4" cols="50"  placeholder="Alamat lengkap" ></textarea>
                        <br>

                        <span>Keterangan Disabilitas</span>
                        <textarea class="form-control" name="keterangan" rows="4" cols="50"  placeholder="Keterangan Disabilitas (Contoh: Tuna rungu, tuna netra, dll)" ></textarea>
                        <br>
                        <span>Foto</span>
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
  
  jQuery(function() {
    jQuery('#filtersekolah').change(function() {
        this.form.submit();
    });
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