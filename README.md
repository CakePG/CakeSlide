# CakeSlide plugin for CakePHP

version 2018.02.13.00

## インストール

下記のコンフィグに一行追加して読み込みます。
config/bootstrap.php
```
Plugin::load('CakePG/CakeSlide', ['bootstrap' => true, 'routes' => true]);
```

`composer.json`に下記のを追記
以下、例
```
"repositories": [
    {
        "type": "vcs",
        "no-api": true,
        "url":  "git@github.com:CakePG/CakeSlide.git"
    }
],
```

キャッシュをクリア
```
docker-compose run --rm php php composer.phar dumpautoload
```

### テーブルを作成
```
docker-compose run --rm php php bin/cake.php migrations migrate -p CakePG/CakeSlide
```

### 設定

`vendor/CakePG/CakeSlide/config/slide.php`をコピーして`config`に置きます。
config/bootstrap.phpに以下一行追加して読み込みます。
```
Configure::load("slide");
```

#### 文言を変更する場合
`vendor/CakePG/CakeSlide/src/Locale/ja_JP/cakeslide.po`の内容を以下のファイルに追加してください。
`src/Locale/ja_JP/cakeslide.po`（ない場合は作成）

## 更新履歴

2018.02.13 コンポーザーからインストールするように変更

2017.11.28 作成時に順序が最後になるように修正。

2017.11.25 削除のエラーとソートの順番表示を修正

2017.11.23 アップロードしたファイルが傾く問題を修正。

2017.11.20 トップスライド機能作成。
