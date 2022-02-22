<?php session_start()?>
<!DOCTYPE html>
<html>
    <body>
        <?php
        //DB creds and connection to DB
        require 'dbInclude.php';
        //Header code
        include 'headerInclude.php';
        ?>
                    
        <h2 class="section__title">Archives</h2>

        <div class="sort__bar">
            <form action="archives.php" method="get">
                <select class="drop__select" name="sort">
                    <option value="recent">Newer First</option>
                    <option value="old">Older First</option>
                    <option value="aFirst">Sort A-Z</option>
                    <option value="zFirst">Sort Z-A</option>
                </select>
                <select class="drop__select" name="topic">
                    <option value="all">All</option>
                    <option value="science">Science</option>
                    <option value="nature">Nature</option>
                    <option value="history">History</option>
                    <option value="h&b">Health and Beauty</option>
                    <option value="entertainment">Entertainment</option>
                </select>
                <input type="submit" value="Sort">
            </form>
        </div>

        <?php 
        //checks the value in the "topic" dropdown, and stores the appropriate SQL query in a variable

        if($_GET['topic'] == "science"){
            $topic = "WHERE article_topicID = 1";
        }
        else if($_GET['topic'] == "nature"){
            $topic = "WHERE article_topicID = 2";
        }
        else if($_GET['topic'] == "history"){ 
            $topic = "WHERE article_topicID = 3";
        }
        else if($_GET['topic'] == "h&b"){
            $topic = "WHERE article_topicID = 4";
        }
        else if($_GET['topic'] == "entertainment"){
            $topic = "WHERE article_topicID = 5";
        }
        else{
            $topic = "WHERE article_title LIKE '%'";
        }

        //checks the value in the "sort" dropdown, and stores the appropriate SQL query in a variable
        if($_GET['sort'] == "recent"){ 
            $sql = "SELECT article_ID, article_title, article_date, article_topicID FROM news_articles {$topic} 
                    ORDER BY article_date DESC;";
        } else if($_GET['sort'] == "old"){
            $sql = "SELECT article_ID, article_title, article_date, article_topicID FROM news_articles {$topic} 
                    ORDER BY article_date;";
        } else if($_GET['sort'] == "aFirst"){
            $sql = "SELECT article_ID, article_title, article_date, article_topicID FROM news_articles {$topic} 
                    ORDER BY article_title;";
        } else if($_GET['sort'] == "zFirst"){
            $sql = "SELECT article_ID, article_title, article_date, article_topicID FROM news_articles {$topic} 
                    ORDER BY article_title DESC;";
        } else{
            $sql = "SELECT * FROM news_articles;";
        }

        //stores results of query in a variable
        $result = $conn->query($sql); 
        //checks to make sure results were returned
        if ($result->num_rows > 0){ 
            //runs for every row of the query results
            while($row = mysqli_fetch_array($result)) {
                $id = $row['article_ID'];
                $_GET['aid'] = $id;
                echo "
                    <p class=article__link>
                    {$row['article_title']} | {$row['article_date']}
                    <a href='article.php?&aid={$_GET["aid"]}'>Read Article</a>
                    </p>"; 
            }
        //tells the user there were no results to be found for their choice
        } else{
            echo "No Results found in: {$_GET['topic']}"; 
        }

        //closes connection
        $conn->close();
        ?>
    </body>
</html>