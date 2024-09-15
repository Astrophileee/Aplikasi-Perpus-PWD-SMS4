
<?php
include_once __DIR__.'/../layouts/session.php';
require_once '../../../Model/Buku.php'; 
$buku = new Buku();

$old_judul = isset($_POST['judul']) ? $_POST['judul'] : '';
$old_penulis = isset($_POST['penulis']) ? $_POST['penulis'] : '';
$old_penerbit = isset($_POST['penerbit']) ? $_POST['penerbit'] : '';
$old_tahun = isset($_POST['tahun']) ? $_POST['tahun'] : '';
$old_jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : '';
$old_sinopsis = isset($_POST['sinopsis']) ? $_POST['sinopsis'] : '';

if(isset($_POST['reset'])){
    $old_judul = '';
    $old_penulis = '';
    $old_penerbit = '';
    $old_tahun = '';
    $old_jumlah = '';
    $old_sinopsis = '';
}

if(isset($_POST['submit'])){
    if(empty($_POST['judul'])){
        $error_message = "Kolom Judul Buku harus diisi.";
        $error_kolom = "judul";
    }
    elseif(empty($_POST['penulis'])){
        $error_message = "Kolom Penulis Buku harus diisi.";
        $error_kolom = "penulis";
    }elseif(empty($_POST['penerbit'])){
        $error_message = "Kolom Penerbit Buku harus diisi.";
        $error_kolom = "penerbit";
    }elseif(empty($_POST['tahun'])){
        $error_message = "Kolom Tahun Terbit Buku harus diisi.";
        $error_kolom = "tahun";
    }elseif(empty($_POST['jumlah'])){
        $error_message = "Kolom jumlah Buku harus diisi.";
        $error_kolom = "jumlah";
    }elseif(empty($_POST['sinopsis'])){
        $error_message = "Kolom sinopsis Buku harus diisi.";
        $error_kolom = "sinopsis";
    }
    elseif(empty($_FILES['cover']['name'])){
        $error_message = "Kolom Cover Buku diisi.";
        $error_kolom = "cover";
    }
    elseif(!is_numeric($_POST['tahun']) || $_POST['tahun'] < 1945 || $_POST['tahun'] > 2045) {
        $error_message = "Kolom Tahun Terbit Buku tidak valid. Harus berada di antara 1945 dan 2045.";
        $error_kolom = "tahun";
      } else {
        $uniqueFilename = uniqid() . '_' . $_FILES['cover']['name'];
        $targetDir = "../../../assets/cover/";
        $targetFilePath = $targetDir . $uniqueFilename;
        move_uploaded_file($_FILES["cover"]["tmp_name"], $targetFilePath);
                $data = [
            'judul' => $_POST['judul'],
            'penulis' => $_POST['penulis'],
            'penerbit' => $_POST['penerbit'],
            'tahun_terbit' => $_POST['tahun'],
            'jumlah' => $_POST['jumlah'],
            'sinopsis' => $_POST['sinopsis'],
            'cover' => $uniqueFilename
        ];
        $buku->createData($data);
        header('Location: dataBuku.php?success=true&message=Data berhasil ditambah.');
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
        <h1 class="text-center">Tambah Buku</h1>
          <div class="container mt-3">
            <form class="form" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="judul">Judul Buku</label>
                    <div>
                      <?php if(isset($error_kolom) && $error_kolom == "judul"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                      <input name="judul" value="<?php echo $old_judul; ?>" class="form-control" id="judul" type="text" placeholder="Ketikan Judul Buku...">
                    </div>
                </div>
                <div class="form-group mb-3">
                  <label for="penulis">Penulis Buku</label>
                  <div>
                    <?php if(isset($error_kolom) && $error_kolom == "penulis"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input name="penulis" value="<?php echo $old_penulis; ?>" class="form-control" type="text" placeholder="Ketikan Penulis Buku...">
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="penerbit">Penerbit Buku</label>
                  <div>
                    <?php if(isset($error_kolom) && $error_kolom == "penerbit"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input name="penerbit" value="<?php echo $old_penerbit; ?>" class="form-control" type="text" placeholder="Ketikan Penerbit Buku...">
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="tahun">Tahun Terbit Buku</label>
                  <div>
                    <?php if(isset($error_kolom) && $error_kolom == "tahun"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input name="tahun" value="<?php echo $old_tahun; ?>" class="form-control" type="number" placeholder="Ketikan Tahun Terbit Buku...">
                  </div>
                </div>
                  <div class="form-group mb-3">
                    <label for="jumlah">Jumlah Buku</label>
                    <div>
                      <?php if(isset($error_kolom) && $error_kolom == "jumlah"): ?>
                          <div class="alert alert-danger"><?php echo $error_message; ?></div>
                      <?php endif; ?>
                      <input name="jumlah" value="<?php echo $old_jumlah; ?>" class="form-control" type="number" placeholder="Ketikan Jumlah Buku...">
                    </div>
                  </div>
                  
                  <div class="form-group mb-3">
                    <label for="sinopsis">Sinopsis Buku</label>
                    <div>
                      <?php if(isset($error_kolom) && $error_kolom == "sinopsis"): ?>
                          <div class="alert alert-danger"><?php echo $error_message; ?></div>
                      <?php endif; ?>
                      <textarea name="sinopsis" class="form-control" type="number" placeholder="Ketikan Sinopsis Buku..."><?php echo $old_sinopsis; ?></textarea>
                    </div>
                  </div>
                <div class="form-group mb-3">
                  <?php if(isset($error_kolom) && $error_kolom == "cover"): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                  <?php endif; ?>
                  <div>
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="cover">Cover Buku</label>
                      <input type="file" class="form-control" id="coverInput" name="cover" accept="image/*">
                    </div>
                  </div>
                  <img id="coverPreview" src="#" alt="Preview Gambar" style="max-width: 200px; display: none;">
                </div>
                <div class="tright">
                    <button id="resetButton" class="movebtn btn btn-danger" type="Reset"><i class="fa fa-fw fa-refresh"></i> Reset </button>
                    <button class="movebtn btn btn-primary" type="Submit" name="submit">Submit <i class="fa fa-fw fa-paper-plane"></i></button>
                </div>
            </form>
            <a href="/Perpustakaan/view/admin/buku/dataBuku.php" type="button" class="btn btn-primary mt-3">Home</a>
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