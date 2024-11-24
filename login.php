<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f1f1f1;
        }

        .container {
            width: 300px;
            padding: 20px;
            background-color: #d2d2d2;
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
            font-family: 'Times New Roman', Times, serif;
        }

        p, label {
            font-size: 18px;
            font-family: 'Times New Roman', Times, serif;
            color: #333;
        }

        table {
            width: 100%;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Login Admin</h1>
        <form method="post" action="">
            <table border="0">
                <tr>
                    <td><label for="username">Username</label></td>
                    <td><input type="text" id="username" name="username" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password</label></td>
                    <td><input type="password" id="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" value="Login">
                    </td>
                </tr>
            </table>
        </form>
        <div class="message">
            <?php
            session_start();

            $message = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = $_POST['password'];

                if (empty($password)) {
                    $message = "Password harus diisi";
                } elseif ($username == 'admin' && $password == 'admin123') {
                    $_SESSION['authenticated'] = true;
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $message = "Username atau password Anda salah";
                }
            }

            if (!empty($message)) {
                echo "<center>$message</center>";
            }
            ?>
        </div>
    </div>
</body>

</html>
