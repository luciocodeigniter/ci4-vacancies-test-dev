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

                    <p class="card-text">Nome: <?php echo $candidate->name; ?></p>
                    <p class="card-text">E-mail: <?php echo $candidate->email; ?></p>
                    <p class="card-text">Criado há: <?php echo $candidate->created_at->humanize(); ?></p>
                    <p class="card-text">Atualizado há: <?php echo $candidate->updated_at->humanize(); ?></p>
                    <p class="card-text">Situação: <?php echo $candidate->active(); ?></p>


                    <a href="<?php echo route_to('candidates.edit', $candidate->id) ?>" class="card-link btn btn-primary">Editar candidato</a>

                    <?php echo form_open(route_to('candidates.delete', $candidate->id), ['onClick' => "return confirm('Tem certeza da exclusão?');", 'class' => 'd-inline-block']); ?>

                    <?php echo form_hidden('_method', 'DELETE'); ?>

                    <?php echo form_submit('', 'Excluir', ['class' => 'btn btn-danger']) ?>

                    <?php echo form_close(); ?>

                    <?php echo anchor(route_to('candidates'), 'Voltar', ['class' => 'card-link btn btn-secondary']); ?>

                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h1 class="h3 text-gray-800">Candidaturas</h1>
                </div>
                <div class="card-body">

                    //// candidaturas

                </div>
            </div>
        </div>


    </div>



</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>