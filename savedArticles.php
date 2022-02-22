<?php session_start() ?>
<!DOCTYPE html>
<html>
<body>
            
<?php
//DB creds and connection to DB
require 'dbInclude.php';
//Header code
include 'headerInclude.php';

//writing the sql query
$sql = "SELECT news_articles.article_ID, news_articles.article_title, news_articles.article_date FROM news_articles 
        RIGHT JOIN news_saved ON news_articles.article_ID = news_saved.article_ID
        WHERE news_saved.article_ID = news_articles.article_ID 
        AND news_saved.user_ID = {$_SESSION['userID']} ORDER BY article_date DESC;";
?>

<h2 class="section__title">My Articles</h2>

<?php
$result = $conn->query($sql);
//checks the database for results to the query
if ($result->num_rows > 0){
    //prints any and all results found from the query.
    while($row = mysqli_fetch_array($result)) {
        echo "
        <p class=article__link>
            {$row['article_title']} | {$row['article_date']} 
            <a href='article.php?&aid={$row['article_ID']}'>Read Article</a>
        </p>";
    }
}
//closes DB connection
$conn->close();
?>

</body>
</html>