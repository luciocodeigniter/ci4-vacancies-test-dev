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

<div class="form-check">
    <input class="form-check-input" type="radio" name="is_paused" id="exampleRadios1" value="0" <?php if (!$vacancy->is_paused) : ?> checked <?php endif; ?> <?php echo set_checkbox('is_paused', '0', $vacancy->is_paused ?? false); ?>>
    <label class="form-check-label" for="exampleRadios1">
        Vaga liberada para candidaturas
    </label>
</div>
<div class="form-check mb-4">
    <input class="form-check-input" type="radio" name="is_paused" id="exampleRadios2" value="1" <?php if ($vacancy->is_paused) : ?> checked <?php endif; ?> <?php echo set_checkbox('is_paused', '1', $vacancy->is_paused ?? false); ?>>
    <label class="form-check-label" for="exampleRadios2">
        Vaga pausada para candidaturas
    </label>
</div>


<?php echo form_submit('', 'Salvar', ['class' => 'btn btn-success']) ?>

<?php if (is_null($vacancy->id)) : ?>

    <?php echo anchor(route_to('vacancies'), 'Voltar', ['class' => 'btn btn-secondary']); ?>

<?php else : ?>

    <?php echo anchor(route_to('vacancies.show', $vacancy->id), 'Voltar', ['class' => 'btn btn-secondary']); ?>

<?php endif; ?>