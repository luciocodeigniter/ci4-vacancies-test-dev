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


        <?php if (empty($jobs)) : ?>

            <div class="col-md-12">


                <div class="card mb-4 py-3 border-left-primary">
                    <div class="card-body">
                        <div class="alert alert-info">Você não possui candidaturas no momento</div>

                        <?php echo anchor(route_to('jobs'), 'Ver vagas disponíveis', ['class' => 'btn btn-primary btn-sm']) ?>
                    </div>
                </div>

            </div>


        <?php else : ?>


            <?php foreach ($jobs as $job) : ?>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $job->type == 'pj' ? 'Contrato - Pessoa Jurídica' : ($job->type == 'clt' ? 'CLT - Pessoa Física' : 'Contrato - Freelancer'); ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $job->title; ?></div>
                                    <p class="card-text">
                                        <?php echo $job->description; ?>
                                    </p>
                                    <p class="card-text">
                                        Data candidatura: <?php echo $job->applied_at; ?>
                                    </p>
                                    <hr>
                                    <?php echo render_form_to_apply_givup($job); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>


        <?php endif; ?>

    </div>


</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>