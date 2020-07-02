<?php include 'inc/header.php'?>
<?php  include 'inc/connection.php'?>
   <?php $entries=connect();
        $rows=  readAll($entries)->fetchAll();
        $tags=  getTags($entries)->fetchAll();

        
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
                <div class="entry-list">
                    
                    <?php foreach($rows as $r){
                        
                        // getting the tags
                        $answer=joinTag($entries,$r["id"])->fetchALL();

                       echo                       
                        "<article>
                        <h2><a href=detail.php?id=".$r["id"].">".$r["title"]."</a></h2>
                        <time >".$r["date"]."</time>";
                     
                    foreach($answer as $a){
                        echo "<ul><li class=tags><a href=index.php?tag=".$a["id"].">".$a["name"]."</a></li></ul>";
                    }
                     echo "</article>";
                
                    }?>
                    
                    <!-- <article>
                        <h2><a href="detail.z".php">The best day I’ve ever had</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_2.php">The absolute worst day I’ve ever had</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_3.php">That time at the mall</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_4.php">Dude, where’s my car?</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article> -->
                </div>
            </div>
        </section>
        <?php include 'inc/footer.php'?>
    </body>

</html>