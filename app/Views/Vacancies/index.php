<?php echo $this->extend('Template/main'); ?>



<?php echo $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection() ?>


<?php echo $this->section('styles') ?>

<link href="<?php echo site_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


<?= $this->endSection() ?>


<?php echo $this->section('content') ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <div class="card shadow mb-4">
        <div class="card-header">

            <?php echo anchor(route_to('vacancies.new'), '+ Nova vaga', ['class' => 'btn btn-success float-right']); ?>

            <h1 class="h3 text-gray-800"><?php echo $title ?? ''; ?></h1>
        </div>
        <div class="card-body">

            <?php if (empty($vacancies)) : ?>


                <div class="alert alert-info">Não há dados para exibir</div>


            <?php else : ?>

                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th scope="col">#
                            </th>
                            <th scope="col">Título</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Ver</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($vacancies as $vacancy) : ?>

                            <tr>
                                <th scope="row"><?php echo $vacancy->id; ?></th>
                                <td><?php echo $vacancy->title; ?></td>
                                <td><?php echo $vacancy->type(); ?></td>
                                <td><?php echo $vacancy->description; ?></td>
                                <td><?php echo $vacancy->isPaused(); ?></td>
                                <td>
                                    <?php echo anchor(route_to('vacancies.show', $vacancy->id), '<i class="fas fa-eye"></i>', 'btn btn-primary'); ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>

            <?php endif; ?>


        </div>
    </div>



</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>

<!-- Page level plugins -->
<script src="<?php echo site_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?php echo site_url('assets/'); ?>js/demo/datatables-demo.js"></script>

<?= $this->endSection() ?>