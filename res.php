<?php 
	include "conn.php";

	if(!$cn){echo "database is note connectexd";}

	if(isset($_POST['btn'])){
		$name=$_POST['name'];
		$salary=$_POST['salary'];

		$insert = mysqli_query($cn,"insert into emp(name,salary) values('$name','$salary')");
		header("location:res.php");
		if(!$insert){
			echo mysql_error($cn);
		}
		
	}

	if(isset($_GET['del'])){
		$id=$_GET['del'];
		$upd = mysqli_query($cn,"update emp set status=0 where id='$id'");

	}

	if(isset($_GET['restore'])){
		$id=$_GET['restore'];
		$upd=mysqli_query($cn,"update emp set status=1 where id='$id'");
	}

	if(isset($_GET['edit'])){
		$id=$_GET['edit'];
		$select=mysqli_query($cn,"select * from emp");
		$data=mysqli_fetch_assoc($select);
	}

	if(isset($_POST['update'])){
		$name=$_POST['name'];
		$salary=$_POST['salary'];

		$update=mysqli_query($cn,"update emp set name='$name',salary='$salary' where id='$id'");
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete Restore Program</title>
</head>
<body>
	<form method="post">
 	<table align="center">
 		<tr>
	 		<td>Enter Emp Name</td>
	 		<td><input type="text" name="name" value="<?php if(isset($data)){
	 			echo $data['name'];}elseif(isset($err)){
	 				echo $_POST['name'];} ?>"></td>
	 	</tr>

	 	<tr>
	 		<td>Enter Emp salary</td>
	 		<td><input type="text" name="salary" value="<?php if(isset($data)){
	 			echo $data['salary'];}elseif(isset($err)){
	 				echo $_POST['salary'];} ?>"></td>
	 	</tr>

	 	<tr align="center">
	 		<td colspan="2">
	 			<?php if(isset($data)){ ?>
	 				<input type="hidden" value="<?php echo $data['id']; ?>">
	 				<input type="submit" name="update" value="Update">
	 			<?php }else{ ?>
	 				<input type="submit" name="btn" value="Insert">
	 			<?php } ?>
	 		</td>
	 	</tr>
 	</table>

 	<table border="1" align="center">
 		<th>Id</th>
 		<th>Emp Name</th>
 		<th>Salary</th>
 		<th>Action</th>
 		<tr>
 			<?php $i=1;
				$select=mysqli_query($cn,"select * from emp where status=1");
				while($data=mysqli_fetch_assoc($select)){ ?>
					<td><?php echo $i++; ?></td>
					<td><?php echo $data['name']; ?></td>
					<td><?php echo $data['salary']; ?></td>
					<td>
						<a href="res.php?del=<?php echo $data['id']; ?>">Delete</a>
						<a href="res.php?edit=<?php echo $data['id'];?>">Edit</a>
					</td>
 		</tr>
 	<?php } ?>
  	</table>

  	<table border="1" align="right">
  		<th>Id</th>
 		<th>Emp Name</th>
 		<th>Salary</th>
 		<th>Action</th>
 		<tr>
 			<?php 
 			$select=mysqli_query($cn,"select * from emp where status=0");
 			while($row=mysqli_fetch_assoc($select)){ ?>
 				<td><?php echo $row['id']; ?></td>
 				<td><?php echo $row['name']; ?></td>
 				<td><?php echo $row['salary']; ?></td>
 				<td>
 					<a href="res.php?restore=<?php echo $row['id']?>">Restore</a>
 				</td>
 		</tr>
 	<?php } ?>
  	</table>
 </form>
</body>
</html>