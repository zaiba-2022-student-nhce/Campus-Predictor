
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>CampusPredictor</title>
    <style>
        /*body {
            background-image: url('b6.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }*/
        .small-img {
            width: 100px;
            height: auto;
        }
        .predictor-box {
            background-color: #f8f9fa;
            border-radius: 50px;
            padding: 20px;
            text-align: center;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
            border: 4px solid #003366; /* Add black border */
            transition: border-color 0.3s; /* Smooth transition */
        }
        .predictor-box img {
            
            width: 50px;
            height: 50px;
        }
        .predictor-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 20px 0;
        }
        .predictor-title {
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 5px;
        }
      
    .predictor-button {
        margin-top: 10px;
        display: inline-block;
        border-radius: 20px;
        background-color: #003366; /* Blue background */
        color: whitesmoke; /* White text */
        border: none; /* No border */
        padding: 10px 20px; /* Padding for better appearance */
        text-decoration: none; /* Remove underline */
        text-align: center; /* Center text */
        cursor: pointer; /* Pointer cursor */
        transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
    }

    .predictor-button:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: scale(1.05); /* Slight scale-up on hover */
    }
    .section-title {
         background-color: #003366; /* Background color for section titles */
         color:whitesmoke ; /* Text color for section titles */
         padding: 5px; /* Padding around the text */
         border-radius: 10px; /* Rounded corners */
         margin-bottom: 20px; /* Spacing at the bottom */
    }


    </style>
