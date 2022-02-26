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
    <div class="row justify-content-center pb-3">

        <?php if (empty($jobs)) : ?>

            <div class="col-md-12">


                <div class="card mb-4 py-3 border-left-primary">
                    <div class="card-body">
                        <div class="alert alert-info">Não há vagas disponíveis no momento</div>
                    </div>
                </div>

            </div>


        <?php else : ?>


            <?php foreach ($jobs as $job) : ?>


                <div class="col-md-3 shadow bg-white p-5 mb-2 m-1">

                    <div class="mb-2">
                        <?php echo render_form_to_apply_givup($job); ?>
                    </div>

                    <h4><?php echo $job->title; ?></h4>
                    <p>
                        <?php echo $job->type(); ?>
                    </p>
                    <p>
                        <?php echo $job->description; ?>
                    </p>
                    <p>
                        Publicada há: <?php echo $job->created_at->humanize(); ?>
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