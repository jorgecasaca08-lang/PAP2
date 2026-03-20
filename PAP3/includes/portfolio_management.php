<?php
// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Add new portfolio item
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_portfolio'])){
    // CSRF token validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF token validation failed.');
    }
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    // Handle secure file upload
    $upload_err = '';
    $image_path = '';
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "assets/";
        $original_filename = $_FILES["image"]["name"];
        $file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
        $safe_filename = preg_replace("/[^A-Za-z0-9_.-]/", "", basename($original_filename));
        $image_path = $target_dir . uniqid() . '_' . $safe_filename;

        // Check if file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check === false) {
            $upload_err = "File is not an image.";
        }

        // Check file size (e.g., 5MB limit)
        if ($_FILES["image"]["size"] > 5000000) {
            $upload_err = "Sorry, your file is too large.";
        }

        // Allow certain file formats
        $allowed_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array($file_extension, $allowed_types)) {
            $upload_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        if (empty($upload_err)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
                // File uploaded successfully, now insert into database
                $sql = "INSERT INTO portfolio (title, description, category, image_path) VALUES (?, ?, ?, ?)";
                if($stmt = $mysqli->prepare($sql)){
                    $stmt->bind_param("ssss", $title, $description, $category, $image_path);
                    $stmt->execute();
                }
            } else {
                $upload_err = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $upload_err = "No file uploaded or an error occurred.";
    }

    if (!empty($upload_err)) {
        // Handle upload error, e.g., display a message to the user
        echo "<div class='alert alert-danger'>" . $upload_err . "</div>";
    }
}

// Remove portfolio item
if(isset($_GET['delete_portfolio'])){
    // CSRF token validation
    if (!isset($_GET['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_GET['csrf_token'])) {
        die('CSRF token validation failed.');
    }
    $id = $_GET['delete_portfolio'];
    $sql = "DELETE FROM portfolio WHERE id = ?";
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>

<form action="admin.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <h3>Add New Portfolio Item</h3>
    <label>Title:</label>
    <input type="text" name="title" required>
    <label>Description:</label>
    <textarea name="description"></textarea>
    <label>Category:</label>
    <input type="text" name="category">
    <label>Image:</label>
    <input type="file" name="image" required>
    <input type="submit" name="add_portfolio" value="Add Item">
</form>

<h3>Existing Portfolio Items</h3>
<?php
$sql = "SELECT * FROM portfolio ORDER BY created_at DESC";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        echo "<table>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Title</th>";
                    echo "<th>Description</th>";
                    echo "<th>Category</th>";
                    echo "<th>Action</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($row = $result->fetch_array()){
                echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                    echo "<td><a href='admin.php?delete_portfolio=" . htmlspecialchars($row['id']) . "&csrf_token=" . $_SESSION['csrf_token'] . "'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</tbody>";
        echo "</table>";
        $result->free();
    } else{
        echo "<p>No portfolio items found.</p>";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
?>
