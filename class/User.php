 <?php
    include_once('Session.php');
	//error_reporting(0);
?>

<?php
class User{
	private $hostdb = "localhost";
	private $userdb = "root";
	private $passdb = "";
	private $namedb = "sms";
	public $pdo;


    public function __construct(){
    	if (!isset($this->pdo)) {
    		try{
    			$link = new PDO("mysql:host=".$this->hostdb.";dbname=".$this->namedb, $this->userdb, $this->passdb);
    			$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    			$link->exec("SET CHARACTER SET utf8");
    			$this->pdo = $link;
    		}catch(PDOException $e){
    			die("Faild to connect with Database".$e->getMessage());
    		}
    	}

    }

	
    public function userRegistration($data){
		$name = $data['name'];
		$username = $data['username'];
		$email = $data['email'];
		$password = md5($data['password']);
		
		$chk_email = $this->emailCheck($email);

	if ($name == "" OR $username == "" OR $email == "" OR $password == "" ) {
		    	
	    	$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		       return $msg; 
		 
	 } 

	 if (strlen($username ) < 3) {
	 	   
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Username is too short.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;	

	}elseif(preg_match('/[^a-z0-9_-]+/i', $username)) {
			
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
	                    <span class='badge badge-pill badge-success'> Error !</span> Username must only contain alphnumerical, deshes and underscores!
	                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	                        <span aria-hidden='true'>&times;</span>
	                    </button>
	                </div>"; 
	}

	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		 	
			 $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
	                    <span class='badge badge-pill badge-success'> Error !</span> The email address is not valid !
	                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	                        <span aria-hidden='true'>&times;</span>
	                    </button>
	                </div>"; 
		 }


	if ($chk_email == true) {
			 	
				$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
	                    <span class='badge badge-pill badge-success'> Error !</span> The email address already Exist!
	                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	                        <span aria-hidden='true'>&times;</span>
	                    </button>
	                </div>"; 
			
	} 
	
   //$password = md5($data['password']);
   $sql = "INSERT INTO users (name,username,email,password) VALUES (:name, :username, :email, :password)";
		$query = $this->pdo->prepare($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':username', $username);
		$query->bindValue(':email', $email);
		$query->bindValue(':password', $password);
		$result = $query->execute();

	if ($result) {
			
			    $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'>Success !</span> Registration Created Successfully Please Login.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
	   
		   
	}else{

     		$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Sorry, Data Not Inserted.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;  
	 
	
	}
	


}

    public function emailCheck($email){
	
		$sql = "SELECT email FROM users WHERE email = :email";
		$query = $this->pdo->prepare($sql);
		$query->bindValue(':email', $email);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}else{
			return false;
		
		}

}



//Login part start//	

   public function getLoginUser($email, $password){

$sql = "SELECT * FROM users WHERE email = :email AND password = :password LIMIT 1";
	$query = $this->pdo->prepare($sql);
	$query->bindValue(':email', $email);
	$query->bindValue(':password', $password);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);
	return $result;

}


   public function userLogin($data){
	    
		$email = $data['email'];
		$password = md5($data['password']);
		
		$chk_email = $this->emailCheck($email);
		
	   if ($email == "" OR $password == "") {	
    	
		      $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		       return $msg;  
	 
		 }    
   		
 if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		 	
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> The email address is not valid.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg; 
		 
		 
		 }


 if ($chk_email == false) {
		 	
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> The email address does not Exist.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg; 
		
		 }

//Session part//
 $result = $this->getLoginUser($email, $password);
	  
	if ($result) {
	  	Session::init();
	  	Session::set("login", true);
	  	Session::set("id", $result->id);
	  	Session::set("name", $result->name);
	  	Session::set("username", $result->username);
	  	Session::set("loginmsg", "<div class='alert alert-success'><strong> Success ! </strong> You are logedin . </div>");
	  	
	  	header("Location: users.php");
	  
	  }else{

		  $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Dose not found !
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg; 

	  }
 
 }

    public function getUserData(){

		$sql = "SELECT * FROM users ORDER BY id DESC";
		$query = $this->pdo->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;

 }

//profile part//
 
  public function getUserById($id){
	 	$sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
	 	$query = $this->pdo->prepare($sql);
	 	$query->bindValue(':id', $id);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		return $result;
	 }

