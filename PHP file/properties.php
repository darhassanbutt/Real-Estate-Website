<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Properties</title>
  <style>
    /* Reset and Global Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      color: white;
      background-color: #f4f4f4;
    }

    /* Background Grid Container */
    .background-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr); /* 3 columns for the images */
      gap: 20px; /* Space between images */
      padding: 20px; /* Padding around the entire grid */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    .background-grid img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px; /* Rounded corners for images */
      filter: blur(4px); /* Blur effect */
      transition: transform 0.3s ease-in-out;
    }

    .background-grid img:hover {
      transform: scale(1.05); /* Slight zoom-in effect on hover */
      filter: blur(4px); /* Reduce blur on hover */
    }

    /* Header */
    header {
      text-align: center;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 20px;
    }

    h1 {
      margin: 0;
      font-size: 2rem;
    }

    /* Properties Section */
    .properties-section {
      position: relative;
      text-align: center;
      margin-top: 150px;
      z-index: 1;
    }

    .properties-section h2 {
      font-size: 3rem;
      margin-bottom: 20px;
      color: rgb(255, 255, 255);
    }
    select#propertySelect {
  padding: 15px;
  font-size: 18px;
  margin: auto; /* Added margin to ensure dropdown stays below H1 */
  width: 300px; /* Larger width */
  max-width: 80%;
  border: 2px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9; /* Subtle background for dropdown */
  color: #333; /* Darker text for readability */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds depth */
  transition: all 0.3s ease; /* Smooth transitions */
  z-index: 2; /* Ensure dropdown is above other elements */
}

select#propertySelect:focus {
  border-color: #006600; /* Highlight border when focused */
  outline: none; /* Remove default focus outline */
}
button#searchButton {
  padding: 15px 30px;
  font-size: 18px;
  background-color: #006600; /* Dark green */
  color: #ffffff; /* White text */
  border: none;
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds depth */
  transition: all 0.3s ease; /* Smooth transitions */
}

button#searchButton:hover {
  background-color: #004d00; /* Darker green on hover */
  transform: scale(1.05); /* Slightly enlarges on hover */
}

button#searchButton:active {
  background-color: #003300; /* Even darker green when clicked */
  transform: scale(0.95); /* Slightly shrinks when clicked */
}

   
  </style>
</head>
<body>
    <form action="" method="post">
  <!-- Background Grid -->
  <div class="background-grid">
    <img src="2 people apartment01.png" alt="Image 1">
    <img src="hero.jpg" alt="Image 2">
    <img src="house02.png" alt="Image 3">
  </div>

  <!-- Header -->
  <header>
    <h1>RealEstate</h1>
  </header>

  <!-- Properties Section -->
  <section class="properties-section">
    <h2>Select Your Ideal Property</h2>
    <select id="propertySelect">
      <option value="" disabled selected>Select a property</option>
      <option value="2 people apartment">2 people apartment</option>
      <option value="family apartment">Family apartment</option>
      <option value="house">House</option>
      <option value="sea-facing">Sea-facing</option>
      <option value="near to city">Near to city</option>
      <option value="Beautiful Villas">Beautiful villas</option>
    </select>
    <button id="searchButton" type="button">Search</button>
  </section>
  </form>



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
</body>
</html>
<script>
    const predefinedOptions = {
      "2 people apartment": {
        url: "2-people-apartment.html",
        rent: "$600/month",
        price: "$150,000",
        bedrooms: 2,
      },
      "family apartment": {
        url: "family-apartment.html",
        rent: "$1000/month",
        price: "$250,000",
        bedrooms: 4,
      },
      "house": {
        url: "house.html",
        rent: "$1,500/month",
        price: "$500,000",
        bedrooms: 6,
      },
      "sea-facing": {
        url: "sea-facing.html",
        rent: "$2000/month",
        price: "$600,000",
        bedrooms: 3,
      },
      "near to city": {
        url: "near-to-city.html",
        rent: "$2500/month",
        price: "$1000,000",
        bedrooms: 3,
      },
      "Beautiful Villas": {
    url: "Villa.html",
    rent: "$5000/month",
    price: "$5000,000",
    bedrooms: 9,
  }
    };

    const propertySelect = document.getElementById("propertySelect");
    const searchButton = document.getElementById("searchButton");

    // Add event listener for search button
    searchButton.addEventListener("click", () => {
      const selectedProperty = propertySelect.value;

      if (selectedProperty) {
        const property = predefinedOptions[selectedProperty];
        if (property) {
            window.open(property.url, "_blank"); // Redirect to the selected property page
        } else {
          alert("Page not available for the selected property.");
        }
      } else {
        alert("Please select a property.");
      }
    });
  </script>