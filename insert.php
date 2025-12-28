<?php
require_once("connection.php");

// Initialize variables
$id = "";
$name = "";
$sex = "";
$phone = "";
$address = "";
$class = "";
$update = false;

// --- Check if update mode ---
if(isset($_GET['update'])){
    $update = true;
    $id = $_GET['update'];

    $result = $conn->query("SELECT * FROM students WHERE id='$id'");
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $name = $row['fullname'];
        $sex = $row['sex'];
        $phone = $row['phone'];
        $address = $row['address'];
        $class = $row['class'];
    }
}

// --- Insert or Update record ---
if(isset($_POST['submit'])){
    $name = $_POST['fname'];
    $sex = isset($_POST['sex']) ? $_POST['sex'] : "";
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $class = $_POST['class'];

    // Validation
    if($name == "" || $sex == "" || $phone == "" || $address == "" || $class == ""){
        echo "<p style='color:red;text-align:center;'>All fields are required!</p>";
    } else {
        if($update){
            // Update existing student
            $sql = "UPDATE students SET fullname='$name', sex='$sex', phone='$phone', address='$address', class='$class' WHERE id='$id'";
            if($conn->query($sql) === TRUE){
                echo "<p style='color:green;text-align:center;'>Successfully updated student!</p>";
                header("Refresh:2; url=select.php");
                exit;
            } else {
                echo "<p style='color:red;text-align:center;'>Error updating: ".$conn->error."</p>";
            }
        } else {
            // Insert new student
            $result = $conn->query("SELECT MAX(CAST(id AS UNSIGNED)) AS maxid FROM students");
            $row = $result->fetch_assoc();
            $id = intval($row['maxid']) + 1;

            $sql = "INSERT INTO students (id, fullname, sex, phone, address, class) VALUES ('$id','$name','$sex','$phone','$address','$class')";
            if($conn->query($sql) === TRUE){
                echo "<p style='color:green;text-align:center;'>Successfully inserted student!</p>";
                header("Refresh:2; url=select.php");
                exit;
            } else {
                echo "<p style='color:red;text-align:center;'>Error inserting: ".$conn->error."</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $update ? "Update Record" : "Insert Record"; ?></title>
    <style>
        h1 {text-align:center;}
        fieldset {border:2px solid brown; margin:auto; width:50%; padding:20px;}
        label {display:inline-block; width:100px; vertical-align:top;}
        input[type="text"], input[type="tel"], select, textarea {margin-bottom:5px; width:70%; padding:5px;}
        .radio-group {display:inline-block; margin-right:15px;}
        input[type="submit"], input[type="reset"] {padding:5px 15px; margin-right:10px;}
    </style>
</head>
<body>
<h1><?php echo $update ? "Update Student" : "Add New Student"; ?></h1>

<form action="" method="post">
    <fieldset>
        <legend>Student Details:</legend>
        <label>ID:</label>
        <input type="text" name="id" value="<?php echo $id; ?>" readonly><br>
        <label>Full Name:</label>
        <input type="text" name="fname" value="<?php echo $name; ?>" required><br>
        <label>Sex:</label>
        <div class="radio-group">
            <input type="radio" name="sex" value="male" <?php if($sex=='male') echo 'checked'; ?>> Male
        </div>
        <div class="radio-group">
            <input type="radio" name="sex" value="female" <?php if($sex=='female') echo 'checked'; ?>> Female
        </div>
        <br><br>
        <label>Phone:</label>
        <input type="tel" name="phone" value="<?php echo $phone; ?>" required><br>
        <label>Address:</label><br>
        <textarea name="address" cols="30" rows="5" required><?php echo $address; ?></textarea><br>
        <label>Class:</label>
        <select name="class" required>
            <?php
            $classes = $conn->query("SELECT * FROM classes");
            if($classes->num_rows > 0){
                while($c = $classes->fetch_assoc()){
                    $selected = ($c['name']==$class) ? "selected" : "";
                    echo "<option value='".$c['name']."' $selected>".$c['name']."</option>";
                }
            }
            ?>
        </select><br><br>
        <input type="submit" name="submit" value="<?php echo $update ? "Update" : "Save"; ?>">
        <input type="reset" value="Clear">
    </fieldset>
</form>

<br>
<div style="text-align:center;"><a href="select.php">Back to Student List</a></div>

</body>
</html>
