<?php 
	include 'connection.php';

	if(isset($_POST['btn'])){

		$s_name = $_POST['s_name'];
		$s_address = $_POST['s_address'];
		$s_mno = $_POST['s_mno'];
		$s_email = $_POST['s_email'];
		$s_password = $_POST['s_password'];
		

		if(!empty($_POST['s_course'])){
			$s_course = implode(",", $_POST['s_course']);
		}else{
			$s_course = null;
		}

		if(empty($s_name)){
			$err['s_name'] = "School Name Is Required"; 
		}elseif(!preg_match("/^[A-Za-z]/",$s_name)){
			$err['s_name'] = "Only Alpha ";
		}

		if(empty($s_address)){
			$err['s_address'] = "School Address Is Required";
		}

		if(empty($s_mno)){
			$err['s_mno'] = "School Mo No Is Required"; 
		}elseif(!preg_match("/^[0-9]/",$s_mno)){
			$err['s_mno'] = "Only Numbers";
		}elseif(!preg_match("/^[0-9]{10}$/",$s_mno)){
			$err['s_mno'] = "Only 10 Numbers ";
		}

		if(empty($s_email)){
			$err['s_email'] = "School Email Id Is Required";
		}elseif(!filter_var($s_email,FILTER_VALIDATE_EMAIL)){
			$err['s_email'] = "Invalid Email Id";
		}

		if(empty($_FILES['s_image']['name'])){
			$err['s_image'] = "School Image Is Required";
		}

		if(empty($s_password)){
			$err['s_password'] = "School Password Is Required";
			// print_r($err);
		}

		if(!isset($err)){
			$s_img = $_FILES['s_image']['name'];

			if(move_uploaded_file($_FILES['s_image']['tmp_name'],"img/".$s_img)){

				$insert = mysqli_query($cn,"insert into tbl_school(s_name,s_address,s_mno,s_email,s_image,s_course,s_password) values('$s_name','$s_address','$s_mno','$s_email','$s_img','$s_course','$s_password')");

				// print_r($insert);die();

				if($insert){
					$_SESSION['msg'] = "School Information Is Submitting Successfully..";
					header("Location:school.php");
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

		$select = mysqli_query($cn,"select * from tbl_school where s_id = '$id'");

		$edit = mysqli_fetch_assoc($select);

		$s_course = explode(",",$edit['s_course']);

		// print_r($s_course);
	}

	if(isset($_POST['ubtn'])){

		$s_name = $_POST['s_name'];
		$s_address = $_POST['s_address'];
		$s_mno = $_POST['s_mno'];
		$s_email = $_POST['s_email'];
		$s_id = $_POST['s_id'];
		

		if(!empty($_POST['s_course'])){
			$s_course = implode(",", $_POST['s_course']);
		}else{
			$s_course = null;
		}

		if(empty($s_name)){
			$err['s_name'] = "School Name Is Required"; 
		}elseif(!preg_match("/^[A-Za-z]/",$s_name)){
			$err['s_name'] = "Only Alpha ";
		}

		if(empty($s_address)){
			$err['s_address'] = "School Address Is Required";
		}

		if(empty($s_mno)){
			$err['s_mno'] = "School Mo No Is Required"; 
		}elseif(!preg_match("/^[0-9]/",$s_mno)){
			$err['s_mno'] = "Only Numbers";
		}elseif(!preg_match("/^[0-9]{10}$/",$s_mno)){
			$err['s_mno'] = "Only 10 Numbers ";
		}

		if(empty($s_email)){
			$err['s_email'] = "School Email Id Is Required";
		}elseif(!filter_var($s_email,FILTER_VALIDATE_EMAIL)){
			$err['s_email'] = "Invalid Email Id";
		}

		if(empty($_FILES['s_image']['name'])){
			$err['s_image'] = "School Image Is Required";
		}

		

		if(!isset($err)){
			$s_img = $_FILES['s_image']['name'];

			if(move_uploaded_file($_FILES['s_image']['tmp_name'],"img/".$s_img)){

				$update = mysqli_query($cn,"update tbl_school set s_name='$s_name',s_address='$s_address',s_mno='$s_mno',s_email='$s_email',s_image='$s_img',s_course='$s_course' where s_id='$s_id' ");
				// print_r($update);die();

				if($update){
					$_SESSION['msg'] = "School Information Is Updatting Successfully..";
					header("Location:school_select.php");
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
	<title>School Registration Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<?php if(isset($_SESSION['msg'])){ ?>
			<div class="alert alert-success">
				<strong><?php echo $_SESSION['msg']; ?></strong>
			</div>
		<?php }	unset($_SESSION['msg']); ?>
		<div class="row justify-content-center mt-3">
			<div class="col-md-6 ">
				<form class="shadow-lg p-3 bg-light" method="post" enctype="multipart/form-data" >
					<?php if(isset($edit)){ ?>
					<h2 class="text-center text-dark">Edit School Data</h2>

					<?php }else{ ?>
					<h2 class="text-center text-dark">School Registration</h2>
				<?php } ?>
					<div class="form-group">
						<label>Enter School Name</label>
						<input type="text" name="s_name" value="<?php if(isset($edit)){echo $edit['s_name'];} ?>" class="form-control">
						<span class="text-danger"><?php if(isset($err['s_name'])){ echo $err['s_name'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Enter School Address</label>
						<textarea class="form-control" name="s_address"><?php if(isset($edit)){echo $edit['s_address'];} ?></textarea>
						<span class="text-danger"><?php if(isset($err['s_address'])){ echo $err['s_address'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Enter Phone No</label>
						<input type="text" value="<?php if(isset($edit)){echo $edit['s_mno'];} ?>" name="s_mno" class="form-control">
						<span class="text-danger"><?php if(isset($err['s_mno'])){ echo $err['s_mno'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Enter School Email</label>
						<input type="text" name="s_email" value="<?php if(isset($edit)){echo $edit['s_email'];} ?>" class="form-control">
						<span class="text-danger"><?php if(isset($err['s_email'])){ echo $err['s_email'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Enter School image</label>
						<input type="file" name="s_image" class="form-control">
						<?php if(isset($edit)){ ?>
						<img src="img/<?php echo $edit['s_image']; ?>" width=100 height=100>
					<?php } ?>
						<span class="text-danger"><?php if(isset($err['s_image'])){ echo $err['s_image'] ; } ?></span>
					</div>

					<div class="form-group">
						<label>Select Courses</label><br>
						<input type="checkbox" name="s_course[]" value="BCA" <?php if(isset($edit)){ if(in_array("BCA",$s_course)){ echo "checked" ; }} ?>>BCA
						<input type="checkbox" name="s_course[]" value="BBA" <?php if(isset($edit)){ if(in_array("BBA", $s_course)){ echo "checked" ; }} ?>>BBA
						<input type="checkbox" name="s_course[]" value="BCOM" <?php if(isset($edit)){ if(in_array("BCOM", $s_course)){ echo "checked" ; }} ?>>BCOM
					</div>

					<?php if(!isset($edit)){ ?>
					<div class="form-group">
						<label>Enter School Password</label>
						<input type="password" name="s_password" class="form-control">
						<span class="text-danger"><?php if(isset($err['s_password'])){ echo $err['s_password'] ; } ?></span>
					</div>
				<?php } ?>

					<?php if(isset($edit)){ ?>
						<input type="submit" value="Edit Data" name="ubtn" class="btn btn-block btn-dark">
						<input type="hidden" name="s_id" value="<?php echo $edit['s_id']; ?>">
					<?php }else{ ?>
					<input type="submit" name="btn" class="btn btn-block btn-dark">
				<?php } ?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>