<?php echo $this->extend('Template/main'); ?>



<?php echo $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection() ?>


<?php echo $this->section('styles') ?>


<?= $this->endSection() ?>


<?php echo $this->section('content') ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <div class="row">

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h1 class="h3 text-gray-800"><?php echo $title ?? ''; ?></h1>
                </div>
                <div class="card-body">

                    <?php echo form_open(route_to('vacancies.update', $vacancy->id)); ?>

                    <?php echo form_hidden('_method', 'PUT'); ?>

                    <?php echo $this->include('Vacancies/_form'); ?>

                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>


    </div>



</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>