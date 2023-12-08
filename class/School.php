<?php
    
   include_once'Database.php';
?>


<?php
class School{
  
  private $db;

  public function __construct(){
  	$this->db = new Database();
  }


 public function getStudentData(){
  	$query = "SELECT *FROM student";
  	$result = $this->db->select($query);
  	return $result; 
  }


 public function insertStudent($name, $roll){
  $name = mysqli_real_escape_string($this->db->link, $name);
  $roll = mysqli_real_escape_string($this->db->link, $roll);
  if (empty($name) || empty($roll)) {
          
          $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Error !</strong> Field must not be Empty !
            </div>';
    
          return $msg; 
      }else{

        $query = "INSERT INTO student(name,roll) VALUES('$name','$roll')";
        $result = $this->db->insert($query);
        

        $query = "INSERT INTO attendence(roll) VALUES('$roll')";
        $result = $this->db->insert($query);
        

        if ($result) {

            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Success !</strong>  Data Inserte Successfully.
            </div>';
  
       return $msg;
     
       
   }else{

            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Error !</strong>  Sorry, Data Not Inserted.
            </div>';
  
       return $msg; 
       } 
      }
  
  }

  public function insertAttendence($cur_date, $attend = array()){

          $query = "SELECT DISTINCT att_time FROM attendence";
          $getdata = $this->db->select($query);
          while($row = $getdata->fetch_assoc()){
            $db_date = $row['att_time'];
            $result = ($cur_date == $db_date);
            if ($result) {
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error !</strong>  Attendence already taken today.
                </div>';
    
               return $msg; 
            
          }
  
     }
   foreach ($attend as $atn_key => $atn_value) {
        
         if ($atn_value == "present") {
             
             $query ="INSERT INTO attendence(roll, attend, att_time)VALUES('$atn_key','present',now())";
               $result = $this->db->insert($query);
         
         }elseif($atn_value == "absent") {
             
             $query ="INSERT INTO attendence(roll, attend, att_time)VALUES('$atn_key','absent',now())";
               $result = $this->db->insert($query);

         
       }

      }

        if ($result) {

            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Success !</strong> Attendence data Inserte Successfully.
            </div>';
  
       return $msg;
     
       
   }else{

            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Error !</strong> Attendence data Not Inserted.
            </div>';
  
       return $msg; 
       } 
      }

   public function getDateList(){
            
            $query = "SELECT DISTINCT att_time FROM attendence";
            $result = $this->db->select($query);
            return $result;

      }

   public function getAllData($dt){

            $query = "SELECT student.name, attendence.*FROM student INNER JOIN attendence ON student.roll = attendence.roll WHERE att_time = '$dt'";
              $result = $this->db->select($query);
              return $result;
      }

      public function updateAttendence($dt, $attend){

         foreach ($attend as $atn_key => $atn_value) {
              if ($atn_value == "present") {
             $query = "UPDATE attendence SET attend = 'present' WHERE roll = '".$atn_key."' AND att_time = '".$dt."'";
              $result = $this->db->update($query);
             
         
         }elseif($atn_value == "absent") {
             
             $query = "UPDATE attendence SET attend = 'absent' WHERE roll = '".$atn_key."' AND att_time = '".$dt."'";
              $result = $this->db->update($query);

         
       }

      }

        if ($result) {

            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Success !</strong> Attendence Update Successfully.
            </div>';
  
       return $msg;
     
       
   }else{

            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <strong>Error !</strong> Attendence Not Updated.
            </div>';
  
       return $msg; 
       } 

      }

 }

	?>