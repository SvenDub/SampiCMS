<?php

/**
 * SampiCMS settings file
 *
 * Contains settings which can't be set via a database.
 *
 * @author Sven Dubbeld <sven.dubbeld1@gmail.com>
 */
/**
 * Namespace
 */
namespace SampiCMS;
use SampiCMS;
/**
 * The current version of SampiCMS
 */
define ( 'SampiCMS\version', '0.0.1-alpha' );
/**
 * The name of the database.
 */
define ( 'SampiCMS\db', '' );
/**
 * The username used to connect to the database.
 */
define ( 'SampiCMS\db_user', '' );
/**
 * The password used to connect to the database.
 */
define ( 'SampiCMS\db_pass', '' );
/**
 * The database server to connect to.
 *
 * This is usually either '127.0.0.1' or 'localhost'. Contact your hosting provider for the correct address.
 */
define ( 'SampiCMS\db_host', '' );

/**
 * Name of the server administrator.
 */
define ( 'SampiCMS\admin', '' );
/**
 * Email address of the server administrator.
 */
define ( 'SampiCMS\admin_mail', '' );
?>