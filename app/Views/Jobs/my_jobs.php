<?php echo $this->extend('Template/main'); ?>



<?php echo $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection() ?>


<?php echo $this->section('styles') ?>


<?= $this->endSection() ?>


<?php echo $this->section('content') ?>




<!-- Begin Page Content -->
<div class="container-fluid">


    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3"><?php echo $title; ?></h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        </div>
    </div>

    <!-- Example row of columns -->
    <div class="row justify-content-center">

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


                <div class="col-md-3 shadow p-5 mb-2 m-1">
                    <h2><?php echo $job->title; ?></h2>
                    <p>
                        <?php echo $job->type == 'pj' ? 'Contrato - Pessoa Jurídica' : ($job->type == 'clt' ? 'CLT - Pessoa Física' : 'Contrato - Freelancer'); ?>
                    </p>
                    <p>
                        <?php echo $job->description; ?>
                    </p>

                    <p>
                        <?php echo render_form_to_apply_givup($job); ?>
                    </p>
                </div>

            <?php endforeach; ?>


        <?php endif; ?>

    </div>

</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>