</head>
<body>
     <!-- Changed the class 'navbar-dark bg-dark' to 'navbar-light bg-primary' -->
     <nav class="navbar sticky-top navbar-expand-sm navbar-light" style="background-color:#003366;">
     <a class="navbar-brand" href="login.php">
        <h3 style="color:white;"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>CampusPredictor</h3>
    </a>
        <!-- Links -->   
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php" style="color: white;">
                    Home <i class="fa fa-home" aria-hidden="true" style="font-size: 24px;"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="practice.php" style="color:white;">About Us <i class="fa fa-info-circle" aria-hidden="true" style="font-size: 20px;" ></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php" style="color: white;">Not <?php if(isset($_SESSION['username'])) { echo htmlspecialchars($_SESSION['username']); } ?>? Logout <i class="fa fa-sign-out" aria-hidden="true" style="font-size: 20px;" ></i></a>
            </li>
        </ul>
    </nav>

    <div class="background">
    <p> <i class="fa fa-quote-left"></i>
       Research shows that there is only half as much variation in student achievement between schools as there is among classrooms in the same school. If you want your child to get the best education possible, it is actually more important to get him assigned to a great teacher than to a great school.
        <i class="fa fa-quote-right"></i></p>
    </div>


    <div class="predictor-container">
        <div class="predictor-box">
            <img src="kcet_logo.jpg" alt="KCET Logo">
            <div class="predictor-title">KCET 2025 College Predictor</div>
            <p>Predict your chances of getting into top colleges based on your KCET 2025 scores.</p>
            <button class="predictor-button" onclick="window.location.href='kcet_form.php'">Predict Now</button>

        </div>
        <div class="predictor-box">
            <img src="neet-logo.jpg" alt="NEET Logo">
            <div class="predictor-title">NEET 2025 College Predictor</div>
            <p>Predict your chances of getting into top medical colleges based on your NEET 2025 scores.</p>
            <button class="predictor-button" onclick="window.location.href='neet_form.php'">Predict Now</button>


        </div>
        <div class="predictor-box">
            <img src="jee_logo.jpg" alt="JEE Main Logo">
            <div class="predictor-title">JEE Main 2025 College Predictor</div>
            <p>Predict your chances of getting into top engineering colleges based on your JEE Main 2025 scores.</p>
            <button class="predictor-button" onclick="window.location.href='jeemain_form.php'">Predict Now</button>

            </div>
        </form>
    </div>

    <?php 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <script>
        function scrollToForm(formId) {
            document.getElementById(formId).scrollIntoView({behavior: 'smooth'});
        }
    </script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4xF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIE"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Colleges</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .college-card {
            width: 1110px;
            height: 150px;
            background-color: #f8f9fa;
            border-radius: 20px;
            padding: 10px;
            text-align: left;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 4px solid #003366; /* Add black border */
            transition: border-color 0.3s; /* Smooth transition */
        }
        .college-card img {
            width: 100px;
            height: 100px;
            margin-right: 15px;
            vertical-align: middle;
        }
        .college-details {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
        .college-title {
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .college-info {
            margin-top: 5px;
        }
        .college-info div {
            margin-bottom: 5px;
        }
        .college-info a {
            text-decoration: none;
            color: #007bff;
        }
        .college-rank {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
<div  class="section-title">
        <!-- KCET Colleges -->
        <h3  class="text-center"> Top 5 Colleges KCET Colleges</h3>
        </div>
    <div class="college-card">
        <div class="college-details">
            <div>
                <img src="VTU.jpg" alt="VTU Logo">
            </div>
            <div class="college-info">
                <div class="college-rank">NIRF'23 Rank: 52</div>
                <div class="college-title">Visvesvaraya Technological University (VTU)</div>
                <div>Rating: 3.9</div>
                <div><a href="https://vtu.ac.in/en/">Visit Website</a></div>
            </div>
        </div>
    </div>
    <div class="college-card">
        <div class="college-details">
            <div>
                <img src="RAM.jpg" alt="RAM Logo">
            </div>
            <div class="college-info">
                <div class="college-rank">NIRF'23 Rank: 78</div>
                <div class="college-title">MS Ramaiah Institute of Technology</div>
                <div>Rating: 4.3</div>
                <div><a href="https://www.msrit.edu/">Visit Website</a></div>
            </div>
        </div>
    </div>
    <div class="college-card">
        <div class="college-details">
            <div>
                <img src="RV.jpg" alt="RV Logo">
            </div>
            <div class="college-info">
                <div class="college-rank">NIRF'23 Rank: 96</div>
                <div class="college-title">RV College of Engineering</div>
                <div>Rating: 4.5</div>
                <div><a href="https://www.rvce.edu.in/">Visit Website</a></div>
            </div>
        </div>
    </div>
    <div class="college-card">
        <div class="college-details">
            <div>
                <img src="BMS.jpg" alt="BMS Logo">
            </div>
            <div class="college-info">
                <div class="college-rank">NIRF'23 Rank: 101-150</div>
                <div class="college-title">BMS College of Engineering</div>
                <div>Rating: 4.2</div>
                <div><a href="https://www.bmsce.ac.in/">Visit Website</a></div>
            </div>
        </div>
    </div>
    <div class="college-card">
        <div class="college-details">
            <div>
                <img src="NMAM.jpg" alt="NMAM Logo">
            </div>
            <div class="college-info">
                <div class="college-rank">NIRF'23 Rank: 101-150</div>
                <div class="college-title">NMAM Institute of Technology</div>
                <div>Rating: 3.9</div>
                <div><a href="https://nmamit.nitte.edu.in/">Visit Website</a></div>
            </div>
        </div>
    </div>
    <div  class="section-title">
        <!-- NEET Colleges -->
        <h3  class="text-center"> Top 5 Colleges NEET Colleges</h3>
        </div>
    <div class="college-card">
        <div class="college-details">
            <div>
                <img src="AIMS.jpg" alt="AIIMS Logo">
            </div>
            <div class="college-info">
                <div class="college-rank">NIRF'23 Rank: 1</div>
                <div class="college-title">AIIMS Delhi</div>
                <div>Rating: 4.9</div>
                <div><a href="https://www.aiims.edu/">Visit Website</a></div>
            </div>
        </div>
    </div>
    <div class="college-card">
        <div class="college-details">
            <div>
                <img src="CMC.jpg" alt="CMC Logo">
            </div>
            <div class="college-info">
                <div class="college-rank">NIRF'23 Rank: 3</div>
                <div class="college-title">Christian Medical College</div>
                <div>Rating: 4.8</div>
                <div><a href="https://www.cmch-vellore.edu/">Visit Website</a></div>
            </div>
        </div>
    </div>
    
    <div class="college-card">
    <div class="college-details">
        <div>
            <img src="JIPMER.jpg" alt="JIPMER Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 8</div>
            <div class="college-title">Jawaharlal Institute of Postgraduate Medical Education & Research</div>
            <div>Rating: 4.6</div>
            <div><a href="https://www.jipmer.edu.in/">Visit Website</a></div>
        </div>
    </div>
</div>
<div class="college-card">
    <div class="college-details">
        <div>
            <img src="MMC.jpg" alt="MMC Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 12</div>
            <div class="college-title">Madras Medical College</div>
            <div>Rating: 4.5</div>
            <div><a href="http://www.mmc.ac.in/">Visit Website</a></div>
        </div>
    </div>
</div>

<div class="college-card">
    <div class="college-details">
        <div>
            <img src="BHU.jpg" alt="BHU Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 6</div>
            <div class="college-title">Institute of Medical Sciences, Banaras Hindu University</div>
            <div>Rating: 4.6</div>
            <div><a href="https://www.bhu.ac.in/ims/">Visit Website</a></div>
        </div>
    </div>
</div>
<div  class="section-title">
        <!-- JEE Colleges -->
        <h3  class="text-center"> Top 5 Colleges JEE Colleges</h3>
        </div>
<div class="college-card">
    <div class="college-details">
        <div>
            <img src="IITB.jpg" alt="IIT Bombay Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 1</div>
            <div class="college-title">Indian Institute of Technology Bombay</div>
            <div>Rating: 4.9</div>
            <div><a href="http://www.iitb.ac.in/">Visit Website</a></div>
        </div>
    </div>
</div>

<div class="college-card">
    <div class="college-details">
        <div>
            <img src="IITD.jpg" alt="IIT Delhi Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 2</div>
            <div class="college-title">Indian Institute of Technology Delhi</div>
            <div>Rating: 4.8</div>
            <div><a href="http://www.iitd.ac.in/">Visit Website</a></div>
        </div>
    </div>
</div>
<div class="college-card">
    <div class="college-details">
        <div>
            <img src="IITM.jpg" alt="IIT Madras Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 3</div>
            <div class="college-title">Indian Institute of Technology Madras</div>
            <div>Rating: 4.7</div>
            <div><a href="http://www.iitm.ac.in/">Visit Website</a></div>
        </div>
    </div>
</div>
<div class="college-card">
    <div class="college-details">
        <div>
            <img src="IITK.jpg" alt="IIT Kanpur Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 4</div>
            <div class="college-title">Indian Institute of Technology Kanpur</div>
            <div>Rating: 4.6</div>
            <div><a href="http://www.iitk.ac.in/">Visit Website</a></div>
        </div>
    </div>
</div>

<div class="college-card">
    <div class="college-details">
        <div>
            <img src="IITKGP.jpg" alt="IIT Kharagpur Logo">
        </div>
        <div class="college-info">
            <div class="college-rank">NIRF'23 Rank: 5</div>
            <div class="college-title">Indian Institute of Technology Kharagpur</div>
            <div>Rating: 4.5</div>
            <div><a href="http://www.iitkgp.ac.in/">Visit Website</a></div>
        </div>
    </div>
</div>
</div><footer class="page-footer font-small" style="background-color:#1C2A4F; color:white;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Contact Us</h3>
                    <p>For any further information regarding courses or the colleges, you may reach out to us on the following numbers: </p>
                    <p><a href="tel:+1-234-567-8901" style="color:white;">+1-234-567-8901</a></p>
                    <p><a href="tel:+1-234-567-8902" style="color:white;">+1-234-567-8902</a></p>
                </div>
                <div class="col-md-4">
                    <h3>Connect With Us</h3>
                    <ul class="list-unstyled">
                        <li><a href="#" style="color:white;"><i class="fa fa-facebook"></i> Facebook</a></li>
                        <li><a href="#" style="color:white;"><i class="fa fa-twitter"></i> Twitter</a></li>
                        <li><a href="#" style="color:white;"><i class="fa fa-linkedin"></i> LinkedIn</a></li>
                        <li><a href="#" style="color:white;"><i class="fa fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>Location</h3>
                    <address>
                        123, ABC Street<br>
                        XYZ City - 123456<br>
                        Country<br>
                    </address>
                </div>
            </div>
        </div>
        <div class="text-center py-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 College Sikhsha. All rights reserved.
        </div>
    </footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4xF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIE"></script>
</body>
</html>

