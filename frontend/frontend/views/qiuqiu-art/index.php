<?php
/**
 * Created by PhpStorm.
 * User: wangxufeng
 * Date: 2018/9/3
 * Time: 18:13
 */

$this->title = '球球素材识别';

//$this->registerJsFile('js/myScript.js', ['position'=>\yii\web\View::POS_END]);
?>

<div class=" pagebox">
    <div class="header_box">
        <h1>球球美术素材智能识别与归类</h1>
        <p class="lead">利用谷歌inception网络提取图像特征进行类别相似度检测</p>
        <a class="btn btn-lg btn-success" id="artsubmit" href="#">点击识别</a>
    </div>

    <div id="artRes" class="art-res"></div>

    <div id="look_box" class="look_box hide">
        <div class="tel_inner">
            <div class="tex_in">
                <h1>查看相似文件</h1>
                <ul>
                    <li>
                        <p>目标文件</p>
                        <dt>
                            <img id="mu_img" src="">
                        </dt>
                        <dd id="mu_name">B1i.png</dd>
                    </li>
                    <li>
                        <p>相似度：<b id="this_num">92</b></p>
                        <dt>
                            <img id="this_img" src="">
                        </dt>
                        <dd id="this_name">B1i.png</dd>
                    </li>

                </ul>
                <a class="btn btn-lg btn-success" id="ok_look" href="javascript:;">我知道了</a>
            </div>
        </div>
    </div>

</div>

