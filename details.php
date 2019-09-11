<?php 
  include('./config/db_connect.php');

  if(isset($_POST['delete'])){

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

    if(mysqli_query($conn, $sql)){
      //sucesso
      header('Location: index.php');
    } else {
      echo 'Erro na query: '. mysqli_error($conn);
    }

  }

  //checar GET id parametro
  if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //fazendo a slq
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    //pegar o resultado da query
    $result = mysqli_query($conn, $sql);

    //buscar o resultado em um array
    $pizza = mysqli_fetch_assoc($result);

    //liberar os resultados e fechar a conexão
    mysqli_free_result($result);
    mysqli_close($conn);

  }

; ?>

<!DOCTYPE html>
<html>

  <?php include('./templates/header.php');?>

  <div class="container center">
    <?php if($pizza): ?>
      <h4 class='brown-text'><?= htmlspecialchars($pizza['nome']);?></h4>
      <p class='grey-text'>Criado por: <?= htmlspecialchars($pizza['email']);?></p>
      <p class='grey-text'><?= date($pizza['created_at']);?></p>
      <h5 class="grey-text">Ingredientes</h5>
      <p class='grey-text'><?= htmlspecialchars($pizza['ingredientes']);?></p>

      <!-- Deletar pizza -->
      <form action="details.php" method="POST">
        <input type="hidden" name="id_to_delete" value=" <?= $pizza['id']?> ">
        <input type="submit" value="Deletar" name="delete" class="btn brown lighten-2">
      </form>
    <?php else: ?>
      <h5 class='orange-text'>A pizza que você procura está em outro forno!</h5>
    <?php endif; ?>
    
    
    
  
  </div>

  <?php include('./templates/footer.php');?>
</html>