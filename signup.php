<?php 
	include "conn.php";

	if(isset($_POST['btn'])){
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$email=$_POST['email'];
		$dob=$_POST['dob'];
		$gender=$_POST['gender'];

		if(isset($_POST['btn'])){
			$insert=mysqli_query($cn,"insert into signup(fname,lname,email,dob,gender)values('$fname','$lname','$email','$dob','$gender')");
			
			header("location:signup.php");
		}
	}

	if(isset($_GET['del'])){
		$id=$_GET['del'];

		$upd=mysqli_query($cn,"update signup set status=0 where id='$id'");
	}


	if(isset($_GET['restore'])){
		$id=$_GET['restore'];
		$upd=mysqli_query($cn,"update signup set status=1 where id='$id'");
	}

	if(isset($_GET['edit'])){
		$id=$_GET['edit'];
		$select=mysqli_query($cn,"select * from signup where id='$id'");
		$data=mysqli_fetch_assoc($select);
	}


	if(isset($_POST['update'])){
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$email=$_POST['email'];
		$dob=$_POST['dob'];
		$gender=$_POST['gender'];

		$update=mysqli_query($cn,"update signup set fname='$fname',lname='$lname',email='$email',dob='$dob',gender='$gender' where id='$id'");
		header("location:signup.php");
	}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>New User Register</title>
 </head>
 <body>
 	<form method="post">
 		<table align="center">
 			<tr>
 				<td>Enter First Name</td>
 				<td><input type="text" name="fname" value="<?php if(isset($data)){
 					echo $data['fname'];}elseif(isset($err)){
 					echo $_POST['fname'];} ?>">
 				</td>
 			</tr>

 			<tr>
 				<td>Enter Last Name</td>
 				<td><input type="text" name="lname" value="<?php if(isset($data)){
 					echo $data['lname'];}elseif(isset($err)){
 					echo $_POST['lname'];} ?>">
 				</td>
 			</tr>


 			<tr>
 				<td>Enter Email Id</td>
 				<td><input type="email" name="email" value="<?php if(isset($data)){
 					echo $data['email'];}elseif(isset($err)){
 						echo $_POST['email'];} ?>"></td>
 			</tr>

 			<tr>
 				<td>Date Of Birth</td>
 				<td><input type="date" name="dob" value="<?php if(isset($data)){
 					echo $data['dob'];}elseif(isset($err)){
 						echo $_POST['dob'];} ?>"></td>
 			</tr>

 			<tr>
 				<td>Gender</td>
 				<td>
 					<input type="radio" name="gender" value="Male">Male
 					<input type="radio" name="gender" value="Female">Female
 				</td>
 			</tr>

 			<tr align="center">
 				<td colspan="2">
 				<?php if(isset($data)){ ?>
 					<input type="hidden" value="<?php echo $data['id'] ?>">
 					<input type="submit" name="update" value="Update">
 				<?php }else{ ?>
 					<input type="submit" name="btn" value="Sign Up">
 				<?php } ?>
 				</td>
 			</tr>
 		</table>

 		<table border="1" align="left" width="40%">
 			<tr align="center">
 				<th colspan="8">All Record</th>
 			</tr>
 			<th>Id</th>
 			<th>First Name</th>
 			<th>Last Name</th>
 			<th>Email</th>
 			<th>Date Of Birth</th>
 			<th>Gender</th>
 			<th>Action</th>

 			<tr>
 				<?php $i=1;
 				 $select=mysqli_query($cn,"select * from signup where status=1");
 				 while($data=mysqli_fetch_assoc($select)){?>
 				 	<td><?php echo $i++; ?></td>
 				 	<td><?php echo $data['fname']; ?></td>
 				 	<td><?php echo $data['lname']; ?></td>
 				 	<td><?php echo $data['email']; ?></td>
 				 	<td><?php echo $data['dob']; ?></td>
 				 	<td><?php echo $data['gender']; ?></td>
 				 	<td>
 				 		<a href="signup.php?del=<?php echo $data['id']; ?>" onclick="return confirm('you are Delete this record')">Delete</a>
 				 		<a href="signup.php?edit=<?php echo $data['id']; ?>">Edit</a>
 				 	</td>


 			</tr>
 		<?php }?>
 		</table>
 		
 		<table border="1" align="right" width="50%">
 			<tr align="center">
 				<th colspan="8">Deleted Record</th>
 			</tr>
 			<th>Id</th>
 			<th>First Name</th>
 			<th>Last Name</th>
 			<th>Email</th>
 			<th>Date Of Birth</th>
 			<th>Gender</th>
 			<th>Action</th>
 				<tr>
		 			<?php  $i=1;
		 					$select=mysqli_query($cn,"select * from signup where status=0");
		 					while($row=mysqli_fetch_assoc($select)){ ?>
		 					<td><?php echo $i++; ?></td>
		 					<td><?php echo $row['fname']; ?></td>
		 				 	<td><?php echo $row['lname']; ?></td>
		 				 	<td><?php echo $row['email']; ?></td>
		 				 	<td><?php echo $row['dob']; ?></td>
		 				 	<td><?php echo $row['gender']; ?></td>
		 				 	<td>
		 				 		<a href="signup.php?restore=<?php echo $row['id'] ?>" onclick="return confirm('you are restore this record')">Restore</a>
		 				 	</td>
		 		</tr>
		 			<?php } ?>	
  		</table>
 	</form>
 </body>
 </html>