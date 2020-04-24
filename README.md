# ShowServerName-for-MODX-Evolution

## はじめに

MODX Evolution の管理画面にサーバー環境名を表示するプラグイン。  
IP アドレスを判定に使用しているのでデータベースを環境間で同期しても動作します。

## スクリーンショット

- ログイン画面の上部にサーバー環境名を表示

  ![login_screen](https://raw.githubusercontent.com/senku1009/ShowServerName-for-MODX-Evolution/images/login_screen-20200424.png)

- 管理画面内にサーバー環境名を表示

  ![manager_screen](https://raw.githubusercontent.com/senku1009/ShowServerName-for-MODX-Evolution/images/manager_screen-20200424.png)

## 導入手順

1. プラグインの作成  
   管理画面から「エレメント」タブ->「エレメント管理」->「プラグイン」タブ->「プラグインを作成」の手順でプラグインを新規作成します。  
    以下の画像のようにプラグイン名の入力、プラグインコード（app/ShowServerName.plugin.php）のコピペを行ってください。

   ![setting_1](https://raw.githubusercontent.com/senku1009/ShowServerName-for-MODX-Evolution/images/settings_1-20200424.png)

1. 設定に以下のオプションを追加し、各種環境の IP アドレスを指定。

   プラグイン作成画面から「設定」タブを開いて「プラグイン設定」に以下の内容をコピペを行い、「パラメータ表示を更新」を押してください。

   ```
   &prd_ip=本番環境;text;10.0.0.1 &stg_ip=ステージング環境;text;10.0.0.2 &edt_ip=執筆環境;text;10.0.0.3 &tst_ip=テスト環境;text;10.0.0.5 &dev_ip=開発環境;text;10.0.0.6
   ```

   続いて各種サーバー環境の IP アドレスを入力してください。

   ![setting_2](https://raw.githubusercontent.com/senku1009/ShowServerName-for-MODX-Evolution/images/settings_2-20200424.png)

1. システムイベントの登録
   システムイベントの以下の項目を有効化。

   - 管理画面に常に表示する  
     `[4] Manager Access Events` -> `[206] OnManagerMainFrameHeaderHTMLBlock`
   - ログイン画面に表示する  
     `[4] Manager Access Events` -> `[99] OnManagerLoginFormPrerender`
   - MODX の設定にサーバー種別を格納する  
     `[4] Manager Access Events` -> `[303] OnGetConfig`

   ![setting_3](https://raw.githubusercontent.com/senku1009/ShowServerName-for-MODX-Evolution/images/settings_3-20200424.png)

1. 他のモジュールなどでサーバー種別を判定を行う場合
   ```php
   if (isset($modx->config['server_type']) && $modx->config['server_type'] === 'prd') {
       return 'this is product server.';
   }
   ```

## 免責
