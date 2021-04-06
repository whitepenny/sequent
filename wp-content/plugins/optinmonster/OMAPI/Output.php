<?php
/**
 * Output class.
 *
 * @since 1.0.0
 *
 * @package OMAPI
 * @author  Thomas Griffin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output class.
 *
 * @since 1.0.0
 */
class OMAPI_Output {

	/**
	 * Holds the class object.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Path to the file.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $file = __FILE__;

	/**
	 * Holds the base class object.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	public $base;

	/**
	 * Holds the meta fields used for checking output statuses.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $fields = array();

	/**
	 * Flag for determining if localized JS variable is output.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	public $localized = false;

	/**
	 * Flag for determining if localized JS variable is output.
	 *
	 * @since 1.0.0
	 *
	 * @var bool
	 */
	public $data_output = false;

	/**
	 * Holds JS slugs for maybe parsing shortcodes.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $slugs = array();

	/**
	 * Holds shortcode output.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $shortcodes = array();

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Checking if AMP is enabled.
		if ( OMAPI_Utils::is_amp_enabled() ) {
			return;
		}

		// Set our object.
		$this->set();

		add_filter( 'optinmonster_pre_campaign_should_output', array( $this, 'enqueue_helper_js_if_applicable' ), 999, 2 );

		// If no credentials have been provided, do nothing.
		if ( ! $this->base->get_api_credentials() ) {
			return;
		}

		// Load actions and filters.
		add_action( 'wp_enqueue_scripts', array( $this, 'api_script' ) );
		add_action( 'wp_footer', array( $this, 'localize' ), 9999 );
		add_action( 'wp_footer', array( $this, 'display_rules_data' ), 9999 );
		add_action( 'wp_footer', array( $this, 'maybe_parse_shortcodes' ), 11 );

		// Maybe load OptinMonster.
		$this->maybe_load_optinmonster();

	}

	/**
	 * Sets our object instance and base class instance.
	 *
	 * @since 1.0.0
	 */
	public function set() {

		self::$instance = $this;
		$this->base     = OMAPI::get_instance();

		$rules = new OMAPI_Rules();

		// Keep these around for back-compat.
		$this->fields = $rules->fields;

	}

	/**
	 * Enqueues the OptinMonster API script.
	 *
	 * @since 1.0.0
	 */
	public function api_script() {

		// A hook to change the API location. Using this hook, we can force to load in header; default location is footer
		$in_footer = apply_filters( 'optin_monster_api_loading_location', true );

		wp_enqueue_script( $this->base->plugin_slug . '-api-script', $this->base->get_api_url(), array(), null, $in_footer );

		if ( version_compare( get_bloginfo( 'version' ), '4.1.0', '>=' ) ) {
			add_filter( 'script_loader_tag', array( $this, 'filter_api_script' ), 10, 2 );
		} else {
			add_filter( 'clean_url', array( $this, 'filter_api_url' ) );
		}

	}

	/**
	 * Filters the API script tag to output the JS version embed and to add a custom ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $tag    The HTML script output.
	 * @param string $handle The script handle to target.
	 * @return string $tag   Amended HTML script with our ID attribute appended.
	 */
	public function filter_api_script( $tag, $handle ) {

		// If the handle is not ours, do nothing.
		if ( $this->base->plugin_slug . '-api-script' !== $handle ) {
			return $tag;
		}

		// Adjust the output to the JS version embed and to add our custom script ID.
		return $this->om_script_tag(
			array(
				'id' => 'omapi-script',
			)
		);
	}

	/**
	 * Filters the API script tag to add a custom ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url  The URL to filter.
	 * @return string $url Amended URL with our ID attribute appended.
	 */
	public function filter_api_url( $url ) {
		// If the handle is not ours, do nothing.
		if ( false === strpos( $url, str_replace( 'https://', '', $this->base->get_api_url() ) ) ) {
			return $url;
		}

		// Adjust the URL to add our custom script ID.
		return "$url' async='async' id='omapi-script";

	}

	/**
	 * Set the default query arg filter for OptinMonster.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $bool Whether or not to alter the query arg filter.
	 * @return bool      True or false based on query arg detection.
	 */
	public function query_filter( $bool ) {

		// If "omhide" is set, the query filter exists.
		if ( isset( $_GET['omhide'] ) && $_GET['omhide'] ) {
			return true;
		}

		return $bool;

	}

