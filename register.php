<?php
require './database/db_connection.php';
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['phone_number']) && !empty($_POST['password'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    try {
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $count = $stmt->fetchColumn();

      if ($count > 0) {
        $error = "This email is already registered.";
      } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("
                    INSERT INTO Users (full_name, email, phone_number, password, role) 
                    VALUES (:full_name, :email, :phone_number, :password, 'customer')
                ");
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {

          $user_id = $pdo->lastInsertId();
          $_SESSION['user_id'] = $user_id;

          header("Location: index.php");
          exit();
        } else {
          $error = "Registration failed. Please try again.";
        }
      }
    } catch (PDOException $e) {
      $error = "Database error: " . $e->getMessage();
    }
  } else {
    $error = "All fields are required.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="shared/common.css">
</head>
<style>
  body {
    overflow: hidden;

    margin: 0;
    padding: 0;
  }

  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-image: url('johny.jpg');
    text-align: center;


  }

  h1 {
    color: lightgreen;
    font-size: 46px;
    margin: 0;

  }

  h3 {
    color: #1B5E20;
    font-size: 18px;
    margin: 10px 0 20px;
  }

  .error {
    color: red;
    margin-bottom: 20px;
    font-size: 14px;
  }

  form {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 500px;
    height: 450px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-top: 10px;
  }

  form label {
    margin-top: 10px;
    font-size: 14px;
    color: #333;
    font-weight: 800;
    font-size: 24px;
  }

  form input {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 18px;
  }


  .register-link {
    margin-top: 20px;
    font-size: 14px;
  }

  .register-link a {
    color: #6c63ff;
    text-decoration: none;
  }

  .register-link a:hover {
    text-decoration: underline;
  }


  a {
    color: #007bff;
    text-decoration: none;
    font-size: 24px;
  }

  p {
    font-size: 24px;
  }

  a:hover {

    background-color: white;
    color: #1B5E20;
  }



  form button {
    width: 100%;
    padding: 10px;
    margin-top: 35px;
    background-color: #1B5E20;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;

  }

  form button:hover {
    background-color: white;
    color: #1B5E20;
    border: 1px solid #1B5E20;
  }

  .back-home {
    display: inline-block;
    margin-top: 20px;
    background-color: #1B5E20;

    color: white;
    padding: 20px 30px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 24px;
    cursor: pointer;

  }

  .back-home:hover {
    background-color: white;
    color: #1B5E20;
    border-color: #1B5E20;
    border: 1px solid #1B5E20;
  }
</style>

<body>
  <div class="container">
    <h1>Create an Account</h1>

    <?php if ($error): ?>
      <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="register.php">
      <label for="full_name">Full Name:</label>
      <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>

      <button type="submit">Register</button>
    </form>

    <p>Already have an account?<a href="logIn.php">Login here</a>.</p>
    <a href="index.php" class="back-home">Go Back</a>
  </div>
</body>

</html>