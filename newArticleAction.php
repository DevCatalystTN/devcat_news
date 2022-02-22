<?php
session_start();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['newArticleAction'])){//ensures that the page can only be navigated to through the sign-up button
    //provides the necessary info to access the users database
    $servername = "localhost:3306";
    $username = "theco_mpinkley";
    $password = "devcat123";
    $dbname = "theco_mpinkley";

    //forms a connection to the users database
    $conn = new mysqli($servername, $username, $password, $dbname);// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //pulls the values used in the signup form from the signup page
    $image = "<img src='".test_input($_POST['img'])."' />";
    $title = test_input($_POST['title']);
    $story = test_input($_POST['body']);
    $date = "'" . date('Y-m-d') . "'";
    $topic = test_input($_POST['topic']);

    //checks to makesure all the values are filled and not a hacker's attempt to destroy the database
    if(empty($_SESSION['userID']) || empty($title) || empty($image) || empty($story) || empty($date) || empty($topic)){
        header("Location: newArticle.php?error=fieldsempty&uid={$_SESSION['userID']}&img={$image}&body={$story}");
        exit();
    }
    //the actual creation of the article
    else{   
            $sql = "INSERT INTO news_articles(article_date, article_authorID, article_title,
             article_photo, article_content, article_topicID)
             VALUES (".$date.", ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){//if the sql doesn't run, return to the previous page with an error
                header("Location: newArticle.php?error=sqlerror");
                exit();
            }
            else{//hash the password for security, and bind parameters to strings for DB entry
                mysqli_stmt_bind_param($stmt, "isssi", $_SESSION['userID'], $title, $image, $story, $topic);
                mysqli_stmt_execute($stmt);
                header("Location: index.php?newArticleAction=success&uid=
                {$_SESSION['userID']}&img={$image}&body={$story}&date={$date}&top={$topic}");
                exit();
            }
        }
    
    //close the sql server 
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else{//return to last page with success message
    header("Location: newsIndex.php");
    exit();
}