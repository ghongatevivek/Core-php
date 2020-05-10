<?php 
	include 'conn.php';

	if(isset($_GET['del'])){
		$id=base64_decode($_GET['del']);
		$delete=mysqli_query($cn,"delete from tbl_img where img_id='$id'");

		if($delete){
			$_SESSION['msg']="Record Is Deleted...";
			header("Location:image_select.php");
			exit();
		}

	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Image Select Page</title>
 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 </head>
 <body>
 	<div class="container">
 		<?php if(isset($_SESSION['msg'])){ ?>
 			<div class="alert alert-danger">
 				<strong><?php echo $_SESSION['msg']; ?></strong>
 			</div>
 		<?php }unset($_SESSION['msg']); ?>
 		<table class="table table-hover">
 			<tr>
 				<th>Id</th>
 				<th>Name</th>
 				<th>Gender</th>
 				<th>Image</th>
 				<th>Action</th>
 			</tr>
 			<?php $select=mysqli_query($cn,"select * from tbl_img");
 			$i=1;
 			while($data=mysqli_fetch_assoc($select)){ ?>
 				<tr>
 					<td><?php echo $i++; ?></td>
 					<td><?php echo $data['name']; ?></td>
 					<td><?php echo $data['gender']; ?></td>
 					<td><img src="img/<?php echo $data['image']; ?>" width="100" height="100"></td>
 					<td>
 						<a href="image_select.php?del=<?php echo base64_encode( $data['img_id']); ?>" class="btn btn-danger" onclick="return confirm('Are You Sure For Delete This Record')">Delete</a>
 						<a href="" class="btn btn-primary">Edit</a>
 					</td>
 				</tr>

 			<?php } ?>
 		</table>
 	</div>
 
 	<script src="js/jquery-3.3.1.min"></script>
 	<script src="js/bootstrap.min.js"></script>
 </body>
 </html>