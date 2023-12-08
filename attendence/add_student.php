<?php
   $filepath = realpath(dirname(__FILE__)); 
   include_once $filepath.'/../class/School.php';
?>

<?php
  $school = new School();
  
   if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $insertStu = $school->insertStudent($name, $roll);
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SMS</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../panels/css/bootstrap.css">
    <link rel="stylesheet" href="../panels/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>



</head>

<body class="bg-dark">

    <div class="container" style="margin-top: 20px;">
      <div class="col-sm-0"></div>
      <div class="col-sm-12">
        
  <?php
    if (isset($insertStu)) {
      echo $insertStu;
    }

    ?> 
    <div class="panel panel-primary">
      <div class="panel-heading" style="text-align: center"><h1>Student Attendece System</h1></div>
     
      
      <div class="panel-body">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <div class="well text-center" style="color: red; font-size: 20px">
            <strong>Date :</strong><?php $cur_date = date('d-m-Y');echo $cur_date; ?>
            <a class="btn btn-success pull-left" href="add_attendence.php" style="margin-top: px;">Add Attendence</a>
            <a class="btn btn-info pull-right" href="date_view.php" style="margin-top: px">Back</a>
          </div>
        <form action="" method="POST">
                <div class="form-group">
                  <label for="name">Student name :</label>
                  <input type="text" class="form-control" id="name" placeholder="Student name" name="name">
                </div>
                <div class="form-group">
                  <label for="roll">Student roll:</label>
                  <input type="text" class="form-control" id="roll" placeholder="Student roll" name="roll">
                </div> 
               <div class="form-group">
               <button type="submit" class="btn btn-primary" name="submit">Submit</button> 
               </div>
             </form>

        </div>
      </div>
    </div>
  </div>
</div>

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../panels/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>


</body>
</html>
