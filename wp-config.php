<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'wordpress');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'root');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'Jwaka228');

/** MySQL のホスト名 */
define('DB_HOST', 'localhost');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '6!z@uLS>-~f:hKHVVM<,di/8cMDDDmrR: _P0AG!$17{Z[WoLPSC2~KwsvkvM3^P');
define('SECURE_AUTH_KEY',  'Xh]YIP-W#p$NNU~&HFe(Eq]Td?KF%ZMp_Dk3]Y7JecrW6Ry^;X15yGrP%(4QpSrk');
define('LOGGED_IN_KEY',    '}Yt+*=FO0cRa:T<*)89S2_ju ?[^?=1-=L4Y[]k|.LWf]q/O*y.K-VW$._SX=Fye');
define('NONCE_KEY',        '%hpB[Y5-v?/Luq_AC$kL|j1;3kV)&rG:g*m1RvtH.{BxvYHqg,J5,RleqW}FLa|V');
define('AUTH_SALT',        '20Vgl`q/Q<.7%BC8&^,l+<ISe8sewoNIi&Ik~6fgu6vFG#]*LpSJUN8#^?)h] +#');
define('SECURE_AUTH_SALT', 'Z^ht}E`I2kZomu&/2%Xru7&H5vVW`h)s~{Aq-X-tB|?a].%nPO>>H@`fHQ~pua~W');
define('LOGGED_IN_SALT',   '!*.pun;u3&$%GM-RRz%0KN9-mZ:]y>t^KRXAQL5C!%&wns4h5gXd=K(#/R]x*5ep');
define('NONCE_SALT',       'MTWT|I$^YoQ7{]kP#I n?IIGmY~3o>8w+(?.$M$0&%{<Oq;`to9>FTJd~Ot`Dx3{');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/*Fileのオーナー権限をすべての人に与える*/
define('FS_METHOD','direct');
