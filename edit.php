<?php include 'inc/header.php'?>
<?php include 'inc/connection.php'?>
<?php  
$res=null;
session_start();
$identity=null;
 if(isset($_GET["id"])){
    $identity=filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);
    $_SESSION["id"]=$identity;
    $res=getOne($conn,$identity)->fetch();

  
    // var_dump($res);die();
    
   
 }

 if(isset($_GET["del"])){
     $delete=$_GET["del"];
   
    delete($conn,$delete);
    session_destroy();
    header("Location:index.php");
 }


//  edit on form submission

    $title = null;
    $date =null;
    $time_spent = null;
    $learned = null;
    $resources = null;
  
if(isset($_POST["title"])){
    echo "true";
  if(filter_has_var(INPUT_POST,"title")){
      $title = $_POST["title"];
  }
    if(filter_has_var(INPUT_POST,"timeSpent")){
    $time_spent= $_POST["timeSpent"];
}
  
if(filter_has_var(INPUT_POST,"resources")){
    $resources = $_POST["resources"];
}
  
if(filter_has_var(INPUT_POST,"learned")){
    $learned = $_POST["learned"];
}
 $date=date("Y")."-".date("m")."-".date("d");
// redirect after form submission

edit($conn,$title,$date,$time_spent,$learned,$resources);
    $title = null;
    $date =null;
    $time_spent = null;
    $learned = null;
    $resources = null;
    
//header("Location:index.php");
}

 ?>

        </header>
        <section>
            <div class="container">
                <div class="edit-entry">
                    <h2>Edit Entry</h2>
                    <form method="post" action="edit.php">
                        <label for="title">Title</label>
                       <?php echo "<input id=title type=text name=title value='".$res["title"]."'>"?><br>
                        <label for="date">Date</label>
                        <?php echo "<input id=title type=text name=date value='".$res["date"]."'>"?><br>
                        <label for="time-spent"> Time Spent</label>
                        <?php echo "<input id=title type=text name=timeSpent value='".$res["time_spent"]."'>"?><br>
                        <label for="what-i-learned">What I Learned</label>
                        <?php echo "<input id=title type=text name=learned value='".$res["learned"]."'>"?><br>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="resources" ><?php echo $res["resources"]?></textarea>
                        <input type="submit" value="Publish Entry" >
                        
                        <a href="#" class="button button-secondary">Cancel</a>
                        <?php echo "<button class=button><a href=edit.php?del=".$res["id"].">Delete</a></button>"?>
                    </form>
                </div>
            </div>
        </section>
        <?php include 'inc/footer.php'?>
    </body>
</html>