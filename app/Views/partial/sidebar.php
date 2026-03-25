<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <!-- Logo icon -->
                <a href="index.html">
                    <img src="<?= base_url('assets/images/logo-main.png') ?>" alt="" class="img-fluid">
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                <h2><?= $title ?></h2>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-end">
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item">
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?= base_url('assets/images/user.png') ?>" alt="user" class="rounded-circle"
                            width="40"> Login as <?= $user['roleFullname'] ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            
                            <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                    class="text-dark"><?= $user['nama'] ?></span></span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i data-feather="power"
                                class="svg-icon me-2 ms-1"></i>
                            Logout</a>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                        href="<?= base_url('dashboard/usul_sapras') ?>" aria-expanded="false"><i data-feather="check-circle"
                            class="feather-icon"></i><span class="hide-menu"> Usul Sapras</span></a></li>
                <?php if ($user['role'] != 'BPP'): ?>
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                        href="<?= base_url('rekomendasi') ?>" aria-expanded="false"><i data-feather="check-square"
                            class="feather-icon"></i><span class="hide-menu"> Rekomendasi</span></a></li>
                <?php endif; ?>   
                <?php if($user['role'] == 'PPL' || $user['role'] == 'KAB'): ?>
                <!-- Menu Poktan kelompok tani -->
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                        href="<?= base_url('poktan') ?>"
                        aria-expanded="false"><i data-feather="check-square" class="feather-icon"></i><span class="people">
                            Poktan</span></a></li>
                <?php endif; ?>
                <?php if ($user['role'] != 'PROV'): ?>
                    <li class="nav-small-cap"><span class="hide-menu">Profil</span></li>
                        
                    <?php if ($user['role'] == 'PPL' || $user['role'] == 'KAB' ): ?>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="<?= base_url('dashboard/profil') ?>" aria-expanded="false"><i data-feather="user"
                                class="feather-icon"></i><span class="hide-menu"> Profil Pengusul</span></a></li>
                    <?php endif; ?> 
                    <?php if ($user['role'] != 'PPL'): ?>
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="<?= base_url('dashboard/profil_dinas') ?>" aria-expanded="false"><i data-feather="codepen"
                                class="feather-icon"></i><span class="hide-menu"> Profil Instansi</span></a></li>
                    
                    <?php endif; ?>        
                <?php endif; ?>        
                <?php if ($user['role'] != 'PPL'): ?>
                    <li class="nav-small-cap"><span class="hide-menu">Account</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="<?= base_url('dashboard/daftar_akun') ?>" aria-expanded="false"><i data-feather="users"
                                class="feather-icon"></i><span class="hide-menu"> Akun Pengusul</span></a></li>
                <?php endif; ?>
                
                <?php if ($user['role'] == 'PROV'): ?>
                    <li class="nav-small-cap"><span class="hide-menu">Master</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="<?= base_url('master_instansi') ?>" aria-expanded="false"><i data-feather="book"
                                class="feather-icon"></i><span class="hide-menu"> Instansi</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="<?= base_url('master_kategori') ?>" aria-expanded="false"><i data-feather="briefcase"
                                class="feather-icon"></i><span class="hide-menu"> Kategori Alsintan</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="<?= base_url('master_tipe') ?>" aria-expanded="false"><i data-feather="box"
                                class="feather-icon"></i><span class="hide-menu"> Tipe Alsintan</span></a></li>
                <?php endif; ?>
                <li class="list-divider"></li>
                <!-- Logout paling bawah -->
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="<?= base_url('auth/logout') ?>"
                        aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span
                            class="hide-menu"> Logout</span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>