<?php
include_once __DIR__.'/../layouts/session.php';
require_once '../../../Model/Peminjaman.php';   
$peminjaman = new Peminjaman();

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
  tbody {
    text-align: center;
  }
  </style>
</head>

<body>
  <?php require_once __DIR__.'/../layouts/sidebar.php'; ?>
  <div class="main p-3">
    <div class="text-center">
      <h1>Data Pengembalian</h1>
          
      <div class="container mt-5 container-peminjaman">
        <div class="col-md-2">
        </div>
        <div class="row">
          <div class="col-12">  
            <table id="tablePeminjaman" class="display">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Peminjam</th>
                  <th>Judul Buku</th>
                  <th>Waktu Peminjaman</th>
                  <th>Tenggat Pengembalian</th>
                  <th>Waktu Pengembalian</th>
                  <th>Denda</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $row = $peminjaman->readData("JOIN member ON peminjaman.id_member = member.id JOIN buku ON peminjaman.id_buku = buku.id WHERE peminjaman.status_pengembalian = true");
                  foreach ($row as $key => $data) {
                    $waktu_peminjaman = date('d-m-Y H:i:s', strtotime($data['waktu_peminjaman']));
                    $tenggat_pengembalian = date('d-M-Y H:i:s', strtotime($data['tenggat_pengembalian']));
                    $waktu_pengembalian = is_null($data['waktu_pengembalian']) ? 'Belum Dikembalikan' : date('d-M-Y H:i:s', strtotime($data['waktu_pengembalian']));
                    
                ?>
                <tr>
                  <td><?= $key+1 ?></td>
                  <td><?=ucwords(strtolower($data['nama']));?></td>
                  <td><?=ucwords(strtolower($data['judul']));?></td>
                  <td><?=$waktu_peminjaman?></td>
                  <td><?=$tenggat_pengembalian?></td>
                  <td><?=$waktu_pengembalian?></td>
                  <td>Rp. <?= number_format($data['denda'], 0, ',', '.'); ?></td>
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

    function refreshPage() {
        window.location.href = '/Perpustakaan/view/admin/peminjaman/dataPeminjaman.php?action=refresh';
    }

jQuery(document).ready(function($) {
    $('#tablePeminjaman').DataTable({
        search: false,
        
    });
});

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