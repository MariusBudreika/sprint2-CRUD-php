<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addEmp</title>
</head>
<body>
<?php
    require 'connection.php';
    if (isset($_POST['create_empl'])) {
        $stmt = $conn->prepare("INSERT INTO employees (firstname, lastname, proj_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $lname, $proj_id);
        $name = $_POST['fname'];
        $lname = $_POST['lname'];
        $proj_id = $_POST['proj_id'];
        $stmt->execute();
        $stmt->close();
        header('Location: Employees.php');
        die;
    }
    ?>
    <br>
    <form action="" method="POST">
        <label for="fname">Firstname:</label><br>
        <input type="text" id="fname" name="fname" value=""><br>
        <label for="lname">Lastname:</label><br>
        <input type="text" id="lname" name="lname" value=""><br><br>
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
            } mysqli_close($conn); ?>
        </select>
        <input type="submit" name="create_empl" value="Submit">
    </form>
</body>
</html>
