<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

if(isset($_GET['location_data_id'])) {
    $location_data_id = $_GET['location_data_id'];
    $sql = "SELECT * FROM updated_air_data WHERE location_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $location_data_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updated Air Data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https:
    <style>
        .navbar {
            background-color: #468847;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #6c6c6c;
        }

        .navbtns {
            float: right;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="project_owner.php" class="btn btn-primary">Go Home</a>
    <div class="navbtns">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<div class="container-fluid mt-4">
    <h1>Updated Air Data</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Air Quality</th>
            <th>Air Temperature (°C)</th>
            <th>Humidity (%)</th>
            <th>Wind Speed (km/h)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["updated_air_quality"] . "</td>";
                echo "<td>" . $row["updated_air_temperature"] . "</td>";
                echo "<td>" . $row["updated_Humidity"] . "</td>";
                echo "<td>" . $row["updated_wind_speed"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No air data found</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <a href="location_data.php" class="btn btn-secondary">Go Back</a>
</div>

</body>
</html>
