<?php include '../includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Management System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        
        .navbar { background: #2c3e50; padding: 20px 50px; display: flex; justify-content: space-between; align-items: center; color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .logo-section { display: flex; align-items: center; cursor: pointer; }
        .logo-circle { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; margin-right: 15px; transition: all 0.3s; }
        .logo-circle img { height: 100%; width: 100%; object-fit: contain; }
        .logo-section:hover .logo-circle { transform: scale(1.1); }
        .logo-text { font-size: 16px; font-weight: bold; }
        
        .nav-links { display: flex; gap: 10px; }
        .nav-links a { color: white; text-decoration: none; padding: 10px 18px; background: rgba(255,255,255,0.1); border-radius: 20px; font-size: 14px; transition: all 0.3s; border: 2px solid transparent; }
        .nav-links a:hover { background: #3498db; border-color: #3498db; }
        
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        
        .welcome-section { background: white; padding: 60px 40px; border-radius: 12px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .welcome-section h1 { color: #2c3e50; font-size: 36px; margin-bottom: 15px; }
        .welcome-section p { color: #666; font-size: 16px; margin-bottom: 25px; }
        .welcome-buttons { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
        .welcome-buttons a { padding: 12px 30px; border-radius: 25px; text-decoration: none; color: white; font-weight: bold; transition: all 0.3s; font-size: 14px; }
        .btn-read { background: #3498db; }
        .btn-read:hover { background: #2980b9; transform: translateY(-2px); }
        .btn-update { background: #f39c12; }
        .btn-update:hover { background: #e67e22; transform: translateY(-2px); }
        .btn-delete { background: #e74c3c; }
        .btn-delete:hover { background: #c0392b; transform: translateY(-2px); }
        .btn-add { background: #27ae60; }
        .btn-add:hover { background: #229954; transform: translateY(-2px); }
        
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); display: none; overflow-x: auto; }
        .card.active { display: block; }
        .card h2 { color: #2c3e50; margin-bottom: 20px; font-size: 24px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; min-width: 600px; }
        th { background: #34495e; color: white; padding: 15px; text-align: left; font-weight: bold; font-size: 13px; }
        td { padding: 12px 15px; border-bottom: 1px solid #ecf0f1; font-size: 13px; }
        tr:hover { background: #f8f9fa; }
        
        .btn-action { padding: 6px 12px; border-radius: 5px; text-decoration: none; color: white; font-size: 11px; font-weight: bold; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; white-space: nowrap; }
        .btn-action-edit { background: #f39c12; }
        .btn-action-edit:hover { background: #e67e22; }
        .btn-action-delete { background: #e74c3c; }
        .btn-action-delete:hover { background: #c0392b; }
        
        .back-link { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #95a5a6; color: white; text-decoration: none; border-radius: 5px; }
        .back-link:hover { background: #7f8c8d; }
        
        .empty-message { text-align: center; color: #999; padding: 40px; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo-section" onclick="window.location.href='index.php'">
        <div class="logo-circle"><img src="../images/logo.svg" alt="Student Management Logo"></div>
        <div class="logo-text">Student Management</div>
    </div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="?view=read">Read</a>
        <a href="?view=update">Update</a>
        <a href="?view=delete">Delete</a>
        <a href="add.php" class="btn-add">+ Add Student</a>
    </div>
</div>

<div class="container">
    <?php $view = $_GET['view'] ?? 'home'; ?>
    
    <!-- HOME SECTION -->
    <div class="card <?= $view == 'home' ? 'active' : '' ?>" id="home">
        <div class="welcome-section">
            <h1>Welcome to Student Management System</h1>
            <p>Manage your student records efficiently. Choose an action below:</p>
            <div class="welcome-buttons">
                <a href="?view=read" class="btn-read">📖 View Records</a>
                <a href="?view=update" class="btn-update">✏️ Update Records</a>
                <a href="?view=delete" class="btn-delete">🗑️ Delete Records</a>
                <a href="add.php" class="btn-add">➕ Add New Student</a>
            </div>
        </div>
    </div>
    
    <!-- READ SECTION -->
    <div class="card <?= $view == 'read' ? 'active' : '' ?>" id="read">
        <h2>📖 Student Records</h2>
        <?php
        $stmt = $pdo->query("SELECT * FROM students ORDER BY Id DESC");
        $students = $stmt->fetchAll();
        
        if (count($students) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id'] ?? $row['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Surname'] ?? $row['surname'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Name'] ?? $row['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Middlename'] ?? $row['middlename'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Address'] ?? $row['address'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Contact_number'] ?? $row['contact_number'] ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">No student records found.</div>
        <?php endif; ?>
        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
    
    <!-- UPDATE SECTION -->
    <div class="card <?= $view == 'update' ? 'active' : '' ?>" id="update">
        <h2>✏️ Update Student Records</h2>
        <?php
        $updateStudents = $pdo->query("SELECT * FROM students ORDER BY Id DESC")->fetchAll();
        
        if ($updateStudents): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($updateStudents as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id'] ?? $row['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars(($row['Surname'] ?? '') . ', ' . ($row['Name'] ?? '')) ?></td>
                        <td><?= htmlspecialchars($row['Address'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Contact_number'] ?? $row['contact_number'] ?? '') ?></td>
                        <td><a href="edit.php?id=<?= $row['Id'] ?? $row['id'] ?>" class="btn-action btn-action-edit">✏️ Edit</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">No student records found.</div>
        <?php endif; ?>
        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
    
    <!-- DELETE SECTION -->
    <div class="card <?= $view == 'delete' ? 'active' : '' ?>" id="delete">
        <h2>🗑️ Delete Student Records</h2>
        <?php
        $deleteStudents = $pdo->query("SELECT * FROM students ORDER BY Id DESC")->fetchAll();
        
        if ($deleteStudents): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deleteStudents as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Id'] ?? $row['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars(($row['Surname'] ?? '') . ', ' . ($row['Name'] ?? '')) ?></td>
                        <td><?= htmlspecialchars($row['Address'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['Contact_number'] ?? $row['contact_number'] ?? '') ?></td>
                        <td><a href="../includes/delete.php?id=<?= $row['Id'] ?? $row['id'] ?>" class="btn-action btn-action-delete" onclick="return confirm('Are you sure you want to delete this record?')">🗑️ Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">No student records found.</div>
        <?php endif; ?>
        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
</div>

</body>
</html>