<?php
include_once("database.php");
?>

<?php

$limit=$_POST['limit'];
$start=$_POST['start'];

        $query=mysqli_query($db,"SELECT * FROM questions ORDER BY id DESC LIMIT $start,$limit");

        while($row=mysqli_fetch_array($query)){
               
            $user_id=$row['user_id'];
            $query_user=mysqli_query($db,"SELECT * FROM users WHERE id=$user_id");
            while($row_user=mysqli_fetch_array($query_user)){
                $row_user_name=$row_user['name'];
            }
            
            //Convert Date to Our Read Format
            $timestamp=strtotime($row['date']);
            $newDate=date('d-F-Y',$timestamp);
            

            echo "<div class='content'>";
           
            echo "<span id='name'>Asked by <b>".$row_user_name."</b> on ".$newDate."</span><br><br>";

            echo "<span id='title'>".$row['title']."</span><br>
            <span id='category'>".$row['category']."</span><br><br>";

            $query_answer=mysqli_query($db,"SELECT * FROM answers WHERE question_id=".$row['id']." ORDER BY id DESC");
            while($row_answer=mysqli_fetch_array($query_answer)){

                $user_id=$row_answer['user_id'];
                $query_user=mysqli_query($db,"SELECT * FROM users WHERE id=$user_id");
                while($row_user=mysqli_fetch_array($query_user)){
                    $row_user_name_answer=$row_user['name'];
                }

                 //Convert Date to Our Read Format
                $timestamp=strtotime($row_answer['date']);
                $newDate=date('d-F-Y',$timestamp);
                
                echo "<div class='answer_div'>";
                if(($_COOKIE['user']==$row_user_name_answer) or ($_COOKIE['user']=="admin")){
                    echo $row_answer['answer']." ";
                    echo "<a href='edit_answer.php?answer_id=".$row_answer['id']."'>";
                    echo "<button id='edit_btn_answer'>Edit Answer</button></a><br><br>";
                }
                else{
                    echo $row_answer['answer']."<br><br>";
                }
                
                echo "<span id='name'>Answered by <b>".$row_user_name_answer."</b> on ".$newDate."</span>";
                echo "</div>"; //End of answer Div
            }

            if(($_COOKIE['user']==$row_user_name) or ($_COOKIE['user']=="admin")){
                echo "<a href='edit_question.php?question_id=".$row['id']."'><button id='edit_btn'>Edit</button></a>";
            }
            else{
                if($row['max_answers']!='yes'){
                    echo "<a href='answer.php?question_id=".$row['id']."'><button id='answer_btn'>Answer</button></a>";
                }
                else{
                    echo "No more answers are accepted for this question.";
                }
            }
            echo "</div>";
        }
        ?>