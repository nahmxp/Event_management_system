<?php
include('../db.php');

$per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

$sql = "SELECT * FROM events LIMIT $per_page OFFSET $offset";
$result = $conn->query($sql);

$total_sql = "SELECT COUNT(*) FROM events";
$total_result = $conn->query($total_sql);
$total_events = $total_result->fetch_row()[0];
$total_pages = ceil($total_events / $per_page);
?>

<!doctype html>
<html lang="en">

<head>
    <title>Event List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Event List</h2>
        <table class="table table-striped">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Capacity</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>

</html>