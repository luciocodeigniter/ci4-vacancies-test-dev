<?php echo $this->extend('Template/auth'); ?>



<?php echo $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection() ?>


<?php echo $this->section('styles') ?>


<?= $this->endSection() ?>


<?php echo $this->section('content') ?>



<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">
                    Se você não recebeu o link de ativação, por favor clique no botão abaixo que enviaremos outro pra você.
                </h1>
            </div>

            <?php echo form_open(route_to('verify.resend'), ['class' => 'user']); ?>

            <?php echo form_hidden('_method', 'PUT'); ?>

            <?php echo form_submit('', 'Reenviar link de ativação', ['class' => 'btn btn-success btn-user btn-block']) ?>

            <?php echo form_close(); ?>

            <hr>

            <?php echo form_open(route_to('login.destroy')); ?>

            <?php echo form_submit('', 'Encerrar sessão', ['class' => 'btn btn-link btn-user btn-block']) ?>

            <?php echo form_close(); ?>

        </div>
    </div>
</div>


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>