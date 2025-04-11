<?php
include '../reusable/connection.php';
include '../includes/functions.php';

// Fetch classes
$sql = "SELECT * FROM classes WHERE deleted_at IS NULL";
$result = $conn->query($sql);
?>

<?php include '../reusable/header-admin.php'; ?>

<div class="container admin-container">
    <h1 class="admin-title">Classes</h1>
    <?php get_message(); ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover admin-table">
            <thead class="table-dark">
                <tr>
                    <th>Class Name</th>
                    <th>Class Time</th>
                    <th>YouTube Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                    <td><?php echo date('d-m-Y H:i', strtotime($row['class_time'])); ?></td>
                    <td>
                        <?php if (!empty($row['video_id'])) { ?>
                            <!-- Display YouTube Video -->
                            <div class="ratio ratio-16x9" style="max-width: 200px;">
                                <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($row['video_id']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        <?php } else { ?>
                            <span class="text-muted">No Video</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="updateclass.php?id=<?php echo urlencode($row['class_id']); ?>" class="btn btn-admin-primary btn-sm">Edit</a>
                        <a href="deleteclass.php?id=<?php echo urlencode($row['class_id']); ?>" class="btn btn-admin-danger btn-sm" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../reusable/footer-admin.php'; ?>
