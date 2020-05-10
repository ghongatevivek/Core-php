<?php 
	include "conn.php";
 	
	if(isset($_POST['btn'])){

		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		
		$insert=mysqli_query($cn,"insert into regi(fname,lname) values('$fname','$lname')");

		if($insert){
			echo "data inserted";

		}
		else{
			echo mysqli_error($cn);
		}
		header("location:regi.php");
	}

	if(isset($_GET['del'])){
		$id=$_GET['del'];
		$delete = mysqli_query($cn,"delete from regi where id='$id'");
		header("location:regi.php");
	}

	if(isset($_GET['edit'])){

		$id=$_GET['edit'];
		$select = mysqli_query($cn,"select * from regi where id='$id'");
		$data= mysqli_fetch_assoc($select);
	}

	if(isset($_POST['update'])){
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];

		$update = mysqli_query($cn,"update regi set fname='$fname',lname='$lname' where id='$id'");
		header("location:regi.php");
	}
	
 ?>

<!DOCTYPE html>
 <html>
 <head>
 	<title>demo</title>
 </head>
 <body>
 	<form method="post">
			<table align="center">
				<tr>
					<td><input type="text"  name="fname" placeholder="Enter First Name" value="<?php if(isset($data)){
						echo $data['fname'];}elseif(isset($err)){ echo $_POST['fname'];}?>">
					</td>

				</tr>

				<tr>
					<td><input type="text"  name="lname" placeholder="Enter last Name" value="<?php if(isset($data)){
						echo $data['lname'];}elseif(isset($ree)){ echo $_POST['lname'];} ?>" ></td>
				</tr>

				<tr align="center">
					<td>
						<?php if(isset($data)){ ?>
						<input type="hidden" value="<?php echo $data['id'] ?>" name="id">
						<input type="submit" name="update"	value="Update Data">
					<?php }else{ ?>
						<input type="submit" name="btn">
					<?php } ?>

					</td>
				</tr>
			</table>
		</form>

		<table align="center" border="1">
			<th>Id</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Action</th>
			<tr>
				<?php $i=1;

				$select=mysqli_query($cn,"select * from regi");
				while($data=mysqli_fetch_assoc($select)){?>
					<td><?php echo $i++; ?></td>
					<td><?php echo $data['fname']; ?></td>
					<td><?php echo $data['lname']; ?></td>
					<td>
						<a href="regi.php?del=<?php echo $data['id'] ?>">Delete</a>
						<a href="regi.php?edit=<?php echo $data['id']?>">Edit</a>
					</td>

			</tr>
			<?php } ?>
		</table>
 </body>
 </html> 


<br /><b>Notice</b>:  Undefined variable: data in <b>D:\xampp\htdocs\demo\regi.php</b> on line <b>53</b><br />