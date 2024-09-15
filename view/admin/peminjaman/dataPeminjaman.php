<?php
include_once __DIR__.'/../layouts/session.php';
require_once '../../../Model/Peminjaman.php'; 
$peminjaman = new Peminjaman();

if(isset($_GET['action']) && $_GET['action'] == "hapus"){
    if(isset($_GET['kode_peminjaman'])) {
        $kode_peminjaman = $_GET['kode_peminjaman'];
        $peminjaman = new Peminjaman();
        $peminjamanData = $peminjaman->readData("WHERE kode_peminjaman = $kode_peminjaman");
        $id_buku = $peminjamanData[0]['id_buku'];
        $where = ['kode_peminjaman' => $kode_peminjaman];
        $peminjaman->tambahStockBuku($id_buku);
        $peminjaman->deleteData($where);
        
        if ($peminjaman) {
            header('Location: /Perpustakaan/view/admin/peminjaman/dataPeminjaman.php?success=true&message=Data berhasil dihapus.');
        } else {
            header('Location: /Perpustakaan/view/admin/peminjaman/dataPeminjaman.php?success=false&message=Gagal menghapus data.');
        }
    }
}

if(isset($_GET['action']) && $_GET['action'] == "pengembalian"){
    if(isset($_GET['kode_peminjaman'])) {
        $peminjaman->tambahDenda();
        $kode_peminjaman = $_GET['kode_peminjaman'];
        $peminjamanData = $peminjaman->readData("WHERE kode_peminjaman = $kode_peminjaman");
        $id_buku = $peminjamanData[0]['id_buku'];
        $peminjaman->updatePengembalian($kode_peminjaman);
        $peminjaman->tambahStockBuku($id_buku);
        header('Location: /Perpustakaan/view/admin/peminjaman/dataPeminjaman.php?success=true&message=Buku Berhasil Dikembalikan.');
    }
}

if (isset($_POST['refresh'])) {
    $peminjaman->tambahDenda();
    header('Location: /Perpustakaan/view/admin/peminjaman/dataPeminjaman.php?success=true&message=Denda Berhasil Terupdate.');
    exit();
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
  tbody {
    text-align: center;
  }
  </style>
</head>

<body>
  <?php require_once __DIR__.'/../layouts/sidebar.php'; ?>
  <div class="main p-3">
    <div class="text-center">
      <h1>Data Peminjaman</h1>
          
      <div class="container mt-5 container-peminjaman">
        <div class="col-md-2">
          <div class="d-inline-block">
              <a href="/Perpustakaan/view/admin/peminjaman/tambahPeminjaman.php" class="btn btn-primary">Tambah</a>
          </div>
          <div class="d-inline-block">
              <form method="post">
                  <button class="btn btn-success" type="submit" name="refresh">
                      <i class="lni lni-reload"></i> Refresh 
                  </button>
              </form>
          </div>
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
                  <th>Aksi</th>
                  <th>Pengembalian</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $row = $peminjaman->readData("JOIN member ON peminjaman.id_member = member.id JOIN buku ON peminjaman.id_buku = buku.id WHERE peminjaman.status_pengembalian = false");
                  foreach ($row as $key => $data) {
                    $waktu_peminjaman = date('d-m-Y H:i:s', strtotime($data['waktu_peminjaman']));
                    $tenggat_pengembalian = date('d-M-Y H:i:s', strtotime($data['tenggat_pengembalian']));
                    $waktu_pengembalian = is_null($data['waktu_pengembalian']) ? 'Belum Dikembalikan' : date('d-M-Y H:i:s', strtotime($data['waktu_pengembalian']));
                    $status_pengembalian = $data['status_pengembalian'] ? 'disabled' : '';
                ?>
                <tr>
                  <td><?= $key+1 ?></td>
                  <td><?=ucwords(strtolower($data['nama']));?></td>
                  <td><?=ucwords(strtolower($data['judul']));?></td>
                  <td><?=$waktu_peminjaman?></td>
                  <td><?=$tenggat_pengembalian?></td>
                  <td><?=$waktu_pengembalian?></td>
                  <td>Rp. <?= number_format($data['denda'], 0, ',', '.'); ?></td>
                  <td class="align-middle">
                    <a href="editPeminjaman.php?kode_peminjaman=<?= $data['kode_peminjaman']; ?>" class="btn btn-primary btn-lg"><i class="lni lni-pencil-alt"></i></a>
                    <button onclick="confirmDelete(<?= $data['kode_peminjaman']; ?>)" class="btn btn-danger btn-delete btn-lg"><i class="lni lni-trash-can"></i></button>
                  </td>
                  <td style="text-align: center">
                    <button onclick="confirmPengembalian(<?= $data['kode_peminjaman']; ?>)" class="btn btn-danger btn-lg btn-pengembalian" <?= $status_pengembalian ?>><i class="lni lni-reply"></i></button>
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

    function refreshPage() {
        window.location.href = '/Perpustakaan/view/admin/peminjaman/dataPeminjaman.php?action=refresh';
    }

jQuery(document).ready(function($) {
    $('#tablePeminjaman').DataTable({
        search: false,
        
    });
});

function confirmPengembalian(kode_peminjaman) {
			Swal.fire({
				title: 'Apakah Anda yakin?',
				text: 'Anda tidak akan dapat mengembalikan tindakan ini!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Kembalikan!',
				cancelButtonText: 'Batal',
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = '?action=pengembalian&kode_peminjaman=' + kode_peminjaman
				}
			})
		}

    function confirmDelete(kode_peminjaman) {
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
					window.location.href = '?action=hapus&kode_peminjaman=' + kode_peminjaman
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