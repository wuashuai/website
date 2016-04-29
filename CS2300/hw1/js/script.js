// Homework 2: Javascript & jQuery //
// Please complete the following problems. Remember, you are not allowed to change the index.php file. Only this js file.

// Event listeners are pretty much what they sounds like: they listen and react to events. Sometimes called Event Handlers

// Problem 1 jQuery Event Listeners
// Add one event listener that responds to a click of any of the "Free Movie Download" buttons and pops up an alert message to users. Make up your own text for the alert message! Be creative! Surprise us!
$(document).ready(function() {
	$(".alert.download.btn").click(function() {
		alert("something wrong");
	});
});


// Problem 2 jQuery CSS
// Even though best practices suggest that you change classes  and style the classes in a separate css file rather than change CSS directly, occasionally it is necessary to edit CSS directly using JavaScript.
// Find the "Border" button on the Control Panel on the page. Add an event handler so that when it is clicked each movie is styled to have a 3px solid yellow border.

$(document).ready(function() {
	$("#border").click(function() {
		$(".movies").css("border",'yellow solid 3px');
	});
});





// Problem 3 - jQuery Toggle
// Attach an event handler / listener to the 'Toggle' button on the control panel that changes whether the descriptive text (Title, release date, running time) are visible.


$(document).ready(function() {
	$("#toggle").click(function() {
    	$("ul").toggle();	
	});
});


// Problem 4 - Loading new text
// At the bottom of the page, you'll find a "Favorite Quotes" section. Your function should add quotes there.
// On the file system, you'll find a folder called 'partials' that contains partial html files. Use the jQuery load() function to load a random quote when the "Load Quote" button is clicked.
//Each new quote should replace the old one, not an increasingly long list of quotes.
//You'll need to figure out how to make it random
//Hint: look at Math.random and Math.floor

$(document).ready(function() {
	$("#quotes").click(function() {
    	$(".quotes").load("partials/quotes_partial"+Math.floor((Math.random() * 5) )+".html");
	});
});


// Problem 5a - Helper Functions
/* For this problem, you will be writing two helper functions that will help you with the next problem. 
* The first is a function to return the running time
* If you could change index.php you might naturally put the running time in a <span> of its own 
* with a class that would allow you to easily reference it. But you can't do that so you have to work harder to 
* get the running time.
* Inside #movies-container, the elements are indexed 0 - 5 with one for each of the six movies 
* Write a function that accepts the movie index (0 for episode 1, 1 for episode 2 etc)
* as a parameter and returns the running time
*/
function runningTime(i){
	var movies = $(".movies");
	var movie = movies[i];
	var tag = movie.getElementsByTagName("li")[2].textContent.split(" ");
	var time = [];
	for (i = 0; i < tag.length; i++) { 
    	if(!isNaN(tag[i])){
    		time.push(parseInt(tag[i]));
     	}
	}
	return time;
};

// Verify that this function works. Open your browser's console and type in the following:
	// runningTime(1);
// you should get the following result:
	// 142

//Problem 5b
//Write another function that takes a movie index and a string 
//as parameters. It should replace the line containing the movie's 
//current running time with the contents of the string.

function rewrite(i, string){
	var movies = $(".movies");
	var movie = movies[i];
	var tag = movie.getElementsByTagName("li")[2];
	tag.innerText = tag.textContent = string;

}

// Verify that this function works. Type the following into your console:
//     replace(0,"Running Time: 400 minutes");
// You should see that the line: "Running Time: 133 minutes" under the first movie is replaced with "Running Time: 400 minutes"

//Problem 5c
// Test your rewrite function! Use values from the "Test Rewrite" pick list
// and text input to run your function when the user clicks the "Test" button
// If the user forgot to select a movie, give them a reminder instead of 
// running the function

$(document).ready(function() {
	$("#test_rewrite").click(function() {
    	var e = document.getElementById("rewrite_select");
		var index  = e.options[e.selectedIndex].value;
    	var string = document.getElementById("rewrite_text").value;

    	if (index >=0 || index <= 5) {
    		rewrite(index, string);
    	}else{
    		alert("please choose one movie");
    	}

    	
	});
});



// Problem 6 - Apply Helper Functions
// Use your helper functions to convert the running time format of all the movies from minutes to ___ hours ___minutes.
// Hint: Be sure to check the running time format so your function 
// responds appropriately if the time has already been converted. 
$(document).ready(function() {
	$( "#convert" ).click(function() {
	// replace below code
		if( runningTime(1).length == 1 ) {
			for (var i = 0; i < 6; i++) {
				var time = runningTime(i);
				var hour = Math.floor(time/60);
				var minutes = time%60;
				rewrite(i ,"Running Time: "+hour +" hours " + minutes + " minutes")
			}
		}
	// OPTIONAL BONUS CHALLENGE - add an "else" statement to the 
	// that converts from hours and mintues back to minutes
	// Note: Maximum score on the assigmnent is 100.
		else { 
			for (var i = 0; i < 6; i++) {
				var times = runningTime(i);
				var time = times[0] * 60 + times[1];
				rewrite(i ,"Running Time: "+ time + " minutes")
			}
		}
	});
});

// Problem 7 - Adding Class
// So far we've learned we can bind events to classes and style them with CSS, but now let's do some logic with classes.
// Write a function that can add a class 'old' to the movie posters of movies released before the year 2000 and bind it to
// the addClass button.

$(document).ready(function() {
	$("#addClass").click(function() {
    	var movies = $(".movies");
    	for(var i = 0; i < movies.length; i++){
    		var movie = movies[i];
    		var tag = movie.getElementsByTagName("li")[1].textContent.split(" ");
    		if(parseInt(tag[4]) < 2000){
    			movies[i].className += " old";
    		}
    	}	
		
	});
});


// Problem 8 - Implement ReplaceAll
// The search functionality is implemented already below for all of the movie details. 
$("#search").bind('keyup', function(){
	// for each of the paragraphs in main text
	$("ul").children().each(function(){
		//retrieve the current HTML
		var currentString = $(this).html();
		//Remove existing highlights
		currentString = replaceAll(currentString, '<span class="matched">',"");
		currentString = replaceAll(currentString, "</span>","");
		// add in new highlights
		currentString = replaceAll(currentString, $("#search").val(), '<span class="matched">$&</span>');
		// replace the current HTML with highlighted HTML
		$(this).html(currentString);
	});
});

/* Replaces all instances of "replace" with "with_this" in the string "txt"
using regular expressions -- SEE BELOW */
function replaceAll(txt, replace, with_this) {
	return txt.replace(new RegExp(replace, 'g'),with_this);
}

  
 // TODO: You must implement the ReplaceAll functionality. 
$("#replace").bind('click', function(){
	
	$("ul").children().each(function(){
		var cur = $(this).html();
		var original = document.getElementById("original").value;
		var newtext = document.getElementById("newtext").value;
	
	   	cur = replaceAll(cur,original,newtext);
	   	$(this).html(cur);

});



});

// To recieve bonus points on this assignment, see the description of Problem 6
	//Note: Maximum points for the assignment is 100. Bonus does not make it higher.
	
// Don't forget to read the published assignment which includes uploading your file to CMS.

