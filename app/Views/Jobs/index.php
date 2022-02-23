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
                        <div class="alert alert-info">Não há vagas disponíveis no momento</div>
                    </div>
                </div>

            </div>



        <?php else : ?>


            <?php foreach ($jobs as $job) : ?>

                <div class="col-lg-3">

                    <div class="card mb-4 py-3 border-left-primary">
                        <div class="card-body">

                            <h4><?php echo $job->title; ?></h4>

                            <h5><?php echo $job->type(); ?></h5>

                            <p class="card-text">
                                <?php echo $job->description; ?>
                            </p>

                            <p class="card-text">
                                Publicada há: <?php echo $job->created_at->humanize(); ?>
                            </p>

                        </div>

                        <div class="card-footer bg-white">

                            <?php echo render_form_to_apply_givup($job); ?>

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