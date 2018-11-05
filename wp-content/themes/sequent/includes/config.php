<?php

// Env

$sl_page_protocol = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
$sl_page_url      = $sl_page_protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$sl_domain        = $sl_page_protocol . $_SERVER['HTTP_HOST'];

if ( strpos( $sl_page_url, '?') > -1 ) {
  $sl_page_url = substr( $sl_page_url, 0, strpos( $sl_page_url, '?') );
}

// Globals

define( 'SL_VERSION', '1.2.0' );
define( 'SL_DEBUG', true );
define( 'SL_DEV', ( strpos( $sl_page_url, '.test') !== false || strpos( $sl_page_url, 'localhost') !== false ) );
