<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>問い合わせ内容確認</title>
</head>
<body>
	<?php
		$name=htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
		$email=htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
		$comment=htmlspecialchars($_POST['comment'],ENT_QUOTES,'UTF-8');
		echo "お名前：",$name,"<br>";
		echo "メールアドレス：",$email,"<br>";
		echo "質問内容：",$comment,"<br>";
		echo "<form action='otoiawase_kanryo.php' method='post'>";
		echo "<input type='hidden' name='name' value='".$name."'>";
		echo "<input type='hidden' name='email' value='".$email."'>";
		echo "<input type='hidden' name='comment' value='".$comment."'>";
		echo "<input type='submit' id='botton' value='送信'>";
		echo "<input type='button' id='botton' value='戻る' onclick='history.go(-1)'>";
		echo "</form>";
	?>
</body>
</html>
