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


    <div class="card shadow mb-4">
        <div class="card-header">

            <?php echo anchor(route_to('candidates.new'), '+ Novo candidato', ['class' => 'btn btn-success float-right']); ?>

            <h1 class="h3 text-gray-800"><?php echo $title ?? ''; ?></h1>
        </div>
        <div class="card-body">

            <?php if (empty($candidates)) : ?>


                <div class="alert alert-info">Não há dados para exibir</div>


            <?php else : ?>

                <table class="table table-striped">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <form action="<?php echo route_to('candidates.order?order'); ?>" method="GET">

                                <select name="order" class="form-control form-control-sm" onchange="this.form.submit();">
                                    <option value="">Ordernar por...</option>
                                    <option value="id">ID</option>
                                    <option value="name">Nome</option>
                                    <option value="email">E-mail</option>
                                </select>

                            </form>

                        </div>
                    </div>

                    <thead>
                        <tr>
                            <th scope="col">#
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
                                <th scope="row"><?php echo $candidate->id; ?></th>
                                <td><?php echo $candidate->name; ?></td>
                                <td><?php echo $candidate->email; ?></td>
                                <td><?php echo $candidate->active(); ?></td>
                                <td><?php echo $candidate->created_at->humanize(); ?></td>
                                <td>
                                    <?php echo anchor(route_to('candidate.show', $candidate->id), '<i class="fas fa-eye"></i>', 'btn btn-primary'); ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>

                <?php echo $pager->links() ?>


            <?php endif; ?>


        </div>
    </div>



</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>