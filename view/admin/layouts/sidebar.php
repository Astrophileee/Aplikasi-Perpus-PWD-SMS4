    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-library"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Aplikasi Perpustakaan</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="/Perpustakaan/view/admin/dashboard.php" class="sidebar-link">
                        <i class="lni lni-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/Perpustakaan/view/admin/buku/dataBuku.php" class="sidebar-link">
                        <i class="lni lni-book"></i>
                        <span>Data Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/Perpustakaan/view/admin/member/dataMember.php" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Data Member</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-cart"></i></i>
                        <span>Transaksi</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/Perpustakaan/view/admin/peminjaman/dataPeminjaman.php" class="sidebar-link">Peminjaman</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/Perpustakaan/view/admin/peminjaman/dataPengembalian.php" class="sidebar-link">Pengembalian</a>
                        </li>
                    </ul>
                </li>
                <?php if ($_SESSION['user']['level'] == 1): ?>
                <li class="sidebar-item">
                        <a href="/Perpustakaan/view/admin/User/dataUser.php" class="sidebar-link">
                            <i class="lni lni-control-panel"></i>
                            <span>Data User</span>
                        </a>
                    </li>
                    <?php endif; ?>
            </ul>
            <div class="sidebar-footer">
            <li class="sidebar-item">
                    <a class="sidebar-link">
                    <img src="/Perpustakaan/assets/photo/<?= $userAktif['gambar']; ?>" alt="Profile" class="navbar-profile-img"
                    style="width: 25px; height: 25px; border-radius: 50%; margin-right: 4px;">
                        <span> <?=$userAktif['username']; ?></span>
                    </a>
                </li>
                <a href="/Perpustakaan/view/admin/user/logout.php" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>