<?php
require_once '../../../Model/User.php'; 
$user = new User();

$old_nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$old_password = isset($_POST['password']) ? $_POST['password'] : '';

if(isset($_POST['reset'])){
    $old_nama = '';
    $old_password = '';
}

if(isset($_POST['submit'])){
    if(empty($_POST['nama'])){
        $error_message = "Kolom Nama harus diisi.";
        $error_kolom = "nama";
    }
    elseif(empty($_POST['password'])){
        $error_message = "Kolom Password harus diisi.";
        $error_kolom = "password";
    }
    elseif(empty($_FILES['gambar']['name'])){
        $error_message = "Kolom Gambar harus diisi.";
        $error_kolom = "gambar";
    } else {
            $password = $_POST['password'];
            $targetDir = "../../../assets/photo/";
            $uniqueFilename = uniqid() . '_' . $_FILES['gambar']['name'];
            $targetFilePath = $targetDir . $uniqueFilename;
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath);
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $passwordHash = trim($passwordHash);
            $data = [
                'nama' => $_POST['nama'],
                'username' => $_POST['username'],
                'password' => $passwordHash,
                'gambar' => $uniqueFilename
            ];
            $user->createData($data);
        header('Location: /Perpustakaan/view/admin/user/Formlogin.php?success=true&message=Anda Berhasil Registrasi.');
        exit;
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once __DIR__.'/../layouts/header.php'; ?>
    <style>
        #usernameAvailability {
            display: none;
        }
    </style>
</head>
<body>
  <form class="form" method="POST" action="" enctype="multipart/form-data">
    <section class="vh-100" style="background-color: #2779e2;">
      <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-9">
            <h1 class="text-white mb-4">Register</h1>
            <div class="card" style="border-radius: 15px;">
              <div class="card-body">
                <div class="row align-items-center pt-4 pb-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Full name</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <?php if(isset($error_kolom) && $error_kolom == "nama"): ?>
                      <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input name="nama" value="<?php echo $old_nama; ?>" type="text" class="form-control form-control-lg" placeholder="Ketikan Nama ...." />
                  </div>
                </div>
                <hr class="mx-n3">
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Username</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <div class="alert alert-danger" id="usernameAvailability"><?php echo $error_message; ?></div>
                    <input id="usernameInput" name="username" type="text" class="form-control form-control-lg" placeholder="Ketikan Username ...." />
                  </div>
                </div>
                <hr class="mx-n3">
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Password</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <?php if(isset($error_kolom) && $error_kolom == "password"): ?>
                      <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <div class="position-relative">
                        <input id="passwordInput" name="password" value="<?php echo $old_password; ?>" type="password" class="form-control form-control-lg" placeholder="Ketikkan Password ...." />
                    </div>
                  </div>
                </div>
                <hr class="mx-n3">
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Upload Photo Profile</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <?php if(isset($error_kolom) && $error_kolom == "gambar"): ?>
                      <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="gambarInput" name="gambar" accept="image/*">
                    <div class="small text-muted mt-2">Upload your Photo Profile</div>
                    <img id="gambarPreview" src="#" alt="Preview Gambar" style="max-width: 200px; display: none;">
                  </div>
                </div>
                <hr class="mx-n3">
                <div class="px-5 py-4">
                  <button id="resetButton" class="movebtn btn btn-danger" type="reset"><i class="fa fa-fw fa-refresh"></i> Reset </button>
                  <button name="submit" type="submit" class="btn btn-primary" disabled>Submit</button>
                  <a href="formLogin.php" type="button" class="btn btn-success">Login?</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    imgPreview.src = '';
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


$(document).ready(function(){
    $('#usernameInput').on('keyup change', function(){
        var searchUsername = $(this).val();
        if (searchUsername.trim() !== '') {
            $.ajax({
                url: 'checkUsername.php',
                method: 'POST',
                data: {query: searchUsername},
                success: function(response){
                  if (response === 'Username tersedia') {
                      $('#usernameAvailability').removeClass('alert-danger').addClass('alert-success').text(response).show();
                      $('button[name="submit"]').prop('disabled', false); // Mengaktifkan kembali tombol submit
                  } else {
                      $('#usernameAvailability').removeClass('alert-success').addClass('alert-danger').text(response).show();
                      $('button[name="submit"]').prop('disabled', true);
                  }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#usernameAvailability').removeClass('alert-success').addClass('alert-danger').text('Terjadi kesalahan saat memeriksa username. Silakan coba lagi.').show();
                    $('button[name="submit"]').prop('disabled', true);
                }
            });
        } else {
            $('#usernameAvailability').hide();
            $('button[name="submit"]').prop('disabled', true);
        }
    });
});

</script>
</body>
</html>