//user Update//
   public function updateUser($id, $data){

	 	$name = $data['name'];
		$username = $data['username'];
		$email = $data['email'];

	if ($name == "" OR $username == "" OR $email == "" ) {
	 

	$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
 
 }       	
    	

	$sql = "UPDATE users set name = :name, username = :username, 
	email = :email WHERE id = :id";

	$query = $this->pdo->prepare($sql);
	$query->bindValue(':name', $name);
	$query->bindValue(':username', $username);
	$query->bindValue(':email', $email);
	$query->bindValue(':id', $id);
	$result = $query->execute();

	if ($result) {
		
		    $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'>Success !</span> Data Updated Successfully.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
	   
	
	}else{

		$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                <span class='badge badge-pill badge-success'> Error !</span> Sorry, Data Not Updated.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
		
	    return $msg;
	
	}
	

  } 

//Update Password//
 
   private function checkPassword($id, $old_pass){
		$password = md5($old_pass);
		$sql = "SELECT password FROM users WHERE id = :id AND password = :password";
		$query = $this->pdo->prepare($sql);
		$query->bindValue(':id', $id);
		$query->bindValue(':password', $password);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}else{
			return false;
		
		}

    }

   public function updatePassword($id, $data){

	 	$old_pass = $data['old_pass'];
		$new_pass = $data['password'];
		$chk_pass = $this->checkPassword($id, $old_pass);
			
		if ($old_pass == "" OR $new_pass == "" ) {
			
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;

	    }
	    
	    if ($chk_pass == false) {
	         
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Old password not Exist.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;

	    } 
	    
	    if (strlen($new_pass) < 6) {

	    	$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Password is too short.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
	         
	    }
	

		$password = md5($new_pass); 
		$sql = "UPDATE users set password = :password WHERE id = :id";

		$query = $this->pdo->prepare($sql);
		$query->bindValue(':password', $password);
		$query->bindValue(':id', $id);
		$result = $query->execute();

		if ($result) {
			
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'>Success !</span> Password Updated Successfully.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
		   
		
		}else{

			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Password Not Updated.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;

		   }
		

	     }
//End User login/register//


//===============   Admim registe/Login  ============= //

	public function adminRegistration($data){
		$name = $data['name'];
		$username = $data['username'];
		$email = $data['email'];
		$password = md5($data['password']);
		
		$chk_email = $this->emailCheckAdmin($email);

	if ($name == "" OR $username == "" OR $email == "" OR $password == "" ) {
		    	
	    	$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		       return $msg; 
		 
	 } 

	 if (strlen($username ) < 3) {
	 	   
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Username is too short.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;	

	}elseif(preg_match('/[^a-z0-9_-]+/i', $username)) {
			
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
	                    <span class='badge badge-pill badge-success'> Error !</span> Username must only contain alphnumerical, deshes and underscores!
	                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	                        <span aria-hidden='true'>&times;</span>
	                    </button>
	                </div>"; 
	}

	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		 	
			 $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
	                    <span class='badge badge-pill badge-success'> Error !</span> The email address is not valid !
	                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	                        <span aria-hidden='true'>&times;</span>
	                    </button>
	                </div>"; 
		 }


	if ($chk_email == true) {
			 	
				$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
	                    <span class='badge badge-pill badge-success'> Error !</span> The email address already Exist!
	                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	                        <span aria-hidden='true'>&times;</span>
	                    </button>
	                </div>"; 
			
	} 
	
   //$password = md5($data['password']);
   $sql = "INSERT INTO admin (name,username,email,password) VALUES (:name, :username, :email, :password)";
		$query = $this->pdo->prepare($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':username', $username);
		$query->bindValue(':email', $email);
		$query->bindValue(':password', $password);
		$result = $query->execute();

	if ($result) {
			
			    $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'>Success !</span> Registration Created Successfully Please Login.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
	   
		   
	}else{

     		$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Sorry, Data Not Inserted.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;  
	 
	
	}
	


}

public function emailCheckAdmin($email){
	
		$sql = "SELECT email FROM admin WHERE email = :email";
		$query = $this->pdo->prepare($sql);
		$query->bindValue(':email', $email);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}else{
			return false;
		
		}

}



