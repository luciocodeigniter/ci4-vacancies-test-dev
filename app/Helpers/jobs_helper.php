<?php

use App\Entities\Vacancy;

if (!function_exists('render_form_to_apply_givup')) {

    /**
     * Display a form to candidate for apply or givup
     *
     * @param Vacancy $job
     * @return string
     */
    function render_form_to_apply_givup(Vacancy $job)
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
            'onClick'   => "return confirm('Tem certeza que deseja desistar dessa vaga?');",
        ];

        // Confirmation will be displayed only only if it's quitting
        if ($user->id != $job->user_id) {

            unset($formAttr['onClick']);
        }

        return form_open($routeTo, $formAttr, $hiddens) . form_submit($buttomAttr) . form_close();
    }
}
