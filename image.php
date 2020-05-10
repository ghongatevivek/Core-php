<?php 
	include 'conn.php';

	if(isset($_POST['insert'])){
		$name=$_POST['name'];
		$gender=$_POST['gender'];

		if(empty($name)){
			$err['name']="Name Is Required";
		}elseif(!preg_match("/^[a-zA-Z]/",$name)){
			$err['name']="Only Alphabets Allow";
		}

		if(empty($_FILES['image']['name'])){
			$err['image']="Please Select Image";
		}

		if(!isset($err)){
			$img=$_FILES['image']['name'];
			if(move_uploaded_file($_FILES['image']['tmp_name'],"img/".$img)){
				$insert=mysqli_query($cn,"insert into tbl_img(name,gender,image) values('$name','$gender','$img')");

				if($insert){
					$_SESSION['msg']="Data Is Inserted To Database Successfully....";
					header("Location:image.php");
					exit();
				}
				else{
					 echo mysqli_error($cn);
					}
			}
		}

	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Image Practise</title>
 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 </head>
 <body>
 		<div class="container jumbotron">
 			<div class="row">
 				<div class="col-md-6">
 					<?php if(isset($_SESSION['msg'])){ ?>
	 					<div class="alert alert-success">
	 						<strong><?php echo $_SESSION['msg']; ?></strong>
	 					</div>
 					<?php } unset($_SESSION['msg']); ?>
 					
 					<form method="post" enctype="multipart/form-data">
	 					<div>
	 						<center><label class="font-weight-bold">Image Upload</label></center>
	 					</div>
				 		<div class="form-group">
				 			<label class="font-weight-bold">Enter Full Name</label>
				 			<input type="text" name="name" class="form-control">
				 			<span class="text-danger"><?php if(isset($err['name'])){ echo $err['name']; } ?></span>

				 		</div>

				 		<div class="form-group">
				 			<label class="font-weight-bold">Gender</label>
				 			<input type="radio" name="gender" value="Male" checked>Male
				 			<input type="radio" name="gender" value="Female">Female
				 		</div>			 		

				 		<div class="form-group">
				 			<label class="font-weight-bold">Upload Image</label>
				 			<input type="file" name="image" class="form-control">
				 			<span class="text-danger"><?php if(isset($err['image'])){echo $err['image']; } ?></span>
				 		</div>

				 		<div class="form-group">
				 			<center><input type="submit" name="insert" class="btn btn-outline-primary" ></center>
				 		</div>
			 		</form>
			 	</div>
		 	</div>
		</div>


 	<script src="js/jquery-3.3.1.min"></script>
 	<script src="js/bootstrap.min.js"></script>
 </body>
 </html>