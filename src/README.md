# Atte（アット）
AtteはWeb上で出勤、退勤および休憩の勤怠状況を管理できるサービスです。
![Atte-Top](storage/Atte-top.png)

## 作成した目的
人事評価のため作成しました。制作目標は利用者数100人達成です。

## アプリケーションURL
- 開発用環境<http://localhost/>
- 本番環境<http://13.231.44.24/>

ログイン前はログイン画面に移行します。会員登録を行なっていない場合は、登録後に使用できます。
## 他のレポジトリ

## 機能一覧
- 会員登録機能
- ログイン機能
- ログアウト機能
- 勤務開始機能
- 勤務終了機能
- 休憩開始機能
- 休憩終了機能
- 日付別勤怠情報取得機能
- ユーザー一覧機能
- ユーザーごとの勤怠情報取得機能
- ページネーション機能

## 使用技術（実行環境）
- PHP 8.2.9
- Laravel 8.83.8
- MySQL 8.1.0
- Nginx 1.22.1
- AWS
  - EC2
  - RDS
  - S3

## テーブル設計
Usersテーブル
![table-users](storage/table-users.png)

Stampsテーブル
![table-stamps](storage/table-stamps.png)

Restsテーブル
![table-rests](storage/table-rests.png)

## ER図
![ER](storage/er.drawio.png)

## 環境構築
#### プロジェクトのセットアップ手順
##### ディレクトリの作成
アプリケーションを作成するために、開発環境を GitHub からクローンします。
`laravel-docker-template.git`をクローンしてください。
```bash
$ git clone git@github.com:coachtech-material/laravel-docker-template.git
```
##### Docker の設定
次に、Docker の設定を行なっていきます。
複数のコンテナを扱うのでdocker-composeを使います。
```bash
$ docker-compose up -d --build
$ code .
```
##### Laravel のパッケージのインストール
docker-composeコマンドで PHPコンテナ内にログインし、composerコマンドを使って必要なパッケージをインストールします。
```bash
$ docker-compose exec php bash
$ composer install
```
##### .envファイルの作成
.envファイルは、.env.exampleファイルをコピーして作成しましょう。
```bash
$ cp .env.example .env
$ exit
```
.envファイルは以下のように修正します。
```
// 前略
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
// 後略
```
##### viewファイルの作成
各ページのviewファイルを作成します。
resources/viewsに、以下4つのBladeファイルを作成します。
| ファイル名| 表示内容 |
| ---- | ---- |
| index.blade.php | 打刻ページ |
| attendance.blade.php | 日付別勤怠ページ |
| user.blade.php | ユーザー一覧ページ |
| user_information.blade.php | ユーザー勤怠表ページ |

また、resources/views/authに以下3つのBladeファイルを作成します。
| ファイル名| 表示内容 |
| ---- | ---- |
| login.blade.php | ログインページ |
| register.blade.php | 会員登録ページ |
| verify-email.blade.php | メール送信確認ページ |

さらに、resources/views/layoutsに以下のBladeファイルを作成します。
| ファイル名| 表示内容 |
| ---- | ---- |
| app.blade.php | ヘッダーとフッダー |

##### cssファイルの作成
cssファイルを作成します。
public/cssに以下9つのファイルを配置します。
- index.css
- attendance.css
- user.css
- user_information.css
- login.css
- register.css
- verify-email.css
- app.blade.css
- sanitize.css

##### RouteとControllerの作成
Controllerファイルを作成し、以下のルート及びアクションを紐付けします。
![controller](storage/controller.png)
##### Modelの作成
各モデルを作成します。

![model](storage/model.png)
##### Fortifyの導入と会員登録機能、ログイン機能の実装
Laravelをインストールしたプロジェクト内でfortifyをインストールし、関連ファイルを作成します。
その後、マイグレートを実行します。
```bash
$ composer require laravel/fortify
$ php artisan migrate
$ php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
```
app/config/app.phpファイルでFortifyServiceProviderを有効にします。
```bash
App\Providers\FortifyServiceProvider::class,
```
app/Providers/FortifyServiceProvider.phpファイルにて、会員登録、ログイン画面の設定を行います。

```
public function boot()
{
    Fortify::registerView(function () {
        return view('auth.register');
    });
    Fortify::loginView(function () {
        return view('auth.login');
    });
```
web.phpにて、ミドルウェアでログイン認証を設定します。
```
Route::middleware('Auth')->group(function () {
```
##### バリデーションの変更
以下のファイルでバリデーションを設定します。
![validation](storage/validation.png)
バリデーションが英語の場合、以下のコマンド実行し、resources/lag/ja/validation.phpファイルを編集します。
```bash
$ php -r "copy('<https://readouble.com/laravel/8.x/ja/install-ja-lang-files.php>', 'install-ja-lang.php');"
$ php -f install-ja-lang.php
$ php -r "unlink('install-ja-lang.php');"
```
##### ページネーション機能の実装
以下のコマンドを実行します。
```bash
$ php artisan vendor:publish --tag=laravel-pagination
```
tailwind.blade.phpを編集し、リンク先に設定します。
##### メール認証機能の実装
fortifyのメール認証機能を使用します。
config/fortifyにある以下の機能をコメントアウトします。
```
Features::emailVerification(),
```
app/Providers/FortifyServiceProvider.phpファイルにて、メール認証の設定を行います。
```
Fortify::verifyEmailView(fn () => view('auth.verify-email'));
```
web.phpにて、ミドルウェアでメール認証を設定します。
```
Route::middleware('verified')->group(function () {
```
今回は本番環境用のメールサーバーを無料で使用することが困難であると判断し、開発用のメールサーバーMaiHogをローカル環境で使用します。
docker-compose.ymlを編集します。
```
mailhog:
  image: 'mailhog/mailhog:latest'
  ports:
      - 1025:1025
      - 8025:8025
```
イメージをビルドし、コンテナを起動します。
```bash
docker-compose up -d --build
code .
```
.envファイルを修正します。
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=maccha
MAIL_PASSWORD=abcdsfgn
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=<example@gmail.com>
MAIL_FROM_NAME="${APP_NAME}"
```
##### EC2の環境構築
AWSにログイン後、EC2インスタンスを作成します。　　
Amazon Linux 2にログイン後、Nginx、PHP、Composerをイ
ンストールします。　　
PHP-FPM、NginXの設定を行います。　　
上記で作成したLaravelプロジェクトをGitHubからクローンします。　　
sockの設定、app/storageの権限の変更、PHPライブラリのインストール、.envファイルの設定を行います。

以下のURLから閲覧できます。
<http://13.231.44.24/>

メール認証機能は時間がなかったためしていません。
また、同様の理由で本説明も簡潔に書いています。
##### RDSの環境構築
AWSにログイン後、RDSでデータベースを作成します。　　
Amazon Linux 2にログイン後、MySQLをインストールします。　　
E上記で使用したC2インスタンスのセキュリティグループを設定します。　　
.envを変更します。　　
マイグレーションを実行します。

なお、DBの可視化をしたかったため、phpMyAdminをインストールし、.envファイルを設定しました。
また、時間がなかったため本説明を簡潔に書いています。

##### S3の環境構築
時間がなかったため出来ませんでした。
