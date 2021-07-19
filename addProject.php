<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addProject</title>
</head>
<body>
<?php
    require 'connection.php';
    if (isset($_POST['create_project'])) {
        $stmt = $conn->prepare("INSERT INTO projects (project) VALUES (?)");
        $stmt->bind_param("s", $project);
        $project = $_POST['project'];
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
        die;
    }
    ?>
    <br>
    <form action="" method="POST">
        <label for="project">Project name:</label><br>
        <input type="text" id="project" name="project" value=""><br>
        <input type="submit" name="create_project" value="Submit">
    </form>
</body>
</html>
