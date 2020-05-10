<?php 
	include "conn.php";

	if(isset($_POST['insert'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$age = $_POST['age'];

		$insert = mysqli_query($cn,"insert into delres(name,email,age) values('$name','$email','$age')");
		header("location:delete.php");
	}

	if(isset($_GET['del'])){
		$id = $_GET['del'];
		$delete  = mysqli_query($cn,"delete from delres where id='$id'");
		header("location:delete.php");
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Delte Restore</title>
 </head>
 <body>
 		<form method="post">
 			<table align="center">
 				<tr>
 					<td>Enter Name</td>
 					<td><input type="text" name="name"></td>
 				</tr>

 				<tr>
 					<td>Enter Email</td>
 					<td><input type="email" name="email"></td>
 				</tr>

 				<tr>
 					<td>Enter Age</td>
 					<td><input type="text" name="age"></td>
 				</tr>

 				<tr align="center">
 					
 					<td colspan="2"><input type="submit" name="insert" value="Submit Data"></td>
 				</tr>
 			</table>

 			<table border="1" align="center">
 				<th>Id</th>
 				<th>Name</th>
 				<th>Email</th>
 				<th>Age</th>
 				<th>Action</th>
 				<tr>
 					<?php $i=1;
 					$select = mysqli_query($cn,"select * from delres");
 					while($data = mysqli_fetch_assoc($select)){?>
 						<td><?php echo $i++; ?></td>
 						<td><?php echo $data['name']; ?></td>
 						<td><?php echo $data['email']; ?></td>
 						<td><?php echo $data['age']; ?></td>
 						<td>
 							<a href="delete.php?del=<?php echo $data['id']; ?>">Delete</a>
 						</td>			

 				</tr>
 			<?php } ?>
 			</table>
 		</form>
 </body>
 </html>