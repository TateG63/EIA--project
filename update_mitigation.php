<?php
session_start();

if (!isset($_SESSION["user_name"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";


$measure_description = $measure_effectiveness = $measure_completion_date = "";


if (isset($_GET['measure_id'])) {
    $measure_id = $_GET['measure_id'];
    $sql = "SELECT * FROM mitigation_plan WHERE Measure_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $measure_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            $measure_description = $row["measure_description"];
            $measure_effectiveness = $row["measure_effectiveness"];
            $measure_completion_date = $row["measure_completion_date"];
        } else {
            echo "Measure not found.";
            exit;
        }
        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $measure_description = trim($_POST["measure_description"]);
    $measure_effectiveness = trim($_POST["measure_effectiveness"]);
    $measure_completion_date = trim($_POST["measure_completion_date"]);

    
    $sql = "UPDATE mitigation_plan SET measure_description=?, measure_effectiveness=?, measure_completion_date=? WHERE Measure_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $measure_description, $measure_effectiveness, $measure_completion_date, $measure_id);
        if ($stmt->execute()) {
            header("location: update_mitigation.php");
            exit;
        } else {
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Mitigation Plan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https:
</head>
<body>

<div class="container mt-4">
    <h2>Update Mitigation Plan</h2>
    <form action="update_mitigation.php" method="post">
        <div class="form-group">
            <label for="measure_description">Measure Description:</label>
            <input type="text" class="form-control" name="measure_description" value="<?php echo $measure_description; ?>">
        </div>
        <div class="form-group">
            <label for="measure_effectiveness">Measure Effectiveness:</label>
            <input type="text" class="form-control" name="measure_effectiveness" value="<?php echo $measure_effectiveness; ?>">
        </div>
        <div class="form-group">
            <label for="measure_completion_date">Measure Completion Date:</label>
            <input type="date" class="form-control" name="measure_completion_date" value="<?php echo $measure_completion_date; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Mitigation Plan</button>
        <a href="mitigation_plan.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
