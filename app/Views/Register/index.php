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

            <?php echo form_open(route_to('register.create'), ['class' => 'user']); ?>

            <div class="form-group">
                <input type="text" name="name" value="<?php echo old('name'); ?>" class="form-control form-control-user" id="exampleInputName" aria-describedby="emailHelp" placeholder="Enter Name...">
            </div>

            <div class="form-group">
                <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleInputpassword_confirmation" placeholder="Confirme Password">
            </div>


            <?php echo form_submit('', 'Criar conta', ['class' => 'btn btn-primary btn-user btn-block']) ?>

            <hr>
            <?php echo form_close(); ?>

            <div class="text-center">
                <a class="small" href="<?php echo route_to('login'); ?>">Já tenho minha conta</a>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>