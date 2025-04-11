<link rel="stylesheet" href="./reusable/css/styles.css">
<?php
include './reusable/connection.php'; 
include './includes/functions.php'; 

// Fetching members with assigned classes and their videos
$sql = "SELECT m.member_id, m.name, m.email, m.role, m.image, 
               c.class_name, c.class_time, c.video_id
        FROM members m
        LEFT JOIN classes c ON m.class_id = c.class_id
        WHERE m.allocation_deleted_at IS NULL 
          AND c.deleted_at IS NULL
          AND m.class_id IS NOT NULL";

$result = $conn->query($sql);
?>

<?php include './reusable/header.php'; ?>
<div class="container mt-4">
<h1>Assigned Class Members</h1>
<?php

get_message(); 
?>


<div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Image</th>
                    <th>Class Name</th>
                    <th>Class Time</th>
                    <th>Class Video</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($row['role'])); ?></td>
                        <td>
                            <?php 
                            $imagePath = './reusable/images/instructors/' . htmlspecialchars($row['image']);
                            if (!empty($row['image']) && file_exists($imagePath)): ?>
                                <img src="<?php echo $imagePath; ?>" alt="Member Image" class="img-thumbnail" style="width:100px;height:100px;">
                            <?php else: ?>
                                <img src="./reusable/images/instructors/no-image.png" alt="No Image" class="img-thumbnail" style="width:100px;height:100px;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['class_name'] ?? 'No Class'); ?></td>
                        <td><?php echo isset($row['class_time']) ? date('d-m-Y H:i', strtotime($row['class_time'])) : 'No Time'; ?></td>
                        <td>
                            <?php if (!empty($row['video_id'])): ?>
                                <div class="ratio ratio-16x9" style="max-width: 200px;">
                                    <iframe src="https://www.youtube.com/embed/<?php echo htmlspecialchars($row['video_id']); ?>" allowfullscreen></iframe>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">No Video</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No assigned members found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include './reusable/footer.php'; ?>