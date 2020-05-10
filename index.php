<?php 
	include 'conn.php';

	if(isset($_POST['btn'])){
		$name=$_POST['name'];
		$address=$_POST['address'];
		$city=$_POST['city'];
		$gender=$_POST['gender'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];
		$mno=$_POST['mno'];

		if(!empty($_POST['hobbies'])){
			$hobbies=implode(",",$_POST['hobbies']);
		}else{
			$hobbies=null;
		}

		if(empty($name)){
			$err['name']="Name Is Required";
		}elseif(!preg_match("/^[a-zA-Z]/",$name)){
			$err['name']="Only Alphabet Allow";
		}

		if(empty($email)){
			$err['email']="Email Is Required";
		}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$err['email']="Invalid Email";
		}

		if(empty($mno)){
			$err['mno']="Mobile No Is Required";
		}elseif(!preg_match("/^[0-9]/", $mno)){
			$err['mno']="Only Digit Allow";
		}elseif(!preg_match("/^[0-9]{10}$/", $mno)){
			$err['mno']="Mobile No Allow Only 10 Digits";
		}

		if(empty($address)){
			$err['address']="Address Is Required";
		}

		if(empty($city)){
			$err['city']="City is requied";
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

				$insert= mysqli_query($cn,"insert into tbl_stud(name,address,city,gender,mno,hobbies,image,email,pass) values('$name','$address','$city','$gender','$mno','$hobbies','$img','$email','$pass')");

				if($insert){
					$_SESSION['msg']="Data Is Inserted To Database Successfully....";
					header("Location:index.php");
					exit();
				}else{
					echo "Data Not Inserted";
				}
			}
		}

	}

	if(isset($_GET['edit'])){
		$id=base64_decode($_GET['edit']);
		$select=mysqli_query($cn,"select * from tbl_stud where stud_id='$id'");
		$edit=mysqli_fetch_assoc($select);
		$hobbies=explode(",",$edit['hobbies']);
	}

	if(isset($_POST['ubtn'])){
		$name=$_POST['name'];
		$address=$_POST['address'];
		$city=$_POST['city'];
		$email=$_POST['email'];
		$mno=$_POST['mno'];
		$stud_id=$_POST['stud_id'];

		if(!empty($_POST['hobbies'])){
			$hobbies=implode(",",$_POST['hobbies']);
		}else{
			$hobbies=null;
		}

		if(empty($name)){
			$err['name']="Name Is Required";
		}elseif(!preg_match("/^[a-zA-Z]/",$name)){
			$err['name']="Only Alphabet Allow";
		}

		if(empty($email)){
			$err['email']="Email Is Required";
		}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$err['email']="Invalid Email";
		}

		if(empty($mno)){
			$err['mno']="Mobile No Is Required";
		}elseif(!preg_match("/^[0-9]/", $mno)){
			$err['mno']="Only Digit Allow";
		}elseif(!preg_match("/^[0-9]{10}$/", $mno)){
			$err['mno']="Mobile No Allow Only 10 Digits";
		}

		if(empty($address)){
			$err['address']="Address Is Required";
		}

		if(empty($city)){
			$err['city']="City is requied";
		}	


		if(!isset($err)){
			if(!empty($_FILES['image']['name'])){
				$img=time().$_FILES['image']['name'];
				if(move_uploaded_file($_FILES['image']['tmp_name'],"img/".$img)){

					$update=mysqli_query($cn,"update tbl_stud set name='$name',address='$address',city='$city',mno='$mno',hobbies='$hobbies',image='$img',email='$email' where stud_id='$stud_id'");
				}else{

					$update=mysqli_query($cn,"update tbl_stud set name='$name',address='$address',city='$city',mno='$mno',hobbies='$hobbies',image='$img',email='$email' where stud_id='$stud_id'");

				}

				if($update){
					$_SESSION['msg']="Data Is Updated To Database Successfully....";
					header("Location:select.php");
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
 	<title>Index Page</title>
 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 </head>
 <body>
 	<form method="post" enctype="multipart/form-data">
 		<div class="container">
 			<?php if(isset($_SESSION['msg'])){ ?>
 				<div class="alert alert-success">
 					<strong><?php echo $_SESSION['msg']; ?></strong>
 				</div>
 			<?php } unset($_SESSION['msg']);?>

 			<h1><?php echo isset($edit)?"Edit Profile":"Student Registration"; ?></h1>


	 		<div class="row">
	 			<div class="col-md-6">
			 		<div class="form-group">
				 		<label class="font-weight-bold">Name</label>
				 		<input type="text" name="name" class="form-control" value="<?php if(isset($edit)){
				 			echo $edit['name'];	} ?>">
				 		<span class="text-danger"><?php if(isset($err['name'])){echo $err['name']; } ?></span>
				 	</div>

				 	<div class="form-group">
				 		<label class="font-weight-bold">Address</label>
				 		<textarea class="form-control" name="address" ><?php if(isset($edit)){
				 			echo $edit['address'];} ?></textarea>
				 		<span class="text-danger"><?php if(isset($err['address'])){echo  $err['address']; } ?></span>		
				 	</div>

				 	<div class="form-group">
				 		<label class="font-weight-bold">City</label>
				 		<select class="form-control" name="city">
				 			<option value="">Select City</option>
				 			<option value="Surat" <?php if(isset($edit)){ if($edit['city']=="Surat"){echo "selected";}} ?>>Surat</option>
				 			<option value="Vapi" <?php if(isset($edit)){ if($edit['city']=="Vapi"){echo "selected";}} ?> >Vapi</option>
				 			<option value="Navsari" <?php if(isset($edit)){ if($edit['city']=="Navsari"){echo "selected";}} ?> >Navsari</option>
				 		</select>		
				 		<span class="text-danger"><?php if(isset($err['city'])){echo $err['city']; } ?></span>
				 	</div>

				 	<?php if(!isset($edit)){ ?>
				 	<div class="form-group">
				 		<label class="font-weight-bold">Gender</label>
				 		<input type="radio" name="gender" value="Male" checked>Male
				 		<input type="radio" name="gender" value="Female">Female	
				 	</div>
				 <?php } ?>

				 	<div class="form-group">
				 		<label class="font-weight-bold">Mobile No</label>
				 		<input type="text" class="form-control" name="mno" value="<?php if(isset($edit)){
				 			echo $edit['mno'];} ?>">
				 		<span class="text-danger"><?php if(isset($err['mno'])){echo $err['mno']; } ?></span>
				 	</div>

				 	<div class="form-group">
				 		<label class="font-weight-bold">Hobbies</label>
				 		
				 		<input type="checkbox" name="hobbies[]" value="Cricket"<?php if(isset($edit)){ if(in_array("Cricket", $hobbies)){ echo "checked";} } ?>>Cricket

				 		<input type="checkbox" name="hobbies[]" value="Reading">Reading
				 		
				 		<input type="checkbox" name="hobbies[]" value="Music">Music
				 		
				 		<input type="checkbox" name="hobbies[]" value="Traveling"> >Traveling
				 	</div>

				 	<div class="form-group">
				 		<label class="font-weight-bold">Image</label>
				 		<input type="file" name="image" class="form-control">
				 		<span class="text-danger"><?php if(isset($err['image'])){echo $err['image']; } ?></span> 
				 		<?php if(isset($edit)){ ?>
				 			<img src="img/<?php echo $edit['image']; ?>" height="100" width="100">
				 		<?php } ?>
				 	</div>

				 	<div class="form-group">
				 		<label class="font-weight-bold">Email</label>
				 		<input type="text" name="email" class="form-control" value="<?php if(isset($edit)){
				 			echo $edit['email'];} ?>">
				 		<span class="text-danger"><?php if(isset($err['email'])){echo $err['email']; } ?></span>
				 	</div>

				 	<?php if(!isset($edit)){ ?>
				 	<div class="form-group">
				 		<label class="font-weight-bold">Password</label>
				 		<input type="password" class="form-control" name="pass">
				 		<span class="text-danger"><?php if(isset($err['pass'])){echo $err['pass']; } ?></span>
				 	</div>
				 <?php } ?>


				 	<div class="form-group">
				 		<?php if(isset($edit)){ ?>
				 		<center><input type="submit" name="ubtn" value="Edit Profile" class="btn btn-outline-success"></center>	
				 			<input type="hidden" value="<?php echo $edit['stud_id'] ?>" name="stud_id">
				 		<?php }else{ ?>
				 			<center><input type="submit" name="btn" class="btn btn-outline-success"></center>
				 		<?php } ?>
				 	</div>
				 </div>
			 </div>	
			</div>
 	</form>


 	<script src="js/jquery-3.3.1.min"></script>
 	<script src="js/bootstrap.min.js"></script>
 </body>
 </html>