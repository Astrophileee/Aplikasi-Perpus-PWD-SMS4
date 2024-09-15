
<?php
include_once __DIR__.'/../layouts/session.php';
require_once '../../../Model/Peminjaman.php'; 
require_once '../../../Model/Member.php';
require_once '../../../Model/Buku.php';
$peminjaman = new Peminjaman();
$member = new Member();
$buku = new Buku();
$books = $buku->readData();
$members = $member->readData();
$kode_peminjaman = $_GET['kode_peminjaman'];
$where = ['kode_peminjaman' => $kode_peminjaman];
$row = $peminjaman->readData("WHERE kode_peminjaman = $kode_peminjaman");
$id_buku = $row[0]['id_buku'];
date_default_timezone_set('Asia/Jakarta');

if(isset($_POST['submit'])){
  
    if(empty($_POST['pengembalian'])){
      $error_message = "Kolom Tanggal Pengembalian harus diisi.";
      $error_kolom = "pengembalian";
    }else {
        if($id_buku != $_POST['judul']){
          $peminjaman->tambahStockBuku($id_buku);
          if($peminjaman->bukuTersedia($_POST['judul'])){
            $data = [
              'id_member' => $_POST['nama'],
              'id_buku' => $_POST['judul'],
              'waktu_peminjaman' => date('Y-m-d H:i:s'),
              'tenggat_pengembalian' => $_POST['pengembalian'],
            ];
            $peminjaman->updateData($data,$where);
            header('Location: dataPeminjaman.php?success=true&message=Data berhasil diedit.');
          }else{
            $error_message = "Maaf Buku Tidak Tersedia Saat Ini.";
            $error_kolom = "judul";
          }
        }
          $data = [
            'id_member' => $_POST['nama'],
            'id_buku' => $_POST['judul'],
            'waktu_peminjaman' => date('Y-m-d H:i:s'),
            'tenggat_pengembalian' => $_POST['pengembalian'],
          ];
          $peminjaman->updateData($data,$where);
          header('Location: dataPeminjaman.php?success=true&message=Data berhasil diedit.');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__.'/../layouts/header.php'; ?>
  <style>
  </style>
</head>

<body>
  <?php require_once __DIR__.'/../layouts/sidebar.php'; ?>
      <div class="main p-3">
        <h1 class="text-center">Tambah Peminjaman</h1>
          <div class="container mt-3">
            <form class="form" method="POST" action="" enctype="multipart/form-data">
              <div class="form-group mb-3">
                <div class="form-floating">
                  <select class="form-select" name="nama" id="nama" id="floatingSelect">
                    <?php foreach ($members as $member) { ?>
                      <option value="<?php echo $member['id']; ?>" <?php if ($row[0]['id_member'] == $member['id']) echo 'selected'; ?>><?php echo $member['nama']; ?></option>
                    <?php } ?>
                  </select>
                  <label for="nama">Nama Member</label>
                </div>
              </div>
              <div class="form-group mb-3">
                <?php if(isset($error_kolom) && $error_kolom == "judul"): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class="form-floating">
                  <select class="form-select" name="judul" id="judul" id="floatingSelect">
                    <?php foreach ($books as $book) { ?>
                      <option value="<?php echo $book['id']; ?>" <?php if ($row[0]['id_buku'] == $book['id']) echo 'selected'; ?>><?php echo $book['judul']; ?></option>
                    <?php } ?>
                  </select>
                  <label for="judul">Judul Buku</label>
                </div>
              </div>
              <div class="form-group mb-3">
                <?php if(isset($error_kolom) && $error_kolom == "pengembalian"): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class="form-floating">
                  <input type="datetime-local" class="form-control" id="pengembalian" name="pengembalian" value="<?= $row[0]['tenggat_pengembalian']; ?>">
                  <label for="pengembalian">Tanggal Tenggat Pengembalian</label>
                </div>
              </div>
                <div class="tright">
                    <button id="resetButton" class="movebtn btn btn-danger" type="Reset"><i class="fa fa-fw fa-refresh"></i> Reset </button>
                    <button class="movebtn btn btn-primary" type="Submit" name="submit">Submit <i class="fa fa-fw fa-paper-plane"></i></button>
                </div>
            </form>
            <a href="/Perpustakaan/view/admin/peminjaman/dataPeminjaman.php" type="button" class="btn btn-primary mt-3">Home</a>
        </div>
      </div>
    </div>
  <?php require_once __DIR__.'/../layouts/footer.php'; ?>

  <script>
        document.getElementById('coverInput').addEventListener('change', function() {
            var input = this;
            var imgPreview = document.getElementById('coverPreview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    imgPreview.style.display = 'block';
                    imgPreview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                imgPreview.style.display = 'none';
                imgPreview.src = '#';
            }
        });

        function resetPreview() {
        var imgPreview = document.getElementById('coverPreview');
        imgPreview.style.display = 'none';
        imgPreview.src = '';
        }
        document.getElementById('resetButton').addEventListener('click', function() {
            resetPreview();
        });
    </script>

</body>
</html>