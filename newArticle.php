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

        <h2 class="section__title">New Article</h2>
        <?php
        $sql = "SELECT users_ID FROM news_users WHERE users_ID = {$_SESSION['userID']};";
                $result = $conn->query($sql);//checks to see if there were any results to the query within the database
                    //makes sure there are more than 0 results
                    if ($result->num_rows > 0){ 
                        //print out the results for the query
                        while($row = mysqli_fetch_array($result)) {
                            $_GET['aid'] = $row['users_ID'];
                            
                        }
                    }
        ?>

        <form action="newArticleAction.php?&aid=" method="post">
            <input type="text" name="img" placeholder="Image src..."/>
            <input type="text" name="title" placeholder="Title..."/>
            <input type="text" name="body" placeholder="Story..."/>
            <select name="topic">
           <?php 
            $sql = "SELECT * FROM news_topics;";
            $result = $conn->query($sql);//checks to see if there were any results to the query within the database
                //makes sure there are more than 0 results
                if ($result->num_rows > 0){ 
                    //print out the results for the query
                    while($row = mysqli_fetch_array($result)) {
                        echo "<option value='{$row['topic_ID']}'>{$row['topic_name']}</option>";
                    }
                }
            ?>
            </select>
            <button type="submit" name="newArticleAction">Publish Article</button>
        </form>
    </body>
</html>