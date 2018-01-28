<?php
   ob_start();
   session_start();
?>

<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">
   
   <head>
      <title>Seat_Match</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      
      <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #ADABAB;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h2{
            text-align: center;
            color: #017572;
         }
      </style>
      
   </head>
	
   <body>
      
      <h2>Enter PNR and Last Name</h2> 
      <div class = "container form-signin">
         
         <?php
		 
			define('DB_SERVER', 'localhost');
			define('DB_USERNAME', 'root');
			define('DB_PASSWORD', '');
			define('DB_NAME', 'user_db');
			 
			/* Attempt to connect to MySQL database */
			$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
			 
			// Check connection
			if($link === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
		 
            // Define variables and initialize with empty values
			$pnr = $lastname = "";
			$lastname_err = $pnr_err = "";
			
			
			// Processing form data when form is submitted
			if($_SERVER["REQUEST_METHOD"] == "POST"){
 
				// Check if lastname is empty
				if(empty($_POST["lastname"])){
					$lastname_err = 'Please enter last name.';
				} else{
					$lastname = trim($_POST["lastname"]);
				}
			
				// Check if PNR is empty
				if(empty($_POST['pnr'])){
					$pnr_err = 'Please enter your PNR';
				} else{
					$pnr = trim($_POST['pnr']);
				}
			
				// Validate credentials
				if(empty($lastname_err) && empty($pnr_err)){
					// Prepare a select statement
					//echo $pnr;
					$sql = "SELECT lastname FROM user_cred WHERE pnr = $pnr";
					
					//echo $sql;
					$result = mysqli_query($link, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							if($row["lastname"] == $lastname){
								/* pnr is correct, so start a new session and
								save the pnr to the session */
								session_start();
								$_SESSION['pnr'] = $pnr;      
								header("location: welcome.php");
							} else {
								echo 'The pnr you entered was not valid.';
							}
						}
					} else {
						echo "PNR or Last Name is not Valid";
					}
					
					// Close statement
					//mysqli_stmt_close($stmt);	
				}
				
				// Close connection
				mysqli_close($link);
			}
      ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            
            <input type = "text" class = "form-control" 
               name = "pnr" placeholder = "PNR" 
               required autofocus></br>
            <input type = "text" class = "form-control"
               name = "lastname" placeholder = "Last Name" required>
			<p>
			What is your Current Seat?
			<select name="currSeat">
			  <option value="">Select...</option>
			  <option value="W">Window</option>
			  <option value="M">Middle</option>
			  <option value="A">Aisle</option>
			</select>
			</p>
			<p>
			What is your choice Seat?
			<select name="choiceSeat">
			  <option value="">Select...</option>
			  <option value="W">Window</option>
			  <option value="M">Middle</option>
			  <option value="A">Aisle</option>
			</select>
			</p>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Enter</button>
         </form>
      </div> 
      
   </body>
</html>