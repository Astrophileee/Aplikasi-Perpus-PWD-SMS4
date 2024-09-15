

<?php
include_once __DIR__.'/../layouts/session.php';

if ($userAktif['level'] == 0) {
    header('Location: /Perpustakaan/view/admin/dashboard.php?success=False&message=Anda Tidak Mempuyai Akses');
    exit;
}
require_once '../../../Model/User.php'; 
$user = new User();
if(isset($_GET['action']) && $_GET['action'] == "hapus"){
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $user = new User();
        $userData = $user->readData("WHERE id = $id");

        if($userData) {
            $where = ['id' => $id];
            $user->deleteData($where);
            $gambar = $userData[0]['gambar'];

            $filePath = "../../../assets/photo/" . $gambar;

            if(file_exists($filePath)) {
                if(unlink($filePath)) {
                    header('Location: /Perpustakaan/view/admin/user/dataUser.php?success=true&message=Data berhasil dihapus.');
                    exit;
                } else {
                    header('Location: /Perpustakaan/view/admin/user/dataUser.php?success=false&message=Gagal menghapus file photo.');
                    exit;
                }
            } else {
                header('Location: /Perpustakaan/view/admin/user/dataUser.php?success=false&message=File photo tidak ditemukan.');
                exit;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once __DIR__.'/../layouts/header.php'; ?>
  <style>
    
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }
    .paginate_button {
      cursor: pointer;
    }
    .paginate_button.previous, .paginate_button.next {
    font-size: 20px;
    padding: 10px 20px;
  }
  </style>
</head>

<body>
  <?php require_once __DIR__.'/../layouts/sidebar.php'; ?>
  <div class="main p-3">
    <div class="text-center">
      <h1>Data User</h1>
          
      <div class="container mt-5 container-user">
        <div class="col-md-1">
          <a href="/Perpustakaan/view/admin/user/tambahUser.php" type="button" class="btn btn-primary">Tambah</a>
        </div>
        <div class="row">
          <div class="col-12">
            <table id="tableUser" class="display">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>username</th>
                  <th>Photo Profile</th>
                  <th>Level</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $row = $user->readData();
                  foreach ($row as $key => $data) {
                ?>
                <tr>
                  <td><?= $key+1 ?></td>
                  <td><?=ucwords(strtolower($data['nama']));?></td>
                  <td><?=$data['username'];?></td>
                  <td><img src="../../../assets/photo/<?= $data['gambar']; ?>" style="max-width: 100px; max-height: 100px;" alt="Photo Profile"></td>
                  <td><?=ucwords(strtolower($data['level']));?></td>
                  <td class="align-middle">
                    <a href="editUser.php?id=<?= $data['id']; ?>" class="btn btn-primary btn-lg"><i class="lni lni-pencil-alt"></i></a>
                    <button onclick="confirmDelete(<?= $data['id']; ?>)" class="btn btn-danger btn-delete btn-lg"><i class="lni lni-trash-can"></i></button>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once __DIR__.'/../layouts/footer.php'; ?>
  
<script>
jQuery(document).ready(function($) {
    $('#tableUser').DataTable({
        search: false,
        
    });
});

    function confirmDelete(id) {
			Swal.fire({
				title: 'Apakah Anda yakin?',
				text: 'Anda tidak akan dapat mengembalikan tindakan ini!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, hapus!',
				cancelButtonText: 'Batal',
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = '?action=hapus&id=' + id
				}
			})
		}

		window.addEventListener('load', function () {
			let urlParams = new URLSearchParams(window.location.search)
			let success = urlParams.get('success')
			let message = urlParams.get('message')

			if (success && message) {
				if (success === 'true') {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: message,
						showConfirmButton: false,
						timer: 1500,
					})
				} else {
					Swal.fire({
						title: 'Error!',
						text: message,
						icon: 'error',
					})
				}
				window.history.replaceState(
					{},
					document.title,
					window.location.pathname
				)
			}
		})

</script>
</body>

</html>