<?php include 'inc/header.php'?>
<?php include 'inc/connection.php'?>
<?php 
    $title = null;
    $date =null;
    $time_spent = null;
    $learned = null;
    $resources = null;
    $tag=null;
if(isset($_POST["title"])){
    
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


add($conn,$title,$date,$time_spent,$learned,$resources);

// add details to joint table
if(isset($_POST["tag"])){
    
$tag=filter_var($_POST["tag"], FILTER_SANITIZE_STRING);
   newBook($conn,$tag,$title);
}
header("Location:index.php");
}
?>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <form method="post" action="new.php">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="learned"></textarea>
                        
                        <label for="tag">Tag</label>
                        <input id="tag" type="text" name="tag"><br>
                        
                        
                        
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="resources"></textarea>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php include 'inc/footer.php'?>
    </body>
</html>