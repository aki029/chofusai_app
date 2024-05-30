<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
        <link rel="stylesheet" href="/app/common/style/common.css" type="text/css">
        <link rel="stylesheet" href="/app/apply/style/input.css">
        <link rel="stylesheet" href="/app/user/style/mypage.css">
        <script src="/app/common/js/common.js"></script>
    </head>
    <body>
        <header>
            <div class="header">
                <div class="title">
                    <a href="/app/">
                        <img src="/app/common/image/header/chofusai_logo.svg" alt="潮風祭総合ポータルサイト">
                        <span>総合ポータルサイト</span>
                    </a>
                </div>
                <div class="menu">
                    <nav class="nav">
                        <ul>
                            <li><a href="/app/apply/sponsor/" class="app-regist-sponsor">協賛申請<span>Sponsor</span></a></li>
                            <li><a href="/app/apply/event/" class="app-regist-event">イベント申請<span>Event&Booth</span></a></li>
                            <li><a href="/app/apply/market/" class="app-regist-market">模擬店申請<span>Market</span></a></li>
                            <li>
                                <?php if(!isset($_SESSION["id"])):?>
                                    <a href="/app/user/login" class="app-login">ログイン</a>
                                <?php else:?>    
                                    <a class="logined" href="/app/user/mypage/">マイページへ</a><?php endif?>
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
                                <a href="/app/">HOME</a>
                            </li>
                            <li>
                                <a href="/app/info/">開催情報</a>
                                <ul>
                                    <li><a href="/app/info/event/">イベント出店</a></li>
                                    <li><a href="/app/info/market/">模擬店出展</a></li>
                                    <li><a href="/app/info/sponsor/">協賛会社様一覧</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="/app/apply/">各種申請</a>
                                <ul>
                                    <li><a href="/app/apply/sponser/">協賛申請</a></li>
                                    <li><a href="/app/apply/event/">イベント申請</a></li>
                                    <li><a href="/app/apply/market/">模擬店申請</a></li>
                                </ul>
                            </li>
                            <li>
                                <?php if(!isset($_SESSION["id"])):?>
                                    <a href="/app/user/login" >ログイン</a>
                                <?php else:?>    
                                    <a href="/app/user/mypage/">マイページへ</a><?php endif?>
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
                            <a href="/app/info/">開催情報</a>
                            <div class="accordion">
                                <ul>
                                    <li><a href="/app/info/event/">イベント・模擬店</a></li>
                                    <li><a href="/app/info/market/">外部団体様出展</a></li>
                                    <li><a href="/app/info/sponser/">協賛会社様一覧</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="/app/apply/">各種申請</a>
                            <div class="accordion">
                                <ul>
                                    <li><a href="/app/apply/sponsor/">協賛のお申込み</a></li>
                                    <li><a href="/app/apply/event/">イベントお申込み</a></li>
                                    <li><a href="/app/apply/market/">模擬店お申込み</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="https://www.akita-pu.ac.jp/gakusei/chofusai/" target="_blank" rel="noreferrer noopener" title="新規タブを開きます">公式HPへ<span>※新規タブを開きます</span></a></li>
                        <li><a href="/app/contact/">お問い合わせ</a></li>
                    </ul>
                </nav>
            </div>
        </header>
           