	/**
	 * Conditionally loads the OptinMonster optin based on the query filter detection.
	 *
	 * @since 1.0.0
	 */
	public function maybe_load_optinmonster() {

		// Add the hook to allow OptinMonster to process.
		add_action( 'pre_get_posts', array( $this, 'load_optinmonster_inline' ), 9999 );
		add_action( 'wp_footer', array( $this, 'load_optinmonster' ) );

		if ( ! empty( $_GET['om-live-preview'] ) || ! empty( $_GET['om-verify-site'] ) ) {
			add_action( 'wp_footer', array( $this, 'load_global_optinmonster' ) );
		}

	}

	/**
	 * Loads an inline optin form (sidebar and after post) by checking against the current query.
	 *
	 * @since 1.0.0
	 *
	 * @param object $query The current main WP query object.
	 */
	public function load_optinmonster_inline( $query ) {

		// If we are not on the main query or if in an rss feed, do nothing.
		if ( ! $query->is_main_query() || $query->is_feed() ) {
			return;
		}

		$priority = apply_filters( 'optin_monster_post_priority', 999 ); // Deprecated.
		$priority = apply_filters( 'optin_monster_api_post_priority', 999 );
		add_filter( 'the_content', array( $this, 'load_optinmonster_inline_content' ), $priority );

	}

	/**
	 * Filters the content to output an optin form.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content  The current HTML string of main content.
	 * @return string $content Amended content with possibly an optin.
	 */
	public function load_optinmonster_inline_content( $content ) {

		global $post;

		// If the global $post is not set or the post status is not published, return early.
		if ( empty( $post ) || isset( $post->ID ) && 'publish' !== get_post_status( $post->ID ) ) {
			   return $content;
		}

		// Don't do anything for excerpts.
		// This prevents the optin accidentally being output when get_the_excerpt() or wp_trim_excerpt() is
		// called by a theme or plugin, and there is no excerpt, meaning they call the_content and break us.
		global $wp_current_filter;

		if ( in_array( 'get_the_excerpt', (array) $wp_current_filter ) ) {
			return $content;
		}

		if ( in_array( 'wp_trim_excerpt', (array) $wp_current_filter ) ) {
			return $content;
		}

		// Prepare variables.
		$post_id = self::current_id();
		$optins  = $this->base->get_optins();

		// If no optins are found, return early.
		if ( empty( $optins ) ) {
			return $content;
		}

		// Loop through each optin and optionally output it on the site.
		foreach ( $optins as $optin ) {
			if ( OMAPI_Rules::check_inline( $optin, $post_id, true ) ) {
				$this->set_slug( $optin );

				// Prepare the optin campaign.
				$prepared = $this->prepare_campaign( $optin );
				$position = get_post_meta( $optin->ID, '_omapi_auto_location', true );
				$inserter = new OMAPI_Inserter( $content, $prepared );

				switch ( $position ) {
					case 'paragraphs':
						$paragraphs = get_post_meta( $optin->ID, '_omapi_auto_location_paragraphs', true );
						$content = $inserter->after_paragraph( absint( $paragraphs ) );
						break;

					case 'words':
						$words = get_post_meta( $optin->ID, '_omapi_auto_location_words', true );
						$content = $inserter->after_words( absint( $words ) );
						break;

					case 'above_post':
						$content = $inserter->prepend();
						break;

					case 'below_post':
					default:
						$content = $inserter->append();
						break;
				}
			}
		}

		// Return the content.
		return $content;

	}

	/**
	 * Possibly loads an optin on a page.
	 *
	 * @since 1.0.0
	 */
	public function load_optinmonster() {

		// Prepare variables.
		$post_id = self::current_id();
		$optins  = $this->base->get_optins();
		$init    = array();

		// If no optins are found, return early.
		if ( empty( $optins ) ) {
			return;
		}

		// Loop through each optin and optionally output it on the site.
		foreach ( $optins as $optin ) {
			$rules = new OMAPI_Rules( $optin, $post_id );

			if ( $rules->should_output() ) {
				$this->set_slug( $optin );

				// Prepare the optin campaign.
				$init[ $optin->post_name ] = $this->prepare_campaign( $optin );
				continue;
			}

			$fields = $rules->field_values;

			// Allow devs to filter the final output for more granular control over optin targeting.
			// Devs should return the value for the slug key as false if the conditions are not met.
			$init = apply_filters( 'optinmonster_output', $init ); // Deprecated.
			$init = apply_filters( 'optin_monster_output', $init, $optin, $fields, $post_id ); // Deprecated.
			$init = apply_filters( 'optin_monster_api_output', $init, $optin, $fields, $post_id );
		}

		// Run a final filter for all items.
		$init = apply_filters( 'optin_monster_api_final_output', $init, $post_id );

		// If the init code is empty, do nothing.
		if ( empty( $init ) ) {
			return;
		}

		// Load the optins.
		foreach ( (array) $init as $optin ) {
			if ( $optin ) {
				echo $optin;
			}
		}

	}

