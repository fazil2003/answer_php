<?php
include_once("database.php");
include_once("header.php");
?>

<?php
$answer_id=$_GET['answer_id'];
?>

<button onclick='history.go(-1);' id='profile_button_top'>Back</button>
<a href='delete_answer.php?answer_id=<?php echo $answer_id;?>'><button id='logout_button_top'>Delete</button></a>


<?php
if(isset($_POST['submit'])){
    $answer_id=$_GET['answer_id'];

    $answer=$_POST['answer'];

    mysqli_query($db,"UPDATE answers SET answer='$answer' WHERE id=$answer_id");
    echo "<script>goBackFunction(2);</script>";
}

$query=mysqli_query($db,"SELECT * FROM answers WHERE id=$answer_id");
while($row=mysqli_fetch_array($query)){
    $answer_text=$row['answer'];
}

?>

<center>
    <div class='container'>
        <form action='edit_answer.php?answer_id=<?php echo $answer_id; ?>' method='post'>
            <textarea id='ask_question_box' name='answer' placeholder='Type your Answer here...' required><?php echo $answer_text;?></textarea>
            
            <br><br>

            <input id='submit_btn' name='submit' type='submit' value='Update Answer' />
        </form>
    </div>
</center>