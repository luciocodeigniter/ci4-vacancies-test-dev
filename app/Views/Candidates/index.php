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


    <div class="card shadow mb-4">
        <div class="card-header">

            <?php echo anchor(route_to('candidates.new'), '+ Novo candidato', ['class' => 'btn btn-success float-right']); ?>

            <h1 class="h3 text-gray-800"><?php echo $title ?? ''; ?></h1>
        </div>
        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-4">

                    <?php echo form_button(['class' => 'btn-delete-all btn btn-danger btn-sm'], 'Excluir selecionados'); ?>

                </div>

            </div>

            <?php if (empty($candidates)) : ?>


                <div class="alert alert-info">Não há dados para exibir</div>


            <?php else : ?>


                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th scope="col">
                                <?php echo render_checkbox_for_delete(); ?>
                            </th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Situação</th>
                            <th scope="col">Data cadastro</th>
                            <th scope="col">Ver</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($candidates as $candidate) : ?>

                            <tr>
                                <th scope="row">
                                    <?php echo render_checkbox_for_delete($candidate->id); ?>
                                </th>
                                <td><?php echo $candidate->name; ?></td>
                                <td><?php echo $candidate->email; ?></td>
                                <td><?php echo $candidate->active(); ?></td>
                                <td><?php echo $candidate->created_at->humanize(); ?></td>
                                <td>
                                    <?php echo anchor(route_to('candidates.show', $candidate->id), '<i class="fas fa-eye"></i>', 'btn btn-primary'); ?>
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

<script>
    const ROUTE_TO_DELETE = '<?php echo route_to('candidates.delete.all'); ?>';
    const ROUTE_TO_REDIRECT = '<?php echo route_to('candidates'); ?>';
</script>

<?php echo $this->include('Shared/_delete_all'); ?>


<?= $this->endSection() ?>