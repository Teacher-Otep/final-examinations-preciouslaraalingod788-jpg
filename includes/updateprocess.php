<?php
include 'db.php'; 

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $middlename = $_POST['middlename'] ?? '';
    $address = $_POST['address'];
    $contact = $_POST['contact_number'];

    try {
        $sql = "UPDATE students SET Surname = ?, Middlename = ?, Name = ?, Address = ?, Contact_number = ? WHERE Id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$surname, $middlename, $name, $address, $contact, $id])) {
            header("Location: ../public/index.php?view=update&status=success");
            exit();
        }
    } catch (PDOException $e) {
        die("Error updating record: " . $e->getMessage());
    }
} else {
    header("Location: ../public/index.php");
    exit();
}
?>