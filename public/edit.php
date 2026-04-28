<?php 
include '../includes/db.php'; 

$row = null;
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE Id = ?");
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch();
}

if (!$row) { die("Student record not found."); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            padding: 20px;
        }
        .edit-card { 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.2); 
            width: 100%;
            max-width: 450px;
        }
        h2 { 
            color: #2c3e50; 
            margin-bottom: 30px; 
            font-size: 24px;
        }
        label { 
            display: block; 
            margin-top: 18px; 
            font-weight: bold; 
            font-size: 14px; 
            color: #34495e; 
        }
        input { 
            width: 100%; 
            padding: 12px; 
            margin-top: 8px; 
            border: 2px solid #ecf0f1; 
            border-radius: 6px; 
            box-sizing: border-box;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        .btn-save { 
            background: #27ae60; 
            color: white; 
            border: none; 
            width: 100%; 
            padding: 12px; 
            border-radius: 6px; 
            margin-top: 25px; 
            cursor: pointer; 
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn-save:hover {
            background: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }
        .back { 
            display: block; 
            text-align: center; 
            margin-top: 15px; 
            color: #3498db; 
            text-decoration: none; 
            font-size: 14px;
            transition: all 0.3s;
        }
        .back:hover {
            color: #2980b9;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="edit-card">
    <h2>✏️ Update Student Information</h2>
    <form action="../includes/updateprocess.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['Id'] ?? $row['id'] ?? '') ?>">
        
        <label>Surname</label>
        <input type="text" name="surname" value="<?= htmlspecialchars($row['Surname'] ?? $row['surname'] ?? '') ?>" required>
        
        <label>First Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row['Name'] ?? $row['name'] ?? '') ?>" required>
        
        <label>Middle Name</label>
        <input type="text" name="middlename" value="<?= htmlspecialchars($row['Middlename'] ?? $row['middlename'] ?? '') ?>">
        
        <label>Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($row['Address'] ?? $row['address'] ?? '') ?>">
        
        <label>Contact Number</label>
        <input type="text" name="contact_number" value="<?= htmlspecialchars($row['Contact_number'] ?? $row['contact_number'] ?? '') ?>">
        
        <button type="submit" name="update" class="btn-save">💾 Save Changes</button>
        <a href="index.php?view=update" class="back">← Back to Update Records</a>
    </form>
</div>

</body>
</html>