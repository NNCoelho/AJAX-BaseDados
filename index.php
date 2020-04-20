<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX e Base de Dados</title>
    <script src="assets/jquery-3.4.1.min.js"></script>
</head>
<body>

    <h3>Clientes</h3>
    <hr>
    <div id="detalhe_cliente">
        <small>Não existe cliente selecionado.</small>
    </div>
    <hr>
    <div id="lista_clientes"></div>

    <script>

        // ------------------------------------
        $(document).ready(function(){

            // Chamada da função para construção da lista de clientes
            lista_clientes();

        });

        // ------------------------------------
        function lista_clientes(){

            $.ajax({
                type: 'GET',
                url: 'ajax/todos_clientes.php',
                success: function(dados){

                    var clientes = JSON.parse(dados);
                    var html = "<ul>";
                    clientes.forEach(c => {
                        html += "<li onclick=\"detalhe_cliente(" + c['id_cliente']+ ")\">" + c ['nome'] + "</li>";
                    });
                    html += "</ul>";

                    $('#lista_clientes').html(html);
                },
                error: function(){
                    console.log('ERRO!');
                }
            });
        }

        // ------------------------------------
        function detalhe_cliente(id_cliente){
            
            $.ajax({
                type: 'POST',
                url: 'ajax/detalhe_cliente.php',
                data: {id_cliente: id_cliente},
                success: function(dados){

                    var cliente = JSON.parse(dados)[0];
                    var html = "<p>Nome:" + cliente.nome + "</p>";
                    html += "<p>Email:" + cliente.email + "</p>";
                    html += "<p>Telefone:" + cliente.telefone + "</p>";

                    // Injectar dentro do div o detalhe do cliente
                    $('#detalhe_cliente').html(html);

                    // Atualiza a lista de clientes
                    lista_clientes();
                },
                error: function(){
                    console.log('ERRO!');
                }
            });
        }
    
    </script>

</body>
</html>