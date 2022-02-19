<?php echo $this->extend('Template/auth'); ?>



<?php echo $this->section('title') ?>

<?php echo $title ?? ''; ?>

<?= $this->endSection() ?>


<?php echo $this->section('styles') ?>


<?= $this->endSection() ?>


<?php echo $this->section('content') ?>



<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"><?php echo $title ?? 'Welcome'; ?></h1>
            </div>

            <?php echo form_open(route_to('password.recovery'), ['class' => 'user']); ?>


            <div class="form-group">
                <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
            </div>


            <?php echo form_submit('', 'Iniciar Recuperação', ['class' => 'btn btn-danger btn-user btn-block']) ?>

            <hr>
            <?php echo form_close(); ?>

            <div class="text-center">
                <a class="small" href="<?php echo route_to('login'); ?>">Lembrei minha senha</a>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>