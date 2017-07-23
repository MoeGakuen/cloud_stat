<?php
if (!defined('IN_KKFRAME')) exit('Access Denied!');
$obj = $_PLUGIN['obj']['cloud_stat'];
?>
<script type="text/javascript">
    function load_cloud_stat_index() {
        showloading();
        $.getJSON("plugin.php?id=cloud_stat&action=get",
        function(result) {
            if (!result) return;
            var str = '';
            str += '<p>截止今天，贴吧签到助手共完成 <span>' + result.ctieba + '</span> 次签到</p>';
            str += '<p>为贴吧用户获取 <span>' + result.cexp + '</span> 点经验</p><hr/>';
            str += '<p>其中，当前站点签到 <span>' + result.tieba + '</span> 次</p>';
            str += '<p>获取了 <span>' + result.exp + '</span> 点经验</p><hr/>';
            var sign = result.tieba / result.ctieba * 100;
            str += '<p>当前站点，签到次数占比 <span>' + sign.toFixed(2) + '%</span></p>';
            var exp = result.exp / result.cexp * 100;
            str += '<p>获取经验占比 <span>' + exp.toFixed(2) + '%</span></p>';
            $('.kk_cloud_stat').html(str);
        }).fail(function() {
            createWindow().setTitle('系统错误').setContent('发生未知错误: 获取统计信息失败').addButton('确定',
            function() {
                location.reload();
            }).append();
        }).always(function() {
            hideloading();
        });
    }
</script>
<h2>签到云统计</h2>
<p class="small_gray">当前插件版本：1.2.1 | 更新日期：17-7-23 | Optimized by <a href="http://gakuen.me" target="_blank">Gakuen</a> | 插件更新群：<a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=ba20b2535872bd9ede8fc11e5b5badf42a4b992b0069ba1621e182ef5defc4dd">187751253</a></p> 
<style type="text/css">
    .kk_cloud_stat {padding: 30px 20px;}
    .kk_cloud_stat p {margin: 10px 0; font-size: 26px; line-height: 42px; font-weight: lighter; text-align: center;}
    .kk_cloud_stat span {font-size: 32px; font-family: "Segoe UI Light", "Segoe UI", "幼圆", "Arial"; letter-spacing: 5px; vertical-align: baseline; font-size: 64px; text-shadow: 0 0 15px #777; position: relative; top: 5px;}
    .stat_source {position: absolute; bottom: 10px;}
</style> 
<div class="kk_cloud_stat"></div> 
<p class="stat_source">* 数据源自 <a target="_blank" href="https://github.com/MoeGakuen/Tieba_Sign">贴吧签到助手</a> <a target="_blank" href="http://api.kk.hydd.cc">学园科技 KK API 开放平台</a> 所有接入签到站点.</p>