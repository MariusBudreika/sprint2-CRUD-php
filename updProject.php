<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Project</title>
</head>

<body>
    <?php
    require 'connection.php';

        if (isset($_POST['update'])) {
            $sql = $conn->prepare("UPDATE projects SET project = ? WHERE id =?");
            $proj = $_POST['project'];
            $sql->bind_param("si", $proj, $_GET["id"]);
            $sql->execute();
            $sql->close();
            header('Location: index.php');
            die;
        }
        $sql = $conn->prepare("SELECT * FROM projects WHERE id=?");
        $sql->bind_param("i",$_GET["id"]);			
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {		
            $row = $result->fetch_assoc();
        } 
        mysqli_close($conn);
    ?>
    <h3>Update project name:</h3>
    <form method="POST">
        <input type="text" name="project" value="<?php echo $row['project'] ?>" placeholder="Enter project" Required>
        <input type="submit" name="update" value="Update">
    </form>

</body>

</html>