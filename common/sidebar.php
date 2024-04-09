<!--サイドバー-->
<section>
        <div class="sidebar">
            <nav>
                <?php 
                //以下ディレクトリナビ表示用のプログラム
                    $place_name = ["app"=>"HOME",
                    "apply"=>"各種申請",
                    "user"=>"ユーザー",
                    "info"=>"ご案内",
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
                <div class="sidemenu">
                    <div class="nav">
                        
                    </div>
                    <div class="adds">
                        <a href="/app/apply/sponsor"><img src="/app/common/image/sidebar/ad_sponsor.jpg"><span>協賛企業様を募集しております！</span></a>
                        <a href="/app/apply/club"><img src="/app/common/image/sidebar/ad_club.jpeg"><span>学外の方の模擬店出店募集中！</span></a>
                        <a href="/app/apply/market"><img src="/app/common/image/sidebar/ad_market.jpeg"><span>今年度よりフリーマーケット開催！</a>
                    </div>
                </div>
            </nav>
        </div>
        </section>