<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vacancies - Dev Test | <?php echo $this->renderSection('title'); ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo site_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo site_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <?php echo $this->renderSection('styles'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo site_url('/'); ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Vacancies - Dev Test <sup>CI4</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <?php if (auth()->user->is_admin) : ?>

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('/'); ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>

            <?php endif; ?>




            <!-- Divider -->
            <hr class="sidebar-divider mb-0">

            <li class="nav-item">
                <a class="nav-link" href="<?php echo route_to('jobs'); ?>">
                    <i class="fas fa-list-ol"></i>
                    <span>Veja as vagas</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider mb-0">


            <li class="nav-item">
                <a class="nav-link" href="<?php echo route_to('jobs.my'); ?>">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Minhas candidaturas</span></a>
            </li>


            <hr class="sidebar-divider mb-0">


            <?php if (auth()->user->is_admin) : ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo route_to('candidates'); ?>">
                        <i class="fas fa-users"></i>
                        <span>Gerenciar candidatos</span></a>
                </li>

                <hr class="sidebar-divider mb-0">


                <li class="nav-item">
                    <a class="nav-link" href="<?php echo route_to('vacancies'); ?>">
                        <i class="fas fa-check"></i>
                        <span>Gerenciar vagas</span></a>
                </li>

            <?php endif; ?>



            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item mb-4">

                <?php echo form_open(route_to('login.destroy')); ?>

                <?php echo form_submit('', 'Logout', ['class' => 'btn btn-primary btn-sm ml-3']) ?>

                <?php echo form_close(); ?>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item">

                            <?php echo form_open(route_to('login.destroy')); ?>

                            <?php echo form_submit('', 'Sair', ['class' => 'btn btn-primary btn-sm']) ?>

                            <?php echo form_close(); ?>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <?php echo $this->include('Template/_session_messages'); ?>

                <?php echo $this->renderSection('content'); ?>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo site_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo site_url('assets/'); ?>js/sb-admin-2.min.js"></script>

    <?php echo $this->renderSection('scripts'); ?>

</body>

</html>