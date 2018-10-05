<div id="content">
    <!-- Заголовок -->
    <h1>Калькулятор школьника</h1>
    <!-- Заголовок -->
    <!-- Область основного контента -->
    <?PHP
    if($_SERVER['REQUEST_METHOD']=="POST"){
     // echo var_dump($_POST);
     // echo var_dump($_SERVER);
      $num1 = abs((int) $_POST['num1']);
      $num2 = abs((int) $_POST['num2']);
      $operator = trim(strip_tags($_POST['operator'])); 
       //echo $num1,$num2;
      
      switch ($operator) {
        case "+":{
      $result = $num1+$num2;
        break;}
        case "-":
      $result = $num1-$num2;
        break;
        case "*":
      $result = $num1*$num2;
        break;
        case "/":{ if($num2==0){
          echo"на ноль делить нельзя";
        }
      $result = $num1/$num2;
        break;}
        default:
      $result = "";
      break; }
      };
      //$cols = ($cols) ? $cols : 10;
      $num1 = ($num1) ? $num1 : "";
      $num2 = ($num2) ? $num2 : "";
      //echo $num1,$num2;
    
     ?>
    
    <form action='<?= $_SERVER['REQUEST_URI']?>' method="POST">
      <label>Число 1:</label>
      <br />
      <input name='num1' type='text' value='<?= $num1 ?>' />
      <br />
      <label>Оператор: </label>
      <br />
      <input name='operator' type='text' value='<?= $operator ?>' />
      <br />
      <label>Число 2: </label>
      <br />
      <input name='num2' type='text' value='<?= $num2 ?>' />
      <br />
      <label>Значение:</label>
      <br />
      <input name='result' type='text' value='<?= $result ?>' />
      <br />
      <br />
      <input type='submit' value='Считать'>
    </form>
   
    <!-- Область основного контента -->
</div>
 