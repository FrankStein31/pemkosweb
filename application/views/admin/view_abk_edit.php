<?php

foreach($abk->result() as $data){
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
                            
                    <form role="form" method="POST" action="<?php echo site_url('admin/abk/prosesedit')?>" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $data->id_abk;?>"/>
                        <div class="form-group">
                        <span>Nama Lengkap</span>
                        <input class="form-control" placeholder="Nama sekolah" value="<?= $data->nama;?>" name="nama" required><br>
                        <span>Sekolah</span>
                        <select class="form-control"  name="sekolah" required>
                          <option value="" disabled selected hidden>Pilih sekolah</option>
                          <?php 
                          foreach($sekolah->result() as $row){
                            echo "<option value='$row->id_sekolah' ";
                            if($data->id_sekolah == $row->id_sekolah) echo "selected ";
                            echo " >$row->nama_sekolah</option>";
                          }
                          ?>
                          
                        </select><br>
                        <span>Nomor Induk Siswa</span>
                        <input class="form-control" placeholder="Nomor Induk Siswa" value="<?= $data->nis;?>" name="nis" required><br>
                        <span>Jenis Kelamin</span>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" id="customRadio1" name="gender" value="L"   <?php if($data->gender == "L") echo "checked";?> required>
                          <label class="form-check-label" for="customRadio1" >Laki - laki</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="customRadio2" value="P" name="gender" <?php if($data->gender == "P") echo "checked";?>>
                          <label class="form-check-label" for="customRadio2" >Perempuan</label>
                        </div>
                        <br>
                        <span>Tempat Lahir</span>
                        <input class="form-control" placeholder="Tempat lahir" value="<?= $data->tempat_lahir;?>" name="tempat" required><br>
                        <span>Tanggal Lahir</span>
                        <input class="form-control" placeholder="Tanggal lahir" value="<?= $data->tanggal_lahir;?>" type="date" name="tanggal" required><br>
                        <span>Kontak</span>
                        <input class="form-control" placeholder="Kontak" value="<?= $data->kontak;?>" name="kontak" required><br>
                        
                        <span>Alamat</span>
                        <textarea class="form-control" name="alamat" rows="4" cols="50"  placeholder="Alamat lengkap" ><?= $data->alamat_abk;?></textarea>
                        <br>

                        <span>Keterangan Disabilitas</span>
                        <textarea class="form-control" name="keterangan" rows="4" cols="50"  placeholder="Keterangan Disabilitas (Contoh: Tuna rungu, tuna netra, dll)" ><?= $data->keterangan;?></textarea>
                        <br>
         
                        <div class="row ">
                          <div class="col-md-8">
                            <span>Foto</span>
                          <br>Ubah ? 
                            <input type="file" class="btn btn-light" id="foto" name="foto" ><br>
                          </div>

                          <div class="col-md-4  text-right">
                            <img class="img-fluid rounded" style="max-height: 180px" src="<?php 
                              if($data->foto_abk!="") echo base_url("assets/image/abk/$data->foto_abk");
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
