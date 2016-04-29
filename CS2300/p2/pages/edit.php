<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>edit employee</title>
   	<link rel="stylesheet" href="../css/main.css">
    
</head>

<body id="edit">
    <div class= "upper">
        <div class="container">
        	<h2>GiveMeInternship Company</h2>
            <nav>
            <ul>
                <li><a href="../index.php">HOME</a></li>
                <li><a class="current" href="edit.php">EDIT</a></li>
                <li><a href="search.php">SEARCH</a></li>
            </ul>
            </nav>      
        </div>    
    </div>

	
	<div class="add">
	<div class="container"> 
		
		<h3>Add a coder</h3>
  			
  		<form action="edit.php" id="create_coder" method="post">
  	
  			New coder's name <br>
  			<input id="name" type="text" class="column1" name="name">
  			<br>

		  	Gender <br>
		  	<select id="gender" name="gender">
		  		<option value="man"> man </option>
		  		<option value="woman">	woman </option>
		  		<option value="other">  other </option>
		  	</select> 
			<br>

			Age<br>
			<input id="age" type="text" class="column2" name="age">
			<br> 
				
			Skill <br>
			<input type="radio" name="skill" value="JAVA"> Java <br>
			<input type="radio" name="skill" value="MySQL"> MySQL <br>
			<input type="radio" name="skill" value="C/C++"> C/C++ <br>
			<input type="radio" name="skill" value="HTML/CSS"> HTML/CSS <br>
			<input type="radio" name="skill" value="PHP"> PHP <br>
			<input type="radio" name="skill" value="python"> python <br>
			<input type="radio" name="skill" value="Javascript"> Javascript <br>
			<br>

			Rate<br>
			<input id="rate" type="text" class="column3" name="rate" placeholder="0-5"> 
			<br> 

			<button type = "submit" id= "add_new" name="add_new">Add</button>
		</form>

		<?php
		    
		$delimiter = '|';
		     
		// add a new employee
		     
		if(isset($_POST['add_new'])){
		    $name = filter_input( INPUT_POST,'name',FILTER_SANITIZE_STRING);
		    $gender = htmlentities($_POST['gender']);
	        $age = filter_input( INPUT_POST,'age',FILTER_VALIDATE_INT);
	        $skill = htmlentities($_POST['skill']);
	        $rate = filter_input( INPUT_POST,'rate',FILTER_VALIDATE_INT);
		       	
		    if(isset($_POST['skill']) && $_POST['skill']!="" && isset($name) && isset($age) && isset($rate)&& preg_match("/^[a-zA-Z][a-zA-Z ]{0,100}$/", $name) && preg_match("/^(\d?[1-9]|[1-9]0)$/", $age)&& preg_match("/^[0-5]$/", $rate)){
		        	
		       	if(!checkDuplicate("$name$delimiter$gender$delimiter$age$delimiter$skill$delimiter$rate\n")){
		        	$file = fopen("../data.txt", "a+");      
		        	if (!$file) {
		            	die("There was a problem opening the votes.txt file");
		        	}
		        	
		        	fputs($file, "$name$delimiter$gender$delimiter$age$delimiter$skill$delimiter$rate\n");
		        	fclose($file);
		        	echo "Great, We have a new employee";
		        }else{
		        	echo "We already have this employee";
		        }
		    }else{
		    	echo '<h3>Please type in a valid name or age or rate and check the box.</h3>';
		    }
		}
		
		//check if the user is already in our database

		function checkDuplicate($name)
		{
		   	if(!file_exists('../data.txt')){
   				print("<p> We don't find the database </p>");
   			}	   		
		   	$file = fopen("../data.txt", "r");
		   	$file_pointer = fopen('../data.txt', 'r');  
    		
    		if(!$file_pointer){
    			print("some error");
  				exit;
 			}
   			$info = array();

   			while(!feof ($file_pointer)){
   				$line = fgets($file_pointer);
   				
   				if($name == $line){
   					
   					return true;

   				}
   			}
   			
   			return false;
	    }


	    ?>
			
	</div>
  	</div>
</body>
</html>
