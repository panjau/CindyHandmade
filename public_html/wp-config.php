<?php
/** 
 * WordPress 基本設定檔。
 *
 * 本檔案包含以下設定選項： MySQL 設定、資料表前綴、
 * 私密金鑰、WordPress 語言設定以及 ABSPATH。如需更多資訊，請
 * 前往 {@link http://codex.wordpress.org/Editing_wp-config.php 編輯
 * wp-config.php} Codex 頁面。或者向您的空間提供商諮詢關於 MySQL 設定資訊。
 *
 * 這個檔案用於安裝程式自動生成 wp-config.php 設定檔。
 * 您不需要將它用於您的網站，可以手動複製這個檔案，
 * 並重新命名為 "wp-config.php"，然後輸入相關訊息。
 *
 * @package WordPress
 */

// ** MySQL 設定 - 您可以從主機服務提供商獲取相關資訊。 ** //
/** WordPress 的資料庫名稱，請更改 "database_name_here" */
define('DB_NAME', 'a6410546_cindy');

/** MySQL 資料庫使用者名稱，請更改 "username_here" */
define('DB_USER', 'a6410546_cindy');

/** MySQL 資料庫密碼，請更改 "password_here" */
define('DB_PASSWORD', 'r94922141');

/** MySQL 主機位址 */
define('DB_HOST', 'mysql12.000webhost.com');

/** 建立資料表時預設的文字編碼 */
define('DB_CHARSET', 'utf8');

/** 資料庫對照型態。如果不確定請勿更改。 */
define('DB_COLLATE', 'utf8_unicode_ci');

define('WP_MAX_MEMORY_LIMIT', '256M');

/**#@+
 * 認證唯一金鑰設定。
 *
 * 將這些更改為不同的唯一字串或符號。
 * 您可以使用 {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org 私密金鑰服務} 來自動產生。
 * 您可於任何時候修改這些字串讓 Cookies 失效。這將會強制所有使用者必須重新登入。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '6XYEsv05)<B90&8N5a`}UkMS0|}|sd2X^rD]= GVji@X*axE l#<zXz*A<FK %2`');
define('SECURE_AUTH_KEY',  'C P=nH7Sn~#tzGan)-uo=V^H5]@JXN3+.2 Oq?bJfQSd,-V}jgtUV:T.T@D<@{G!');
define('LOGGED_IN_KEY',    'C|kd&_oO9,%1C3h%~aD9~wlj]-8VT7[|C1-Hy.jT=.+s3?+_ Qs?2;CCRz,*q=$x');
define('NONCE_KEY',        '=CQ_bO$0V$N>,|vJtLN(+| [.P=wmK7-->fE5T|p+8EIIf7)i~%f|t Pp~ 0`Ho ');
define('AUTH_SALT',        'T04nSYp<Q9>bR[m*>Ez*Zj}*zeR8kVv7ZgG/`%1udz{^C*L6bwlzD-o5| l+5~N/');
define('SECURE_AUTH_SALT', '8xgOn`9e/?E&O`IS3JKFQ-lIR5T]TEtFif-`A*-1e9SU4]_#1$4yDs$-3o~stT,R');
define('LOGGED_IN_SALT',   'F=+3aC,l{Sc5Q|B=Z;e#)KAVCTN]:mD<JwW;9&/fj;`Dr_GM%BDh{K] q9u+|uiK');
define('NONCE_SALT',       'Ob^ME7HDPaXVqP+nEeJYLF<luN#VN^Y}oBdr`_Dtm=}Ub&Kv6p(h~w;-DE+}^Dd;');

/**#@-*/

/**
 * WordPress 資料表前綴。
 *
 * 若您為每個 WordPress 設定不同的資料表前綴，則可在同個資料庫內安裝多個 WordPress。
 * 前綴只能使用半型數字、字母和底線！
 */
$table_prefix  = 'wp_';

/**
 * WordPress 本地化語言設定。預設為正體中文。
 *
 * 舉例來說，要使用 WordPress 正體中文介面，只需要填入 'zh_TW'。 
 * 更改此設定將 WordPress 本地化。對應的 MO 檔案必須放置於 wp-content/languages 目錄下。
 * 舉例來說，將 zh_TW.mo 放置於 wp-content/languages 內並將 WPLANG 設定為 'zh_TW' 將
 * 使用正體中文介面。
 */
define ('WPLANG', 'zh_TW');

/**
 * WordPress 自動儲存間隔
 *
 * 當您編輯文章時 WordPress 使用 Ajax 技術自動地定時幫您儲存文章草稿。
 * 您可更改數值以延長或減少自動儲存的時間間隔。
 * 預設儲存間隔為 60 秒。
 */
//define('AUTOSAVE_INTERVAL', 60 );  // 單位：秒

/**
 * WordPress 文章版本設定
 *
 * WordPress 預設會幫您儲存舊版的文章與分頁，以便您之後可以回復到先前的版本。
 * 這功能可關閉，或是指定最大版本數量。
 * 預設為開啟，若要關閉請將它設為 false。
 * 若您想指定指定最大版本數量，請設個整數。
 */
//define('WP_POST_REVISIONS', true );

/**
 * 快取
 *
 * 若 WP_CACHE 值為 true，當它執行 wp-settings.php 時會把 wp-content/advanced-cache.php 一起執行。
 * 許多快取外掛會要求您將這個值設為 true。
 */
//define('WP_CACHE', false);

/**
 * 啟用多網誌站台與網誌網路功能
 *
 * 若 WP_ALLOW_MULTISITE 值為 true 可啟用多網誌站台功能。
 */
//define('WP_ALLOW_MULTISITE', false);

/**
 * 開發人員用： WordPress 偵錯模式。
 *
 * 將此設定為 true 將可開啟開發時的通知顯示。
 * 強烈建議外掛與佈景主題開發人員使用 WP_DEBUG
 * 於他們的開發環境中。
 */
define('WP_DEBUG', false);

/* 設定完成，請儲存檔案。然後開始 Blogging 吧！ */

/** WordPress 目錄的絕對路徑。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 設定 WordPress 變數和包含的檔案。 */
require_once(ABSPATH . 'wp-settings.php');
