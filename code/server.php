<?php 
$indicesServer = array('PHP_SELF', 
'SERVER_ADDR', 
'SERVER_SOFTWARE', 
'SERVER_PROTOCOL', 
'HTTP_HOST', 
'HTTPS', 
'SERVER_PORT') ; 

echo '<table cellpadding="10">' ; 
foreach ($indicesServer as $arg) { 
    if (isset($_SERVER[$arg])) { 
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
    } 
    else { 
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
    } 
} 
echo '</table>' ; 

?>
