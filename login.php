<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include './database/db_connection.php';
if (isset($_SESSION['user_id'])) {
  header("Location: user.php");
  exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
      $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();

      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username']; // Add username to session
        header("Location: user.php");
        header("Location: index.php");
        exit();
      } else {
        $error = "Invalid email or password.";
      }
    } catch (PDOException $e) {
      $error = "Database error: " . $e->getMessage();
    }
  } else {
    $error = "Please provide both email and password.";
  }
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./userPage_SRC/sign.css">
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
    height: 280px;
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
    <h1>Sign in to your account</h1>

    <?php if ($error): ?>
      <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="logIn.php">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>

      <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    <a href="index.php" class="back-home">Go Back</a>
  </div>
</body>

</html>