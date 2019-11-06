
<?php

try{
    $dsn="";
    $user='';
    $password='';
    $dbh=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    
    
    $datetable="CREATE TABLE IF NOT EXISTS  form(".
    "id INT AUTO_INCREMENT PRIMARY KEY,".
    "name TEXT , ".
    "comment TEXT , ".
    "date INT ,".
    "pass TEXT".
    ");";
    $res=$dbh->query($datetable);
    
    //フォーム処理

//投稿処理
if(empty($_POST["edit"])){
if(empty($_POST["name"]) or empty($_POST["text"]) or empty($_POST["pass"])){
}
else{



$name=$_POST["name"];
$comment=$_POST["text"];
$day=date("Y-m-d H:i:s");
$pass=$_POST["pass"];

$in="INSERT INTO form(name,comment,date,pass) VALUES(:name, :comment, :date, :pass)";
$upload=$dbh->prepare($in);
$upload->bindParam(':name',$name ,PDO::PARAM_STR);
$upload->bindParam(':comment',$comment ,PDO::PARAM_STR);
$upload->bindParam(':date',$day ,PDO::PARAM_INT);
$upload->bindParam(':pass',$pass ,PDO::PARAM_STR);
$upload->execute();
}


}
elseif(isset($_POST["name"]) and isset($_POST["text"]) and isset($_POST["pass"])){
    
    $editnumber=$_POST["edit"];
$rogin=$_POST["pass"];
    $sql="SELECT *  FROM form";
    $result=$dbh->query($sql);
    foreach($result as $val) {
    
    
     if($val['id']==$editnumber){
          if($val['pass']==$rogin){
         $names=$_POST["name"];
         $comments=$_POST["text"];
         $days=date("Y-m-d H:i:s");
         
         $up='update form set name=:name, comment=:comment, date=:date where id=:id';
    $update=$dbh->prepare($up);
    $update->bindParam(':name',$names ,PDO::PARAM_STR);
    $update->bindParam(':comment',$comments ,PDO::PARAM_STR);
    $update->bindParam(':date',$days ,PDO::PARAM_INT);
    $update->bindParam(':id',$editnumber ,PDO::PARAM_INT);
    $update->execute();
    
         
         
          
     }
     }
    }
}


//削除処理
if(isset($_POST["delite"])){
$delite=$_POST["delite"];
$delitepass=$_POST["delitepass"];


$del="DELETE FROM form WHERE id=:id";
$dele=$dbh->prepare($del);
$sql="SELECT *  FROM form";
$result=$dbh->query($sql);
foreach($result as $val) {
if($val['id']==$delite){
if($val['pass']==$delitepass)
$dele->bindParam(':id',$delite,PDO::PARAM_INT);
$dele->execute();
}
}

}


//編集処理






if(!empty($_POST["editnumber"])){

    $editnumber=$_POST["editnumber"];
    $sql="SELECT *  FROM form";

    $result=$dbh->query($sql);
    
    foreach($result as $val) {
        if($val['id']==$_POST["editnumber"]){


            $editname=$val['name'];
            $editcomment=$val['comment'];

        }
       
    
    
    }


}


}
catch(PDOException $e) {

  echo $e->getMessage();
  die();
}


?>



<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" charset="utf-8">
</head>
<body>
<p>投稿用フォーム
<form action="" method="post">
<input type="text" name="name" value="<?php if(isset($editname)){ echo $editname;}?> " placeholder="名前">
<input type="text" id="text" name="text" value="<?php if(isset($editcomment)){ echo $editcomment;}?> " placeholder="コメント" >
<input type="hidden" name="edit" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
<input type="text" name="pass" placeholder="パスワード">
<input type="submit" value="送信">
</form>

<p>削除用フォーム
<form action="" method="post">
<input type="text" name="delite" placeholder="削除番号を入力してください">
<input type="text" name="delitepass" placeholder="パスワード">
<input type="submit" value="削除">


<p>編集用フォーム
	<form action="" method="post">
        <input type="text" name="editnumber" placeholder="編集番号を入力してください">
        <input type="text" name="editpass" placeholder="パスワード">
<input type="submit" value="編集">

</form>
</body>
</html>



<?php
//記述処理

$sql="SELECT *  FROM form";

$result=$dbh->query($sql);

foreach($result as $val) {
    echo $val['id']. '<br />';
    echo $val['name']. '<br />';
     echo $val['comment'].'<br />';
     echo $val['date'].'<br />';



}
?>
