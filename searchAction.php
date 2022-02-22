<?php

if(isset($_POST['search-button'])){//ensures that the page can only be navigated to through the search button
    //DB creds and connection to DB
    require 'dbInclude.php';
    
    $search_term = $post['sid'];
    if(empty($search_term)){
        header("Location: search.php?error=fieldsempty&sid={$search_term}");
    }
}