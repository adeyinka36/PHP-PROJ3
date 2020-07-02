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

    $data=$database->query("SELECT * FROM entries ORDER BY entries.date ASC ");
    // $data=$database->query("SELECT * FROM entries_tags");
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
         catch(Exception $e){
             echo $e->getMessage();
         }



  }

//   edit fucntion
function edit ($database,$t,$d,$ts,$l,$r,$tags){
 $tagArr=explode(",",$tags);
 $tagIds=[];
    // filtering inputs for databas
    
    $query="UPDATE entries SET title = :t, 'date'= :d, time_spent  =:ts, learned = :l ,resources= :r WHERE id =:id";
     try{
     $sql=$database->prepare($query);
     $sql->execute(['t'=>$t,'d'=>$d,'ts'=>$ts,'l'=>$l,'r'=>$r,"id"=>$_SESSION["id"]]);
     
    //   foreach($tagArr as $tA){
    //       try{
    //         $q="SELECT * FROM  tags WHERE name = :v";
    //         $qRes=$database->prepare($q);
    //         $qRes->execute(["v"=>$tA])->fetch();
    //         array_push($tagIds,$qRes["id"]);
            
    //       }catch(Exception $e){
    //           echo $e->getMessage();
    //       }
    //   }
    session_start();
      deleteTags($database,$_SESSION["id"]);
      
      session_destroy();
      foreach($tagArr as $qr){
        
          updateJoint($database,$qr,$t);
      }
        
     }
     catch(Exception $e){
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
     catch(Exception $e){
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
    $query="SELECT entries_tags.entriesId,entries_tags.tagId,entries.title FROM entries_tags JOIN  entries ON entries_tags.entriesId=entries.id WHERE entries_tags.tagId =:d";
    try{
    $result=$db->prepare($query);
    $result->execute(["d"=>$tag]);
    return $result;
    }
    catch(Exception $e){
     echo $e->getMessage();
    }
}



// get tags from joined table
function joinTag($db,$id){
    try{
    
    $query="SELECT entries_tags.entriesId,entries_tags.tagId,tags.name,tags.id FROM entries_tags JOIN  tags ON entries_tags.tagId=tags.id WHERE entries_tags.entriesId =:d";
    $res=$db->prepare($query);
    $res->execute(["d"=>$id]);
    return $res;
    }catch( Exception $e){
        echo $e->getMessage();
    }
}



function newBook($db,$t,$book){
    
    if(gettype($t)=="string"){
        $t=explode(",",$t);
    
    }

    
    foreach($t as $tag){
      updateJoint($db,$tag,$book);
    }
}


// function for adding new data to joint table
function updateJoint($db,$tags,$book){
    
        
        checkTag($db,$tags);
    
    $query1="SELECT * FROM tags WHERE name=:t";
    $res=$db->prepare($query1);
    $res->execute(["t"=>$tags]);
    $tagId=$res->fetch();
    $tagId=$tagId["id"];
 

    // getting new book id
    $query3="SELECT * FROM entries WHERE title=:b";
    $res3=$db->prepare($query3);
    $res3->execute(["b"=>$book]);
    $bookPk=$res3->fetch();
    $bookPk=$bookPk["id"];

 
    // query to update joint table with both ids
    $query2="INSERT INTO  entries_tags(tagId,entriesId)
         VALUES( :tI,:eI)";
    $res2=$db->prepare($query2);
    $res2->execute(["tI"=>$tagId,"eI"=>$bookPk]);

}



// this function check if tag exists and creates one if it doesnt

function checkTag($db,$tagCheck){
    $query1="SELECT * FROM tags WHERE name=:t";
    $res=$db->prepare($query1);
    $res->execute(["t"=>$tagCheck]);
    $tagId=$res->fetch();
    $tagId=$tagId["id"];
    if(!$tagId){

        $insertNewTag="INSERT INTO tags(name) VALUES (:n)";
        $insertion=$db->prepare($insertNewTag);
        $insertion->execute(["n"=>$tagCheck]);
    }
}



// DELETE TAS BEFORE PUTTING NEW ONES

function deleteTags($db,$id){
    $query ="DELETE FROM entries_tags WHERE entriesId=:id";
    $res=$db->prepare($query);
    $res->execute(["id"=>$id]);
    
}