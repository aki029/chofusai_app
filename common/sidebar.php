<!--サイドバー-->
<section>
        <div class="sidebar">
            <nav>
                <div class="root">
                <?php 
                //以下ディレクトリナビ表示用のプログラム
                    $place_name = ["app"=>"HOME",
                    "apply"=>"各種申請",
                    "user"=>"ユーザー",
                    'login'=>'ログイン',
                    "info"=>"ご案内",
                    "club"=>"模擬店・イベント申請",
                    "sponsor"=>"協賛のお申込み"];
                    $docroot = $_SERVER["DOCUMENT_ROOT"];
                    $dirs = str_replace($docroot,"",dirname($_SERVER["PHP_SELF"]));
                    $visited = explode("/",$dirs);
                    $visited = array_filter($visited);
                    $result = "";
                    foreach($visited as $dirname){
                        if($dirname === reset($visited)){
                            $result = "<a href="."/".$dirname.">".$place_name[$dirname]."</a>".htmlspecialchars(" > ");
                        }
                        elseif($dirname !== end($visited)){
                            $result .= $place_name[$dirname].htmlspecialchars(" > ");
                        }else{
                            echo $result.$place_name[$dirname];
                        }
                    }
                ?>    
                </div>
                <div class="sidemenu">
                    <div class="nav">
                        <a href="/apply/">各種申請ページ</a>
                        <a href="/info/">今年度開催情報</a>
                        <a href="/contact/">お問い合わせ</a>
                    </div>
                    <div class="SNS">
                        <a href='https://twitter.com/apuchofusai' class="X" target='_blank' rel='noreferrer noopener'><img src='/app/common/image/sidebar/logo-white.png'></a>
                        <a href="https://www.instagram.com/apuchofusai/" class="Insta" target="_blank" rel="noreferrer noopener"><img src="/app/common/image/sidebar/Instagram_Glyph_Gradient.png"></a>
                    </div>
                    <div class="toHP">
                        <a href="https://www.akita-pu.ac.jp/gakusei/chofusai/" target="_blank" rel="noreferrer noopener" title="新規タブを開きます">公式HPへ</a>
                    </div>
                </div>
            </nav>
        </div>
        </section>