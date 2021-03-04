<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>メール送信完了しました</title>
</head>
<body>
	<?php
		$name = $_POST['name'];
		$email = $_POST['email'];
		$comment = $_POST['comment'];
		$message = "名前：".$name."メールアドレス：".$email."ご要望：".$comment;
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		if (!mb_send_mail("aa@aa.aa","質問:".$name,$message,"From:".$email,"-f bb@bb.bb")) {
			exit("送信エラー");
		}
		else{
			echo "<p>送信完了いたしました。</p>";
		}
/*
mb_language("Japanese");
mb_internal_encoding("UTF-8");
の２つの命令は、メール送信命令（mb_send_mail）の言語指定
mb_send_mail
第一引数（aa@aa.aa）には送信先アドレス
第二引数（"質問:".$name）にはメールタイトル
第三引数（$message）にはメール本文
第四引数（"From:".$email）には送信元等のメールヘッダ
					Fromは必須。CCやBCCをつける場合、それぞれを「\r\n」で区切る
					例）From:cc@cc.cc\r\nCC:dd@dd.dd\r\nBCC:ee@ee.ee
第五引数（-f bb@bb.bb）には送信エラー時戻り先メアドを「-f 」の後に
if文でメール送信失敗した場合「exit("送信エラー")」となり、送信エラーと出して処理終了
以下にＰＨＰ命令があっても処理されない
*/
	?>
</body>
</html>
