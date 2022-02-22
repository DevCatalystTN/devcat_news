<?php

session_start();//ensures the continuation of the session before removal of values
session_unset();//empties the session of all stored values
session_destroy();//ends the session started at login

header("Location: index.php");//returns the user to the home page
exit();
