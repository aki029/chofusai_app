<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <link rel="stylesheet" href="/app/common/style/common.css" type="text/css">
        <link rel="stylesheet" href="style/input.css">
        <script src="/app/common/script/flex.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <div class="header">
                <div class="title">
                    <a href="/Chofusai_app">
                        <img src="/app/common/image/header/chofusai_logo.svg" alt="潮風祭総合ポータルサイト">
                        <span>潮風祭総合ポータルサイト</span>
                    </a>
                </div>
                <div class="menu">
                    <nav class="nav">
                        <ul>
                            <li><a href="/apply/sponser/registsp.php" class="app-regist-sponsor">協賛申請<span>Sponsor</span></a></li>
                            <li><a href="/apply/club/registcb.php" class="app-regist-club">サークルイベント申請<span>Event&Booth</span></a></li>
                            <li><a href="/apply/club/registmk.php" class="app-regist-market">フリーマーケット申請<span>Market</span></a></li>
                            <li>
                                <a href="/user/login.php" class="app-login">ログイン</a>
                                <?php if(isset($_SESSION["id"])):?><a class="logined" href="/user/mypage/">マイページへ</a><?php endif?>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!--スマホ・タブレット用-->
                <div class="for-smart hamburgur-menu">
                    <input type="checkbox" id="toggle" name="toggle">
                    <label for="toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                    <nav class="nav">
                        <ul>
                            <li>
                                <a href="/">HOME</a>
                            </li>
                            <li>
                                <a href="/info/">開催情報</a>
                                <ul>
                                    <li><a href="/info/event/">イベント</a></li>
                                    <li><a href="/info/booth/">模擬店</a></li>
                                    <li><a href="/info/market/">フリーマーケット</a></li>
                                    <li><a href="/info/sponsor/">協賛会社様一覧</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="/apply/">各種申請</a>
                                <ul>
                                    <li><a href="/apply/sponser/registsp.php">協賛</a></li>
                                    <li><a href="/apply/club/">イベント・模擬店</a></li>
                                    <li><a href="/apply/market/">フリーマーケット</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="/user/">ログイン</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!--ここまでスマホ・タブレット用-->
            </div>
            <div class="menu-bar">
                <nav class="menu-nav">
                    <ul>
                        <li><a href="/">HOME</a></li>
                        <li>
                            <a href="/info/">開催情報</a>
                            <div class="accordion">
                                <ul>
                                    <li><a href="/info/club/">イベント・模擬店</a></li>
                                    <li><a href="/info/market/">フリーマーケット</a></li>
                                    <li><a href="/info/sponser/">協賛会社様一覧</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="/apply/">各種申請</a>
                            <div class="accordion">
                                <ul>
                                    <li><a href="/apply/sponser/">協賛のお申込み</a></li>
                                    <li><a href="/apply/club/">模擬店・イベントお申込み</a></li>
                                    <li><a href="/apply/market/">フリーマーケットのお申込み</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="https://www.akita-pu.ac.jp/gakusei/chofusai/" target="_blank" rel="noreferrer noopener" title="新規タブを開きます">公式HPへ<span>※新規タブを開きます</span></a></li>
                        <li><a href="/contact/">お問い合わせ</a></li>
                    </ul>
                </nav>
            </div>
        </header>
           
