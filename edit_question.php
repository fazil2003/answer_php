<?php
include_once("database.php");
include_once("header.php");
?>

<?php
$question_id=$_GET['question_id'];
?>

<button onclick='history.go(-1);' id='profile_button_top'>Back</button>
<a href='delete_question.php?question_id=<?php echo $question_id;?>'><button id='logout_button_top'>Delete</button></a>


<?php
if(isset($_POST['submit'])){

    $question_id=$_GET['question_id'];

    $user=$_COOKIE['user'];
    $title=$_POST['question'];
    $category=$_POST['category'];

    $query=mysqli_query($db,"SELECT * FROM users WHERE name='$user'");
    while($row=mysqli_fetch_array($query)){
        $user_id=$row['id'];
    }

    mysqli_query($db,"UPDATE questions SET title='$title',category='$category',user_id=$user_id WHERE id=$question_id");
    echo "<script>goBackFunction(2);</script>";
}


$query=mysqli_query($db,"SELECT * FROM questions WHERE id=$question_id");
while($row=mysqli_fetch_array($query)){
    $question=$row['title'];
    $category=$row['category'];
    $uc_category=ucfirst($category);
}
?>

<center>
    <div class='container'>
        <form action='edit_question.php?question_id=<?php echo $question_id; ?>' method='post'>
            <textarea id='ask_question_box' name='question' placeholder='Type your Question here...' required><?php echo $question;?></textarea>

            <br><br>
			
			<?php
			$array=array('General','Animation','Architecture','Art','Automobile','Biology','Business','Chemistry','Computer-Hardware','Computer-Programming','Computer-Software','Economics','Electrical','Electronics','Environment','Fashion','Foods-and-Cooking','Gaming','Geography','Hacking','Health','History','Language','Love','Mathematics','Mechanical','Memes','Movie','Physics','Politics','Psychology','Religion','Society','Sports','Technology','Quote');
	 		echo "<select name='category' id='select_box' required>";
			echo"<option value='$category'>".$uc_category."</option>";
			for($i=0;$i<count($array);$i++){
				echo"<option value='".$array[$i]."'>".$array[$i]."</option>";
			}
			echo"</select>";
			?>

            <br><br>

            <input id='submit_btn' name='submit' type='submit' value='Update Question' />
        </form>
    </div>
</center>