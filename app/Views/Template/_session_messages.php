<div class="container-fluid">
    <?php if ($mensagem = session()->has('success')) : ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo session('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <?php endif; ?>

    <?php if (session()->has('info')) : ?>

        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo session('info'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <?php endif; ?>

    <?php if (session()->has('danger')) : ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo session('danger'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <?php endif; ?>

    <!-- Usaremos em alguns POST's sem ajax -->
    <?php if (session()->has('errors_model')) : ?>

        <ul>
            <?php foreach (session('errors_model') as $error) : ?>

                <li class="text-danger"><?php echo $error; ?></li>

            <?php endforeach; ?>
        </ul>

    <?php endif; ?>


    <!-- Para os erros do csrf 'Not allowed' -->
    <?php if (session()->has('error')) : ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro!</strong> <?php echo session('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

    <?php endif; ?>
</div>