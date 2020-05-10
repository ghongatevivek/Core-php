<?php 
	include 'conn.php';

	if(isset($_POST['btn'])){
		$name=$_POST['name'];
		$gender=$_POST['gender'];
		$city=$_POST['city'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];

		if(!empty($_POST['hobb'])){
			$hobb=implode(",", $_POST['hobb']);
		}else{
			$hobb=null;
		}

		if(empty($name)){
			$err['name']="Employee Name Is Required";
		}elseif(!preg_match("/[A-Za-z]/", $name)){
			$err['name']="Only Alphabets Allow";
		}

		if(empty($city)){
			$err['city']="City Is Required";
		}

		if(empty($email)){
			$err['email']="Email Is Required";
		}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$err['email']="Please Enter Right Email";
		}

		if(empty($pass)){
			$err['pass']="Password Is Required";
		}

		if(empty($_FILES['image']['name'])){
			$err['image']="Please Select Image";
		}

		if(!isset($err)){
			$img=$_FILES['image']['name'];
			if(move_uploaded_file($_FILES['image']['tmp_name'],"img/".$img)){

				$insert=mysqli_query($cn,"insert into tbl_emp(name,gender,city,hobbies,email,pass,image) values('$name',$gender,'$city','$hobb','$email','$pass','$img')");
				
				if($insert){
					$_SESSION['msg']="Record Is Inserted";
					header("Location:emp.php");
					exit();
				}else{
					echo mysqli_error($cn);
				}
			}
		}

	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Employee Page</title>
 	 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 </head>
 <body>
 	<div class="container">
 		<?php if(isset($_SESSION['msg'])){ ?>
 			<strong class="alert alert-success"><?php echo $_SESSION['msg']; ?></strong>
 		<?php }unset($_SESSION['msg']); ?>

 		<h2>Employee Registration</h2>
 		<div class="row">
 			<div class="col-md-6">
 				<form method="post" enctype="multipart/form-data">
 					<div class="form-group">
 						<label>Enter Employee Name</label>
 						<input type="text" name="name" class="form-control">
 						<span class="text-danger"><?php if(isset($err['name'])){ echo $err['name'];} ?></span>
 					</div>

 					<div class="form-group">
 						<label>Gender</label>
 						<input type="radio" name="gender" value="Male" checked>Male
 						<input type="radio" name="gender" value="Female" > Female
 					</div>

 					<div class="form-group">
 						<label>City</label>
 						<select class="form-control" name="city">
 							<option value="">Selected</option>
 							<option value="Surat">Surat</option>
 							<option value="Vadodara">Vadodara</option>
 						</select>
 						<span class="text-danger"><?php if(isset($err['name'])){ echo $err['city'];} ?></span>
 					</div>

 					<div class="form-group">
 						<label>Hobbies</label>
 						<input type="checkbox" name="hobb[]" value="Cricket">Cricket
 						<input type="checkbox" name="hobb[]" value="Dancing">Dancing
 						<input type="checkbox" name="hobb[]" value="Reading">Reading

 					</div>

 					<div class="form-group">
 						<label>Email</label>
 						<input type="text" name="email" class="form-control">
 						<span class="text-danger"><?php if(isset($err['email'])){ echo $err['email'];} ?></span>
 					</div>

 					<div class="form-group">
 						<label>Password</label>
 						<input type="password" name="pass" class="form-control">
 						<span class="text-danger"><?php if(isset($err['pass'])){ echo $err['pass'];} ?></span>
 					</div>

 					<div class="form-group">
 						<label>Employee Image</label>
 						<input type="file" name="image" class="form-control">
 						<span class="text-danger"><?php if(isset($err['image'])){ echo $err['image'];} ?></span>
 					</div>

 					<div class="form-group">
 						<input type="submit" name="btn" value="Submit Details" class="btn btn-primary">
 					</div>
 				</form>
 			</div>
 		</div>
 	</div>

 	<script src="js/jquery-3.3.1.min"></script>
 	<script src="js/bootstrap.min.js"></script>
 </body>
 </html>