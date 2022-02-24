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
