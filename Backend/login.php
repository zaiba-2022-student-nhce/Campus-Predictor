    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        unset($_SESSION['username']);
    }
    session_destroy();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>College Shiksha</title>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="Login.css">
        <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            /*body {
                background-image: url('b6.jpg');
                background-repeat: no-repeat;
                background-size: cover;
                background-attachment: fixed;
                background-position: center;
}           */
            .transparent-container {
            max-width: 510px;
            height: 640px;
            margin: 0 auto;
            padding: 5px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.5); /* Transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Light shadow for container */
        }
        .box {
            background-color:#003366;
            width: 400px;
            height: auto;
            padding: 0px;
            border-radius: 50px;
            color: white;
            text-align: center;
        }

            .social-container a {
                background-color: white !important;
            }
           .button {
                border: none;
                outline: none;
                background: #19bf7d;
                font-size: 20px;
                color: white;
                width: 40%;
                height: 50px;
                text-shadow: 2px 2px #000000;
                border-radius: 50px;
                transition: background-color 0.3s ease;
            }
            .button:hover {
                background-color: #128c6e; /* Change color on hover */
            }
        </style>
    </head>
    <body style="background-image:url(b6.jpg)">
    <a class="navbar-brand" href="login.php">
        <h1 style="color:#003366;"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>CampusPredictor</h1>
    </a>
    <div class="transparent-container">
    <div class="form" id="login">
        <div style="background-color:#003366" class="box">
            <h3 style="color:white">LOGIN<i class="fa fa-sign-in" style="font-size: 25px; margin-left: 5px; vertical-align: middle;"></i></h3>
            <h3 style="color:white">Welcome to CampusPredictor!!!</h3>

            <div class="social-container">
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>
            <div>
                <?php
                function test_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $login_error_message = "";

                if (isset($_POST['login'])) {
                    $username = $password = "";
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $username = test_input($_POST['Username']);
                        $password = test_input($_POST['Password']);

                        $link = mysqli_connect("localhost", "root", "", "test_db");
                        if (!$link) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $query = "SELECT * FROM usertable WHERE Username=? LIMIT 1";
                        $stmt = mysqli_prepare($link, $query);
                        mysqli_stmt_bind_param($stmt, 's', $username);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if ($row = mysqli_fetch_assoc($result)) {
                            if (password_verify($password, $row['Password'])) {
                                session_start();
                                $_SESSION['username'] = $username;
                                if ($username === 'admin') {
                                    header("Location: admin.php"); // Redirect to admin page
                                    exit();
                                } else {
                                    header("Location: home.php"); // Redirect to home page
                                    exit();
                                }
                            } else {
                                $login_error_message = "Password verification failed.";
                            }
                        } else {
                            $login_error_message = "Username not found.";
                        }
                        mysqli_close($link);
                    }
                }
                ?>
            </div>
            <div style="color: red;"><?php echo $login_error_message; ?></div>
            <form action="login.php" method="POST">
                <input class="input" type="text" name="Username" placeholder="Username" required style="background-color:white"><br>
                <input class="input" type="password" name="Password" placeholder="Password" required style="background-color:white"><br>
                <input class="button" type="submit" name="login" value="LOGIN"><br>
                <a id="oksignup" href="#" style="color:white">Sign Up here???</a>
            </form>
        </div>
    </div>
    <div class="form reg" id="signup" style="display:none;">
        <div style="background-color:#003366" class="box">
            <h3 style="color:white;">SIGN UP <i class="fa fa-user-plus" style="margin-left: 10px;"></i></h3>
            
            <div class="social-container">
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>
            <?php
            $signup_error_message = "";
            if (isset($_POST['signup'])) {
                $usernameSub = $password1 = $password2 = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $usernameSub = test_input($_POST['Username']);
                    $password1 = test_input($_POST['Password']);
                    $password2 = test_input($_POST['ConfirmPassword']);

                    if ($password1 !== $password2) {
                        $signup_error_message = "Passwords don't match";
                    } else {
                        // Passwords match, proceed with signup process
                        $link = mysqli_connect("localhost", "root", "", "test_db");
                        if (!$link) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $query = "INSERT INTO usertable (Username, Password) VALUES (?, ?)";
                        $stmt = mysqli_prepare($link, $query);
                        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, 'ss', $usernameSub, $hashed_password);

                        if (mysqli_stmt_execute($stmt)) {
                            header("Location: login.php"); // Relative path to login.php
                            exit();
                        } else {
                            $signup_error_message = "Error: " . mysqli_error($link);
                        }
                        mysqli_close($link);
                    }
                }
            }
            ?>
            <div style="color: red;"><?php echo $signup_error_message; ?></div>
            <form action="login.php" method="POST">
                
                <input class="input" type="text" name="Username" placeholder="Username" required style="background-color:white"><br>
                <input class="input" type="password" name="Password" placeholder="Password" required style="background-color:white" ><br>
                <input class="input" type="password" name="ConfirmPassword" placeholder="Confirm Password" required style="background-color:white"><br>
                <input class="button" type="submit" name="signup" value="SIGN UP"><br>
                <a id="oklogin" href="#" style="color:white">Already Have Account?? <span style="color:blue">Login Here</span></a>
            </form>
        </div>
    </div>
    </div>
    </div>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="Login.js"></script>
    <script>
    $(document).ready(function() {
        $('#oksignup').click(function() {
            $('#login').hide();
            $('#signup').show();
        });
        $('#oklogin').click(function() {
            $('#signup').hide();
            $('#login').show();
        });

        <?php if (!empty($signup_error_message)) { ?>
            $('#login').hide();
            $('#signup').show();
        <?php } elseif (!empty($login_error_message)) { ?>
            $('#login').show();
            $('#signup').hide();
        <?php } ?>
    });
    </script>
    </body>
    </html>