	/**
	 * Loads the global OM code on this page.
	 *
	 * @since 1.8.0
	 */
	public function load_global_optinmonster() {
		$option = $this->base->get_option();

		// If we don't have the data we need, return early.
		if ( empty( $option['userId'] ) || empty( $option['accountId'] ) ) {
			return;
		}

		$option['id'] = 'omapi-script-global';

		echo $this->om_script_tag( $option );
	}

	/**
	 * Sets the slug for possibly parsing shortcodes.
	 *
	 * @since 1.0.0
	 *
	 * @param object $optin The optin object.
	 */
	public function set_slug( $optin ) {
		$slug = str_replace( '-', '_', $optin->post_name );

		// Set the slug.
		$this->slugs[ $slug ] = array(
			'slug'     => $slug,
			'mailpoet' => (bool) get_post_meta( $optin->ID, '_omapi_mailpoet', true ),
		);

		// Maybe set shortcode.
		if ( get_post_meta( $optin->ID, '_omapi_shortcode', true ) ) {
			$this->shortcodes[] = get_post_meta( $optin->ID, '_omapi_shortcode_output', true );
		}

		if ( get_post_meta( $optin->ID, '_omapi_mailpoet', true ) ) {
			$this->wp_mailpoet();
		}

		return $this;
	}

