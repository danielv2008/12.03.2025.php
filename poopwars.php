<?php
// Database connection details
$servername = "localhost";
$username = "new_username";  // Replace with your database username
$password = "new_password";  // Replace with your database password
$sql_store = "blog_12032025";  // Replace with your database name

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$sql_store", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve name and comment from the form
        $name = $_POST['name'];
        $comment = $_POST['comment'];

        // Check if both fields are not empty
        if (!empty($name) && !empty($comment)) {
            // SQL query to insert the new comment into the database
            $sql = "INSERT INTO comments (author, comment, created_at) VALUES (:name, :comment, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':comment', $comment);

            // Execute the query
            if ($stmt->execute()) {
                echo "Komentārs veiksmīgi pievienots!<br><hr>";
            } else {
                echo "Radās kļūda, mēģiniet vēlreiz.<br><hr>";
            }
        } else {
            echo "Lūdzu, aizpildiet visus laukus.<br><hr>";
        }
    }

    // SQL query to get all comments
    $sql = "SELECT author, comment, created_at FROM comments ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch all results
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display all comments
    if (!empty($comments)) {
        echo "<h3>Visi komentāri:</h3><ul>";
        foreach ($comments as $comment) {
            echo "<li><strong>" . htmlspecialchars($comment['author']) . ":</strong> " . nl2br(htmlspecialchars($comment['comment'])) . " <small>({$comment['created_at']})</small></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nav komentāru.</p>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
