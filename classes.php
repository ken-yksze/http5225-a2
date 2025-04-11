<?php
include 'reusable/connection.php';
include 'includes/functions.php';

$sql = "SELECT * FROM classes WHERE deleted_at IS NULL";
$result = $conn->query($sql);

include 'reusable/header.php';
?>

<h1 class="mb-4">Our Classes</h1>

<div class="row">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['class_name']); ?></h5>
                    <p class="card-text">
                        <strong>Time:</strong> <?php echo date('d-m-Y H:i', strtotime($row['class_time'])); ?>
                    </p>
                    <a target="_blank"
                        href="https://www.youtube.com/watch?v=<?php echo htmlspecialchars($row['video_id']); ?>"
                        class="btn btn-primary">Learn More</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php include 'reusable/footer.php'; ?>