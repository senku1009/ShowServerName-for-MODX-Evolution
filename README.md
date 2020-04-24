# ShowServerName-for-MODX-Evolution

## はじめに

MODX Evolutionの管理画面にサーバー環境名を表示するプラグイン

## 導入手順

1. 設定に以下のオプションを追加し、各種環境の IP アドレスを指定。

   ```
   &prd_ip=本番環境;text;10.0.0.1 &stg_ip=ステージング環境;text;10.0.0.2 &edt_ip=執筆環境;text;10.0.0.3 &tst_ip=テスト環境;text;10.0.0.5 &dev_ip=開発環境;text;10.0.0.6
   ```

2. システムイベントの登録
   システムイベントの以下の項目を有効化。

   - 管理画面に常に表示する
     > [4] Manager Access Events -> [206] OnManagerMainFrameHeaderHTMLBlock
   - ログイン画面に表示する
     > [4] Manager Access Events -> [99] OnManagerLoginFormPrerender
   - MODX の設定にサーバー種別を格納する
     > [4] Manager Access Events -> [303] OnGetConfig

3. 他のモジュールなどでサーバー種別を判定を行う場合
   ```php
   if (isset($modx->config['server_type']) && $modx->config['server_type'] === 'prd') {
       return 'this is product server.';
   }
   ```

## 免責
