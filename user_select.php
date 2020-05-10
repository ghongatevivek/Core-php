<?php 
	include 'connection.php';

	if(isset($_GET['del'])){
		$id = base64_decode($_GET['del']);

		$delete = mysqli_query($cn,"delete from tbl_user where u_id = '$id'");

		if($delete){
			$_SESSION['msg'] = "User Information Is Deleted Successfully...";
			header("Location:user_select.php");
			exit();
		}else{
			echo mysqli_error($cn);
		}
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>User Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<?php if(isset($_SESSION['msg'])){ ?>
			<div class="alert alert-danger">
				<strong><?php echo $_SESSION['msg']; ?></strong>
			</div>
		<?php }	unset($_SESSION['msg']); ?>
		<table class="table table-bordered">
			<tr>
				<th>No</th>
				<th>Username</th>
				<th>City</th>
				<th>Email</th>
				<th>Hobbies</th>
				<th>Phone No</th>
				<th>Action</th>
			</tr>
			<?php $i=1;
			$select = mysqli_query($cn,"select * from tbl_user");

			while($data = mysqli_fetch_assoc($select)){ ?>
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $data['u_name']; ?></td>
					<td><?php echo $data['u_city'] ?></td>
					<td><?php echo $data['u_email'] ?></td>
					<td><?php echo $data['u_hobbies'] ?></td>
					<td><?php echo $data['u_mno'] ?></td>
					<td>
						<a class="btn btn-danger" onclick="return confirm('Are You Sure For Delete This Recored')" href="user_select.php?del=<?php echo base64_encode($data['u_id']); ?>">Delete</a>

						<a class="btn btn-success" href="user.php?edit=<?php echo base64_encode($data['u_id']); ?>">Edit</a>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>

</body>
</html>