<?php

$comment_array = array();
$pdo =null;
$stmt = null;

//DB接続
try{
  $pdo = new PDO('mysql:host=localhost;dbname=kendea-bord', "root", "");
}catch(PDOException $e){
  echo $e->getMessage();
  }


//フォームを打ち込んとき
if(!empty($_POST["submitButton"])){

  try{
    $posyDate = date("Y-m-d H:i:s");
    $stmt = $pdo->prepare("INSERT INTO `kendea-bord` (`username`, `comment`, `posyDate`) VALUES (:username,;comment,:posyDate );");
    $stmt->bindParam(':username', $_post['username'],PDO::PARAM_STR);
    $stmt->bindParam(':comment', $_POST["comment"],PDO::PARAM_STR);
    $stmt->bindParam(':posyDate', $posyDate,PDO::PARAM_STR);
    
    $stmt->execute();
  } catch (PDOException $e){
     echo $e->getMessage();
    }

  
}


//DBからコメントデータを取得する
$sql = "INSERT INTO `kendea-bord` (`username`, `comment`, `posyDate`) VALUES (:username,;comment,:posyDate )";
$comment_array = $pdo->query($sql);

//DBの接続を閉じる
$pdo = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kendea掲示板</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1 class="title">Kendea掲示板</h1>
  <hr>
  <div class="boardWrapper">
    <section>
      <?php foreach($comment_array as $comment): ?>
      <article>
        <div class="wrapper">
          <div class="nameArea">
            <span>名前:</span>
            <p class="username"><?php echo $comment["username"]; ?></p>
            <time>:<?php echo $comment["posyDate"]; ?></time>
          </div>
          <p class="comment"><?php echo $comment["comment"]; ?></p>
        </div>
      </article>
      <?php endforeach;?>
    </section>


    <form class="formWrapper" method="POST">
      <div>
        <input type="submit" value="書き込む" name="submitButton">
        <label for="">名前:</label>
        <input type="text" name="username">
      </div>
      <div>
        <textarea class="commentTextArea" name="comment"></textarea>
      </div>
    </form>
  </div>
</body>
</html>