<!DOCTYPE html>
<html>
<head>
<title>contact with me</title>
<link rel="stylesheet" href="../css/contact.css">
<link rel="stylesheet" href="../css/main.css">
</head>

<body id="contact">

    <div class= "upper">
        <div class="container">
            <h1>Zhongru Wu</h1>

            <nav>
            <ul>
                <li><a href="../index.php">HOME</a></li>
                <li><a href="about.html">ABOUT</a></li>
                <li><a href="trip.html">TRIP</a></li>
                <li><a class="current" href="contact.php">CONTACT</a></li>
            </ul>
            </nav>      
        </div>    
    </div>

<div id="container">     
    <div class="inside">
    
        <div class="left-part" id="map">
            <!-- This image is a screen-shot  -->
            <img id = "google-map" src="../img/map.png" alt = "map">
        </div>
        
        <div class="right-part">
            <div class="top">

                <h2><strong>How to Contact with Me</strong></h2>
                <h3>Phone: <strong>(607)379-0815</strong></h3>
                <h3>email: <strong>wuzhongru@gmail.com</strong></h3>
                <h3>Location: <strong>126 Westbourne Lane Ithaca</strong></h3>
                
            </div>
            
            <div class="bottom">
                <h2 class="email"></h2>
                <?php
                    if(isset($_POST["submit"])) {
                        $name = $_POST["name"];
                        $email = $_POST["email"];
                        $comments = $_POST["comments"];
                
                        if(isset($name) && isset($email) && preg_match("/[a-zA-Z ]+/", $name) && preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)){
                            mail('wuzhongru@gmail.com', $name.'***'.$email, $comments);
                            echo "<h3>Your message was sent successfully.<br>thank you.</h3>";
                        }
                        else {
                            echo '<h3>Please type in a valid name or Email.</h3>';
                        }
                    }
                ?>
                               
                <form id="contact_form" method="post">
                <input id="name" type="text" class="column1" placeholder="Name" name="name">
                <input id="email" type="email" class="column2" placeholder="Email Address" name="email">
                <textarea id="comments" placeholder="Comments" name="comments"></textarea>
                <button id="submit" name="submit" >Submit</button>
                </form> 
            </div>
        </div>

    </div>
</div>
    
</body>
</html>