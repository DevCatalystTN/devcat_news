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

        <h2 class="section__title">Search Our Database</h2>

        <div class="search__bar">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="text" name="sid" placeholder="Search...">
                <button type="submit" name="search-button">Submit</button>
            </form>
        </div>

        <?php //checks the values input into the search field to protect against SQL injection attacks.
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $search_term = test_input($_GET['sid']);
            $search = "'%{$search_term}%'";
        }
        else{
            $search = "'%'";
        }

        //removes any potentially harmful search terms from the search query
        function test_input($data) { 
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //writes the query with the sanitized search term and stores results as a variable
        $sql = "SELECT article_ID, article_title, article_date, article_topicID FROM news_articles 
                WHERE article_title LIKE {$search};";

        $result = $conn->query($sql); 
        //checks the database for any query results
        if ($result->num_rows > 0){
            //prints all the results found from the sql query
            while($row = mysqli_fetch_array($result)) {
                $id = $row['article_ID'];
                $_GET['aid'] = $id;
                echo "
                    <p class=article__link>{$row['article_title']} | {$row['article_date']}
                    <a href='article.php?&aid={$_GET["aid"]}'>Read Article</a>
                    </p>"; 
            }
        // reports no results found.
        }else{
            echo "No Results found matching your search";
        }

        //closes the connection to the database
        $conn->close(); 
        ?>
    </body>
</html>