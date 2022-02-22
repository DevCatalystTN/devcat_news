<?php session_start() ?>
<!DOCTYPE html>
<html>
    <body>
        <?php
        //DB creds and connection to DB
        require 'dbInclude.php';
        //Header code
        include 'headerInclude.php';

        //writing the sql query and storing the results
        $sql = "SELECT news_articles.article_ID, news_articles.article_photo, news_articles.article_title,
        news_articles.article_content, news_articles.article_date, news_articles.article_authorID, 
        news_users.users_ID, news_users.user_FName, news_users.user_LName
        FROM news_articles LEFT JOIN news_users ON news_articles.article_authorID = news_users.users_ID 
        WHERE news_articles.article_ID = " . $_GET['aid'] . ";";

        $result = $conn->query($sql);//checks to see if there were any results to the query within the database
        
        //makes sure there are more than 0 results
        if ($result->num_rows > 0){ 
            //print out the results for the query
            while($row = mysqli_fetch_array($result)) {
                //if there is an image, it displays the image
                if($row['article_photo'] != null){
                    echo "<div class='article_image'>{$row["article_photo"]}</div>";
                }
                //grabs the articleID from the URL
                $_SESSION['aid'] = $row['article_ID'];
                echo "
                    <h1 class='article__title'>{$row['article_title']}</h1>
                    <div class=article__namedate>
                        <i>{$row['user_FName']} {$row['user_LName']}, {$row['article_date']}</i>
                    </div>
                    <div class=article__body>{$row['article_content']}
                    </div>";
            }
        // reports to the user that there are no results from the query
        } else{
            echo "Couldn't find values in database.";
        }
        //checks if the user is logged in
        if(isset($_SESSION['userID'])){
            //checks to see if the user has saved this article, displays unsave button accordingly
            $sql = "SELECT user_ID, article_ID FROM news_saved
                    WHERE article_ID = {$_SESSION['aid']} AND user_ID = {$_SESSION['userID']}";
            $result = $conn->query($sql);
            
            if ($result->num_rows == 0){
                echo "<a href='saveArticleAction.php?&aid={$_SESSION['aid']}&uid={$_SESSION['userID']}'>Save Article</a>";
            }
            else if ($result->num_rows > 0){
                echo "<a href='unsaveArticleAction.php?&aid={$_SESSION['aid']}&uid={$_SESSION['userID']}'>Unsave Article</a>";
            }
        }

        //closes the database connection
        $conn->close();
        ?>
    </body>
</html>