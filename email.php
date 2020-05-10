<?php 
	include "conn.php";

	if(isset($_POST['btn'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];

		$insert = mysqli_query($cn,"insert into email(name,email,pass) values('$name','$email','$pass')");

		if($insert){
			echo "data inserted";
		}else{
			echo "data not inserted";
		}
		header("location:email.php");
	}

	if(isset($_GET['del'])){
		$del=$_GET['del'];
		$delete=mysqli_query($cn,"delete from email where id='$del'");
		header("location:email.php");
	}

	if(isset($_GET['edit'])){
		$edit = $_GET['edit'];
		$select = mysqli_query($cn,"select * from email where id='$edit'");
		$data = mysqli_fetch_assoc($select);
	}

	if(isset($_POST['update'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];

		$update=mysqli_query($cn,"update email set name='$name',email='$email',pass='$pass' where id='$id'");
		header("location:email.php");
	}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Email</title>
 </head>
 <body>
 	<form method="post">
 		<table align="center">
 			<tr>
 				<td><input type="text" name="name" placeholder="Enter Name" value="<?php if(isset($data)){
 					echo $data['name'];}elseif(isset($err)){
 						echo $_POST['name'];} ?>"></td>
 			</tr>

 			<tr>
 				<td><input type="email" name="email" placeholder="Enter Email Id" value="<?php if(isset($data)){
 					echo $data['email'];}elseif(isset($err)){
 						echo $_POST['email.com'];} ?>"></td>
 			</tr>

 			<tr>
 				<td><input type="text" name="pass" placeholder="Enter Password" value="<?php if(isset($data)){
 					echo $data['pass'];}elseif(isset($err)){
 						echo $_POST['pass'];} ?>" ></td>
 			</tr>

 			<tr align="center">
 				<td>
 					<?php if(isset($data)){ ?>
 						<input type="hidden" value="<?php echo $data['id'] ?>">
 						<input type="submit" name="update" value="Update">
 					<?php }else{ ?>
 						<input type="submit" name="btn">
 					<?php } ?>
 				</td>
 			</tr>
 		</table>

 		<table border="1" align="center">
 			<th>Id</th>
 			<th>Name</th>
 			<th>Email</th>
 			<th>Password</th>
 			<th>Action</th>
 			<tr>
 				
 				<?php $i=1;
 				$select=mysqli_query($cn,"select * from email");
 				while($data=mysqli_fetch_assoc($select)){?>
 					<td><?php echo $i++; ?></td>
 					<td><?php echo $data['name']; ?></td>
 					<td><?php echo $data['email']; ?></td>
 					<td><?php echo $data['pass']; ?></td>
 					<td>
 						<a href="email.php?del=<?php echo $data['id'] ?>">Delete</a>
 						<a href="email.php?edit=<?php echo $data['id']?>">Edit</a>
 					</td>
 			</tr>
 		<?php } ?>
 		</table>
 	</form>
 </body>
 </html>

