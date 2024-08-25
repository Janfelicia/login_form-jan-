<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get form data
$email = $_POST['email']; 
$password = $_POST['password']; 

// Database connection
$con = new mysqli("localhost", "root", "", "login_db");

// Check connection
if ($con->connect_error) {
    die("Failed to connect: " . $con->connect_error); 
} else {
    // Prepare the SQL statement
    $stmt = $con->prepare("SELECT * FROM login WHERE Usernmae = ?");
    $stmt->bind_param('s', $email); 
    $stmt->execute(); 
    $stmt_result = $stmt->get_result(); 

    // Check if user exists
    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc(); 
        
        // Verify the password (assuming it's hashed)
        if ($data['Password'] === $password) {
            echo "
            <div id='success-message' class='message-box'>
                <h2>You logged in successfully!!</h2>
                <button onclick='closeMessage()'>OK</button>
            </div>
            <script>
                function closeMessage() {
                    document.getElementById('success-message').style.display = 'none';
                    window.location.href = 'login.php';
                }
            </script>
            <style>
                .message-box {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: #04AA6D;
                    padding: 20px;
                    border-radius: 10px;
                    text-align: center;
                    color: white;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                    z-index: 1000;
                }
                .message-box h2 {
                    margin-bottom: 20px;
                }
                .message-box button {
                    background-color: #fff;
                    color: #04AA6D;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                }
                .message-box button:hover {
                    background-color: #e0e0e0;
                }
            </style>
            "; 
        } else {
            echo "<script>alert('Incorrect username or password!'); window.location.href='javascript:history.go(-1)';</script>";
        }

    } else {
        echo "<script>alert('congratulations! you have successfully logged in.'); window.location.href='javascript:history.go(-1)';</script>";
    }
}
?>
