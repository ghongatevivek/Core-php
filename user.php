<?php 
	include 'connection.php';

	if(isset($_POST["btn"])){

		$u_name=$_POST['u_name'];
		$u_city = $_POST['u_city'];
		$u_email = $_POST['u_email'];
		$u_mno = $_POST['u_mno'];
		$u_password = $_POST['u_password'];

		if(empty($u_name)){
			$err['u_name'] = "Username Field Is Required";
			// print_r($err);
		}elseif(!preg_match("/^[A-Za-z]/",$u_name)){
			$err ['u_name'] = "Only Alpha";
		}

		if(empty($u_city)){
			$err['u_city'] = "City Field Is Required";
			// print_r($err);
		}

		if(empty($u_password)){
			$err['u_password'] = "Password Field Is Required";
			// print_r($err);
		}

		if(empty($u_mno)){
			$err['u_mno'] = "Phone No Field Is Required";
			// print_r($err);
		}elseif(!preg_match("/^[0-9]/",$u_mno)){
			$err ['u_mno'] = "Only Numbers";
		}elseif(!preg_match("/^[0-9]{10}$/",$u_mno)){
			$err ['u_mno'] = "Only 10 Numbers";
		}

		if(empty($u_email)){
			$err['u_email'] = "Email Field Is Required";
		}elseif (!filter_var($u_email,FILTER_VALIDATE_EMAIL)) {
			$err['u_email'] = "Invalid Email";
		}

		if(empty($_FILES['u_image']['name'])){
			$err ['u_image'] = "Image Field Is Required";
		}

		if(!empty($_POST['u_hobbies'])){
			$hobb = implode(",", $_POST['u_hobbies']);
			// print_r($hobb);
		}else{
			$hobb = null;
		}

		if(!isset($err)){
			$u_img = $_FILES['u_image']['name'];
			if(move_uploaded_file($_FILES['u_image']['tmp_name'],"img/".$u_img)){

				$insert = mysqli_query($cn,"insert into tbl_user(u_name,u_city,u_email,u_hobbies,u_image,u_mno,u_password) values('$u_name','$u_city','$u_email','$hobb','$u_img','$u_mno','$u_password')");

				// print_r($insert);
				if($insert){
					$_SESSION['msg'] = "User Information Is Submitting Successfully..";
					header("Location:user.php");
					exit();
				}else{
					echo mysqli_error($cn);
					echo "Data Not Submitting";
				}
			}
		}

	}

	if(isset($_GET['edit'])){
		$id = base64_decode($_GET['edit']);

		$select = mysqli_query($cn,"select * from tbl_user where u_id = '$id'");

		$edit = mysqli_fetch_assoc($select);

		$hobbies = explode(",", $edit['u_hobbies']);
	}

	if(isset($_POST['ubtn'])){

		$u_name=$_POST['u_name'];
		$u_city = $_POST['u_city'];
		$u_email = $_POST['u_email'];
		$u_mno = $_POST['u_mno'];
		$u_id = $_POST['u_id'];

		if(empty($u_name)){
			$err['u_name'] = "Username Field Is Required";
			// print_r($err);
		}elseif(!preg_match("/^[A-Za-z]/",$u_name)){
			$err ['u_name'] = "Only Alpha";
		}

		if(empty($u_city)){
			$err['u_city'] = "City Field Is Required";
			// print_r($err);
		}

		

		if(empty($u_mno)){
			$err['u_mno'] = "Phone No Field Is Required";
			// print_r($err);
		}elseif(!preg_match("/^[0-9]/",$u_mno)){
			$err ['u_mno'] = "Only Numbers";
		}elseif(!preg_match("/^[0-9]{10}$/",$u_mno)){
			$err ['u_mno'] = "Only 10 Numbers";
		}

		if(empty($u_email)){
			$err['u_email'] = "Email Field Is Required";
		}elseif (!filter_var($u_email,FILTER_VALIDATE_EMAIL)) {
			$err['u_email'] = "Invalid Email";
		}

		if(empty($_FILES['u_image']['name'])){
			$err ['u_image'] = "Image Field Is Required";
		}

		if(!empty($_POST['u_hobbies'])){
			$hobb = implode(",", $_POST['u_hobbies']);
			// print_r($hobb);
		}else{
			$hobb = null;
		}

		if(!isset($err)){
			$u_img = $_FILES['u_image']['name'];
			if(move_uploaded_file($_FILES['u_image']['tmp_name'],"img/".$u_img)){

				$update = mysqli_query($cn,"update tbl_user set u_name='$u_name',u_city='$u_city',u_email='$u_email',u_hobbies='$hobb',u_image='$u_img' where u_id = '$u_id' ");
				 print_r($update);
				if($update){
					$_SESSION['msg'] = "User Information Is Updatting Successfully..";
					header("Location:user_select.php");
					exit();
				}else{
					echo mysqli_error($cn);
					echo "Data Not Submitting";
				}
			}
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>User Details Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<?php if(isset($_SESSION['msg'])){ ?>
			<div class="alert alert-success">
				<strong><?php echo $_SESSION['msg']; ?></strong>
			</div>
		<?php }	unset($_SESSION['msg']); ?>
		<div class="row justify-content-center mt-3 bg-light">
			<div class="col-md-6 col-sm-6">
				<form class="shadow-lg p-3 " method="post" enctype="multipart/form-data">
					<?php if(isset($edit)){ ?>

					<h2 class="text-center text-success">Edit User </h2>
					<?php }else{ ?>
					<h2 class="text-center text-success">User Register</h2>
				<?php } ?>
					<div class="form-group">
						<label>Enter Username</label>
						<input type="text" name="u_name" value="<?php if(isset($edit)){ echo $edit['u_name'];} ?>" class="form-control">
						<span class="text-danger"><?php if(isset($err['u_name'])){ echo $err['u_name'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Select City</label>
						<select class="form-control" name="u_city">
							<option value="">Select City</option>
							<option value="Surat" <?php if(isset($edit)){ if($edit['u_city']=="Surat"){ echo "selected" ; }} ?>>Surat</option>
							<option value="Malkapur" <?php if(isset($edit)){ if($edit['u_city']=="Malkapur"){ echo "selected" ; }} ?>>Malkapur</option>
							<option value="Vapi" <?php if(isset($edit)){ if($edit['u_city']=="Vapi"){ echo "selected" ; }} ?>>Vapi</option>
							<option value="Navsari" <?php if(isset($edit)){ if($edit['u_city']=="Navsari"){ echo "selected" ; }} ?>>Navsari</option>
							<option value="Bardoli" <?php if(isset($edit)){ if($edit['u_city']=="Bardoli"){ echo "selected" ; }} ?>>Bardoli</option>
							<option value="Ahamdabad" <?php if(isset($edit)){ if($edit['u_city']=="Ahamdabad"){ echo "selected" ; }} ?>>Ahamdabad</option>
							
						</select>
						<span class="text-danger"><?php if(isset($err['u_city'])){ echo $err['u_city'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Enter Email Id</label>
						<input type="text" name="u_email" value="<?php if(isset($edit)){ echo $edit['u_email'];} ?>" class="form-control">
						<span class="text-danger"><?php if(isset($err['u_email'])){ echo $err['u_email'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>User Hobbies</label><br>
						<input type="checkbox" name="u_hobbies[]" value="Music" <?php if(isset($edit)){ if(in_array("Music", $hobbies)){ echo "checked" ; }} ?>>Music
						<input type="checkbox" name="u_hobbies[]" value="Cricket" <?php if(isset($edit)){ if(in_array("Cricket", $hobbies)){ echo "checked" ; }} ?>>Cricket
						<input type="checkbox" name="u_hobbies[]" value="Movie" <?php if(isset($edit)){ if(in_array("Movie", $hobbies)){ echo "checked" ; }} ?>>Movie			
					</div>

					<div class="form-group">
						<label>Enter Image</label>
						<input type="file" name="u_image" class="form-control">
						<?php if(isset($edit)){ ?>
						<img src="img/<?php echo $edit['u_image']; ?>" height=100 width=100>
						<?php } ?>
						<span class="text-danger"><?php if(isset($err['u_image'])){ echo $err['u_image'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Enter Phone No</label>
						<input type="text" name="u_mno" value="<?php if(isset($edit)){ echo $edit['u_mno'];} ?>" class="form-control">
						<span class="text-danger"><?php if(isset($err['u_mno'])){ echo $err['u_mno'] ; } ?></span>
					</div>

					<?php if(!isset($edit)){ ?>
					<div class="form-group">
						<label>Enter Password</label>
						<input type="text" name="u_password" class="form-control">
						<span class="text-danger"><?php if(isset($err['u_password'])){ echo $err['u_password'] ; } ?></span>
					</div>
				<?php } ?>

				<?php if(isset($edit)){ ?>
					<input type="submit" name="ubtn" class="btn btn-primary btn-block" value="Edit Data">
					<input type="hidden" name="u_id" value="<?php echo $edit['u_id']; ?>">
				<?php }else{ ?>
					<input type="submit" name="btn" class="btn btn-md btn-primary btn-block">
				<?php } ?>
				</form>
			</div>
		</div>
	</div>

</body>
</html>