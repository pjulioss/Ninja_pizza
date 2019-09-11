<?php 

  include('./config/db_connect.php');

  //htmlspecialchars() previne executar scripts no envio de dados pelo form
  //lidando com erros
  $email = $nome = $ingredientes = '';

  $erros = ['email'=>'', 'nome'=> '', 'ingredientes'=> ''];

  if(isset($_POST['submit'])){
    
    if(empty($_POST['email'])){
      $erros['email'] = 'Necessário um email!';
    } else {
      $email = $_POST['email'];
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        
        $erros['email'] = 'Email inválido!';
      }
    }
    if(empty($_POST['nome'])){
      $erros['nome'] = 'Expecifique o nome da pizza!';
    } else {
      $nome = $_POST['nome'];
      if(!preg_match('/^[a-zA-Z\s]+$/', $nome)){
        
        $erros['nome'] = 'Apenas letras e espaços no nome!';
      }
    }
    if(empty($_POST['ingredientes'])){
      $erros['ingredientes'] = 'Ao menos um ingrediente é necessário!';
    } else {
      $ingredientes = $_POST['ingredientes'];
      if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredientes)){
        
        $erros['ingredientes'] = 'Use , (virgulas) para separar os ingredientes!';
      }
    }

    if(array_filter($erros)){
      //echo "Existem erros no formulário!";
    } else {
      //prevenindo injeção de dados maliciosos na tabela do banco
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $nome = mysqli_real_escape_string($conn, $_POST['nome']);
      $ingredientes = mysqli_real_escape_string($conn, $_POST['ingredientes']);

      //criando sql
      $sql = "INSERT INTO pizzas(email, nome, ingredientes) VALUES('$email', '$nome', '$ingredientes')";

      //salvar no db
      if(mysqli_query($conn, $sql)){
        //sucesso
        header('Location: index.php');
      } else {
        echo 'Erro na query: '. mysqli_error($conn);
      }
    }
  }

; ?>


<!DOCTYPE html>
<html lang="pt-BR">

  <?php include('./templates/header.php');?> <!--por usarmos o include de um arquivo que contém nosso css, podemos usar os elementos do css normalmente aqui-->

    <section class="container grey-text">
      <h4 class="center">Adicionar Pizza</h4>

      <form action="add.php" method="POST" class="white">
        <label for="">Seu email:</label>
        <div class="red-text"><?= $erros['email']?></div><!--exibindo a msg de erro no formulario-->
        <input type="text" name="email" value="<?= htmlspecialchars($email)?>"><!--permanecendo com o dado digitado caso esteja correto-->

        <label for="">Nome da pizza:</label>
        <div class="red-text"><?= $erros['nome']?></div><!--exibindo a msg de erro no formulario-->
        <input type="text" name="nome" value="<?= htmlspecialchars($nome)?>"><!--permanecendo com o dado digitado caso esteja correto-->

        <label for="">Ingredientes:</label>
        <div class="red-text"><?= $erros['ingredientes']?></div><!--exibindo a msg de erro no formulario-->
        <input type="text" name="ingredientes" value="<?= htmlspecialchars($ingredientes)?>"><!--permanecendo com o dado digitado caso esteja correto-->

        <div class="center">
          <input type="submit" name="submit" value="Salvar" class="btn brown lighten-1 z-depth-0">
        </div>
      </form>

    </section>

  <?php include('./templates/footer.php');?>


</html>