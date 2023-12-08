<?php
   $filepath = realpath(dirname(__FILE__)); 
   include_once $filepath.'/../class/School.php';
?>
<?php
  //error_reporting(0);
  $school = new School();
  $dt = $_GET['dt'];
 
  //$cur_date = date('Y-m-d');

  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   $attend = $_POST['attend'];
   $updateAtten = $school->updateAttendence($dt, $attend);
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

<body class="bg-">

    <div class="container" style="margin-top: 20px;">
      <div class="col-sm-0"></div>
      <div class="col-sm-12">
        
  <?php
    if (isset($updateAtten)) {
      echo $updateAtten;
    }

    ?> 
    <div class="alert alert-danger alert-dismissible" style="display: none;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Error !</strong> Student Roll Missing !
            </div>
    <div class="panel panel-primary">
      <div class="panel-heading" style="text-align: center"><h1>Student Attendece System</h1></div>
     
      
      <div class="panel-body">
        <div class="col-sm-0"></div>
        <div class="col-sm-12">
          <div class="well text-center" style="color: red; font-size: 20px">
            <strong>Date :</strong><?php $cur_date = date('d-m-Y');echo $dt; ?>
            <a class="btn btn-success pull-left" href="add_student.php" style="margin-top: px;">Add Student</a>
            <a class="btn btn-info pull-right" href="add_attendence.php" style="margin-top: px">Take Attendence</a>
          </div>
         <form action="" method="POST">
          <div class="form-group">
            <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
            <thead>
                <tr align="center">
                    <th width="25%">Serial</th>
                    <th width="25%">Student name</th>
                    <th width="25%">Roll</th>
                    <th width="25%">Attendence</th>
                 </tr>
            </thead>
           <tbody>
              <?php
                  //$school = new School();
                  $getStu = $school->getAllData($dt);
                  if ($getStu) {
                    $i = 0;
                     foreach ( $getStu as $row){
                    $i++;
                      
                 ?>

              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['roll']; ?></td>
                <td>
                  <input type="radio" name="attend[<?php echo $row['roll']; ?>]" value="present" <?php if($row['attend'] == "present"){echo "checked";} ?>>P
                  <input type="radio" name="attend[<?php echo $row['roll']; ?>]" value="absent" <?php if($row['attend'] == "absent"){echo "checked";} ?>>A
                </td>
                <?php } }?>
              </tr>
              
                <td colspan="4">
                  <input type="submit" class="btn btn-primary" name="update" value="Update">
                </td>
                  </tbody>
                </table>
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
    <script src="../panels/js/jquery.min.js"></script>
    <script  type="text/javascript">
    $(document).ready(function(){
      $("form").submit(function(){
        var roll = true;
        $(':radio').each(function(){
          name = $(this).attr('name');
          if (roll && !$(':radio[name="'+ name +'"]:checked').length) {
            //alert(name + "Roll Missing !");
            $('.alert').show();
            roll = false;
          }
        });
        return roll;
      });
    });

</script>
    
</body>
</html>