<div class="form-group">
    <label for="title">Nome do candidato</label>
    <input type="text" name="name" value="<?php echo old('name', $candidate->name); ?>" class="form-control" id="name" aria-describedby="titleHelp" placeholder="Escreva o nome">
</div>


<div class="form-group">
    <label for="title">Email do candidato</label>
    <input type="email" name="email" value="<?php echo old('email', $candidate->email); ?>" class="form-control" id="email" aria-describedby="titleHelp" placeholder="Escreva o email">
</div>


<div class="form-group">
    <label for="password">Senha do candidato <?php if (!is_null($candidate->id)) : ?> <small>(Deixe em branco se não quer alterá-la)</small> <?php endif; ?></label>
    <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
</div>

<div class="form-group">
    <label for="password_confirmation">Confirmação de senha <?php if (!is_null($candidate->id)) : ?> <small>(Deixe em branco se não quer alterá-la)</small> <?php endif; ?></label>
    <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleInputpassword_confirmation" placeholder="Confirme Password">
</div>

<div class="custom-control custom-checkbox my-1 mr-sm-2 mb-4">

    <input type="hidden" name="is_active" value="0">

    <input type="checkbox" name="is_active" value="1" <?php echo set_checkbox('is_active', '1', $candidate->is_active); ?> class="custom-control-input" id="is_active">

    <label class="custom-control-label" for="is_active">Acesso liberado</label>
</div>


<?php echo form_submit('', 'Salvar', ['class' => 'btn btn-success']) ?>

<?php if (is_null($candidate->id)) : ?>

    <?php echo anchor(route_to('vacancies'), 'Voltar', ['class' => 'btn btn-secondary']); ?>

<?php else : ?>

    <?php echo anchor(route_to('vacancies.show', $candidate->id), 'Voltar', ['class' => 'btn btn-secondary']); ?>

<?php endif; ?>