
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" charset="utf-8">
</head>
<body>
<p>投稿、編集用フォーム
<form action="" method="post">
<input type="text" name="number" placeholder="編集対象番号を入力してください">
<input type="text" name="name" placeholder="名前">
<input type="text" id="text" name="text" placeholder="コメント" >
<input type="text" name="pass" placeholder="パスワード">
<input type="submit" value="送信、編集">
</form>

<p>削除用フォーム
<form action="" method="post">
<input type="text" name="delite" placeholder="削除番号を入力してください">
<input type="text" name="rogin" placeholder="パスワード">
<input type="submit" value="削除">



</form>
</body>
</html>



<?php


try{
$dsn="mysql:dbname=tb********";
$user='tb-******';
$password='PASSWORD';
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
if(empty($_POST["number"])){
if(empty($_POST["name"]) or empty($_POST["text"])){
}
else{

$name=$_POST["name"];
$comment=$_POST["text"];
$pass=$_POST["pass"];
$day=date("Y-m-d H:i:s");


$in="INSERT INTO form(name,comment,date,pass) VALUES(:name, :comment, :date, :pass)";
$upload=$dbh->prepare($in);
$upload->bindParam(':name',$name ,PDO::PARAM_STR);
$upload->bindParam(':comment',$comment ,PDO::PARAM_STR);
$upload->bindParam(':date',$day ,PDO::PARAM_INT);
$upload->bindParam(':pass',$pass ,PDO::PARAM_STR);
$upload->execute();
}}

//削除処理
if(isset($_POST["delite"])){
$delite=$_POST["delite"];
$rogin=$_POST["rogin"];

$del="DELETE FROM form WHERE id=:id";
$dele=$dbh->prepare($del);
$sql="SELECT *  FROM form";
$result=$dbh->query($sql);
foreach($result as $val) {
if($val['id']==$delite){
if($val['pass']==$rogin)
$dele->bindParam(':id',$delite,PDO::PARAM_INT);
$dele->execute();
}
}


}



//編集処理
if(isset($_POST["number"])){
$editnumber=$_POST["number"];
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



//記述処理

$sql="SELECT *  FROM form";

$result=$dbh->query($sql);

foreach($result as $val) {
    echo $val['id']. '<br />';
    echo $val['name']. '<br />';
     echo $val['comment'].'<br />';
     echo $val['date'].'<br />';


}

}
  catch(PDOException $e) {

	echo $e->getMessage();
	die();
}
?>