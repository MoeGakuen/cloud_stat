<?php
if (!defined('IN_KKFRAME')) exit('Access Denied!');
class plugin_cloud_stat extends Plugin {
    public $description = '云统计，记录建站以来的签到次数以及获得经验数';
    public $modules = array(
        array(
            'type' => 'page',
            'id' => 'index',
            'title' => '签到云统计',
            'file' => 'index.inc.php'
        ),
        array(
            'type' => 'cron',
            'cron' => array(
                'id' => 'cloud_stat/cloud_stat',
                'order' => '40'
            )
        )
    );
    public $version = '1.2.1';
    function checkCompatibility() {
        if (version_compare(VERSION, '1.14.4.24', '<')) showmessage('本插件不兼容此版的贴吧签到助手.');
    }
    function install() {
        $count = DB::result_first('SELECT COUNT(*) FROM sign_log WHERE status=2');
        $this->saveSetting('tieba', $count);
        $count = DB::result_first('SELECT SUM(exp) FROM sign_log WHERE status=2');
        $this->saveSetting('exp', $count);
        $ret = kk_fetch_url("http://api.kk.hydd.cc/stat.php");
        if (!$ret) return;
        $data = json_decode($ret);
        if (!$data) return;
        $this->saveSetting('cloud_tieba', $data->tieba);
        $this->saveSetting('cloud_exp', $data->exp);
    }
    function on_upgrade($from_version) {
        switch ($from_version) {
            case '1.0':
                DB::query("UPDATE cron SET id='cloud_stat/cloud_stat' WHERE id='cloud_stat'");
                return '1.1';
            case '1.1':
            case '1.2':
                return '1.2.1';
            default:
                throw new Exception("未知插件版本: {$from_version}");
        }
    }
    function handleAction() {
        $json = json_encode(
            array(
                'ctieba' => (int)$this->getSetting('cloud_tieba'),
                'cexp' => (int)$this->getSetting('cloud_exp'),
                'tieba' => (int)$this->getSetting('tieba'),
                'exp' => (int)$this->getSetting('exp')
            )
        );
        echo $json;
    }
}
