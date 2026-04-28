<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM students WHERE Id = ?");
        $stmt->execute([$id]);
        
        header("Location: ../public/index.php?view=delete&status=success");
        exit();
    } catch (PDOException $e) {
        die("Error deleting record: " . $e->getMessage());
    }
} else {
    header("Location: ../public/index.php");
    exit();
}
?>