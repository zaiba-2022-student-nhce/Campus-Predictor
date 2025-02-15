<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="practice.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>College Sikhsha</title>
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
		<i class="fa fa-quote-left"></i><p>Nothing in this world can take the place of persistence. Talent will not: nothing is more common than unsuccessful men with talent. Genius will not; unrewarded genius is almost a proverb. Education will not: the world is full of educated derelicts. Persistence and determination alone are omnipotent.</p>
	</div>
	<div class="background">
		<h2>About Us</h2>
		<p>College Shiksha is a comprehensive platform designed to simplify the process of selecting courses and colleges for students aiming to pursue undergraduate (UG) and postgraduate (PG) programs in India. This web application leverages the latest web technologies and tools to provide a seamless and intuitive user experience, accessible on desktop .</p>

		<p>Comprehensive College Predictor Tools:
		1.NEET 2025 College Predictor: Helps medical aspirants predict their chances of admission based on their NEET scores.
		2.KCET 2025 College Predictor: Assists engineering aspirants in identifying potential colleges based on their KCET ranks.
		3.JEE Main 2025 College Predictor: Provides engineering aspirants with insights into their probable college admissions based on JEE Main scores.</p>

		<p>Project Vision:
			College Shiksha is committed to empowering students with the knowledge and tools they need to make informed decisions about their education and career paths. By blending domain expertise with technological innovation, we strive to provide a personalized and insightful experience that supports students in achieving their academic and professional goals.</p>

		<p>Project Milestones:
			2024: Launch of the College Shiksha platform, featuring the NEET, KCET, and JEE Main College Predictors.
			Ongoing Development: Continuous enhancement of features, integration of user feedback, and expansion of our information repository.
			</p>

			<p>Conclusion:
				College Shiksha is poised to become India's leading educational gateway, offering students a comprehensive, reliable, and user-friendly platform to navigate their educational journey. Our commitment to excellence and innovation ensures that we will continue to provide valuable resources and support to students across India.</p>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
