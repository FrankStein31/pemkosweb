<html>
    <head>
    <style>
table, td, th {
  border: 1px solid black;
  font-size: 12px;
}

table {
  width: 100%;
  border-collapse: collapse;
}
</style>
    </head>
    <body>

        <h3 ><center>Data Tenaga Didik</center></h3>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                     <th>Jenis Kelamin</th>
                     <th>Tempat, Tanggal Lahir</th>
                     <th>Alamat</th>
                     <th>Kontak</th>
                     <th>Keterangan</th>
                     <th>Sekolah</th>
                     </tr>
                </thead>
                <tbody>
                <?php $no=1; foreach ($tenagadidik->result() as $key) {  ?>
                <tr>
                                    <th><?php echo $no++;?></th>
                                    <td><?php echo $key->nip;?></td>
                                    <td><?php echo $key->nama;?></td>
                                    <td><?php echo $key->jabatan;?></td>
                                    <td><?php if($key->gender == "L") echo "Laki - laki"; else echo "Perempuan";?></td>
                                    <td><?php echo $key->tempat_lahir.", ".date('d M Y', strtotime($key->tanggal_lahir));?></td>
                                    <td><?php echo "$key->alamat";?></td>
                                    <td><?php echo "$key->kontak";?></td>
                                    <td><?php echo "$key->keterangan";?></td>
                                    <td><?php echo "$key->nama_sekolah";?></td>
                                    
                                    
                                    
                                    </tr>
                                    <?php } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
    </body>
</html>