<?php 
  include('./config/db_connect.php');

  //escrever a query para todas as pizzas
  $sql = 'SELECT nome, ingredientes, id FROM pizzas ORDER BY created_at';

  //fazer a query e pegar os resultados
  $result = mysqli_query($conn, $sql);

  //buscar os resultados como um array
  $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

  //liberar o resultado da memoria
  mysqli_free_result($result);

  //fechar a conexão
  mysqli_close($conn);

  //print_r($pizzas);

; ?>

<!DOCTYPE html>
<html lang="pt-BR">


<?php include('./templates/header.php'); #reaproveitando o cabeçalho ?>

<h4 class='center red-text text-accent-4'>Pizzas
  <i class="small material-icons red-text text-accent-4">local_pizza</i>
  <br>
</h4>
<div class="container">
  <div class="row">
    <?php foreach($pizzas as $pizza): ?>
      <div class="col s6 md3">
        <div class="card z-depth-0">
          <img src="img/pizza.svg" alt="pizza-logo" class="pizza">
          <div class="card-content center">
            <span class='card-title brown lighten-5'> <?= htmlspecialchars($pizza['nome']);?> </span>
            <ul>
              <?php foreach(explode(',', $pizza['ingredientes']) as $ing): ?>
                <li><?= htmlspecialchars(ucwords($ing)) ?></li>
              <?php endforeach; ?>
              
            </ul>
          </div>
          <div class="card-action right-align">
            <a href="details.php?id=<?= $pizza['id'];?>" class="brand-text">Saiba mais</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    
  </div>
</div>

<?php include('./templates/footer.php');#a ordem é importante na hora do include ?>



  



</html>