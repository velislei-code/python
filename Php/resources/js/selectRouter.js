$(document).ready(function() {
    // Inicializa os Select2
    $('#select1, #select2').select2();

    // Dados das subcategorias (pode vir de uma API no mundo real)
    const subcategorias = {
        eletronicos: ["Smartphone", "Notebook", "TV"],
        roupas: ["Camiseta", "Calça", "Vestido"],
        livros: ["Ficção", "Técnico", "Biografia"]
    };

    // Quando o select1 muda, atualiza o select2
    $('#select1').on('change', function() {
        const categoriaSelecionada = $(this).val();
        const $select2 = $('#select2');

        // Limpa e desabilita o select2 se não houver categoria selecionada
        if (!categoriaSelecionada) {
            $select2.empty().append('<option value="">Selecione primeiro uma categoria</option>').prop('disabled', true);
            return;
        }

        // Habilita o select2 e preenche com as subcategorias correspondentes
        $select2.empty().append('<option value="">Selecione uma subcategoria...</option>').prop('disabled', false);
        
        subcategorias[categoriaSelecionada].forEach(function(subcategoria) {
            $select2.append(`<option value="${subcategoria.toLowerCase()}">${subcategoria}</option>`);
        });

        // Re-inicializa o Select2 para atualizar as opções
        $select2.trigger('change.select2');
    });
});