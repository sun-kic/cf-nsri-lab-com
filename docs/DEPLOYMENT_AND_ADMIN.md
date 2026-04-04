# 管理者画面・本番デプロイ手順

本ドキュメントでは、**再エネ施設の管理画面**の使い方、**管理者ユーザーの設定**、**サーバーへの同期（更新）**についてまとめます。

## 本リポジトリで追加・関連した機能（概要）

- **再エネ施設管理（管理者向け）** … `/admin/renewable-facilities` で CRUD。`renewable_facilities` テーブル・`users.is_admin`。
- **HOME** … 施設一覧は DB 参照。施設名クリックで住所ジオコーディングし地図に表示（Google Geocoding / Maps の設定が必要）。
- **TODAY 活動** … 「2/6. 時間を入力」にプリセット（在宅 / 在宅・出社 / 出社・在宅）。
- **本番トラブルシュートの例** … CLI と Web の PHP バージョン差、`fileinfo` / `mbstring`、`vendor` の権限、`storage` 書き込み、管理一覧は `Str::limit` をやめ CSS 省略表示に変更済み（mbstring 未導入でも一覧表示可）。

---

## 1. 管理者画面の使用方法

### 1.1 概要

ログイン後、**管理者（`is_admin = true`）** のユーザーのみが、再エネ施設リストの **登録・編集・削除** を行える画面にアクセスできます。

### 1.2 画面への入り方

| 方法 | 内容 |
|------|------|
| **メニュー** | 画面上部のハンバーガーメニューを開き、**「再エネ施設管理」** を選択（管理者のみ表示） |
| **URL** | `https://（ドメイン）/admin/renewable-facilities` |

例（ローカル）: `http://127.0.0.1:8000/admin/renewable-facilities`

### 1.3 できること

- **一覧** … 登録済み施設をカテゴリ・表示順・施設名・紹介・アドレスで確認。編集・削除ボタンあり。
- **新規登録** … 「新規登録」から、カテゴリ（カフェ / スキーリゾート / 温泉施設 / ホテル）、施設名、施設紹介、アドレス、表示順を入力して保存。
- **編集** … 一覧の「編集」から同項目を更新。
- **削除** … 一覧の「削除」（確認ダイアログの後に削除）。

### 1.4 TOP（HOME）との関係

HOME の「あなたの地域のおすすめ情報」内 **「再エネを導入している施設」** のタブと表は、**データベースの `renewable_facilities` テーブル**の内容を表示します。管理画面で変更すると、次回表示から反映されます。

### 1.5 初期データ

マイグレーション後、施設が空のときはシーダーでサンプルを投入できます。

```bash
php artisan db:seed --class=Database\\Seeders\\RenewableFacilitySeeder --force
```

（本番では運用方針に合わせて実行してください。）

---

## 2. 管理者ユーザーの付け方

管理者かどうかは、**`users` テーブルの `is_admin` カラム**（boolean）で判定します。マイグレーション `2026_04_04_000001_add_is_admin_to_users_table` 適用後に利用できます。

### 2.1 Artisan Tinker（推奨）

プロジェクトルートで:

```bash
php artisan tinker
```

メールアドレスで指定:

```php
\App\Models\User::where('email', '管理者のメールアドレス@example.com')->update(['is_admin' => true]);
```

ユーザー ID で指定:

```php
\App\Models\User::where('id', 1)->update(['is_admin' => true]);
```

終了: `exit`

### 2.2 SQL で直接更新

```sql
UPDATE users SET is_admin = 1 WHERE email = '管理者のメールアドレス@example.com';
```

### 2.3 確認

- 再ログイン後、ハンバーガーメニューに **「再エネ施設管理」** が出るか。
- `/admin/renewable-facilities` にアクセスし、**403 にならない**か。

### 2.4 注意

- 一般ユーザーの新規登録フォームから `is_admin` を送らない実装のままにしておくと、**勝手に管理者が増えにくく**なります。
- 管理者を外すときは `is_admin` を `false` / `0` に更新します。

