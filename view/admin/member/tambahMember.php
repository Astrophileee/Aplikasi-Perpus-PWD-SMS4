
<?php
include_once __DIR__.'/../layouts/session.php';
require_once '../../../Model/Member.php'; 
$member = new Member();

$old_nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$old_email = isset($_POST['email']) ? $_POST['email'] : '';
$old_no_telp = isset($_POST['no_telp']) ? $_POST['no_telp'] : '';
$old_alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';

if(isset($_POST['reset'])){
    $old_nama = '';
    $old_email = '';
    $old_no_telp = '';
    $old_alamat = '';
}

if(isset($_POST['submit'])){
    if(empty($_POST['nama'])){
        $error_message = "Kolom Nama Member harus diisi.";
        $error_kolom = "nama";
    }elseif(empty($_POST['email'])){
        $error_message = "Kolom Email Member harus diisi.";
        $error_kolom = "email";
    }elseif(empty($_POST['no_telp'])){
        $error_message = "Kolom Nomor Telpon Member harus diisi.";
        $error_kolom = "no_telp";
    }elseif(empty($_POST['alamat'])){
        $error_message = "Kolom Alamat Member harus diisi.";
        $error_kolom = "alamat";
    }
    elseif(!preg_match('/^08\d{8,18}$/', $_POST['no_telp'])) {
        $error_message = "Kolom Nomor Telpon Member tidak valid. Harus diawali dengan '08' dan terdiri dari 10 sampai 20 angka.";
        $error_kolom = "no_telp";
    }
      else {
        $data = [
          'nama' => $_POST['nama'],
          'email' => $_POST['email'],
          'no_telp' => $_POST['no_telp'],
          'alamat' => $_POST['alamat'],
        ];
        $member->createData($data);
        header('Location: dataMember.php?success=true&message=Data berhasil ditambah.');
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
        <h1 class="text-center">Tambah Member</h1>
          <div class="container mt-3">
            <form class="form" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nama">Nama Member</label>
                    <div>
                      <?php if(isset($error_kolom) && $error_kolom == "nama"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                      <input name="nama" value="<?php echo $old_nama; ?>" class="form-control" id="nama" type="text" placeholder="Ketikan Nama Member...">
                    </div>
                </div>
                <div class="form-group mb-3">
                  <label for="email">Email Member</label>
                  <div>
                    <?php if(isset($error_kolom) && $error_kolom == "email"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input name="email" value="<?php echo $old_email; ?>" class="form-control" type="email" placeholder="Ketikan Email Member...">
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="no_telp">Nomor Telpon Member</label>
                  <div>
                    <?php if(isset($error_kolom) && $error_kolom == "no_telp"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input name="no_telp" value="<?php echo $old_no_telp; ?>" class="form-control" type="number" placeholder="Ketikan Email Member...">
                  </div>
                </div>
                  <div class="form-group mb-3">
                    <label for="alamat">Alamat Member</label>
                    <div>
                      <?php if(isset($error_kolom) && $error_kolom == "alamat"): ?>
                          <div class="alert alert-danger"><?php echo $error_message; ?></div>
                      <?php endif; ?>
                      <textarea name="alamat" class="form-control" type="number" placeholder="Ketikan Alamat Member..."><?php echo $old_alamat; ?></textarea>
                    </div>
                  </div>
                <div class="tright">
                    <button id="resetButton" class="movebtn btn btn-danger" type="Reset"><i class="fa fa-fw fa-refresh"></i> Reset </button>
                    <button class="movebtn btn btn-primary" type="Submit" name="submit">Submit <i class="fa fa-fw fa-paper-plane"></i></button>
                </div>
            </form>
            <a href="/Perpustakaan/view/admin/member/dataMember.php" type="button" class="btn btn-primary mt-3">Home</a>
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