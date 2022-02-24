<?php

if (!function_exists('render_form_to_apply_givup')) {

    /**
     * Display a form to candidate for apply or givup
     *
     * @param Vacancy $job
     * @return string
     */
    function render_form_to_apply_givup(object $job)
    {

        // Get the logged user
        $user = service('auth')->user();

        // Define wich route will be requested on button click
        $routeTo = ($user->id == $job->user_id ? route_to('jobs.givup', $job->id) : route_to('jobs.apply', $job->id));

        // Define wich HTTP verb will be used on the resquest
        $hiddens = [
            '_method' => $user->id == $job->user_id ? 'DELETE' : 'PUT'
        ];

        $buttomAttr = [
            'value'   => ($user->id == $job->user_id ? 'Desistir' : 'Candidatar'),
            'class'     => "btn btn-sm btn-" . ($user->id == $job->user_id ? 'warning' : 'success'),
        ];


        $formAttr = [
            'onClick'   => "return confirm('Tem certeza que deseja desistir dessa vaga?');",
        ];

        // Confirmation will be displayed only only if it's quitting
        if ($user->id != $job->user_id) {

            unset($formAttr['onClick']);
        }

        return form_open($routeTo, $formAttr, $hiddens) . form_submit($buttomAttr) . form_close();
    }
}


if (!function_exists('show_type')) {

    /**
     * Display the type of contract job. Eg.: Contrato - Pessoa Jurídica, CLT - Pessoa Física, etc
     *
     * @param string $type
     * @return void
     */
    function show_type(string $type)
    {
        return match ($type) {
            'pj'        => 'Contrato - Pessoa Jurídica',
            'clt'       => 'CLT - Pessoa Física',
            'fr'        => 'Contrato - Freelancer',
            default     => 'Tipo desconhecido'
        };
    }
}


if (!function_exists('render_checkbox_for_delete')) {

    /**
     * Renderiza um checkbox. 
     * 
     * $idToDelete -> Caso informado, será renderizado um checkbox com atributos para deleção de registros.
     * $classDivCheckbox -> Classe da div que comporta o checkbox
     *
     * @param integer|null $idToDelete Caso informado, será renderizado um checkbox com atributos para deleção de registros
     * @param string $classDivCheckbox Classe da div que comporta o checkbox
     * @param string $classCheckbox
     * @param string $classLabel
     * @return void
     */
    function render_checkbox_for_delete(
        int $idToDelete = null,
        string $classDivCheckbox = 'custom-control custom-checkbox',
        string $classCheckbox = 'custom-control-input',
        string $classLabel = 'custom-control-label'
    ) {

        // Se veio um $idToDelete, então a classe classCheckbox recebe 'check-$idToDelete' + ela mesma
        $classCheckbox = ($idToDelete ? "checkbox_delete $classCheckbox" : $classCheckbox);

        // Se veio um $idToDelete, então o idCheckbox recebe 'check-$idToDelete', caso contrário 'select_all'
        $idCheckbox = ($idToDelete ? "check-$idToDelete" : 'select_all');

        $checkboxAttr = [
            'id'      => $idCheckbox,
            'data-id' => $idToDelete, // usaremos no script
            'class'   => $classCheckbox,
        ];

        // Não veio um $idToDelete?
        // Então removemos o 'data-id'
        if (is_null($idToDelete)) {
            unset($checkboxAttr['data-id']);
        }

        // Criamos o checkbox
        $checkbox = form_checkbox($checkboxAttr);

        $labelAttr = [
            'class' => $classLabel,
        ];

        // Criamos o label
        $label = form_label('', $idCheckbox, $labelAttr);

        // Retornamos a div montada
        return "<div class='{$classDivCheckbox}'>{$checkbox}{$label}</div>";
    }
}
