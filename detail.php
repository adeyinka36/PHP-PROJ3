<?php include 'inc/header.php'?>
<?php include 'inc/connection.php'?>
<?php  
$res=null;
$identity;
 if(isset($_GET["id"])){
    $identity=filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $res=getOne($conn,$identity)->fetch();
    $entries=connect();
    $tags=  getTags($entries)->fetchAll();

 }

 ?>
 
 <?php 
     if(isset($_GET["tag"])){
        session_start();
         $_SESSION["tag"]=filter_var($_GET["tag"], FILTER_SANITIZE_NUMBER_INT);
         header("Location:tags.php");
     }
     ?>

        <section>
            <div class="container">
                <div class="entry-list single">
                <ul>
                <?php
                 $answer=joinTag($entries,$res["id"])->fetchALL();
                 
                 foreach($answer as $a){
                     echo "<li class=tags>".$a["name"]."<?li>";
                 }
                 ?>
                    </ul>
                    <article>
                        <h1><?php echo $res["title"]?></h1>
                        <time datetime="2016-01-31"><?php echo $res["date"]?></time>
                        <div class="entry">
                            <h3>Time Spent:</h3>
                            <p><?php echo $res["time_spent"]?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php  echo $res["learned"]?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <ul>
                                <!-- <li><a href="">Lorem ipsum dolor sit amet</a></li>
                                <li><a href="">Cras accumsan cursus ante, non dapibus tempor</a></li>
                                <li>Nunc ut rhoncus felis, vel tincidunt neque</li>
                                <li><a href="">Ipsum dolor sit amet</a></li> -->
                                <?php
                                echo  "<li>".$res["resources"]."</li>";
                            //     if(!empty($res["resources"])){
                            //     foreach($res["resources"] as $r){
                            //         echo  "<li>".$r."</li>";
                            //     }
                            // }
                                    ?>
                            
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
                <?php echo "<p><a href=edit.php?id=".$res["id"].">Edit Entry</a></p>";
                ?>
            </div>
        </section>
        <?php include 'inc/footer.php'?>
    </body>
</html>