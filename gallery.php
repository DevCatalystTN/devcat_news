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
        
        <h2>Gallery</h2>

        <?php
        //writing the sql query and storing results
        $sql = "SELECT picture_embed FROM news_pictures ORDER BY picture_date DESC;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            //prints any query results found
            while($row = mysqli_fetch_array($result)) {
                echo "<div>{$row['picture_embed']}</div>";
            }
        } else{
            echo "could not find values in database.";//reports a lack of results
        }

        //closes the DB connection
        $conn->close();
        ?>
    </body>
</html>