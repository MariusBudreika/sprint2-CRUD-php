<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
</head>
<body>
    <?php
        require 'connection.php';
        if (isset($_POST['update'])) {
            $sql = $conn->prepare("UPDATE employees SET firstname = ?, lastname = ?, proj_id = ? WHERE id =?");
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $proj_id = $_POST['proj_id'];
            $sql->bind_param("ssii", $firstname, $lastname, $proj_id, $_GET["id"]);
            $sql->execute();
            $sql->close();
            header('Location: Employees.php');
        }
        $sql = $conn->prepare("SELECT * FROM employees WHERE id=?");
        $sql->bind_param("i",$_GET["id"]);			
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {		
            $row = $result->fetch_assoc();
        }
    ?>
    <h3>Update Employee Data</h3>
    <form method="POST">
        <input type="text" name="firstname" value="<?php echo $row['firstname'] ?>" placeholder="Enter first name" Required>
        <input type="text" name="lastname" value="<?php echo $row['lastname'] ?>" placeholder="Enter last name" Required>
        <select id="project" name="proj_id">
            <?php
            $sql = "SELECT id, project 
                FROM projects";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['project']; ?></option>
                    <?php 
                }
            } 
            mysqli_close($conn); 
            ?>
        </select>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>