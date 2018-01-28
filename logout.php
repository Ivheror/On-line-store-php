<?php 
session_cache_limiter();
session_name('tienda');
session_start();
session_unset('tienda');
header("Location: index.php");
exit();
?>