<div class="form-group">
    <label for="title">Título da vaga</label>
    <input type="text" name="title" value="<?php echo old('title', $vacancy->title); ?>" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Escreva o título">
</div>


<div class="form-group">

    <label for="type">Título da vaga</label>
    <select name="type" class="form-control">

        <option value="">Escolha...</option>
        <option value="fr" <?php echo ($vacancy->type === 'fr' ? 'selected' : ''); ?>>Freelancer</option>
        <option value="pf" <?php echo ($vacancy->type === 'pf' ? 'selected' : ''); ?>>Pessoa Física</option>
        <option value="pj" <?php echo ($vacancy->type === 'pj' ? 'selected' : ''); ?>>Pessoa Jurídica</option>

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


<button type="submit" class="btn btn-primary">Salvar</button>

<?php if (is_null($vacancy->id)) : ?>

    <a href="<?php echo route_to('vacancies'); ?>" class="btn btn-secondary">Voltar</a>

<?php else : ?>

    <a href="<?php echo route_to('vacancies.show', $vacancy->id); ?>" class="btn btn-secondary">Voltar</a>

<?php endif; ?>