<script>
    document.ready(function() {
        $("#ok_look").unbind().bind("click",function(){
            $("#look_box").addClass("hide");
        });

        $("#artsubmit").click(function () {
            if (typeof $("#artsubmit").attr("disabled") == "undefined" || $("#artsubmit").attr("disabled") == false) {
                $("#artsubmit").html("正在处理...").attr("disabled", true);
                $("#artRes").html('+<?=\yii\helpers\Html::img('@web/images/pizzas4.gif', ['alt'=>'', 'class'=>'']);?>+');

                //var tmp = {"data": {"similarities": [{"similarity": [{"dist": "0.0", "name": "B1i.png"}, {"dist": "0.07404142", "name": "B76_3i.png"}, {"dist": "0.08027156", "name": "B48i.png"}, {"dist": "0.084304914", "name": "B8i.png"}, {"dist": "0.08827237", "name": "B64i.png"}, {"dist": "0.09562082", "name": "B82i.png"}, {"dist": "0.09568178", "name": "B45i.png"}, {"dist": "0.09952135", "name": "B67i.png"}, {"dist": "0.11245718", "name": "B41_1i.png"}, {"dist": "0.11462635", "name": "B37i.png"}, {"dist": "0.1198861", "name": "B1_72i.png"}, {"dist": "0.12041819", "name": "B20i.png"}, {"dist": "0.120566495", "name": "B93i.png"}, {"dist": "0.12378894", "name": "B1_75i.png"}, {"dist": "0.13232407", "name": "B16i.png"}, {"dist": "0.13261668", "name": "B13i.png"}, {"dist": "0.13553455", "name": "B21i.png"}, {"dist": "0.14250427", "name": "B31_2i.png"}, {"dist": "0.15571038", "name": "B95i.png"}, {"dist": "0.16398019", "name": "B44i.png"}, {"dist": "0.16486822", "name": "B60i.png"}, {"dist": "0.17027913", "name": "B77i.png"}, {"dist": "0.17033505", "name": "B11i.png"}, {"dist": "0.17113072", "name": "B17i.png"}, {"dist": "0.17255104", "name": "B27i.png"}, {"dist": "0.17529964", "name": "B36i.png"}, {"dist": "0.17594406", "name": "B4i.png"}, {"dist": "0.17712961", "name": "B10i.png"}, {"dist": "0.17976634", "name": "B26i.png"}, {"dist": "0.18619798", "name": "B28i.png"}, {"dist": "0.18815309", "name": "B74i.png"}, {"dist": "0.18839931", "name": "B19i.png"}, {"dist": "0.19172715", "name": "B10_4i.png"}, {"dist": "0.19644466", "name": "B1_2i.png"}, {"dist": "0.19862092", "name": "B39i.png"}, {"dist": "0.19873884", "name": "B22i.png"}, {"dist": "0.20379515", "name": "B43i.png"}, {"dist": "0.21053895", "name": "B12i.png"}, {"dist": "0.21523018", "name": "B92_3i.png"}, {"dist": "0.21713619", "name": "B40i.png"}, {"dist": "0.21967547", "name": "B96_3i.png"}, {"dist": "0.22197066", "name": "B15i.png"}, {"dist": "0.22257715", "name": "B6i.png"}, {"dist": "0.22586225", "name": "B34i.png"}, {"dist": "0.22994967", "name": "B3i.png"}, {"dist": "0.23719841", "name": "B65i.png"}, {"dist": "0.23956873", "name": "B18i.png"}, {"dist": "0.24506447", "name": "B41i.png"}, {"dist": "0.2492586", "name": "B25i.png"}, {"dist": "0.2606735", "name": "B1_77i.png"}, {"dist": "0.27243632", "name": "B46i.png"}, {"dist": "0.27576247", "name": "B101i.png"}, {"dist": "0.29164994", "name": "B86_2i.png"}, {"dist": "0.29728788", "name": "B2i.png"}], "target": "B1i.png"}, {"similarity": [{"dist": "0.0", "name": "B1_2i.png"}, {"dist": "0.11581148", "name": "B18i.png"}, {"dist": "0.11711789", "name": "B26i.png"}, {"dist": "0.11998501", "name": "B22i.png"}, {"dist": "0.12892404", "name": "B17i.png"}, {"dist": "0.13363038", "name": "B13i.png"}, {"dist": "0.13387322", "name": "B39i.png"}, {"dist": "0.13609926", "name": "B95i.png"}, {"dist": "0.13696909", "name": "B12i.png"}, {"dist": "0.13698123", "name": "B19i.png"}, {"dist": "0.14273632", "name": "B77i.png"}, {"dist": "0.14314012", "name": "B11i.png"}, {"dist": "0.14391291", "name": "B36i.png"}, {"dist": "0.14532866", "name": "B28i.png"}, {"dist": "0.14759748", "name": "B74i.png"}, {"dist": "0.15169312", "name": "B1_77i.png"}, {"dist": "0.15169904", "name": "B65i.png"}, {"dist": "0.15211095", "name": "B31_2i.png"}, {"dist": "0.15406562", "name": "B10i.png"}, {"dist": "0.15540126", "name": "B1_72i.png"}, {"dist": "0.15742512", "name": "B1_75i.png"}, {"dist": "0.15826018", "name": "B20i.png"}, {"dist": "0.15864547", "name": "B92_3i.png"}, {"dist": "0.15883401", "name": "B6i.png"}, {"dist": "0.15950249", "name": "B3i.png"}, {"dist": "0.16073334", "name": "B43i.png"}, {"dist": "0.16131456", "name": "B60i.png"}, {"dist": "0.1615079", "name": "B41i.png"}, {"dist": "0.1626606", "name": "B16i.png"}, {"dist": "0.16492355", "name": "B8i.png"}, {"dist": "0.16502145", "name": "B34i.png"}, {"dist": "0.16562922", "name": "B15i.png"}, {"dist": "0.16645403", "name": "B46i.png"}, {"dist": "0.16922702", "name": "B67i.png"}, {"dist": "0.17031053", "name": "B25i.png"}, {"dist": "0.17283551", "name": "B21i.png"}, {"dist": "0.17541645", "name": "B45i.png"}, {"dist": "0.1757279", "name": "B10_4i.png"}, {"dist": "0.17573494", "name": "B44i.png"}, {"dist": "0.17746465", "name": "B27i.png"}, {"dist": "0.1778876", "name": "B93i.png"}, {"dist": "0.17840236", "name": "B96_3i.png"}, {"dist": "0.18300413", "name": "B4i.png"}, {"dist": "0.18690114", "name": "B76_3i.png"}, {"dist": "0.19495656", "name": "B64i.png"}, {"dist": "0.19644466", "name": "B1i.png"}, {"dist": "0.19839142", "name": "B86_2i.png"}, {"dist": "0.1992558", "name": "B41_1i.png"}, {"dist": "0.19934963", "name": "B48i.png"}, {"dist": "0.20106025", "name": "B2i.png"}, {"dist": "0.20157601", "name": "B101i.png"}, {"dist": "0.20470081", "name": "B40i.png"}, {"dist": "0.20527892", "name": "B82i.png"}, {"dist": "0.24274209", "name": "B37i.png"}], "target": "B1_2i.png"}]}, "msg": "", "code": 0};
                //var similarities = tmp["data"]["similarities"];
                //for (var i in similarities) {
                //    console.log(similarities[i]);
                //    var simiCol = '<div class="column">' +
                //            '<div class="item item-target">' +
                //                '<div class="item-head">' + similarities[i]['target'] + '(目标)</div>' +
                //                '<div class="item-art"><a target="_blank" href="' + <?php //echo "'".$targetUrl."'" ?>// + similarities[i]['target'] + '"><img src="' + <?php //echo "'".$targetUrl."'" ?>// + similarities[i]['target'] + '"/></a></div>' +
                //            '</div>';
                //    for (var simiKey in similarities[i]['similarity']) {
                //        if (simiKey >= 9) break;
                //        simiCol += '<div class="item">' +
                //                '<div class="item-head">' + similarities[i]['similarity'][simiKey]["name"] + ': ' + parseFloat(similarities[i]['similarity'][simiKey]["dist"]).toFixed(3) + '</div>' +
                //                '<div class="item-art"><a target="_blank" href="' + <?php //echo "'".$artUrl."'" ?>// + similarities[i]['similarity'][simiKey]["name"] + '"><img src="' + <?php //echo "'".$artUrl."'" ?>// + similarities[i]['similarity'][simiKey]["name"] + '"/></a></div>' +
                //            '</div>';
                //    }
                //    simiCol += '</div>';
                //
                //    $("#artRes").append(simiCol);
                //}

                $.ajax({
                    type: 'POST',
                    url: "<?php echo $mlApi?>",
                    data: {},
                    success: function (data) {
                        data = JSON.parse(data);
                        if (data["code"] == 0) {
                            $("#artRes").empty();
                            var similarities = data["data"]["similarities"];
                            var simiCol = "";
                            for (var i in similarities) {
                                simiCol += "<ul>";
                                simiCol += "<div class='mu_box'><li><p>目标文件</p>";
                                simiCol += "<dt><img src='" + <?="'".$targetUrl."'"?> +similarities[i]['target']+"'/></dt>";
                                simiCol += "<dd>"+similarities[i]['target']+"</dd></li></div><div class='si_box'>";
                                for (var simiKey in similarities[i]['similarity']) {
                                    if (simiKey >= 10) break;

                                    var some_num = 1-parseFloat(similarities[i]['similarity'][simiKey]["dist"]);
                                    var tonum = parseFloat(some_num)*100.toFixed(2);
                                    simiCol += "<li><p>相似度：<b>"+tonum+"</b></p>";
                                    simiCol += "<dt><img src='" + <?="'".$artUrl."'"?> + similarities[i]['similarity'][simiKey]["name"]+"'></dt>";
                                    simiCol += "<dd>"+similarities[i]['similarity'][simiKey]["name"]+"</dd></li>";
                                }
                                simiCol += "</div></ul>";
                            }
                            $("#artRes").append(simiCol);

                            $(".si_box li dt").unbind().bind("click",function(){
                                var this_img = $(this).children("img").attr("src");
                                var this_num = $(this).prev("p").children("b").text();
                                var this_name = $(this).next("dd").text();

                                var mu_img = $(this).parent("li").parent("div").siblings("div").children("li").children("dt").children("img").attr("src");
                                var mu_name = $(this).parent("li").parent("div").siblings("div").children("li").children("dd").text();

                                $("#this_img").attr("src",this_img);
                                $("#this_num").html(this_num);
                                $("#this_name").html(this_name);
                                $("#mu_img").attr("src",mu_img);
                                $("#mu_name").html(mu_name);

                                $("#look_box").removeClass("hide");
                            })
                        }

                        $("#artsubmit").html("点击识别").attr("disabled", false);
                    }
                });
            }
        });
    });
</script>