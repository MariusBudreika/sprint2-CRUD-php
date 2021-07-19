<?php
require 'connection.php';

if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $sql = 'DELETE FROM Projects WHERE id = ?';
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
    <title>Projects</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <header>
        <a href="./index.php">Projects</a>
        <a href="./employees.php">Employees</a>
        <h1>Project management</h1>
    </header>
    <?php
    $sql = "SELECT projects.id, projects.project , group_concat(CONCAT_WS(' ' , employees.firstname, employees.lastname)) as fullname FROM Projects
    LEFT JOIN employees ON projects.id = employees.proj_id
    GROUP BY projects.id;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        print('<table>');
        print('<thead>');
        print('<tr><th>Id</th><th>Name</th><th>Employee</th><th>Actions</th></tr>');
        print('</thead>');
        print('<tbody>');
        while ($row = mysqli_fetch_assoc($result)) {
            print('<tr>'
                . '<td>' . $row['id'] . '</td>'
                . '<td>' . $row['project'] . '</td>'
                . '<td>' . $row['fullname'] . '</td>'
                . '<td>' .
                '<a href="?action=delete&id='  . $row['id'] . '"><button>DELETE</button></a>'
                . '<a href="updProject.php?id='  . $row['id'] . '"><button>UPDATE</button></a>' . '</td>'
                . '</tr>');
        }
        print('</tbody>');
        print('</table>');
    } else {
        echo '0 results';
    }
    mysqli_close($conn);
    ?>
    <button class="addbutton"><a href="addProject.php">Add project</a></button>
</body>

</html>