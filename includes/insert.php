  <?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $middlename = $_POST['middlename'] ?? '';
    $contact = $_POST['contact_number'] ?? '';
    $address = $_POST['address'] ?? '';

    try {
        $sql = "INSERT INTO students (Surname, Middlename, Name, Contact_number, Address) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$surname, $middlename, $name, $contact, $address]);

        header("Location: ../public/index.php?status=success");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: ../public/index.php");
    exit();
}
?>