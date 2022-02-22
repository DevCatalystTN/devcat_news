<header class="header">
    <h1 class="page__title">DevCat News!</h1>
    <ul>
        <li><a class="header__link" href="index.php">Home</a></li>
        <li><a class="header__link" href="archives.php">Archives</a></li>
        <li><a class="header__link" href="gallery.php">Gallery</a></li>
        <li><a class="header__link" href="search.php">Search</a></li>
        <?php
        //checks if the user is logged in, prints the link to the user's saved articles, 
        if(isset($_SESSION['userID'])){
            echo '<li><a class="header__link" href="savedArticles.php">My Articles</a></li>';
            //checks to see if the user is an admin, prints the link to write a new article
            if($_SESSION['user_privledges'] === 1){
                 echo '<li><a class="header__link" href="newArticle.php">Write An Article</a></li>';
            }
        //if they're not signed in, it gives a message to tell them they need to.
        }else{
            echo 'Sign In for More Features!';
        }
        ?>
    </ul>
    
    <?php
    //checks to see if the user is logged in, displays a "Logout" button
    if(isset($_SESSION['userID'])){
        echo 
        '<form action="logoutAction.php" method="post">
            <button type="submit" name="logoutAction">Logout</button>
        </form>';
    //if the user is not logged in, displays a "Login" button
    }else{
        echo 
        '<form action="loginAction.php" method="post">
            <input type="text" name="mailuid" placeholder="Username or Email"/>
            <input type="password" name="pwd" placeholder="Password"/>
            <button type="submit" name="loginAction">Login</button>
        </form>
        <a href="signup.php">Sign Up</a>';
    }
    ?>
</header>