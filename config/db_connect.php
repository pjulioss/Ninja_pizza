<?php 

  //Conectando com o banco de dados(usando MySQL)

  //usamos a function mysql_connect(host name, usuario, senha, nome do banco)
  $conn = mysqli_connect('localhost', 'pjulioss', 'teste12345', 'ninja_pizza');

  //checando conexão
  if(!$conn){
    echo 'Erro: ' . mysqli_connect_error();
  }


; ?>
