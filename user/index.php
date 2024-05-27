<?php
    session_start();

    require_once 'operateDB.php';

?>

<?php require_once 'header.php';?>
<script>
    var title = document.createElement('title');
    title.innerHTML = 'マイページ';
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(title);
</script>
<article>
    <?php require_once 'sidebar.php';?>
    <main>
        <div class="mypage">
            <div class="log">

            </div>
            <div class="RegistedContents">
                <div class="tab_wrap">
                    <input id="sp" type='radio' name="check" checked>
                    <label for="sp" class="tab_sp tabs">協賛</label>
                    <input id="club" type='radio' name="check">
                    <label for="club" class="tab_club tabs">模擬店・イベント</label>
                    <input id="market" type="radio" name="check">
                    <label for="market" class="tab_market tabs">外部団体としての出展</label>
                </div>
            </div>
        </div>
    </main>
</article>