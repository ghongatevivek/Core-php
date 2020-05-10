<?php
    include 'conn.php';
    if(isset($_POST['btn'])){
        $name=$_POST['name'];
        $mno=$_POST['mno'];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        $gender=$_POST['gender'];
        $password=$_POST['password'];

        $hobbbies=!empty($_POST['hobbies'])?implode(",",$_POST['hobbies']):""; // use ternary operator insted of if statement

        // Validation 
        if(empty($name)){
            $err['name']="Name is required";
        }elseif(!preg_match("/^[a-zA-Z]/",$name)){
            $err['name']="Name allow only character";
        }

        if(empty($mno)){
            $err['mno']="Mobile No is required";
        }elseif(!preg_match("/^[0-9]/",$mno)){
            $err['mno']="Mobile No allow only digit";
        }elseif(!preg_match("/^[0-9]{10}$/",$mno)){
            $err['mno']="Mobile No allow only 10 digit";
        }

        if(empty($email)){
            $err['email']="Email is required";
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $err['email']="Invalid Email";
        }

        if(empty($city)){
            $err['city']="City is required";
        }
        
        if(empty($password)){
            $err['password']="Password is required";
        }

        if(empty($_FILES['image']['name'])){
            $err['image']="Please Select Image";
        }

        if(!isset($err)){
            // check image upload or not
            if(move_uploaded_file($_FILES['image']['tmp_name'],"img/IMG".$_FILES['image']['name'])){
                $image="IMG".$_FILES['image']['name']; // create image name
                $addData=mysqli_query($cn,"INSERT INTO `tbl_stud` (`name`, `mno`, `email`, `address`, `city`, `hobbies`, `gender`, `image`, `password`) VALUES ('$name', '$mno', '$email', '$address', '$city', '$hobbies', '$gender', '$image', '$password');"); // Insert Query
                if($addData){
                    $_SESSION['msg']="Record Has Been Added Succesfully..."; 
                    header("Location:core.php");
                    exit;
                }else{
                    echo mysqli_error($cn); // database error
                }
            }else{
                $err['image']="Something Wrong. Please Select Another Image";
            }
        }
    }
    // delete data
    if(isset($_GET['dlt'])){
        $id=$_GET['dlt'];
        $deleteData=mysqli_query($cn,"delete from tbl_stud where student_id='$id'"); // delete Query
        if($deleteData){
            $_SESSION['msg']="Record Has Been Deleted Succesfully..."; 
            header("Location:core.php");
            exit;
        }else{
            echo mysqli_error($cn); // database error
        }
    }
    if(isset($_GET['edit'])){
        $id=$_GET['edit'];
        $getSingleData=mysqli_query($cn,"select * from tbl_stud where student_id='$id'"); // getdata Query
        $edit=mysqli_fetch_assoc($getSingleData);

        // print_r($edit);
    }

    if(isset($_POST['ubtn'])){
        $name=$_POST['name'];
        $mno=$_POST['mno'];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        $student_id=$_POST['student_id'];
        $hobbbies=!empty($_POST['hobbies'])?implode(",",$_POST['hobbies']):""; // use ternary operator insted of if statement

        // Validation 
        if(empty($name)){
            $err['name']="Name is required";
        }elseif(!preg_match("/^[a-zA-Z]/",$name)){
            $err['name']="Name allow only character";
        }

        if(empty($mno)){
            $err['mno']="Mobile No is required";
        }elseif(!preg_match("/^[0-9]/",$mno)){
            $err['mno']="Mobile No allow only digit";
        }elseif(!preg_match("/^[0-9]{10}$/",$mno)){
            $err['mno']="Mobile No allow only 10 digit";
        }

        if(empty($email)){
            $err['email']="Email is required";
        }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $err['email']="Invalid Email";
        }

        if(empty($city)){
            $err['city']="City is required";
        }


        if(!isset($err)){
            if(!empty($_FILES['image']['name'])){
                if(move_uploaded_file($_FILES['image']['tmp_name'],"img/IMG".$_FILES['image']['name'])){
                    $image="IMG".$_FILES['image']['name']; // create image name
                }else{
                    $err['image']="Something Wrong. Please Select Another Image";
                }
            }else{
                $image=$_POST['img'];
            }
            $updateData=mysqli_query($cn,"update `tbl_stud` set name='$name',mno='$mno',email='$email', address='$address',city='$city', hobbies='$hobbbies', image='$image' where student_id='$student_id'"); // Update Query
            if($updateData){
                $_SESSION['msg']="Record Has Been Updated Succesfully..."; 
                header("Location:core.php");
                exit;
            }else{
                echo mysqli_error($cn); // database error
            }
        }
    }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CORE PHP Demo</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <?php if(isset($_SESSION['msg'])){ ?>
        <div class="alert alert-success">
            <strong>Success!</strong> <?php echo $_SESSION['msg']; ?>
        </div>
        <?php } unset($_SESSION['msg']); ?>
        <!-- form start -->
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php if(isset($err)){ echo $name; }elseif(isset($edit)){ echo $edit['name']; } ?>">
                <span class="text-danger"><?php echo isset($err['name'])?$err['name']:""; ?></span>
            </div>
            <div class="form-group">
                <label>Mobile No</label>
                <input type="text" name="mno" class="form-control" value="<?php if(isset($err)){ echo $mno; }elseif(isset($edit)){ echo $edit['mno']; } ?>">
                <span class="text-danger"><?php echo isset($err['mno'])?$err['mno']:""; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php if(isset($err)){ echo $email; }elseif(isset($edit)){ echo $edit['email']; } ?>">
                <span class="text-danger"><?php echo isset($err['email'])?$err['email']:""; ?></span>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" class="form-control" ><?php if(isset($err)){ echo $address; }elseif(isset($edit)){ echo $edit['address']; } ?></textarea>
                <span class="text-danger"><?php echo isset($err['address'])?$err['address']:""; ?></span>
            </div>
            <div class="form-group">
                <label>City</label>
                <select name="city" class="form-control">
                    <option value="">Select City</option>
                    <option value="Surat" <?php if(isset($err)){ if($city=="Surat"){ echo "selected"; } }elseif(isset($edit)){ if($edit['city']=="Surat"){ echo "selected"; } }?>>Surat</option>
                    <option value="Vapi" <?php if(isset($err)){ if($city=="Vapi"){ echo "selected"; } }elseif(isset($edit)){ if($edit['city']=="Vapi"){ echo "selected"; } }?>>Vapi</option>
                </select>
                <span class="text-danger"><?php echo isset($err['city'])?$err['city']:""; ?></span>
            </div>
            <?php if(!isset($edit)){ ?>
            <div class="form-group">
                <label>Gender</label>
                <input type="radio" name="gender" value="Male" checked <?php if(isset($err)){ if($gender=="Male"){ echo "checked"; }}?>> Male
                <input type="radio" name="gender" value="Female" <?php if(isset($err)){ if($gender=="Female"){ echo "checked"; }}?>> Female
            </div>
            <?php } ?>
            <div class="form-group">
                <label>Hobbies</label>
                <input type="checkbox" name="hobbies[]" value="Reading" 
                    <?php 
                        if(isset($err) && !empty($_POST['hobbies'])){ 
                            if(in_array("Reading",$_POST['hobbies'])){ 
                                echo "checked"; 
                            } 
                        }elseif(isset($edit)){ 
                            if(in_array("Reading",explode(",",$edit['hobbies']))){ 
                                echo "checked"; 
                            } 
                        }
                    ?>
                > Reading
                <input type="checkbox" name="hobbies[]" value="Singing"
                    <?php 
                    if(isset($err) && !empty($_POST['hobbies'])){ 
                        if(in_array("Singing",$_POST['hobbies'])){ 
                            echo "checked"; 
                        } 
                    }elseif(isset($edit)){ 
                        if(in_array("Singing",explode(",",$edit['hobbies']))){ 
                            echo "checked"; 
                        } 
                    }
                ?>
                > Singing
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
                <span class="text-danger"><?php echo isset($err['image'])?$err['image']:""; ?></span>
            </div>
            <?php if(isset($edit)){ ?>
            <div class="form-group">
                <img src="img/<?php echo $edit['image']; ?>" width="100" height="100" class="img-thumbnail">
            </div>
            <?php }else{ ?>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="text-danger"><?php echo isset($err['password'])?$err['password']:""; ?></span>
            </div>
            <?php } ?>
            <div class="form-group">
                <?php if(isset($edit)){ ?>
                <input type="submit" name="ubtn" value="Update">
                <input type="hidden" value="<?php echo $edit['student_id']; ?>" name="student_id">
                <input type="hidden" value="<?php echo $edit['image']; ?>" name="img">
                <?php }else{ ?>
                    <input type="submit" name="btn">
                <?php } ?>
            </div>
        </form>
        <!-- end form -->
        <!-- start select data -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Mobile No</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>Gender </th>
                <th>Hobbies</th>
                <th>Image</th>
                <th>Actiom</th>
            </tr>
            </thead>
            <tbody>
                <?php $getData=mysqli_query($cn,"select * from tbl_stud"); 
                    if(mysqli_num_rows($getData)>0){
                        $i=1;
                        while($data=mysqli_fetch_assoc($getData)){
                ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $data['name']; ?></td>
                            <td><?php echo $data['mno']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo $data['address']; ?></td>
                            <td><?php echo $data['city']; ?></td>
                            <td><?php echo $data['gender']; ?></td>
                            <td><?php echo $data['hobbies']; ?></td>
                            <td><img src="img/<?php echo $data['image']; ?>" width="100" height="100" class="img-thumbnail"></td>
                            <td>
                                <a href="core.php?edit=<?php echo $data['student_id']; ?>" class="btn btn-success">Edit</a>
                                <a href="core.php?dlt=<?php echo $data['student_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure remove this record ?')">Delete</a>
                            </td>
                        </tr>
                <?php
                        }
                    }else{
                ?>
                        <tr>
                            <th colspan="10">No Data Found</th>
                        </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</body>
</html>
