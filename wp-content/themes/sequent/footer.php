<?php
$main_title = get_bloginfo( 'name' );
$social_links = get_field( 'global_social', 'option' );

$search_page = get_field( 'global_search_page', 'option' );
$register_page = get_field( 'global_register_page', 'option' );
?>
        </main>
      </div>
      <footer class="footer">
        <div class="footer_top">
          <div class="fs-row">
            <div class="fs-cell">
              <a href="<?php echo get_home_url(); ?>" class="footer_logo">
                <span class="icon logo_white"></span>
                <span class="screenreader"><?php echo $main_title; ?></span>
              </a>
              <div class="footer_nav">
                <?php sl_main_navigation( 2 ); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="footer_bottom">
          <div class="fs-row">
            <div class="fs-cell">
              <div class="footer_social">
                <?php
                  foreach ( $social_links as $social_link ) :
                ?>
                <a href="<?php echo $social_link['link']; ?>" class="footer_social_link" target="_blank">
                  <span class="icon social_<?php echo strtolower( $social_link['service'] ); ?>_blue"></span>
                  <span class="screenreader"><?php echo $social_link['service']; ?></span>
                </a>
                <?php
                  endforeach;
                ?>
              </div>
              <p class="footer_copyright">&copy; <?php echo date( 'Y' ); ?> All Rights Reserved.</p>
            </div>
          </div>
        </div>
      </footer>
    </div>

    <?php wp_footer(); ?>

    <!-- Start of HubSpot Embed Code -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/2062555.js"></script>
    <!-- End of HubSpot Embed Code -->

  </body>
</html>
