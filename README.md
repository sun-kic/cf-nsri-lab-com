# カーボン消費計算アプリ

ログインしたユーザーが、勤務・移動・食事などの日々の活動を記録し、カーボンに関する指標をダッシュボードで確認できる **Laravel 9** 製の Web アプリケーションです。画面やメッセージの一部は日本語です。

## 主な機能

- **ダッシュボード**（`/`）: `Carbonsum` や直近の `Today` データに基づく集計・推移の表示
- **今日の記録**（`/today`）: 日次の活動・カーボン関連データの入力・編集
- **カイゼン**（`/kaizen`）、**データ**（`/data`）、**About**（`/about`）、**プロフィール**（`/profile`）
- **認証**: 登録・ログイン・ログアウト、パスワードリセット（ルートは `routes/web.php` に定義）

API は `GET /api/user`（`auth:sanctum`）が中心で、公開 REST API はありません。

## 技術スタック（概要）

- PHP **^8.0.2**、Laravel **9**
- フロント資産: **Vite 3**（`npm run dev` / `npm run build`）
- 認証: セッション + **Laravel Sanctum**

リポジトリのディレクトリ構成、ルート一覧、モデルとコントローラの対応は **[AGENTS.md](./AGENTS.md)** の **Application Structure (This Repository)** を参照してください。

## 開発を始める

1. `composer install`
2. `npm install`
3. `.env.example` を `.env` にコピーし、`php artisan key:generate` で `APP_KEY` を設定
4. データベースを `.env` で設定したうえで `php artisan migrate`
5. 開発時: `php artisan serve` と、別ターミナルで `npm run dev`

詳しいコマンド、テスト、コミット・PR のルールは [AGENTS.md](./AGENTS.md) にまとめています。
