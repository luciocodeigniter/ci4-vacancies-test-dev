<script>
    /**
     * Inspirado em: https://www.phpzag.com/delete-multiple-rows-with-checkbox-using-jquery-php-mysql/
     */


    $(document).on('click', '#select_all', function() {

        // Quando clicar no checkbox 'select_all',
        // seleciono todos os da view
        $(".checkbox_delete").prop("checked", this.checked);
    });


    $(document).on('click', '.checkbox_delete', function() {

        if ($('.checkbox_delete:checked').length == $('.checkbox_delete').length) {
            $('#select_all').prop('checked', true);
        } else {
            $('#select_all').prop('checked', false);
        }
    });

    // Exclui os registros selecionados
    $('.btn-delete-all').on('click', function(e) {

        // Receberá os ID's a serem excluidos
        var dataIds = [];

        // Percorro todos os checkbox que estão checados com a classe 'checkbox_delete',
        $(".checkbox_delete:checked").each(function() {

            // Faço o push de cada checkbox selecionado,
            // recuperando data-id
            dataIds.push($(this).data('id'));
        });

        // Temos algum que foi selecionado?
        if (dataIds.length <= 0) {

            alert('Escolha pelo menos um registro para excluir.');

            return;

        }

        // Quer mesmo excluir?
        var checked = confirm('Tem certeza da exclusão?');

        if (checked == true) {

            // Constantes definidas na view que fez o include desse arquivo
            console.log(ROUTE_TO_DELETE);
            console.log(ROUTE_TO_REDIRECT);


            $.ajax({
                type: "POST",
                url: ROUTE_TO_DELETE,
                data: {
                    id: dataIds, // ID's selecionados
                    csrf_test_name: $('[name=csrf_test_name]').val(), // CSRF Token do formulário 
                    _method: 'DELETE' // Spoofing... Não esquecer de criar a rota
                },
                success: function(response) {

                    // Redireciono para a mesma vies
                    window.location.href = ROUTE_TO_REDIRECT;
                }
            });

        }
    });
</script>