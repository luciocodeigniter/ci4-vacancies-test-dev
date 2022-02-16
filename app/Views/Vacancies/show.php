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

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h1 class="h3 text-gray-800"><?php echo $title ?? ''; ?></h1>
                </div>
                <div class="card-body">

                    <p class="card-text">Título: <?php echo $vacancy->title; ?></p>
                    <p class="card-text">Criada há: <?php echo $vacancy->created_at->humanize(); ?></p>
                    <p class="card-text">Atualizada há: <?php echo $vacancy->created_at->humanize(); ?></p>
                    <p class="card-text">Tipo da vaga: <?php echo $vacancy->type(); ?></p>
                    <p class="card-text">Situação da vaga: <?php echo $vacancy->isPaused(); ?></p>
                    <p class="card-text">Descrição: <?php echo $vacancy->description; ?></p>


                    <a href="<?php echo route_to('vacancies.edit', $vacancy->id) ?>" class="card-link btn btn-primary">Editar vaga</a>

                    <?php echo form_open(route_to('vacancies.delete', $vacancy->id), ['onClick' => "return confirm('Tem certeza da exclusão?');", 'class' => 'd-inline-block']); ?>

                    <?php echo form_hidden('_method', 'DELETE'); ?>

                    <button type="submit" class="btn btn-danger">Excluir</button>

                    <?php echo form_close(); ?>

                    <a href="<?php echo route_to('vacancies') ?>" class="card-link btn btn-secondary">Voltar</a>

                </div>
            </div>
        </div>


    </div>



</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>