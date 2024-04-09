<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

if(isset($_GET['location_id'])) {
    $location_id = $_GET['location_id'];
    $sql = "SELECT * FROM soil_data WHERE location_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $location_id);
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
    <title>Soil Data</title>
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

        .action-btns {
            margin-top: 20px;
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
    <h1>Soil Data</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Soil Type</th>
            <th>Soil Moisture</th>
            <th>Soil pH</th>
            <th>Soil Nutrients</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Soiltype"] . "</td>";
                echo "<td>" . $row["Soilmoisture"] . "</td>";
                echo "<td>" . $row["soilPH"] . "</td>";
                echo "<td>" . $row["SoilNutrients"] . "</td>";
                echo "<td>";
                echo "<a href='compare_soil_data.php?location_id=" . $location_id . "' class='btn btn-primary'>Compare with Updated Data</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No soil data found</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="action-btns">
        <a href="location.php" class="btn btn-secondary">Go Back</a>
    </div>
</div>

</body>
</html>
