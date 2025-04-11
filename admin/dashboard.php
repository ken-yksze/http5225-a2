<?php
include '../reusable/connection.php';
include '../includes/functions.php';

//Fetch Count
$member_query = "SELECT COUNT(*) as total_members FROM members WHERE deleted_at IS NULL";
$member_result = $conn->query($member_query);
$total_members = $member_result->fetch_assoc()['total_members'];


$class_query = "SELECT COUNT(*) as total_classes FROM classes WHERE deleted_at IS NULL";
$class_result = $conn->query($class_query);
$total_classes = $class_result->fetch_assoc()['total_classes'];

// Fetch recent activities
$recent_members_query = "SELECT name, created_at FROM members WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 1";
$recent_classes_query = "SELECT class_name, class_time, created_at FROM classes WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 1";
$recent_assignments_query = "SELECT m.name as member_name, c.class_name, m.created_at 
                             FROM members m
                             JOIN classes c ON m.class_id = c.class_id
                             WHERE m.deleted_at IS NULL AND m.allocation_deleted_at IS NULL
                             ORDER BY m.created_at DESC LIMIT 1";

$recent_members_result = $conn->query($recent_members_query);
$recent_classes_result = $conn->query($recent_classes_query);
$recent_assignments_result = $conn->query($recent_assignments_query);


$recent_member = $recent_members_result->fetch_assoc();
$recent_class = $recent_classes_result->fetch_assoc();
$recent_assignment = $recent_assignments_result->fetch_assoc();

include '../reusable/header-admin.php';
?>

<link rel="stylesheet" href="../reusable/css/admin-styles.css">

<div class="container admin-container">
    <h1 class="admin-title text-center">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Members</h5>
                    <p class="card-text display-4"><?php echo $total_members; ?></p>
                    <a href="members.php" class="btn btn-admin-primary">View Members</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Classes</h5>
                    <p class="card-text display-4"><?php echo $total_classes; ?></p>
                    <a href="classes.php" class="btn btn-admin-primary">View Classes</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <a href="addMember.php" class="btn btn-admin-primary">Add New Member</a>
                    <a href="addClass.php" class="btn btn-admin-primary">Add New Class</a>
                    <a href="manageallocation.php" class="btn btn-admin-primary">Assign Member to Class</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Activity</h5>
                    <ul class="list-group">
                        <?php if ($recent_member): ?>
                            <li class="list-group-item">Last member added: <?php echo $recent_member['name']; ?> at
                                <?php echo $recent_member['created_at']; ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($recent_class): ?>
                            <li class="list-group-item">Last class created: <?php echo $recent_class['class_name']; ?> at
                                <?php echo $recent_class['class_time']; ?> on <?php echo $recent_class['created_at']; ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($recent_assignment): ?>
                            <li class="list-group-item">Last assignment: <?php echo $recent_assignment['member_name']; ?> to
                                <?php echo $recent_assignment['class_name']; ?> at
                                <?php echo $recent_assignment['created_at']; ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../reusable/footer-admin.php'; ?>