//Login part start//	

   public function getLoginAdmin($email, $password){

    $sql = "SELECT * FROM admin WHERE email = :email AND 
            password = :password LIMIT 1";
	$query = $this->pdo->prepare($sql);
	$query->bindValue(':email', $email);
	$query->bindValue(':password', $password);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);
	return $result;

}


   public function adminLogin($data){
	    
		$email = $data['email'];
		$password = md5($data['password']);
		
		$chk_email = $this->emailCheckAdmin($email);
		
	   if ($email == "" OR $password == "") {	
    	
		      $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		       return $msg;  
	 
		 }    
   		
 if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		 	
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> The email address is not valid.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg; 
		 
		 
		 }


 if ($chk_email == false) {
		 	
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> The email address does not Exist.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg; 
		
		 }

//Session part//
 $result = $this->getLoginAdmin($email, $password);
	  
	if ($result) {
	  	Session::init();
	  	Session::set("login", true);
	  	Session::set("id", $result->id);
	  	Session::set("name", $result->name);
	  	Session::set("username", $result->username);
	  	Session::set("loginmsg", "<div class='alert alert-success'><strong> Success ! </strong> You are logedin . </div>");
	  	
	  	header("Location: index.php");
	  
	  }else{

		  $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Dose not found !
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg; 

	  }
 
 }

 public function getAdminData(){

		$sql = "SELECT * FROM admin ORDER BY id DESC";
		$query = $this->pdo->prepare($sql);
		$query->execute();
		$result = $query->fetchAll();
		return $result;

 }

//profile part//
 
 public function getAdminById($id){
 	$sql = "SELECT * FROM admin WHERE id = :id LIMIT 1";
 	$query = $this->pdo->prepare($sql);
 	$query->bindValue(':id', $id);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);
	return $result;
 }

//admin Update//
 public function updateAdmin($id, $data){

	 	$name = $data['name'];
		$username = $data['username'];
		$email = $data['email'];

	if ($name == "" OR $username == "" OR $email == "" ) {
	 

	$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
 
 }       	
    	

	$sql = "UPDATE admin set name = :name, username = :username, 
	email = :email WHERE id = :id";

	$query = $this->pdo->prepare($sql);
	$query->bindValue(':name', $name);
	$query->bindValue(':username', $username);
	$query->bindValue(':email', $email);
	$query->bindValue(':id', $id);
	$result = $query->execute();

	if ($result) {
		
		    $msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'>Success !</span> Data Updated Successfully.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
	   
	
	}else{

		$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                <span class='badge badge-pill badge-success'> Error !</span> Sorry, Data Not Updated.
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>";
		
	    return $msg;
	
	}
	

  } 

//Update Password//
 
 private function checkPasswordAdmin($id, $old_pass){
		$password = md5($old_pass);
		$sql = "SELECT password FROM admin WHERE id = :id AND password = :password";
		$query = $this->pdo->prepare($sql);
		$query->bindValue(':id', $id);
		$query->bindValue(':password', $password);
		$query->execute();
		if ($query->rowCount() > 0) {
			return true;
		}else{
			return false;
		
		}

    }

  public function updatePasswordAdmin($id, $data){

	 	$old_pass = $data['old_pass'];
		$new_pass = $data['password'];
		$chk_pass = $this->checkPasswordAdmin($id, $old_pass);
			
		if ($old_pass == "" OR $new_pass == "" ) {
			
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Field must not be Empty.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;

	    }
	    
	    if ($chk_pass == false) {
	         
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Old password not Exist.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;

	    } 
	    
	    if (strlen($new_pass) < 6) {

	    	$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Password is too short.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
	         
	    }
	

		$password = md5($new_pass); 
		$sql = "UPDATE admin set password = :password WHERE id = :id";

		$query = $this->db->pdo->prepare($sql);
		$query->bindValue(':password', $password);
		$query->bindValue(':id', $id);
		$result = $query->execute();

		if ($result) {
			
			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'>Success !</span> Password Updated Successfully.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;
		   
		
		}else{

			$msg = "<div class='alert  alert-success alert-dismissible fade show' role='alert'>
                    <span class='badge badge-pill badge-success'> Error !</span> Password Not Updated.
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
			
		    return $msg;

		   }
		

	     }

	     

	 }

	?>





	