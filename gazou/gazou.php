<?php

$link=mysqli_connect("localhost","root","");
if(!$link){
	die("データベースに接続できません".mysqli_connect_error());
}
mysqli_select_db($link,"gazou_bbs");
mysqli_set_charset($link,"utf8");

$errors=array();

	if($_SERVER["REQUEST_METHOD"]==="POST"){
		$name=null;
		if(!isset($_POST["name"]) || !strlen($_POST["name"])){
			$errors["name"]="名前を入力してください";
		}else if(strlen($_POST["name"])>40){
			$errors["name"]="名前は４０文字以内で入力してください";
		}else{
			$name=$_POST["name"];
		}
		
		$comment=null;
		if(!isset($_POST["comment"]) || !strlen($_POST["comment"])){
			$errors["comment"]="ひとことを入力してください";
		}else if(strlen($_POST["comment"])>200){
			$errors["comment"]="ひとことは２００文字以内で入力してください";
		}else{
			$comment=$_POST["comment"];
		}
		if(count($errors)===0){
			$e_code=$_FILES["file"]["error"];
			if($e_code!=0){
				$errors["error"]="ファイル送信エラーです";
			}
			else{
				$file_name=$_FILES["file"]["name"];
				$tmp_name=$_FILES["file"]["tmp_name"];
				$filename="images/";
				$filename=$filename.$file_name;
				if (file_exists($filename)) {
					$errors["doumei"]= '同名のファイルがアップロードされています。';
					$file_result=0;
				}
				else{
					$file_result = @move_uploaded_file( $tmp_name, $filename);
				}
				if(!$file_result){
					$errors["error2"]="ファイル送信エラーです";
				}
			}
		}
	$date=date('Y-m-d H:i:s');
	if(count($errors)===0){
			$sql = mysqli_prepare($link,'INSERT INTO `post` (`name`,`comment`,`created_at`,`img`) VALUES (?,?,?,?)');
			mysqli_stmt_bind_param($sql,'ssss',$name,$comment,$date,$filename);
			mysqli_stmt_execute($sql);
			mysqli_stmt_close($sql);
			mysqli_close($link);
			header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		}
	}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>画像掲示板</title>
</head>
<boby>
	<h1>画像掲示板</h1>
	<form action="gazou.php" method="post" enctype="multipart/form-data">
<?php if (count($errors)): ?>
		<ul>
<?php foreach($errors as $error): ?>
			<li>
				<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
			</li>
<?php endforeach; ?>
		</ul>
<?php endif; ?>
		名前：<input type="text" name="name"><br>
		ひとこと：<textarea type="text" name="comment" cols="30" rows="3"></textarea><br>
		画像：<input type="file" name="file"><br>
		<input type="submit" name="submit" value="投稿">
	</form>
<?php
		$sql="SELECT * FROM `post` ORDER BY `created_at` DESC";
		$result=mysqli_query($link,$sql);
?>
<?php if($result!==false && mysqli_num_rows($result)): ?>
	<ul>
<?php while($post=mysqli_fetch_assoc($result)): ?>
			<li>
				<?php echo htmlspecialchars($post["name"],ENT_QUOTES,"UTF-8"); ?>:
				<?php echo nl2br(htmlspecialchars($post["comment"],ENT_QUOTES,"UTF-8")); ?>
				<?php echo '<img src="'.htmlspecialchars($post["img"],ENT_QUOTES,"UTF-8").'" alt="投稿画像">'; ?>
				- <?php echo htmlspecialchars($post["created_at"],ENT_QUOTES,"UTF-8"); ?>
			</li>
<?php endwhile; ?>
	</ul>
<?php endif; ?>
<?php
		mysqli_free_result($result);
		mysqli_close($link);
?>
</body>
</html>