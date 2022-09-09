<?php
/**
 * Admin functions
 *
 * @package Advanced_Google_Recaptcha
 */

/**
 * Render admin page.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_options_page() {
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-2">

				<div id="post-body-content">

					<div class="tab-wrapper">
						<ul class="tabs-nav">
							<li class="tab-active"><a href="#tab-settings" class="button"><?php esc_html_e( 'Settings', 'advanced-google-recaptcha' ); ?></a></li>
							<li><a href="#tab-features" class="button"><?php esc_html_e( 'Features', 'advanced-google-recaptcha' ); ?></a></li>
						</ul>
					</div><!-- .tab-wrapper -->

					<div class="tabs-stage">
						<div id="tab-settings" class="meta-box-sortables ui-sortable active">
							<div class="postbox">
								<div class="inside">

									<form action="options.php" method="post">
										<?php settings_fields( 'advanced_google_recaptcha_group' ); ?>
										<?php do_settings_sections( 'agr-options' ); ?>
										<?php submit_button( esc_html__( 'Save Changes', 'advanced-google-recaptcha' ) ); ?>
									</form>

								</div><!-- .inside -->
							</div><!-- .postbox -->
						</div><!-- .meta-box-sortables -->

						<div id="tab-features" class="meta-box-sortables ui-sortable">
							<div class="postbox">
								<div class="inside">
									<ul>
										<li>Supports reCAPTCHA Version 2 and Version 3</li>
										<li>Works perfectly with default Login, Registration and Comment forms of WordPress</li>
										<li>Protects your eCommerce websites (WooCommerce and EDD) from unwanted registrations and logins</li>
										<li>Compatible with all WordPress themes</li>
										<li>No coding or advanced skills required to configure the plugin</li>
									</ul>
								</div><!-- .inside -->
							</div><!-- .postbox -->
						</div><!-- .meta-box-sortables -->

					</div><!-- .tabs-stage -->


				</div><!-- #post-body-content -->

				<div id="postbox-container-1" class="postbox-container">

					<div class="meta-box-sortables">
						<div class="postbox">

							<h3><span>Our Products</span></h3>
							<div class="inside">
								<ul>
									<li><a href="https://wpconcern.com/plugins/woocommerce-product-tabs/" target="_blank">WooCommerce Product Tabs</a></li>
									<li><a href="https://wpconcern.com/plugins/post-grid-elementor-addon/" target="_blank">Post Grid Elementor Addon</a></li>
									<li><a href="https://wordpress.org/plugins/nifty-coming-soon-and-under-construction-page/" target="_blank">Coming Soon & Maintenance Mode Page</a></li>
									<li><a href="https://wpconcern.com/plugins/advanced-google-recaptcha/" target="_blank">Advanced Google reCAPTCHA</a></li>
									<li><a href="https://wordpress.org/plugins/admin-customizer/" target="_blank">Admin Customizer</a></li>
									<li><a href="https://wordpress.org/plugins/prime-addons-for-elementor/" target="_blank">Prime Addons for Elementor</a></li>
								</ul>
							</div> <!-- .inside -->

						</div><!-- .postbox -->
					</div><!-- .meta-box-sortables -->

					<div class="meta-box-sortables">
						<div class="postbox">

							<h3><span>Have any queries?</span></h3>
							<div class="inside">
								<p>If you have any queries or feedback, please feel free to send us an email to <code>support@wpconcern.com</code></p>
							</div><!-- .inside -->

						</div><!-- .postbox -->
					</div><!-- .meta-box-sortables -->

					<div class="meta-box-sortables">
						<div class="postbox">

							<h3><span>Important Links</span></h3>
							<div class="inside">
								<ul>
								<li><a href="https://wpconcern.com/documentation/advanced-google-recaptcha/" target="_blank">Documentation</a></li>
								<li><a href="https://wpconcern.com/request-customization/" target="_blank">Customization Request</a></li>
								<li><a href="https://wordpress.org/plugins/advanced-google-recaptcha/#reviews" target="_blank">Submit a Review</a></li>
								</ul>
							</div> <!-- .inside -->

						</div><!-- .postbox -->
					</div><!-- .meta-box-sortables -->

				</div><!-- #postbox-container-1 .postbox-container -->

			</div><!-- #post-body -->
		</div><!-- #poststuff -->

	</div><!-- .wrap -->
	<?php
}

/**
 * Register menu page.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_register_menu() {
	add_menu_page( esc_html__( 'Advanced Google reCAPTCHA', 'advanced-google-recaptcha' ), esc_html__( 'Advanced Google reCAPTCHA', 'advanced-google-recaptcha' ), 'manage_options', 'agr-options', 'advanced_google_recaptcha_options_page', 'dashicons-lock' );
}

add_action( 'admin_menu', 'advanced_google_recaptcha_register_menu' );

/**
 * Display key section message.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_content_key_section() {
	/* translators: 1: link open, 2: link close */
	printf( esc_html__( 'Please %1$sregister your domain%2$s first, get required keys from Google (reCAPTCHA v2 or reCAPTCHA v3) and save them below.', 'advanced-google-recaptcha' ), '<a href="https://www.google.com/recaptcha/admin" target="_blank">', '</a>' );
}

