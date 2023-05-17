<?php
// koneksi Database 
$server = "localhost";
$user = "root";
$password =  "";
$database = "dbcrud2023";

// buat koneksi 
$koneksi = mysqli_connect($server, $user, $password, $database) or die(mysqli_error($koneksi));


// kode otomatis
$q = mysqli_query($koneksi, "SELECT kode FROM tbarang order by kode desc limit 1");
$datax = mysqli_fetch_array($q);
if($datax) {
    $no_terakhir = substr($datax['kode'], -3);
    $no = $no_terakhir + 1;

    if ($no > 0 and $no < 10) {
        $kode = "00".$no;  

      }else if($no > 10 and $no < 10) {
        $kode = "0" .$no;
      }else if($no > 100) {
        $kode = $no;
      }
}else{
    $kode = "001";
}

$tahun = date('Y');
$vkode = "INV-" .$tahun . '-' . $kode;
// INV-2022-001



// jika tombol simpan diklik
if(isset($_POST['bsimpan'])) {

    // pengujian apakah data akan diedit atau disimpan baru
    if (isset($_GET['hal']) =="edit") {
        // data akan di edit
        $edit = mysqli_query($koneksi, "UPDATE tbarang SET
        nama = '$_POST[tnama]',
        asal = '$_POST[tasal]',
        jumlah = '$_POST[tjumlah]',
        satuan = '$_POST[tsatuan]',
        tanggal_diterima = '$_POST[ttanggal_diterima]'
        WHERE id_barang = '$_GET[id]'
        ");

        // uji jika edit data sukses
if($edit) {
    echo "<script>
            alert('Edit data sukses!');
            documen.location='index.php';
            </script>";
} else {
   echo "<script>
        alert('Edit Data Gagal!');
        document.location='index.php';
    </script>";
 }

}else{
    
}

    // Data akann disimpan baru
    $simpan = mysqli_query($koneksi, "INSERT INTO tbarang(kode, nama, asal, jumlah, satuan, tanggal_diterima)
    VALUE ( '$_POST[tkode]',
            '$_POST[tnama]',
            '$_POST[tasal]',
            '$_POST[tjumlah]',
            '$_POST[tsatuan]',
            '$_POST[ttanggal_diterima]')
");
// uji jika simpan data sukses
if($simpan) {
    echo "<script>
            alert('Simpan data sukses!');
            documen.location='index.php';
            </script>";
} else {
   echo "<script>
        alert('Simpan Data Gagal!');
        document.location='index.php';
    </script>";
 }

}
// deklarasi variabel untuk menampung data yang akan diedit

$nama = "";
$vasal = "";
$vjumlah = "";
$vsatuan = "";
$vtanggal_diterima = "";

// pengujian jika tombol edit / hapus diklik
if (isset($_GET['hal'])) {

    // pengujian jika edit data
    if($_GET['hal'] == "edit"){

        // tampilkan data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data) {
            // jika data ditemukan, maka data ditampung kedalam variabel
            $vkode = $data['kode'];
            $vnama = $data['nama'];
            $vasal = $data['asal'];
            $vjumlah = $data['jumlah'];
            $vsatuan = $data['satuan'];
            $vtanggal_diterima = $data['tanggal_diterima'];
         
        }
    }else if($_GET['hal'] == "hapus") {
        // persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang = '$_GET[id]' ");
        // uji jika hapus data sukses
if($hapus) {
    echo "<script>
            alert('Hapus data sukses!');
            documen.location='index.php';
            </script>";
} else {
   echo "<script>
        alert('Hapus Data Gagal!');
        document.location='index.php';
    </script>";
 }
    }
}
?>





<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>crud php & mysql + bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>

    <!-- awal container -->
    <div class="container">

    <h3 class="text-center">Nokensoft</h3>
    <h3 class="text-center">Papua IT Consultan</h3>
    
    <!-- awal row -->
<div class="row">

    <!-- awal col 8 -->
    <div class="col-md-8 mx-auto">
        
        <!-- awal crud -->
        <div class="card">
            <div class="card-header bg-success text-light">
                Form Inpur Data Barang
            </div>
            <div class="card-body">

                <!-- awal form -->
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="tkode" value="<?= $vkode ?>" class="form-control" placeholder="Masukan Kode Barang">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="tnama" value="<?= $vnama ?>" class="form-control" placeholder="Masukan Nama Barang">
                </div>

                <div class="mb-3">
                    <label class="form-label">Asal Barang</label>
                    <select class="form-select" name="tasal">
                        <option value="<?= $vasal ?>"><?= $vasal ?></option>
                        <option value="pembelian">Pembelian</option>
                        <option value="Hibah">Hibah</option>
                        <option value="Bantuan">Bantuan</option>
                        <option value="Sumbangan">Sumbangan</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                    <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="tjumlah" value="<?= $vjumlah ?>" class="form-control" placeholder="Masukan Jumlah Barang">
                </div>
            </div>

             <div class="col">
                    <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <select class="form-select" name="tsatuan">
                        <option value="<? $vsatuan ?>"><?= $vsatuan ?></option>
                        <option value="Unit">Unit</option>
                        <option value="Kotak">Kotak</option>
                        <option value="Pos">Pcs</option>
                        <option value="Pak">Pak</option>
                    </select>
                </div>
            </div>

            <div class="col">
                        <div class="mb-3">
                        <label class="form-label">Tanggal Diterima></label>
                        <input type="date" name="ttanggal_diterima" value="<?= $vtanggal_diterima ?>" class="form-control" placeholder="Masukan Jumlah Barang">
                </div>
            </div>

            <div class="text-center">
                <hr>
                <button class="btn btn-primary" name="bsimpan" type="submit">Simpan</button>
                <button class="btn btn-danger" name="bkosongkan" type="res">Kosongkan</button>
            </div>
        </div>
    </form>
               <!-- akhir form -->

            </div>
            <div class="card-footer bg-success">
            
            </div>
        </div>
        <!-- akhir crud -->

    </div>
    <!-- akhir col 8 -->

</div>
    <!-- akhir row -->

     <div class="col-md-8 mx-auto">
        <!-- awal crud -->
        <div class="card text-center mt-3">
            <div class="card-header bg-success text-light ">
                Data Barang
    </div>
        <div class="card-body">
            <div class="col-md-8 mx-auto">
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="tcari" value="<?= @$_POST['tcari']?>" class="form-control" placeholder="Masukan Kata Kunci">
                        <button class="btn btn-primary" name="bcari" type="submit">Cari</button>
                        <button class="btn btn-danger" name="breset" type="submit">Reset</button>
                    </div>
                </form>
            </div>

               <table class="table table-striped table-hover table-bordered">
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Asal Barang</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
                <?php
                // persiapan menampilkan data
                $no = 1;

                // untuk pencarian data
                // jika tombo; cari di klik
                if(isset($_POST['bcari'])){
                    // tampilkan data yang dicari 
                    $keyword = $_POST['tcari'];
                    $q = "SELECT * FROM tbarang WHERE kode like '%$keyword%' or nama like '%$keyword%' or asal 
                    like '%$keyword%' order by id_barang desc";
                }else {
                    $q = "SELECT * FROM tbarang order by id_barang desc";
                }
                $tampil = mysqli_query($koneksi, $q);
                while($data = mysqli_fetch_array($tampil)):
                ?>

                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data['kode'] ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['asal'] ?></td>
                    <td><?= $data['jumlah'] ?> <?= $data['satuan'] ?></td>
                    <td><?= $data['tanggal_diterima'] ?></td>
                    <td>
                    <a href="index.php?hal=edit&id=<?=$data['id_barang'] ?>" class="btn btn-warning">Edit</a>
                    <a href="index.php?hal=hapust&id=<?=$data['id_barang'] ?>" class="btn btn-danger" oncanplay="return confim('Apakah Anda Yaking Inggin Menghapus Data ini')">Hapus</a>
                    </td>
                </tr>
                                            
            <?php endwhile; ?>
               </table>
            </div>
            <div class="card-footer bg-success">
            
            </div>
        </div>
    </div>
    <!-- akhir curd -->


</div>
    <!-- akhir container -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>