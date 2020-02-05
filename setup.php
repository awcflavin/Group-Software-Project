<?php
# login to MySQL
# set the look & feel of the page
# terminate the page

function setup_connect ()
{
$server = "cs1.ucc.ie";
$database = "2021_awf1";
$username = "awf1";
$password = "Shochel2";
$connection = mysqli_connect ($server, $username, $password, $database);
if ($connection)
 return ($connection);
return (FALSE);
}
/*
function html_begin ($title, $header)
{
print ("<html>\n");
print ("<head>\n");
if ($title != "")
print ("<title>$title</title>\n");
print ("</head>\n");
#print ("<body bgcolor=\"aqua\">\n");
print ("<h1>Welcome</h1>\n");
if ($header != "")
print ("<h2>$header</h2>\n");
}
#Terminate Page Properly
function html_end ()
{
print ("</body></html>\n");
}*/
