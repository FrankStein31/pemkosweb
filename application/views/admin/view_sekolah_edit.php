<?php

foreach($sekolah->result() as $data){
};

?>
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
                <h3 class="card-title">Ubah Data Sekolah</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php echo $this->session->flashdata('suces')?>
                    <br>
                            
                    <form role="form" method="POST" action="<?php echo site_url('admin/sekolah/prosesedit')?>" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $data->id_sekolah;?>"/>
                        <div class="form-group">
                        <span>Nama Sekolah</span>
                        <input class="form-control" placeholder="Nama sekolah" value="<?= $data->nama_sekolah;?>" name="nama" required><br>
                        <span>Nama Kepala Sekolah</span>
                        <input class="form-control" placeholder="Nama kepala sekolah" value="<?= $data->nama_kepala_sekolah;?>" name="namakepsek" required><br>
                        <span>Email</span>
                        <input class="form-control" type="email" placeholder="Email" name="email" value="<?= $data->email;?>" required><br>
                        <span>Password &nbsp;</span>
                        <input class="form-control" type="password" placeholder="Password" name="password" value="" >
                        <span class="text-muted">(Kosongi jika tidak diubah)</span><br><br>
                        
                        <span>Alamat</span>
                        <textarea class="form-control" name="alamat" rows="4" cols="50"  placeholder="Alamat lengkap" ><?= $data->alamat;?></textarea>
                        <br>
         
                        <div class="row ">
                          <div class="col-md-8">
                            <span>Gambar</span>
                          <br>Ubah ? 
                            <input type="file" class="btn btn-light" id="foto" name="foto" ><br>
                          </div>

                          <div class="col-md-4  text-right">
                            <img class="img-fluid rounded" src="<?php 
                              if($data->foto!="") echo base_url("assets/image/sekolah/$data->foto");
                              else echo  base_url("assets/image/sekolah/placeholder_building.png");
                              ?>"/>
                          </div>
                        </div>
                          <br>
                        
                        <div class="modal-footer">
                        <button class="btn btn-light" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" value="Ubah">
                        </div>
                        </div>
                    </div>
               </form> 
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
