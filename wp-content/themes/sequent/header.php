<?php
global $header_transparent;

$main_title = get_bloginfo( 'name' );
$social_links = get_field( 'global_social', 'option' );

$scripts_head = get_field( 'scripts_head', 'option' );
$scripts_body = get_field( 'scripts_body', 'option' );
?><!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <link rel="stylesheet" href="https://use.typekit.net/puq8glt.css">

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PCTC43F');</script>
<!-- End Google Tag Manager -->

    
    <?php wp_head(); ?>
    <?php sl_favicons(); ?>
    <?php echo $scripts_head; ?>
  </head>
  <body <?php body_class( 'fs-grid fs-grid-fluid' ); ?>>
    
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCTC43F"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php echo $scripts_body; ?>

    <div class="container js-mobile_nav_content">

      <header class="header">
        <div class="fs-row">
          <div class="fs-cell">
            <a href="<?php echo get_home_url(); ?>" class="header_logo">
              <span class="icon logo_main"></span>
              <span class="screenreader"><?php echo $main_title; ?></span>
            </a>
            <div class="main_nav">
              <?php sl_main_navigation( 2 ); ?>
            </div>
            <button type="button" class="mobile_nav_handle js-mobile_nav_handle">
              <span class="line_1"></span>
              <span class="line_2"></span>
              <span class="line_3"></span>
              <span class="screenreader">Menu</span>
            </button>
          </div>
        </div>


        <?php
          $navigation_options = array(
            'type'     => 'overlay',
            'gravity'  => 'right',
            'label'    => false,
            'maxWidth' => '1219px'
          );
        ?>
        <div class="mobile_nav_tray js-navigation" data-navigation-handle=".js-mobile_nav_handle" data-navigation-options="<?php echo sl_json_options( $navigation_options ); ?>" aria-hidden="true">
          <div class="mobile_nav_container">
            <nav class="mobile_nav main_nav">
              <?php sl_main_navigation( 2 ); ?>
            </nav>
            <div class="mobile_social">
              <?php
                foreach ( $social_links as $social_link ) :
              ?>
              <a href="<?php echo $social_link['link']; ?>" class="mobile_social_link" target="_blank">
                <span class="icon social_<?php echo strtolower( $social_link['service'] ); ?>_white"></span>
                <span class="screenreader"><?php echo $social_link['service']; ?></span>
              </a>
              <?php
                endforeach;
              ?>
            </div>
          </div>
        </div>

      </header>

      <div class="page_wrapper">
        <main class="main">