	/**
	 * Maybe outputs the JS variables to parse shortcodes.
	 *
	 * @since 1.0.0
	 */
	public function maybe_parse_shortcodes() {

		// If no slugs have been set, do nothing.
		if ( empty( $this->slugs ) ) {
			return;
		}

		// Loop through any shortcodes and output them.
		foreach ( $this->shortcodes as $shortcode_string ) {
			if ( empty( $shortcode_string ) ) {
				continue;
			}

			if ( strpos( $shortcode_string, '|||' ) !== false ) {
				$all_shortcode = explode( '|||', $shortcode_string );
			} else { // Backwards compat.
				$all_shortcode = explode( ',', $shortcode_string );
			}

			foreach ( $all_shortcode as $shortcode ) {
				if ( empty( $shortcode ) ) {
					continue;
				}

				echo '<div style="position:absolute;overflow:hidden;clip:rect(0 0 0 0);height:1px;width:1px;margin:-1px;padding:0;border:0">';
					echo '<div class="omapi-shortcode-helper">' . html_entity_decode( $shortcode, ENT_COMPAT, 'UTF-8' ) . '</div>';
					echo '<div class="omapi-shortcode-parsed omapi-encoded">' . htmlentities( do_shortcode( html_entity_decode( $shortcode, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' ) . '</div>';
				echo '</div>';
			}
		}

		// Output the JS variables to signify shortcode parsing is needed.
		?>
		<script type="text/javascript">
		<?php
		foreach ( $this->slugs as $slug => $data ) {
			echo 'var ' . $slug . '_shortcode = true;'; }
		?>
		</script>
		<?php

	}

	/**
	 * Possibly localizes a JS variable for output use.
	 *
	 * @since 1.0.0
	 */
	public function localize() {

		// If no slugs have been set, do nothing.
		if ( empty( $this->slugs ) ) {
			return;
		}

		// If already localized, do nothing.
		if ( $this->localized ) {
			return;
		}

		// Set flag to true.
		$this->localized = true;

		// phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
		$slugs = function_exists( 'wp_json_encode' )
			? wp_json_encode( $this->slugs )
			: json_encode( $this->slugs );

		// Output JS variable.
		?>
		<script type="text/javascript">var omapi_localized = { ajax: '<?php echo esc_url_raw( add_query_arg( 'optin-monster-ajax-route', true, admin_url( 'admin-ajax.php' ) ) ); ?>', nonce: '<?php echo wp_create_nonce( 'omapi' ); ?>', slugs: <?php echo $slugs; ?> };</script>
		<?php
	}

	/**
	 * Enqueues the WP mailpoet script for storing local optins.
	 *
	 * @since 1.8.2
	 */
	public function wp_mailpoet() {
		// Only try to use the MailPoet integration if it is active.
		if ( $this->base->is_mailpoet_active() ) {
			wp_enqueue_script(
				$this->base->plugin_slug . '-wp-mailpoet',
				$this->base->url . 'assets/js/mailpoet.js',
				array( 'jquery' ),
				$this->base->asset_version(),
				true
			);
		}
	}

	/**
	 * Enqueues the WP helper script for the API.
	 *
	 * @since 1.0.0
	 */
	public function wp_helper() {
		wp_enqueue_script(
			$this->base->plugin_slug . '-wp-helper',
			$this->base->url . 'assets/js/helper.js',
			array(),
			$this->base->asset_version(),
			true
		);
	}

	/**
	 * Outputs a JS variable, in the footer of the site, with information about
	 * the current page, and the terms in use for the display rules.
	 *
	 * @since 1.6.5
	 *
	 * @return void
	 */
	public function display_rules_data() {
		global $wp_query;

		// If already localized, do nothing.
		if ( $this->data_output ) {
			return;
		}

		// Set flag to true.
		$this->data_output = true;

		$tax_terms    = array();
		$object       = get_queried_object();
		$object_id    = self::current_id();
		$object_class = is_object( $object ) ? get_class( $object ) : '';
		$object_type  = '';
		$object_key   = '';
		$post         = null;
		if ( 'WP_Post' === $object_class ) {
			$post        = $object;
			$object_type = 'post';
			$object_key  = $object->post_type;
		} elseif ( 'WP_Term' === $object_class ) {
			$object_type = 'term';
			$object_key  = $object->taxonomy;
		}

		// Get the current object's terms, if applicable. Defaults to public taxonomies only.
		if ( ! empty( $post->ID ) && is_singular() || ( $wp_query->is_category() || $wp_query->is_tag() || $wp_query->is_tax() ) ) {

			// Should we only check public taxonomies?
			$only_public = apply_filters( 'optinmonster_only_check_public_taxonomies', true, $post );
			$taxonomies  = get_object_taxonomies( $post, false );

			if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy ) {

					// Private ones should remain private and not output in the JSON blob.
					if ( $only_public && ! $taxonomy->public ) {
						continue;
					}

					$terms = get_the_terms( $post, $taxonomy->name );
					if ( ! empty( $terms ) && is_array( $terms ) ) {
						$tax_terms = array_merge( $tax_terms, wp_list_pluck( $terms, 'term_id' ) );
					}
				}

				$tax_terms = wp_parse_id_list( $tax_terms );
			}
		}

		$output = array(
			'wc_cart'     => $this->woocommerce_cart(),
			'object_id'   => $object_id,
			'object_key'  => $object_key,
			'object_type' => $object_type,
			'term_ids'    => $tax_terms,
		);

		// phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
		$output = function_exists( 'wp_json_encode' )
			? wp_json_encode( $output )
			: json_encode( $output );

		// Output JS variable.
		// phpcs:ignore XSS
		?>
		<script type="text/javascript">var omapi_data = <?php echo $output; ?>;</script>
		<?php
	}

	/**
	 * Prepare the optin campaign html.
	 *
	 * @since  1.5.0
	 *
	 * @param  object $optin The option post object.
	 *
	 * @return string         The optin campaign html.
	 */
	public function prepare_campaign( $optin ) {
		return isset( $optin->post_content ) && ! empty( $optin->post_content )
			? trim( html_entity_decode( stripslashes( $optin->post_content ), ENT_QUOTES, 'UTF-8' ), '\'' )
			: '';
	}

	/**
	 * Enqueues the WP helper script if relevant optin fields are found.
	 *
	 * @since  1.5.0
	 *
	 * @param  bool        $should_output Whether it should output.
	 * @param  OMAPI_Rules $rules   OMAPI_Rules object
	 *
	 * @return array
	 */
	public function enqueue_helper_js_if_applicable( $should_output, $rules ) {

		// Check to see if we need to load the WP API helper script.
		if ( $should_output ) {
			if ( ! $rules->field_empty( 'mailpoet' ) ) {
				$this->wp_mailpoet();
			}

			$this->wp_helper();
		}

		return $should_output;
	}

	/**
	 * Get the current page/post's post id.
	 *
	 * @since  1.6.9
	 *
	 * @return int
	 */
	public static function current_id() {
		$post_id = get_queried_object_id();
		if ( ! $post_id ) {
			if ( 'page' === get_option( 'show_on_front' ) ) {
				$post_id = get_option( 'page_for_posts' );
			}
		}

		return $post_id;
	}

	/**
	 * AJAX callback for returning WooCommerce cart information.
	 *
	 * @since 1.7.0
	 *
	 * @return array An array of WooCommerce cart data.
	 */
	public function woocommerce_cart() {
		// Bail if WooCommerce isn't currently active.
		if ( ! OMAPI::is_woocommerce_active() ) {
			return array();
		}

		// Check if WooCommerce is the minimum version.
		if ( ! OMAPI_WooCommerce::is_minimum_version() ) {
			return array();
		}

		// Bail if we don't have a cart object.
		if ( ! isset( WC()->cart ) || '' === WC()->cart ) {
			return array();
		}

		// Calculate the cart totals.
		WC()->cart->calculate_totals();

		// Get initial cart data.
		$cart               = WC()->cart->get_totals();
		$cart['cart_items'] = WC()->cart->get_cart();

		// Set the currency data.
		$currencies       = get_woocommerce_currencies();
		$currency_code    = get_woocommerce_currency();
		$cart['currency'] = array(
			'code'   => $currency_code,
			'symbol' => get_woocommerce_currency_symbol( $currency_code ),
			'name'   => isset( $currencies[ $currency_code ] ) ? $currencies[ $currency_code ] : '',
		);

		// Add in some extra data to the cart item.
		foreach ( $cart['cart_items'] as $key => $item ) {
			$item_details = array(
				'type'              => $item['data']->get_type(),
				'sku'               => $item['data']->get_sku(),
				'categories'        => $item['data']->get_category_ids(),
				'tags'              => $item['data']->get_tag_ids(),
				'regular_price'     => $item['data']->get_regular_price(),
				'sale_price'        => $item['data']->get_sale_price() ? $item['data']->get_sale_price() : $item['data']->get_regular_price(),
				'virtual'           => $item['data']->is_virtual(),
				'downloadable'      => $item['data']->is_downloadable(),
				'sold_individually' => $item['data']->is_sold_individually(),
			);
			unset( $item['data'] );
			$cart['cart_items'][ $key ] = array_merge( $item, $item_details );
		}

		// Send back a response.
		return $cart;
	}

	/**
	 * Get the OptinMonster embed script JS.
	 *
	 * @since  1.9.8
	 *
	 * @param  array $args Array of arguments for the script, including
	 *                     optional user id, account id, and script id.
	 *
	 * @return string        The embed script JS.
	 */
	public function om_script_tag( $args = array() ) {

		$src = esc_url_raw( $this->base->get_api_url() );

		$script_id = ! empty( $args['id'] )
			? sprintf( 's.id="%s";', esc_attr( $args['id'] ) )
			: '';

		$account_id = ! empty( $args['accountId'] )
			? sprintf( 's.dataset.account="%s";', esc_attr( $args['accountId'] ) )
			: '';

		$user_id = ! empty( $args['userId'] )
			? sprintf( 's.dataset.user="%s";', esc_attr( $args['userId'] ) )
			: '';

		$env = defined( 'OPTINMONSTER_ENV' )
			? sprintf( 's.dataset.env="%s";', esc_attr( OPTINMONSTER_ENV ) )
			: '';

		$tag  = '<script>';
		$tag .= '(function(d){';
		$tag .= 'var s=d.createElement("script");';
		$tag .= 's.type="text/javascript";';
		$tag .= 's.src="%1$s";';
		$tag .= 's.async=true;';
		$tag .= '%2$s';
		$tag .= '%3$s';
		$tag .= '%4$s';
		$tag .= '%5$s';
		$tag .= 'd.getElementsByTagName("head")[0].appendChild(s);';
		$tag .= '})(document);';
		$tag .= '</script>';

		return sprintf(
			$tag,
			$src,
			$script_id,
			$account_id,
			$user_id,
			$env
		);
	}
}
