<?php
require_once '../../includes/auth.inc.php';
require_once '../../includes/dbh.inc.php';
requireRole('admin');

// Handle approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_admin'])) {
    $adminId = (int)$_POST['admin_id'];
    
    try {
        // Check if column exists first
        $columnExists = $pdo->query("SHOW COLUMNS FROM users LIKE 'admin_approved'")->rowCount() > 0;
        
        if ($columnExists) {
            $stmt = $pdo->prepare("UPDATE users SET admin_approved = TRUE WHERE id = ? AND role = 'admin'");
        } else {
            // Fallback if column doesn't exist (shouldn't happen based on your error)
            $stmt = $pdo->prepare("UPDATE users SET is_verified = TRUE WHERE id = ? AND role = 'admin'");
        }
        
        $stmt->execute([$adminId]);
        header("Location: admin_approval.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Approval failed: " . $e->getMessage());
    }
}

// Get pending admins (check both columns)
try {
    $columnExists = $pdo->query("SHOW COLUMNS FROM users LIKE 'admin_approved'")->rowCount() > 0;
    
    if ($columnExists) {
        $pendingAdmins = $pdo->query("
            SELECT id, username, email, created_at 
            FROM users 
            WHERE role = 'admin' AND admin_approved = FALSE
        ")->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $pendingAdmins = $pdo->query("
            SELECT id, username, email, created_at 
            FROM users 
            WHERE role = 'admin' AND is_verified = FALSE
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Approvals</title>
    <link rel="stylesheet" href="../../css/output.css">
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Pending Admin Approvals</h1>
        
        <?php if (empty($pendingAdmins)): ?>
            <p>No pending admin approvals.</p>
        <?php else: ?>
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Registered</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingAdmins as $admin): ?>
                    <tr>
                        <td><?= htmlspecialchars($admin['id']) ?></td>
                        <td><?= htmlspecialchars($admin['username']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                        <td><?= htmlspecialchars($admin['created_at']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="admin_id" value="<?= $admin['id'] ?>">
                                <button type="submit" name="approve_admin" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    Approve
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>