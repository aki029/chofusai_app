<?php require_once "header.php";?>
<script type="text/javascript">
    var title = document.createElement('title');
    title.innerHTML = "お問い合わせフォーム";
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(title);
</script>
<?php
    $page_flag = 0;
    if($_POST["btn_confirm"])
    $page_flag = 1;
    elseif($_POST["btn_submit"])
    $page_flag = 2;
?>
<article>
    <?php require_once'sidebar.php';?>
    <main class="contents">
        <div class="inputform">
            <h1>お問い合わせフォーム</h1>
            <form method="POST" enctype="multipart/form-data">
                <?php if($page_flag == 0):?>
                    <p>お名前：<input type="text" name="name"></p>
                    <p>メールアドレス：<input type="email" name="email"></p>
                    <p>件名：<input type="text" name="title"/></p>
                    <p>お問い合わせ内容：</p>
                    <textarea name="contents" style="width:25vw;height:40vh"></textarea>
                <p><input name="btn_confirm" type="submit" value="確認"></p>
                <?php elseif($page_flag == 1):?>
                    <p>メールアドレス：<?=htmlspecialchars($_POST['email'])?></p>
                    <p>件名：<?=htmlspecialchars($_POST["title"])?></p>
                    <p>お問い合わせ内容：</p>
                    <p><?=htmlspecialchars($_POST["contents"])?></p>
                    <input type="submit" value="戻る">
                    <input type="submit" value="送信" name="btn_submit">
                <?php elseif($page_flag == 2):?>
                    <p>送信が完了しました。<br>回答まで今しばらくお待ちください</p>
                <?php endif;?>
            </form>
        </div>
    </main>
</article>
<?php require_once 'footer.php'?>