/**
 * Display status section message.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_content_status_section() {
	esc_html_e( 'You can enable/disable reCAPTCHA for different forms separately.', 'advanced-google-recaptcha' );
}

/**
 * Register site_key field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_site_key() {
	$site_key = advanced_google_recaptcha_option( 'site_key' );
	?>
	<input type="text" name="agr_options[site_key]" id="site_key" class="regular-text" value="<?php echo esc_attr( $site_key ); ?>" />
	<?php
}

/**
 * Register secret_key field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_secret_key() {
	$secret_key = advanced_google_recaptcha_option( 'secret_key' );
	?>
	<input type="text" name="agr_options[secret_key]" id="secret_key" class="regular-text" value="<?php echo esc_attr( $secret_key ); ?>" />
	<?php

}

/**
 * Register enable_login field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_enable_login() {
	$enable_login = advanced_google_recaptcha_option( 'enable_login' );
	?>
	<input type="checkbox" name="agr_options[enable_login]" id="enable_login" value="1" <?php checked( 1, $enable_login ); ?> />&nbsp;<?php esc_html_e( 'Applies for default login, WooCommerce & Easy Digital Downloads logins', 'advanced-google-recaptcha' ); ?>
	<?php
}

/**
 * Register enable_register field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_enable_register() {
	$enable_register = advanced_google_recaptcha_option( 'enable_register' );
	?>
	<input type="checkbox" name="agr_options[enable_register]" id="enable_register" value="1" <?php checked( 1, $enable_register ); ?> />
	<?php
}

/**
 * Register enable_lost_password field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_enable_lost_password() {
	$enable_lost_password = advanced_google_recaptcha_option( 'enable_lost_password' );
	?>
	<input type="checkbox" name="agr_options[enable_lost_password]" id="enable_lost_password" value="1" <?php checked( 1, $enable_lost_password ); ?> />
	<?php
}

/**
 * Register plugin option fields.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_register_plugin_option_fields() {
	register_setting( 'advanced_google_recaptcha_group', 'agr_options', 'advanced_google_recaptcha_validate_plugin_options' );

	add_settings_section( 'advanced_google_recaptcha_key_section', esc_html__( 'Key Settings', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_content_key_section', 'agr-options' );

	add_settings_field( 'captcha_type', esc_html__( 'reCAPTCHA Type', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_captcha_type', 'agr-options', 'advanced_google_recaptcha_key_section' );

	add_settings_field( 'site_key', esc_html__( 'Site Key', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_site_key', 'agr-options', 'advanced_google_recaptcha_key_section' );
	add_settings_field( 'secret_key', esc_html__( 'Secret Key', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_secret_key', 'agr-options', 'advanced_google_recaptcha_key_section' );

	add_settings_section( 'advanced_google_recaptcha_status_section', esc_html__( 'Status Settings', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_content_status_section', 'agr-options' );

	add_settings_field( 'enable_login', esc_html__( 'Enable for Login', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_enable_login', 'agr-options', 'advanced_google_recaptcha_status_section' );
	add_settings_field( 'enable_register', esc_html__( 'Enable for Register', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_enable_register', 'agr-options', 'advanced_google_recaptcha_status_section' );
	add_settings_field( 'enable_lost_password', esc_html__( 'Enable for Lost Password', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_enable_lost_password', 'agr-options', 'advanced_google_recaptcha_status_section' );

	add_settings_field( 'enable_comment_form', esc_html__( 'Enable for Comment Form', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_enable_comment_form', 'agr-options', 'advanced_google_recaptcha_status_section' );
	add_settings_field( 'enable_woo_register', esc_html__( 'Enable for WooCommerce Register', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_enable_woo_register', 'agr-options', 'advanced_google_recaptcha_status_section' );
	add_settings_field( 'enable_edd_register', esc_html__( 'Enable for Easy Digital Downloads Register', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_enable_edd_register', 'agr-options', 'advanced_google_recaptcha_status_section' );
	add_settings_field( 'enable_bp_register', esc_html__( 'Enable for BuddyPress Register', 'advanced-google-recaptcha' ), 'advanced_google_recaptcha_field_enable_bp_register', 'agr-options', 'advanced_google_recaptcha_status_section' );
}

add_action( 'admin_init', 'advanced_google_recaptcha_register_plugin_option_fields' );

/**
 * Validate plugin options.
 *
 * @since 1.0.0
 *
 * @param array $input Options.
 * @return array Validated options.
 */
