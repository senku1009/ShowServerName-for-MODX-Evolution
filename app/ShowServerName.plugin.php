/**<?php
 * @name            Show Server Name
 * @description     管理画面上でサーバー環境名を表示
 * @version         1.00
 * @lastupdate      2020-04-24
 * @license         GNU General Public License v3 or later
 * @author          senku inc.
 * @reportissues    ishibashi@senku.jp
 * @link            https://senku.jp
 * @documentation
 *      モジュールなどでサーバー種別を判定する場合
 *      `if (isset($modx->config['server_type']) && $modx->config['server_type'] === 'prd') { return 'this is product server.'; }`
 * @internal    @events     OnManagerMainFrameHeaderHTMLBlock, OnManagerLoginFormPrerender, OnGetConfig
 * @internal    @properties &prd_ip=本番環境;text;10.0.0.1 &stg_ip=ステージング環境;text;10.0.0.2 &edt_ip=執筆環境;text;10.0.0.3 &tst_ip=テスト環境;text;10.0.0.5 &dev_ip=開発環境;text;10.0.0.6
 * @internal    @guid
 * @internal    @modx_category
 */
$pulugin_params = $modx->event->params;

$server_list = array(
    'prd' => array(
        'name'   => '本番環境',
        'colors' => array('#232323', '#ffcccc', '#ff0000')
    ),
    'stg' => array(
        'name'   => 'ステージング環境',
        'colors' => array('#232323', '#fff8e8', '#ffc06e')
    ),
    'edt' => array(
        'name'   => '執筆環境',
        'colors' => array('#232323', '#e6ffea', '#80ff95')
    ),
    'tst' => array(
        'name'   => 'テスト環境',
        'colors' => array('#232323', '#cfdce6', '#454a4d')
    ),
    'dev' => array(
        'name'   => '開発環境',
        'colors' => array('#232323', '#e6f7ff', '#80d5ff')
    ),
    'unk' => array(
        'name'   => '環境不明',
        'colors' => array('#232323', '#ccccff', '#8080ff')
    )
);

switch ($_SERVER['SERVER_ADDR']) {
    case $pulugin_params['prd_ip']:
        $server = $server_list['prd'];
        $server['type'] = 'prd';
        break;
    case $pulugin_params['stg_ip']:
        $server = $server_list['stg'];
        $server['type'] = 'stg';
        break;
    case $pulugin_params['edt_ip']:
        $server = $server_list['edt'];
        $server['type'] = 'edt';
        break;
    case $pulugin_params['tst_ip']:
        $server = $server_list['tst'];
        $server['type'] = 'tst';
        break;
    case $pulugin_params['dev_ip']:
        $server = $server_list['dev'];
        $server['type'] = 'dev';
        break;
    default:
        $server = $server_list['unk'];
        $server[] = 'unk';
        break;
}

// MODXの設定にサーバー種別を設定 要「[303] OnGetConfig」
if($modx->event->name === 'OnGetConfig') {
    $modx->config['server_type'] = $server['type'];
    return;
}

// 画面出力
echo "<style type=\"text/css\">
.box-servername {
    padding: 0.5em 1em;
    margin: 1em 1em;
    color: {$server['colors'][0]};
    background: {$server['colors'][1]};
    border-left: solid 10px {$server['colors'][2]};
}
.box-servername p {
    margin: 0;
    padding: 0;
}
</style>";

printf('<div class="box-servername"><p>%s (Server IP address: %s)</p></div>', $server['name'], $_SERVER['SERVER_ADDR']);