<?php
require 'connection.php';
if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $sql = 'DELETE FROM Employees WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $res = $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Employees</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <header>
        <a href="./index.php">Projects</a>
        <a href="./employees.php">Employees</a>
        <h1>Project management</h1>
    </header>
    <?php
    $sql = "SELECT employees.id, employees.firstname, employees.lastname, projects.project FROM employees 
    LEFT JOIN projects ON employees.proj_id = projects.id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        print('<table>');
        print('<thead>');
        print('<tr><th>Id</th><th>Name</th><th>Surname</th><th>Project</th><th>Actions</th></tr>');
        print('</thead>');
        print('<tbody>');
        while ($row = mysqli_fetch_assoc($result)) {
            print('<tr>'
                . '<td>' . $row['id'] . '</td>'
                . '<td>' . $row['firstname'] . '</td>'
                . '<td>' . $row['lastname'] . '</td>'
                . '<td>' . $row['project'] . '</td>'
                . '<td>' . '<a href="?action=delete&id='  . $row['id'] . '"><button>DELETE</button></a>'
                . '<a href="updEmp.php?id='  . $row['id'] . '"><button>UPDATE</button></a>' . '</td>'
                . '</tr>');
        }
        print('</tbody>');
        print('</table>');
    } else {
        echo '0 results';
    }
    mysqli_close($conn);
    ?>
    <button class="addbutton"><a href="addEmp.php">Add employee</a></button>
</body>

</html>