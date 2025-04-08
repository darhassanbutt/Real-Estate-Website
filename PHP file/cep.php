<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $property_id = intval($_POST['property_id']); // From the hidden input field

    // Validate form fields
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Save to database
    $conn = new mysqli('localhost', 'username', 'password', 'database');
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO inquiries (name, email, phone, message, property_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssi", $name, $email, $phone, $message, $property_id);

    if ($stmt->execute()) {
        echo "Inquiry submitted successfully!";

        // Send email
        $to = "admin@example.com";
        $subject = "New Inquiry for Property ID: $property_id";
        $body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
        mail($to, $subject, $body);

        // Optionally, send acknowledgment to user
        mail($email, "Thank you for your inquiry", "We’ll get back to you soon!");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
