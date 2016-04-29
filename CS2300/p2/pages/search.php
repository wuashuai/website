<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>search employee</title>
    <link rel="stylesheet" href="../css/main.css">
    
</head>


<body id="search">
    <div class= "upper">
    <div class="container">
        <h2>GiveMeInternship Company</h2>    
        <nav>
        <ul>
            <li><a href="../index.php">HOME</a></li>
            <li><a href="edit.php">EDIT</a></li>
            <li><a class="current" href="search.php">SEARCH</a></li>
        </ul>
        </nav>      
    </div>    
    </div>

    <div class="search">
    <div class="container">

        <h3>Which employees do you want to use</h3>

        <form id="search_coder" method="post">
    
            Coder's name <br>
            <input id="name" type="text" class="column1" name="name">
            <br>

            Gender <br>
            <select id="gender" name="gender">
                <option value="man"> man </option>
                <option value="woman">  woman </option>
                <option value="other">  other </option>
            </select> 
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
            <br>

            <button type = "submit" name="search">search</button>

            </form>

            <br>
            <br>
            <table border="1">
            <tr>
                <td>Name</td>
                <td>Gender</td>
                <td>Age</td>
                <td>Skill</td>
                <td>Rate</td>
            </tr>

            <?php
                if(isset($_POST["search"])){
                    
                    $name = "";
                    $gender = "";
                    $skill = "";

                    if(isset($_POST['name']) && ($_POST['name'])!=""){ 
                        $name = htmlentities($_POST['name']);
                        if(!preg_match("/^[a-zA-Z][a-zA-Z ]{0,100}$/", $name)){
                            echo "please input a valid name";
                            exit;
                        }
                    }
                    if(isset($_POST['gender'])){
                        $gender = htmlentities($_POST['gender']);
                    }
                    
                    if(isset($_POST['skill'])){
                        $skill = htmlentities($_POST['skill']);
                    }
                    if(isset($name) || isset($gender) || isset($skill)){
                        search($name, $gender, $skill);
                    }
                
                }
                

                function search($name, $gender, $skill){
                     
                    $delimiter = '|';
                    if(!file_exists('../data.txt')){
                        print("<p> We don't find the database </p>");
                    }

                    $file_pointer = fopen('../data.txt', 'r'); 
                    
                    while(! feof ($file_pointer)){
                        
                        $line = fgets($file_pointer);
                        if($line != ""){
                        $info = explode($delimiter, $line);
                        $match = true;
                        
                        if(isset($name) && $name != ""){
                            if(strcasecmp($name, $info[0]) == 0){
                                $match = $match && true;
                            }else{
                                $match = false;
                            }
                        }
                        if(isset($gender) && $gender != ""){
                            if($gender == $info[1]){
                                $match = $match && true;
                            }else{
                                $match = false;
                                
                            }
                        }
                        if(isset($skill) && $skill != "" ){
                            if($skill == $info[3]){
                                $match = $match && true;
                            }else{
                                $match = false;
                            } 
                        }

                        if($match == true){
                            echo "<tr>";
                            foreach ($info as $infos) {
                                $safe_element = htmlentities($infos);
                                echo "<td class = find> $safe_element </td>";
                            } 
                            echo "</tr>";
                        }
                        unset($info);
                        unset($line);
                        }      
                        
                    }
                    fclose($file_pointer); 
                }

            ?>
            </table>
    </div>    
    </div>

</body>
</html>




