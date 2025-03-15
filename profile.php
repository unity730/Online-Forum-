<?php
session_start();
include('database/db_connection.php'); // Include your database connection

// Assuming the user is logged in, fetch user data from the database
$user_id = $_SESSION['user_id']; // Get user ID from session

// Securely fetch user data using prepared statement
$sql = "SELECT username, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
    $profile_picture = $user['profile_picture']; // Path to profile picture or NULL
} else {
    echo "User not found.";
    exit;
}

// Handle profile picture upload if form is submitted
if (isset($_POST['submit']) && isset($_FILES['profile_picture'])) {
    // Handle the file upload
    $upload_dir = 'profile_pictures/'; // Directory to save the uploaded image
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
    }

    // Get the uploaded file details
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_name = $_FILES['profile_picture']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Set a valid file extension
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    // Check if the file extension is valid
    if (in_array($file_ext, $allowed_ext)) {
        // Create a unique filename
        $new_file_name = $upload_dir . $user_id . '.' . $file_ext;

        // Move the uploaded file to the profile pictures folder
        if (move_uploaded_file($file_tmp, $new_file_name)) {
            // Update the profile picture in the database
            $sql = "UPDATE users SET profile_picture = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_file_name, $user_id);
            $stmt->execute();

            // Update the profile picture path
            $profile_picture = $new_file_name;

            // Redirect to the dashboard after a successful upload
            header("Location: user_dashboard.php"); // Replace with your dashboard page URL
            exit(); // Make sure no further code is executed after the redirect
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        echo "Invalid file type. Please upload a valid image (jpg, jpeg, png, gif).";
    }
}

?>

<!-- Profile Picture Upload Form -->
<form action="profile.php" method="POST" enctype="multipart/form-data">
    <label for="profile_picture">Upload Profile Picture:</label>
    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required>
    <input type="submit" name="submit" value="Upload">
</form>

<?php
// Display the profile picture only if it's set (after upload)
if ($profile_picture) {
    echo '<img src="' . $profile_picture . '" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%;">';
} else {
    echo '<img src="' . generateDefaultProfilePicture($username) . '" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%;">';
}
?>

<?php

// Function to generate the default profile picture with the first letter of the username
function generateDefaultProfilePicture($username) {
    // Extract the first letter of the username
    $first_letter = strtoupper(substr($username, 0, 1));

    // Define the directory for profile pictures
    $dir = 'profile_pictures/';
    // Ensure the directory exists
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true); // Create the directory if it doesn't exist
    }

    // Generate a unique image filename based on the username's first letter
    $image_filename = $dir . strtolower($first_letter) . "_default.jpg";

    // Check if the default profile image already exists, if not, create it
    if (!file_exists($image_filename)) {
        createDefaultImage($image_filename, $first_letter);
    }

    return $image_filename;
}

// Function to create a default profile picture image with the first letter
function createDefaultImage($filename, $letter) {
    // Set image size
    $width = 100;
    $height = 100;

    // Create an image resource
    $image = imagecreatetruecolor($width, $height);

    // Set the background color (light blue)
    $bg_color = imagecolorallocate($image, 173, 216, 230); // Light blue background
    imagefill($image, 0, 0, $bg_color);

    // Set text color (dark blue)
    $text_color = imagecolorallocate($image, 0, 0, 139); // Dark blue text

    // Set font size
    $font_size = 30;

    // Ensure this is the correct path to your .ttf font file
    $font_path = 'fonts/arial.ttf'; // Example: Update the path to a valid font file

    // Check if the font file exists
    if (!file_exists($font_path)) {
        die("Font file not found: " . $font_path);
    }

    // Calculate text size and position
    $text_box = imagettfbbox($font_size, 0, $font_path, $letter);
    $x = ($width - ($text_box[2] - $text_box[0])) / 2;
    $y = ($height - ($text_box[5] - $text_box[3])) / 2;

    // Add the letter to the image
    imagettftext($image, $font_size, 0, $x, $y + 10, $text_color, $font_path, $letter);

    // Save the image to the file
    imagejpeg($image, $filename);

    // Destroy the image resource to free up memory
    imagedestroy($image);
}

?>
