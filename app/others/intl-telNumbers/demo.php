<?php
  // require("../includes/config.php");
  // require_once("core/frontEnd-wrapper.php");
  $domain = "http://localhost/ns";
  //
  if(isset($_POST['phone'])){

    echo "<pre>";
    print_r($_POST);

    echo $_POST['phone'].'<br>';
    echo $_POST['dialCode'].'<br>';

    echo $_POST['phonefull'].'<br>';

    $phone = str_replace($_POST['dialCode'], '', $_POST['phone']);

    echo 'Just Num: '.$phone.'<br>';
    echo 'Full Num: '.$_POST['dialCode'].$phone.'<br>';
    echo 'Int Num: '.preg_replace('#[^0-9.]#', '', $_POST['dialCode'].$phone).'<br>';

    exit();

  }


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>International Telephone Input</title>
</head>

<body>
  <h1>International Telephone Input</h1>
  <form action="" method="post">
    <input name="phone" id="phone" type="tel">
    <input type="" name="phonefull" id="phonefull" />
    <input type="" name="dialCode" id="dialCode" />
    <button type="submit">Submit</button>
  </form>

<?php include("custom.php");?>
</body>

</html>
