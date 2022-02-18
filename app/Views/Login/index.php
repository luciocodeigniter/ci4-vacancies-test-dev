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
                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
            </div>

            <?php echo form_open(route_to('login.create'), ['class' => 'user']); ?>

            <div class="form-group">
                <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox small">
                    <input type="checkbox" name="remember_me" class="custom-control-input" id="customCheck">
                    <label class="custom-control-label" for="customCheck">Remember
                        Me</label>
                </div>
            </div>

            <?php echo form_submit('', 'Login', ['class' => 'btn btn-primary btn-user btn-block']) ?>

            <hr>
            <?php echo form_close(); ?>
            <div class="text-center">
                <a class="small" href="forgot-password.html">Forgot Password?</a>
            </div>
            <div class="text-center">
                <a class="small" href="register.html">Create an Account!</a>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>


<?php echo $this->section('scripts') ?>



<?= $this->endSection() ?>