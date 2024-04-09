<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'exporter_kqkq_gbbaktxylejgrmafdc' );

/** MySQL database username */
define( 'DB_USER', 'xjsekqpbamatlcbl' );

/** MySQL database password */
define( 'DB_PASSWORD', 'CFkg46f2V3v6xVb' );

/** MySQL hostname */
define( 'DB_HOST', 'exporter.domaincommysql.com' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ')bJ+ZGDjF>;>[K}2qd_Kqi(`cB1~j&Zp/j6,|t%X6,n%,XMq=y_uML,1=GF=5xEp');
define('SECURE_AUTH_KEY',  'XaM:IB?{:+S.zW+K@Of1lafJ<OjsnvgKYM{Fr&h$8Y-g%N ;htDY!O`p&q~R+ZL{');
define('LOGGED_IN_KEY',    'J){.b5K/1pG<nN0GIVm+TtKgOZ4kRH0U3zGxNeBOOy]YTm<4Q4L2G;5H,:dCG%+]');
define('NONCE_KEY',        'x+,3.piwUyF!8?c6+lAC|M[S)G{ixp8ViBJVdVkFud/4r1ng^-zW[ %Hw;J$^/fw');
define('AUTH_SALT',        '7qZb4O:3Q+Bb4;q7UV ?;f<R|Wj5;+(:@iSX9e{<n`U|/M<5f3goLe8++mEB-2cF');
define('SECURE_AUTH_SALT', '70uPW}R7K8|_,FShpNHT4+bjg9<`BB><J?h~Jg s_-u9G*2E-ua~; 6z|/&+Ag-{');
define('LOGGED_IN_SALT',   'W7ob9rS%-l/;nPam?W:N!kw**Q(6rPC--*hV}Dftv*H2k4i&3q3?|?gY<IQ~N,Qi');
define('NONCE_SALT',       'Ck|1X;j1RWI&`x%g&iuXd`])cS8%D/I*:*5aPHRU5Ung){-nsw0-vl;W^I-Zi>T2');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'kqkq_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('FS_METHOD', 'direct');
