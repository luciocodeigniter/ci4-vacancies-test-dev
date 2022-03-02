<?php echo $this->extend('Template/main'); ?>



<?php echo $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection() ?>


<?php echo $this->section('styles') ?>


<?= $this->endSection() ?>


<?php echo $this->section('content') ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">


        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo route_to('vacancies'); ?>">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Vagas cadastradas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalVacancies; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-briefcase fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo route_to('vacancies'); ?>">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Vagas pausadas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPausedVacancies; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-briefcase fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>




        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo route_to('candidates'); ?>">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Candidados cadastrados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCandidates; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-xl-3 col-md-6 mb-4">
            <a href="<?php echo route_to('candidates') ?>">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Contas bloqueadas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalLockedCandidates; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-alt-slash fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


    </div>

</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>