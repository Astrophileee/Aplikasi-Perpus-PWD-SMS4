<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: dataBaju.php?success=true&message=Anda Sudah Login');
    exit;
}

require_once '../../../Model/User.php'; 
$user = new User();

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $loginResult = $user->checkLogin($username, $password);
    if ($loginResult === true) {
      header('Location: /Perpustakaan/view/admin/dashboard.php?success=true&message=Anda Berhasil Login.');
        exit;
    } else {
        header('Location: /Perpustakaan/view/admin/user/formLogin.php?success=false&message='.$loginResult);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__.'/../layouts/header.php'; ?>
<body>
  <form class="form" method="POST" action="" enctype="multipart/form-data">
    <section class="vh-100" style="background-color: #2779e2;">
      <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-9">
            <h1 class="text-white mb-4">Login</h1>
            <div class="card" style="border-radius: 15px;">
              <div class="card-body">
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Username</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input id="usernameInput" name="username" type="text" class="form-control form-control-lg" placeholder="Ketikan Username ...." />
                  </div>
                </div>
                <hr class="mx-n3">
                <div class="row align-items-center py-3">
                  <div class="col-md-3 ps-5">
                    <h6 class="mb-0">Password</h6>
                  </div>
                  <div class="col-md-9 pe-5">
                    <input name="password" type="password" class="form-control form-control-lg" placeholder="Ketikan Password ...." />
                  </div>
                </div>
                <hr class="mx-n3">
                <div class="px-5 py-4">
                  <a href="formRegis.php" type="button" class="btn btn-success">Register?</a>
                  <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-DTLKIoN4RWkgv4+Kiu9ZLlOA1/2Vc6YrYN/OrAvHJYOQGv8/kmyKCBt7QI/vXhfR" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   window.addEventListener('load', function() {
    let urlParams = new URLSearchParams(window.location.search);
    let success = urlParams.get('success');
    let message = urlParams.get('message');

    if (success && message) {
        if (success === "true") {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: message,
                showConfirmButton: false,
                timer: 1500
                });
        } else {
            Swal.fire({
                title: "Error!",
                text: message,
                icon: "error"
            });
        }
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
</body>
</html>
