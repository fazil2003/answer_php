<?php
include_once("database.php");
include_once("header.php");
?>


<?php
if(isset($_POST['submit'])){
    $user=$_COOKIE['user'];
    $title=$_POST['question'];
    $category=$_POST['category'];
		
	$user_id=0;
    $find_user_query=mysqli_query($db,"SELECT * FROM users WHERE name='$title'");
    while($find_user_row=mysqli_fetch_array($find_user_query)){
        $user_id=$find_user_row['id'];
    }
	
	####GOOGLE####
	$search=$title;
	$searchSplit=explode(' ',$search);
	$searchQueryItems=array();
	foreach($searchSplit as $searchTerm){
		$searchQueryItems[]="(title LIKE '%".$searchTerm."%' OR category LIKE '%".$searchTerm."%')";
	}
	$query1='SELECT * FROM questions'.(!empty($searchQueryItems)?' WHERE '.implode(' AND ',$searchQueryItems):'').' OR user_id='.$user_id.'';
	$query_s=mysqli_query($db,$query1);
	
	if(mysqli_num_rows($query_s)>0){
		header("Location:topic.php?category=".$title."");
	}
	
	else{
		$query=mysqli_query($db,"SELECT * FROM users WHERE name='$user'");
		while($row=mysqli_fetch_array($query)){
			$user_id=$row['id'];
		}

		mysqli_query($db,"INSERT INTO questions (title,category,user_id) VALUES ('$title','$category',$user_id)");
		echo "<script>goBackFunction(2);</script>";
	}
	
}
?>

<button onclick='history.go(-1);' id='profile_button_top'>Back</button>
<a href='logout.php'><button id='logout_button_top'>Logout</button></a>

<center>
    <div class='container'>
        <form action='ask.php' method='post'>
            <textarea id='ask_question_box' name='question' placeholder='Type your Question here...' required></textarea>

            <br><br>
			
			<?php
			$array=array('General','Animation','Architecture','Art','Automobile','Biology','Business','Chemistry','Computer-Hardware','Computer-Programming','Computer-Software','Economics','Electrical','Electronics','Environment','Fashion','Foods-and-Cooking','Gaming','Geography','Hacking','Health','History','Language','Love','Mathematics','Mechanical','Memes','Movie','Physics','Politics','Psychology','Religion','Society','Sports','Technology','Quote');
	 		echo "<select name='category' id='select_box' required>";
			echo "<option value=''>Select Category</option>";
			for($i=0;$i<count($array);$i++){
				echo"<option value='".$array[$i]."'>".$array[$i]."</option>";
			}
			echo"</select>";
			?>

            <br><br>

            <input id='submit_btn' name='submit' type='submit' value='Ask Question' />
        </form>
    </div>
</center>