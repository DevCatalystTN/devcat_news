<?php session_start() ?>

<!DOCTYPE html>
<html>
    <body>
        <?php
        //DB creds and connection to DB
        require 'dbInclude.php';
        //Header code
        include 'headerInclude.php';
        ?>

        <h2>Recent Articles</h2>

        <?php
        //defines sql query and stores result of SQL query as $result
        $sql = "SELECT article_ID, article_title, article_date 
        FROM news_articles ORDER BY article_date DESC LIMIT 5;";
        $result = $conn->query($sql);

        //checks to make sure the the query retuned results (that there were more than 0 results)
        if ($result->num_rows > 0){
            //tells the page to print database results as long as there are any.
            while($row = mysqli_fetch_array($result)) {
                $id = $row['article_ID'];
                $_GET['aid'] = $id;//makes sure you have the correct aid for the link to article.php
                echo 
                "<div>
                    <p>{$row['article_title']} | {$row['article_date']}
                    <a href='article.php?&aid={$_GET["aid"]}'>Read Article</a>
                    </p>
                </div>"; 
            }
        } 
        //tells the user if there weren't any values in the database.
        else{
            echo "could not find values in database.";
        }

        //ends connection to DB
        $conn->close();
        ?>
    </body>
</html>