---

## 3. サーバーへの同期方法

ここでは **Ubuntu + aaPanel**、ドキュメントルートが **`/www/wwwroot/cf.nsri-lab.com`** である前提の例を示します。パス・ユーザー名は環境に合わせて読み替えてください。

### 3.1 事前確認

- サイトの **PHP バージョン**（例: PHP 8.3）と **CLI の `php`** が一致しているか（`php -v`）。  
  不一致のときは `/www/server/php/83/bin/php` など **フルパス**で `composer` / `artisan` を実行するか、`PATH` を通す。
- **拡張**: `fileinfo`（Composer / Flysystem）、**`mbstring`**（Laravel 全体で推奨）を PHP（CLI / FPM 両方）で有効にする。
- **Web ルート**が Laravel の **`public`** を指していること。

### 3.2 コードの取得（Git）

```bash
cd /www/wwwroot/cf.nsri-lab.com
sudo git pull origin main
```

ブランチ名は運用に合わせて変更。

### 3.3 PHP 依存関係

```bash
cd /www/wwwroot/cf.nsri-lab.com
composer install --no-dev --optimize-autoloader --no-interaction
```

root で実行する場合は Composer の警告に従い、`COMPOSER_ALLOW_SUPERUSER=1` を付けるか、**`www` ユーザーで実行**する方が望ましいです。

```bash
sudo -u www -H bash -lc 'cd /www/wwwroot/cf.nsri-lab.com && composer install --no-dev --optimize-autoloader --no-interaction'
```

### 3.4 フロント（Vite）

サーバーでビルドする場合:

```bash
npm ci
npm run build
```

別マシンでビルド済みの `public/build` をデプロイする運用でも構いません。

### 3.5 データベース

```bash
php artisan migrate --force
```

必要に応じてシーダー（上記 1.5）。

### 3.6 キャッシュ（本番）

```bash
sudo -u www -H php /www/wwwroot/cf.nsri-lab.com/artisan config:cache
sudo -u www -H php /www/wwwroot/cf.nsri-lab.com/artisan route:cache
sudo -u www -H php /www/wwwroot/cf.nsri-lab.com/artisan view:cache
```

`.env` を変えたあとは **必ず `config:cache` をやり直す**こと。

### 3.7 所有権・権限（重要）

`git pull` や `sudo` で更新したあと、**Web ユーザー（aaPanel では多くは `www`）に戻す**と、ログやキャッシュ・セッションで詰まりにくくなります。

```bash
sudo chown -R www:www /www/wwwroot/cf.nsri-lab.com
sudo chmod -R 775 /www/wwwroot/cf.nsri-lab.com/storage
sudo chmod -R 775 /www/wwwroot/cf.nsri-lab.com/bootstrap/cache
```

`public/.user.ini` で **`chown: Operation not permitted`** になる場合は、`lsattr` で **immutable（`i`）** が付いていないか確認し、パネル手順に従って調整するか、**`storage` と `bootstrap/cache` と `vendor` だけ** `chown` する方法でも可。

### 3.8 同期作業の流れ（まとめ）

1. `git pull`  
2. `composer install --no-dev ...`（必要なら `npm run build`）  
3. `php artisan migrate --force`  
4. `php artisan config:cache` など  
5. `chown` / `chmod` で **www と storage・bootstrap/cache** を整える  

---

## 参考（リポジトリ内）

- ルート: [`routes/web.php`](../routes/web.php) … `admin` ミドルウェア付き `renewable-facilities`  
- コントローラ: [`app/Http/Controllers/Admin/RenewableFacilityController.php`](../app/Http/Controllers/Admin/RenewableFacilityController.php)  
- ミドルウェア: [`app/Http/Middleware/EnsureUserIsAdmin.php`](../app/Http/Middleware/EnsureUserIsAdmin.php)  
- 開発ガイド: ルートの [`AGENTS.md`](../AGENTS.md)

---

*このファイルは運用説明用です。環境固有のパス・ユーザー名はサーバー実態に合わせてください。*
