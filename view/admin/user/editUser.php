
<?php
include_once __DIR__.'/../layouts/session.php';

if ($userAktif['level'] == 0) {
    header('Location: /Perpustakaan/view/admin/dashboard.php?success=False&message=Anda Tidak Mempuyai Akses');
    exit;
}

require_once '../../../Model/User.php'; 
$user = new User();
$id = $_GET['id'];
$where = ['id' => $id];
$row = $user->readData("WHERE id = $id");

if(isset($_POST['submit'])){
    if(empty($_POST['nama'])){
        $error_message = "Kolom Nama harus diisi.";
        $error_kolom = "nama";
    }
    else {
        $data = [
            'nama' => $_POST['nama'],
            'level' => $_POST['level']
        ];
        if (!empty($_FILES['gambar']['name'])) {
            $gambar = $row[0]['gambar'];
            $filePath = "../../../assets/photo/" . $gambar;
            unlink($filePath);
            $uniqueFilename = uniqid() . '_' . $_FILES['gambar']['name'];
            $data['gambar'] = $uniqueFilename;
            $_SESSION['user']['gambar'] = $data['gambar'];
            $targetDir = "../../../assets/photo/";
            $targetFilePath = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath);
        } else {
            $row = $user->readData("WHERE id = $id");
            $data['gambar'] = $row[0]['gambar'];
        }
        $where = ['id' => $id];

        $user->updateData($data, $where);
        header('Location: dataUser.php?success=true&message=Data berhasil diedit.');
        exit;
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
        <h1 class="text-center">Edit User</h1>
        <div class="container mt-3">
            <form class="form" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="nama">Nama User</label>
                    <div>
                    <?php if(isset($error_kolom) && $error_kolom == "nama"): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input name="nama" value="<?= $row[0]['nama']; ?>" class="form-control" id="nama" type="text" placeholder="Ketikan Nama User...">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="form-floating">
                        <select class="form-select" name="level" id="level">
                            <option value="1" <?php if ($row[0]['level'] == '1' || '1') echo 'selected'; ?>>Level 1</option>
                            <option value="0" <?php if ($row[0]['level'] == '0' || '0') echo 'selected'; ?>>Level 0</option>
                        </select>
                    <label for="judul">Level</label>
                    </div>
                </div>
                <div class="form-group mb-3">
                <?php if(isset($error_kolom) && $error_kolom == "gambar"): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="gambar">Gambar Buku</label>
                        <?php if (!empty($row[0]['gambar'])): ?>
                            <img src="../../../assets/photo/<?php echo $row[0]['gambar']; ?>" alt="Gambar Baju" style="max-width: 200px;">
                        <?php endif; ?>
                        <input type="file" class="form-control" id="gambarInput" name="gambar" accept="image/*">
                        </div>
                    </div>
                    <img id="gambarPreview" src="#" alt="Preview Gambar" style="max-width: 200px; display: none;">
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
        document.getElementById('gambarInput').addEventListener('change', function() {
            var input = this;
            var imgPreview = document.getElementById('gambarPreview');

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
        var imgPreview = document.getElementById('gambarPreview');
        imgPreview.style.display = 'none';
        imgPreview.src = '';
        }
        document.getElementById('resetButton').addEventListener('click', function() {
            resetPreview();
        });
    </script>

</body>
</html>