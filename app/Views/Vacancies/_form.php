<div class="form-group">
    <label for="title">Título da vaga</label>
    <input type="text" name="title" value="<?php echo old('title', $vacancy->title); ?>" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Escreva o título">
</div>


<div class="form-group">

    <label for="type">Título da vaga</label>
    <select name="type" class="form-control">

        <option value="">Escolha...</option>
        <option value="fr" <?php echo ($vacancy->type === 'fr' ? 'selected' : ''); ?>>Contrato - Freelancer</option>
        <option value="clt" <?php echo ($vacancy->type === 'clt' ? 'selected' : ''); ?>>CLT - Pessoa Física</option>
        <option value="pj" <?php echo ($vacancy->type === 'pj' ? 'selected' : ''); ?>>Contrato - Pessoa Jurídica</option>

    </select>

</div>


<div class="form-group">
    <label for="description">Descrição da vaga</label>
    <textarea name="description" class="form-control" id="description" rows="3"><?php echo old('description', $vacancy->description); ?></textarea>
</div>

<div class="custom-control custom-checkbox my-1 mr-sm-2 mb-4">

    <input type="hidden" name="is_paused" value="0">

    <input type="checkbox" name="is_paused" value="1" <?php echo set_checkbox('is_paused', '1', $vacancy->is_paused); ?> class="custom-control-input" id="is_paused">

    <label class="custom-control-label" for="is_paused">Vaga pausada para candidatura</label>
</div>


<?php echo form_submit('', 'Salvar', ['class' => 'btn btn-success']) ?>

<?php if (is_null($vacancy->id)) : ?>

    <?php echo anchor(route_to('vacancies'), 'Voltar', ['class' => 'btn btn-secondary']); ?>

<?php else : ?>

    <?php echo anchor(route_to('vacancies.show', $vacancy->id), 'Voltar', ['class' => 'btn btn-secondary']); ?>

<?php endif; ?>