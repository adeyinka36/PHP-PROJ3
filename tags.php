<?php include 'inc/header.php'?>
<?php include 'inc/connection.php'?>
<body>
<?php 
    $entries=connect();
    session_start();
    $mTags=matchingTags($entries,$_SESSION["tag"])->fetchAll();
    ?>
<ul>
   <?php 
   foreach($mTags as $m){
       echo "<li>".$m["title"]."</li>";
   };
?>
</ul>





<?php include 'inc/footer.php'?>
</body>
</html>