<?php
           
    //   connecton to database
    function connect(){
    try{
        $db=null;
        $db=new PDO("sqlite:inc/journal.db");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    }catch(Exception $e){
        echo "error occured".$e->getMessage();
    }
    return $db;
}
   
  $conn= connect();
  

// function to return all entries
  function readAll($database){

    $data=$database->query("SELECT * FROM entries ORDER BY date ");
    return $data;
    
  }

  function add ($database,$t,$d,$ts,$l,$r){
        // filtering inputs for database
         $query="INSERT INTO entries (title,'date',time_spent,learned,resources)
         VALUES (:t,:d,:ts,:l,:r)";
         try{
         $sql=$database->prepare($query);
         $sql->execute(['t'=>$t,'d'=>$d,'ts'=>$ts,'l'=>$l,'r'=>$r]);
         
         }
         catch(Exeception $e){
             echo $e->getMessage();
         }



  }

//   edit fucntion
function edit ($database,$t,$d,$ts,$l,$r){

    // filtering inputs for databas
    
    $query="UPDATE entries SET title = :t, 'date'= :d, time_spent  =:ts, learned = :l ,resources= :r WHERE id =:id";
     try{
     $sql=$database->prepare($query);
     $sql->execute(['t'=>$t,'d'=>$d,'ts'=>$ts,'l'=>$l,'r'=>$r,"id"=>$_SESSION["id"]]);
     echo "sucess";
     }
     catch(Exeception $e){
         echo $e->getMessage();
     }



}
function getOne ($database,$id){
    $query=("SELECT * FROM entries WHERE id=:id");
    try{
    $result=$database->prepare($query);
    $result->execute(["id"=>$id]);
    return $result;
    }catch(Exception $e){
        echo $e->getMessage();
    }
   
}
// delete from database 
function delete ($database,$id){
    // filtering inputs for database
    $query="DELETE FROM entries WHERE id=:id";
     try{
     $sql=$database->prepare($query);
     $sql->execute(['id'=>$_SESSION["id"]]);
     
     }
     catch(Exeception $e){
         echo $e->getMessage();
     }



}

function getTags($c){
    try{
    $query="SELECT * FROM tags";
    $result=$c->prepare($query);
    $result->execute();
    
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
return $result;
}
// read
  
// get tags of a specific id
function matchingTags($db,$tag){
    $query="SELECT * FROM entries WHERE tagId=:t ";
    try{
    $result=$db->prepare($query);
    $result->execute(["t"=>$tag]);
    return $result;
    }
    catch(Exception $e){
     echo $e->getMessage();
    }
}