<?php
include_once("database.php");
include_once("header.php");
?>

<?php
if(isset($_POST['submit'])){
    mysqli_query($db,"DELETE FROM questions WHERE id>0 LIMIT 100");
    mysqli_query($db,"DELETE FROM answers WHERE id>0 LIMIT 100");
    mysqli_query($db,"DELETE FROM email_verification WHERE id>0");
    echo "<script>goBackFunction(1);</script>";
}
?>
<center>
    <div class='container'>
        <form action='delete.php' method='post'>
            <input id='submit_btn' name='submit' type='submit' value='Delete' />
        </form>
    </div>
</center>