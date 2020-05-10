<?php 	
		include "connection.php";

		if(isset($_GET['del'])){
			$id = base64_decode($_GET['del']);

			$delete = mysqli_query($cn,"delete from tbl_school where s_id = '$id'");

				// print_r($delete);die();
			if($delete){
				$_SESSION['msg'] = "Your School Data Is Deleted Successfully...";
				header("Location:school_select.php");
				exit();
			}else{
				echo mysqli_error($cn);
			}
		}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>School Information Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<?php if(isset($_SESSION['msg'])){ ?>
				<div class="alert alert-danger">
					<strong><?php echo $_SESSION['msg']; ?></strong>
				</div>
		<?php 	} unset($_SESSION['msg']); ?>
		<table class="table table-hover">
			<tr class="bg-dark text-white">
				<th>No</th>
				<th>School Name</th>
				<th>School Address</th>
				<th>Phone No</th>
				<th>Email Id</th>
				<th>Image</th>
				<th>Courses</th>
				<th>Action</th>
			</tr>
			<?php 	
			$i=1;
			$select = mysqli_query($cn,"select * from tbl_school");

			while($data = mysqli_fetch_assoc($select)){ ?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php echo $data['s_name']; ?></td>
						<td><?php echo $data['s_address']; ?></td>
						<td><?php echo $data['s_mno']; ?></td>
						<td><?php echo $data['s_email']; ?></td>
						<td><img src="img/<?php echo $data['s_image']; ?>" height="100" width="100"></td>
						<td><?php echo $data['s_course']; ?></td>
						<td>
							<a class="btn btn-danger" onclick="return confirm('Are You Sure For Delete This School Record')" href="school_select.php?del=<?php echo base64_encode($data['s_id']); ?>">Delete</a>

							<a class="btn btn-success"  href="school.php?edit=<?php echo base64_encode($data['s_id']); ?>">Edit</a>
						</td>
					</tr>
			<?php 	} ?>
		</table>
	</div>

</body>
</html>