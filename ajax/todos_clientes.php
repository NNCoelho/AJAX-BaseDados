<?php

    // Ligacao a Base de Dados
    include 'gestor.php';

    $gestor = new Gestor();

    $clientes = $gestor->EXE_QUERY('SELECT id_cliente, nome FROM clientes ORDER BY nome ASC');

    echo json_encode($clientes, 128);
    
?>