function advanced_google_recaptcha_validate_plugin_options( $input ) {
	if ( ! empty( $input['captcha_type'] ) ) {
		$input['captcha_type'] = sanitize_text_field( $input['captcha_type'] );
	} else {
		$input['captcha_type'] = 'v2';
	}

	$input['site_key']   = sanitize_text_field( $input['site_key'] );
	$input['secret_key'] = sanitize_text_field( $input['secret_key'] );

	// Status.
	$input['enable_login']         = ( isset( $input['enable_login'] ) && (bool) $input['enable_login'] ) ? 1                : 0;
	$input['enable_register']      = ( isset( $input['enable_register'] ) && (bool) $input['enable_register'] ) ? 1          : 0;
	$input['enable_lost_password'] = ( isset( $input['enable_lost_password'] ) && (bool) $input['enable_lost_password'] ) ? 1: 0;
	$input['enable_comment_form']  = ( isset( $input['enable_comment_form'] ) && (bool) $input['enable_comment_form'] ) ? 1  : 0;
	$input['enable_woo_register']  = ( isset( $input['enable_woo_register'] ) && (bool) $input['enable_woo_register'] ) ? 1  : 0;
	$input['enable_edd_register']  = ( isset( $input['enable_edd_register'] ) && (bool) $input['enable_edd_register'] ) ? 1  : 0;
	$input['enable_bp_register']   = ( isset( $input['enable_bp_register'] ) && (bool) $input['enable_bp_register'] ) ? 1    : 0;

	return $input;
}

/**
 * Display admin notices.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_display_admin_message() {
	if ( advanced_google_recaptcha_is_key_setup_complete() ) {
		return;
	}

	$message = esc_html__( 'To implement reCAPTCHA, Key settings should be completed first.', 'advanced-google-recaptcha' );

	$message .= ' <a href="' . esc_url( admin_url( '/admin.php?page=agr-options' ) ) . '">' . esc_html__( 'Captcha Settings', 'advanced-google-recaptcha' ) . '</a>';

	if ( ! empty( $message ) ) {
		?>
		<div class="notice notice-error">
			<?php echo wp_kses_post( wpautop( $message ) ); ?>
		</div>
		<?php
	}
}

add_action( 'admin_notices', 'advanced_google_recaptcha_display_admin_message' );

/**
 * Load admin assets.
 *
 * @since 1.0.0
 *
 * @param string $hook Hook name.
 */
function advanced_google_recaptcha_load_admin_scripts( $hook ) {
	if ( 'toplevel_page_agr-options' === $hook ) {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style( 'advanced-google-recaptcha-admin-style', ADVANCED_GOOGLE_RECAPTCHA_URL . '/assets/css/admin' . $min . '.css', array(), ADVANCED_GOOGLE_RECAPTCHA_VERSION );
		wp_enqueue_script( 'advanced-google-recaptcha-admin-script', ADVANCED_GOOGLE_RECAPTCHA_URL . '/assets/js/admin' . $min . '.js', array( 'jquery' ), ADVANCED_GOOGLE_RECAPTCHA_VERSION, true );
	}
}

add_action( 'admin_enqueue_scripts', 'advanced_google_recaptcha_load_admin_scripts' );


/**
 * Render captcha_type field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_captcha_type() {
  $captcha_type = advanced_google_recaptcha_option( 'captcha_type' );
  ?>
  <label><input type="radio" name="agr_options[captcha_type]" value="v2" <?php checked( 'v2', $captcha_type ); ?> /><?php esc_html_e( 'V2', 'advanced-google-recaptcha' ); ?></label>&nbsp;
  <label><input type="radio" name="agr_options[captcha_type]" value="v3" <?php checked( 'v3', $captcha_type ); ?> /><?php esc_html_e( 'V3', 'advanced-google-recaptcha' ); ?></label>
  <?php
}

/**
 * Render enable_comment_form field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_enable_comment_form() {
  $enable_comment_form = advanced_google_recaptcha_option( 'enable_comment_form' );
  ?>
  <input type="checkbox" name="agr_options[enable_comment_form]" id="enable_comment_form" value="1" <?php checked( 1, $enable_comment_form ); ?> />
  <?php
}

/**
 * Render enable_woo_register field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_enable_woo_register() {
  $enable_woo_register = advanced_google_recaptcha_option( 'enable_woo_register' );
  ?>
  <input type="checkbox" name="agr_options[enable_woo_register]" id="enable_woo_register" value="1" <?php checked( 1, $enable_woo_register ); ?> />
  <?php
}

/**
 * Render enable_edd_register field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_enable_edd_register() {
  $enable_edd_register = advanced_google_recaptcha_option( 'enable_edd_register' );
  ?>
  <input type="checkbox" name="agr_options[enable_edd_register]" id="enable_edd_register" value="1" <?php checked( 1, $enable_edd_register ); ?> />
  <?php
}

/**
 * Render enable_bp_register field.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_field_enable_bp_register() {
  $enable_bp_register = advanced_google_recaptcha_option( 'enable_bp_register' );
  ?>
  <input type="checkbox" name="agr_options[enable_bp_register]" id="enable_bp_register" value="1" <?php checked( 1, $enable_bp_register ); ?> />
  <?php
}
