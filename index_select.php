<?php 
	include 'conn.php';

	if(isset($_GET['del'])){
		$id=base64_decode($_GET['del']);
		$delete=mysqli_query($cn,"delete from tbl_stud where stud_id='$id'");

		if($delete){
			$_SESSION['msg']="Record Is Deleted Successfully...";
			header("Location:index_select.php");
			exit();

		}else{
			echo mysqli_error($cn);
		}
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Select Page</title>
 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 </head>
 <body>
 	<div class="container">
 		<?php if(isset($_SESSION['msg'])){ ?>
 			<div class="alert alert-danger">
 				<strong><?php echo $_SESSION['msg']; ?></strong>
 			</div>
 		<?php  } unset($_SESSION['msg']);?>

 		


 		<table class="table table-bordered" width="100%">
	 		<tr>
	 			<th>Id</th>
	 			<th>Name</th>
	 			<th>Address</th>
	 			<th>City</th>
	 			<th>Gender</th>
	 			<th>Mobile No</th>
	 			<th>Hobbies</th>
	 			<th>Image</th>
	 			<th>Email</th>
	 			<th>Action</th>
	 		</tr>
	 		<?php $select=mysqli_query($cn,"select * from tbl_stud");
	 			$i=1;
	 			while($data=mysqli_fetch_array($select)){ ?>
	 				<tr>
	 					<td><?php echo $i++; ?></td>
	 					<td><?php echo $data['name']; ?></td>
	 					<td><?php echo $data['address']; ?></td>
	 					<td><?php echo $data['city']; ?></td>
	 					<td><?php echo $data['gender']; ?></td>
	 					<td><?php echo $data['mno']; ?></td>
	 					<td><?php echo $data['hobbies']; ?></td>
	 					<td><img src="img/<?php echo $data['image']; ?>" width="100" height="100"></td>
	 					<td><?php echo $data['email']; ?></td>
	 					<td>
	 						<a href="index_select.php?del=<?php echo base64_encode( $data['stud_id']); ?>" class="btn btn-danger" onclick="return confirm('Are You Sure For Delete This Record')">Delete</a>
	 						<a href="" class="btn btn-success">Edit</a>
	 					</td>
	 				</tr>


	 		<?php } ?>
 		</table>
 	</div>
 </body>
 </html>