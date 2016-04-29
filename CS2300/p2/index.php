<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>employee home</title>
    <link rel="stylesheet" href="css/main.css">
    
</head>


<body id="home">
    <div class= "upper">
    <div class="container">
        <h2>GiveMeInternship Company</h2> 
        <nav>
        <ul>
            <li><a class="current" href="home.php">HOME</a></li>
            <li><a href="pages/edit.php">EDIT</a></li>
            <li><a href="pages/search.php">SEARCH</a></li>
        </ul>
        </nav>      
    </div>    
    </div>

    <div class="home">
    <div class="container">
    	
    	<h3>Name of employee</h3>


    	<table border="1">
			<tr>
				<td>Name</td>
				<td>Gender</td>
				<td>Age</td>
				<td>Skill</td>
				<td>Rate</td>
			</tr>
	    	
	    	<?php
	    		$delimiter = '|';
	    		if(!file_exists('data.txt')){
	   				print("<p> We don't find the database </p>");
	   			}
	    		
	    		$file_pointer = fopen('data.txt', 'r');  
	    		
	    		if(! $file_pointer){
	    			print("some error");
	  				exit;
	   			}
	   			$info = array();

	   			while(! feof ($file_pointer)){
	   				$line = fgets($file_pointer);
	   				if($line != ""){
	   					$info = explode($delimiter, $line);
	   					echo "<tr>";
	   					foreach ($info as $infos) {
	   						$safe_element = htmlentities($infos);
	   						echo "<td> $safe_element </td>";
	   					}
	   					echo "</tr>";
	   				}
	   			}
	   			unset($info);
	   			unset($line);
	   			fclose($file_pointer);	
	    	?>
		</table>
	</div>
	</div>
</body>
</html>