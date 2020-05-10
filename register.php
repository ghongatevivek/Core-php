<?php 
	include 'connection.php';

	if(isset($_POST['btn'])){
		$r_name = $_POST['r_name'];
		$r_gender = $_POST['r_gender'];
		$r_password = $_POST['r_password'];
		$r_city = $_POST['r_city'];

		$hobb=!empty($_POST['r_hobbies'])?implode(",",$_POST['r_hobbies']):"";

		// $hobbbies=!empty($_POST['hobbies'])?implode(",",$_POST['hobbies']):"";

		if(empty($r_name)){
			$err ['r_name'] = "Name Is Required";
		}elseif(!preg_match("/^[A-Za-z]/", $r_name)){
			$err ['r_name'] = "Name Containe Only Alpha";
		}

		if(empty($r_password)){
			$err ['r_password'] = "Password Is Required";
		}

		if(empty($r_city)){
			$err ['r_city'] = "City Is Required";
		}

		if(empty($_FILES['r_image']['name'])){
			$err ['r_image'] = "Image Is Required";
		}

		if(!isset($err)){
			if(move_uploaded_file($_FILES['r_image']['tmp_name'],"img/IMG".$_FILES['r_image']['name'])){
				$image = "IMG".$_FILES['r_image']['name'];

				$addData = mysqli_query($cn,"INSERT INTO `tbl_register`(`r_name`,`r_gender`,`r_city`,`r_hobbies`,`r_image`,`r_password`) VALUES('$r_name','$r_gender','$r_city','$hobb','$image','$r_password')");

				if($addData){
					$_SESSION['msg'] = "Data Stored To Database Successfully...";
					header("Location:register.php");
					exit;
				}else{
					echo mysqli_error($cn);
				}
			}else{
				echo "Something Went Wrong Please Select Another Image";
			}
		}
	}

	if(isset($_GET['dlt'])){
		$id = $_GET['dlt'];

		$deleteData = mysqli_query($cn,"delete from tbl_register where register_id = '$id'");

		if($deleteData){
			$_SESSION['msg'] = "Recored Deleted Successfully..";
			header("Location:register.php");
			exit();
		}else{
			echo mysqli_error($cn);
		}
	}

	if(isset($_GET['edit'])){
		$id = $_GET['edit'];

		$getSingaleData = mysqli_query($cn,"select * from tbl_register where register_id = '$id'");

		$edit = mysqli_fetch_assoc($getSingaleData);

		// print_r($edit);
	}

	if(isset($_POST['ubtn'])){
		$r_name = $_POST['r_name'];
		$r_city = $_POST['r_city'];
		$register_id = $_POST['register_id'];

		$hobb=!empty($_POST['r_hobbies'])?implode(",",$_POST['r_hobbies']):"";

		// $hobbbies=!empty($_POST['hobbies'])?implode(",",$_POST['hobbies']):"";

		if(empty($r_name)){
			$err ['r_name'] = "Name Is Required";
		}elseif(!preg_match("/^[A-Za-z]/", $r_name)){
			$err ['r_name'] = "Name Containe Only Alpha";
		}

		// if(empty($r_password)){
		// 	$err ['r_password'] = "Password Is Required";
		// }

		if(empty($r_city)){
			$err ['r_city'] = "City Is Required";
		}

		// if(empty($_FILES['r_image']['name'])){
		// 	$err ['r_image'] = "Image Is Required";
		// }

		if(!isset($err)){
			if(!empty($_FILES['r_image']['name'])){
				if(move_uploaded_file($_FILES['r_image']['tmp_name'],"img/IMG".$_FILES['r_image']['name'])){
					$image = "IMG".$_FILES['r_image']['name'];
				}else{
					$err['r_image'] = "Somthing Wrong Please Select Another Image";
				}
			}else{
				$image = $_POST['edit_image'];
				// print_r($image);
			}

			$updateData = mysqli_query($cn,"update `tbl_register` set r_name='$r_name',r_city='$r_city',r_hobbies='$hobb',r_image='$image' where register_id='$register_id' ");

			print_r($updateData);
			if($updateData){
				$_SESSION['msg'] = "Your Details Updated Successfully...";
				header("Location:register.php");
				exit;
			}else{
				echo mysqli_error($cn);	
			}
		}else{
			print_r($err);
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registeration Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<?php if(isset($_SESSION['msg'])){ ?>
			<div class="alert alert-success">
				<strong>Success !</strong><?php echo $_SESSION['msg']; ?>
			</div>
		<?php } unset($_SESSION['msg']); ?>
		<div class="row justify-content-center mt-3">
			<div class="col-md-6">
				<form method="post" enctype="multipart/form-data" class="shadow-lg p-3 mb-5">
					<div class="form-group">
						<label>Enter Name</label>
						<input type="text" name="r_name" value="<?php if(isset($err)){ echo $r_name;}elseif(isset($edit)){ echo $edit['r_name'] ; }?>" class="form-control">
						<span class="text-danger"><?php echo isset($err['r_name'])?$err['r_name']:""; ?></span>
					</div>

					<?php if(!isset($edit)){ ?>
					<div class="form-group">
						<label>Gender</label><br>
						<input type="radio" name="r_gender" value="Male" checked <?php if(isset($err)){ if($r_gender=="Male"){ echo "checked" ; }} ?>>Male
						<input type="radio" name="r_gender" value="Female" <?php if(isset($err)){ if($r_gender=="Female"){ echo "checked" ; }} ?>>Female
					</div>
				<?php } ?>

					<div class="form-group">
						<label>Select City</label>
						<select class="form-control" name="r_city">
							<option value="" >Select City</option>
							<option value="Surat" <?php if(isset($err)){ if($r_city=="Surat"){ echo "selected" ; }}elseif(isset($edit)){ if($edit['r_city']=="Surat"){ echo "selected" ; }} ?>>Surat</option>
							<option value="Vapi" <?php if(isset($err)){ if($r_city=="Vapi"){ echo "selected" ; }}elseif(isset($edit)){ if($edit['r_city']=="Vapi"){ echo "selected" ; }} ?>>Vapi</option>
						</select>
						<span class="text-danger"><?php echo isset($err['r_city'])?$err['r_city']:""; ?></span>
					</div>

					<div class="form-group">
						<label>Hobbies</label><br>
						<input type="checkbox" name="r_hobbies[]" value="Music" 
							<?php
								if(isset($err) && !empty($_POST['r_hobbies'])){
									if(in_array("Music",$_POST['r_hobbies'])){
										echo "checked";	
									}
								}elseif(isset($edit)){
									if(in_array("Music",explode(",",$edit['r_hobbies']))){
										echo "checked";
									}
								} 
							?>
						>Music
						<input type="checkbox" name="r_hobbies[]" value="Traveling" 
							<?php 
								if(isset($err) && !empty($_POST['r_hobbies'])){
									if(in_array("Traveling", $_POST['r_hobbies'])){
										echo "checked";
									}
								}elseif(isset($edit)){
									if(in_array("Traveling",explode(",",$edit['r_hobbies']))){
										echo "checked";
									}
								}
							 ?>
						>Traveling
					</div>

					<div class="form-group">
						<label>Upload Image</label>
						<input type="file" name="r_image" class="form-control">
						<span class="text-danger"><?php echo isset($err['r_image'])?$err['r_image']:"" ; ?></span>
					</div>

					<?php if(isset($edit)){ ?>
						<div class="form-group">
							<img src="img/<?php echo $edit['r_image']; ?>" height="100" width="100" class="img-thumbnail">
						</div>
					<?php }else{ ?>

					<div class="form-group">
						<label>Enter Password</label>
						<input type="password" name="r_password" class="form-control">
						<span class="text-danger"><?php echo isset($err['r_password'])?$err['r_password']:""; ?></span>
					</div>

					<?php } ?>

					<div class="form-group">
						<?php if(isset($edit)){ ?>
							<input type="submit" name="ubtn" value="Update Data" class="btn btn-info">
							<input type="hidden" name="register_id" value="<?php echo $edit['register_id']; ?>">
							<input type="hidden" name="edit_image" value="<?php echo $edit['r_image']; ?>">
						<?php }else{ ?>
							<input type="submit" name="btn" class="btn btn-info">
						<?php } ?>
					</div>
					 
				</form>
			</div>
		</div>
		<br><br>
		<table class="table table-bordered bg-warning table-hover">
		<thead>
			<tr>
				<th>No</th>
				<th>Name</th>
				<th>Gender</th>
				<th>City</th>
				<th>Hobbies</th>
				<th>Image</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$getData = mysqli_query($cn,"select * from tbl_register");

					if(mysqli_num_rows($getData)>0){
						$i=1;
						while($data = mysqli_fetch_assoc($getData)){?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $data['r_name']; ?></td>
								<td><?php echo $data['r_gender']; ?></td>
								<td><?php echo $data['r_city']; ?></td>
								<td><?php echo $data['r_hobbies']; ?></td>
								<td>
									<img src="img/<?php echo $data['r_image']; ?>" width=100 height=100 class="img-thumbnail">
								</td>
								<td>
									<a href="register.php?edit=<?php echo $data['register_id']; ?>" class="btn btn-success">Edit</a>

									<a onclick="return confirm('Are You Sure For Delete This Record')" href="register.php?dlt=<?php echo $data['register_id']; ?>" class="btn btn-danger">Delete</a>
								</td>
							</tr>
						<?php }
					}else { ?>
						<tr class="text-center text-primary">
							<td colspan="7">No Recored</td>
						</tr>
					<?php }
			 ?>
		</tbody>
	</table>
	</div> 


	
</body>
</html>