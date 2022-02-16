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
            <h1 class="h3 text-gray-800"><?php echo $title ?? ''; ?></h1>
        </div>
        <div class="card-body">

            <?php if (empty($vacancies)) : ?>


                <div class="alert alert-info">Não há dados para exibir</div>


            <?php else : ?>

                <table class="table table-striped">

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <form action="<?php echo route_to('vacancies.order?order'); ?>" method="GET">

                                <select name="order" class="form-control form-control-sm" onchange="this.form.submit();">
                                    <option value="">Ordernar por...</option>
                                    <option value="id">ID</option>
                                    <option value="title">Título</option>
                                    <option value="type">Tipo</option>
                                    <option value="description">Descrição</option>
                                    <option value="is_paused">Situação</option>
                                </select>

                            </form>

                        </div>
                    </div>

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

                <?php echo $pager->links() ?>


            <?php endif; ?>


        </div>
    </div>



</div>
<!-- /.container-fluid -->


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>