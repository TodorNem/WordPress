<?php
/**
 * Core functions
 *
 * @package Advanced_Google_Recaptcha
 */

/**
 * Load frontend scripts.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_load_frontend_scripts() {
	if ( true !== advanced_google_recaptcha_is_key_setup_complete() ) {
		return;
	}

	$captcha_type = advanced_google_recaptcha_option( 'captcha_type' );

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	$site_key = advanced_google_recaptcha_option( 'site_key' );

	wp_enqueue_script( 'advanced-google-recaptcha-custom', ADVANCED_GOOGLE_RECAPTCHA_URL . '/assets/js/captcha' . $min . '.js', array(), ADVANCED_GOOGLE_RECAPTCHA_VERSION, false );
	wp_localize_script( 'advanced-google-recaptcha-custom', 'agrRecaptcha', array( 'site_key' => $site_key ) );

	$api_url = advanced_google_recaptcha_get_captcha_api_url( $captcha_type );

	if ( ! empty( $api_url ) ) {
		wp_enqueue_script( 'advanced-google-recaptcha-api', $api_url, array(), ADVANCED_GOOGLE_RECAPTCHA_VERSION, false );
	}

	wp_enqueue_style( 'advanced-google-recaptcha-style', ADVANCED_GOOGLE_RECAPTCHA_URL . '/assets/css/captcha' . $min . '.css', array(), ADVANCED_GOOGLE_RECAPTCHA_VERSION );
}

/**
 * Display captcha wrapper.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_display_wrapper() {
	echo '<div class="agr-recaptcha-wrapper"></div>';
}

/**
 * Display captcha input.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_display_captcha_input() {
	echo '<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">';
}

/**
 * Register hooks.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_check() {
	if ( true !== advanced_google_recaptcha_is_key_setup_complete() ) {
		return;
	}

	add_action( 'login_enqueue_scripts', 'advanced_google_recaptcha_load_frontend_scripts' );
	add_action( 'wp_enqueue_scripts', 'advanced_google_recaptcha_load_frontend_scripts' );

	// Login.
	$enable_login = advanced_google_recaptcha_option( 'enable_login' );
	if ( 1 === absint( $enable_login ) ) {
		add_filter( 'wp_authenticate_user', 'advanced_google_recaptcha_process_login_form', 10, 2 );
	}

	// Register.
	$enable_register = advanced_google_recaptcha_option( 'enable_register' );
	if ( 1 === absint( $enable_register ) ) {
		add_filter( 'registration_errors', 'advanced_google_recaptcha_process_register_form', 10, 3 );
	}

	// Lost password.
	$enable_lost_password = advanced_google_recaptcha_option( 'enable_lost_password' );
	if ( 1 === absint( $enable_lost_password ) ) {
		add_action( 'lostpassword_post', 'advanced_google_recaptcha_process_lost_password_form', 10, 1 );
		// Reset password.
		add_action( 'validate_password_reset', 'advanced_google_recaptcha_process_reset_password_form', 10, 2 );
	}
}

add_action( 'plugins_loaded', 'advanced_google_recaptcha_check' );

/**
 * Process reset password form.
 *
 * @since 1.0.0
 *
 * @param WP_Error         $errors WP_Error object.
 * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
 */
function advanced_google_recaptcha_process_reset_password_form( $errors, $user ) {
	if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
			$errors->add( 'reCAPTCHA', esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
		}
	} else {
		$errors->add( 'reCAPTCHA', esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
	}
}

/**
 * Process login form.
 *
 * @since 1.0.0
 *
 * @param WP_User|WP_Error $user     WP_User or WP_Error object.
 * @param string           $password Password to check against the user.
 * @return WP_User|WP_Error Modified object.
 */
function advanced_google_recaptcha_process_login_form( $user, $password ) {

	if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
			$user = new WP_Error( 'reCAPTCHA', '<strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
		}
	} else {
		$user = new WP_Error( 'reCAPTCHA', '<strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
	}

	return $user;
}

/**
 * Process register form.
 *
 * @since 1.0.0
 *
 * @param WP_Error $errors               A WP_Error object.
 * @param string   $user_login User's username after it has been sanitized.
 * @param string   $user_email           User's email.
 * @return WP_Error Modified error object.
 */
function advanced_google_recaptcha_process_register_form( $errors, $user_login, $user_email ) {
	if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
			$errors = new WP_Error( 'reCAPTCHA', '<strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
		}
	} else {
		$errors = new WP_Error( 'reCAPTCHA', '<strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
	}

	return $errors;
}

/**
 * Process lost password form.
 *
 * @since 1.0.0
 *
 * @param WP_Error $errors A WP_Error object.
 */
function advanced_google_recaptcha_process_lost_password_form( $errors ) {
	if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
			$errors->add( 'reCAPTCHA', '<strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
		}
	} else {
		$errors->add( 'reCAPTCHA', '<strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
	}
}

/**
 * Add plugin settings link.
 *
 * @since 1.0.0
 *
 * @param array $links Links.
 * @return array Modified links.
 */
function advanced_google_recaptcha_add_plugin_action_links( $links ) {
	return array_merge( array( 'settings' => '<a href="' . esc_url( admin_url( 'admin.php?page=agr-options' ) ) . '">' . esc_html__( 'Settings', 'advanced-google-recaptcha' ) . '</a>' ), $links );
}

add_filter( 'plugin_action_links_' . ADVANCED_GOOGLE_RECAPTCHA_BASENAME, 'advanced_google_recaptcha_add_plugin_action_links' );

/**
 * Load language.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_load_language() {
	load_plugin_textdomain( 'advanced-google-recaptcha', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'advanced_google_recaptcha_load_language' );

/**
 * Validate posted captcha.
 *
 * @since 1.0.0
 *
 * @return bool True if valid.
 */
function advanced_google_recaptcha_validate_posted_captcha() {
	$secret_key = advanced_google_recaptcha_option( 'secret_key' );

	$grecaptcha_response = $_POST['g-recaptcha-response']; // phpcs:ignore WordPress.Security.NonceVerification.Missing

	$captcha_obj = new \ReCaptcha\ReCaptcha( $secret_key );

	$resp = $captcha_obj->setExpectedHostname( $_SERVER['SERVER_NAME'] )->verify( $grecaptcha_response, $_SERVER['REMOTE_ADDR'] );

	return (bool) $resp->isSuccess();
}


/**
 * Custom injection hooks.
 *
 * @since 1.0.0
 *
 * @param array $hooks Hooks list.
 * @return array Modified hooks list.
 */
function advanced_google_recaptcha_customize_injection_hooks( $hooks ) {
  // Lost password for WooCommerce.
  $enable_lost_password = advanced_google_recaptcha_option( 'enable_lost_password' );
  if ( 1 === absint( $enable_lost_password ) ) {
    $hooks[] = 'woocommerce_lostpassword_form';
  }

  // Comment form.
  $enable_comment_form = advanced_google_recaptcha_option( 'enable_comment_form' );
  if ( 1 === absint( $enable_comment_form ) ) {
    $hooks[] = 'comment_form_after_fields';
  }

  // Buddypress.
  $enable_bp_register = advanced_google_recaptcha_option( 'enable_bp_register' );
  if ( 1 === absint( $enable_bp_register ) ) {
    $hooks[] = 'bp_after_signup_profile_fields';
  }

  // Woo Login.
  $enable_login = advanced_google_recaptcha_option( 'enable_login' );
  if ( 1 === absint( $enable_login ) ) {
   $hooks[] = 'woocommerce_login_form';
  }

  // Woo Register.
  $enable_woo_register = advanced_google_recaptcha_option( 'enable_woo_register' );
  if ( 1 === absint( $enable_woo_register ) ) {
    $hooks[] = 'woocommerce_register_form';
    $hooks[] = 'woocommerce_checkout_after_customer_details';
  }

  // EDD Register.
  $enable_edd_register = advanced_google_recaptcha_option( 'enable_edd_register' );
  if ( 1 === absint( $enable_edd_register ) ) {
    $hooks[] = 'edd_register_form_fields_before_submit';
  }

  // EDD Login.
  $enable_login = advanced_google_recaptcha_option( 'enable_login' );
  if ( 1 === absint( $enable_login ) ) {
   $hooks[] = 'advanced_google_recaptcha_edd_login_fields_after_password';
  }

  return $hooks;
}

add_filter( 'advanced_google_recaptcha_filter_injection_hooks', 'advanced_google_recaptcha_customize_injection_hooks' );

/**
 * Process captcha.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_captcha_processor() {
  if ( true !== advanced_google_recaptcha_is_key_setup_complete() ) {
    return;
  }

  // Comment form.
  $enable_comment_form = advanced_google_recaptcha_option( 'enable_comment_form' );
  if ( 1 === absint( $enable_comment_form ) ) {
    add_filter( 'preprocess_comment', 'advanced_google_recaptcha_process_comment_form', 10, 1 );
  }

  // Buddypress signup.
  $enable_bp_register = advanced_google_recaptcha_option( 'enable_bp_register' );
  if ( 1 === absint( $enable_bp_register ) ) {
    add_action( 'bp_signup_validate', 'advanced_google_recaptcha_process_buddypress_signup_form' );
  }

  // Woo Register.
  $enable_woo_register = advanced_google_recaptcha_option( 'enable_woo_register' );
  if ( 1 === absint( $enable_woo_register ) ) {
    add_action( 'woocommerce_register_post', 'advanced_google_recaptcha_check_woo_register_form', 10, 3 );
  }

  // EDD Register.
  $enable_edd_register = advanced_google_recaptcha_option( 'enable_edd_register' );
  if ( 1 === absint( $enable_edd_register ) ) {
    add_action( 'edd_process_register_form', 'advanced_google_recaptcha_check_edd_register_form' );
  }
}

add_action( 'plugins_loaded', 'advanced_google_recaptcha_captcha_processor' );

/**
 * Process comment form.
 *
 * @since 1.0.0
 *
 * @param array $commentdata Comment data.
 * @return array Modified comment data.
 */
function advanced_google_recaptcha_process_comment_form( $commentdata ) {
  // No need to check for loggedin user.
  if ( absint( $commentdata['user_ID'] ) > 0 ) {
    return $commentdata;
  }

  if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
    if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
      wp_die(
        '<p><strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) . '</p>',
        'reCAPTCHA',
        array(
          'response'  => 403,
          'back_link' => 1,
        )
      );
    }
  } else {
      wp_die(
        '<p><strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) . '</p>',
        'reCAPTCHA',
        array(
          'response'  => 403,
          'back_link' => 1,
        )
      );
  }

  return $commentdata;
}

/**
 * Custom EDD template paths.
 *
 * @since 1.0.0
 *
 * @param array $file_paths File paths.
 * @return array Modified file paths.
 */
function advanced_google_recaptcha_customize_edd_template_paths( $file_paths ) {
  $file_paths[0] = ADVANCED_GOOGLE_RECAPTCHA_DIR . '/edd_templates/';
  return $file_paths;
};

// EDD Login.
$enable_login = advanced_google_recaptcha_option( 'enable_login' );

if ( 1 === absint( $enable_login ) ) {
  add_filter( 'edd_template_paths', 'advanced_google_recaptcha_customize_edd_template_paths', 10, 1 );
}

/**
 * Check Buddypress signup form.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_process_buddypress_signup_form() {
  if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
    if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
      wp_die(
        '<p><strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) . '</p>',
        'reCAPTCHA',
        array(
          'response'  => 403,
          'back_link' => 1,
        )
      );
    }
  } else {
      wp_die(
        '<p><strong>' . esc_html__( 'ERROR:', 'advanced-google-recaptcha' ) . '</strong> ' . esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) . '</p>',
        'reCAPTCHA',
        array(
          'response'  => 403,
          'back_link' => 1,
        )
      );
  }
}

/**
 * Check EDD register form.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_check_edd_register_form() {
  if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
    if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
      edd_set_error( 'reCAPTCHA', esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
    }
  } else {
    edd_set_error( 'reCAPTCHA', esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
  }
}

/**
 * Process WooCommerce register form.
 *
 * @since 1.0.0
 *
 * @param string   $username Username.
 * @param string   $email Email.
 * @param WP_Error $errors A WP_Error object.
 */
function advanced_google_recaptcha_check_woo_register_form( $username, $email, $errors ) {
  if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
    if ( true !== advanced_google_recaptcha_validate_posted_captcha() ) {
      $errors->add( 'reCAPTCHA', esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
    }
  } else {
    $errors->add( 'reCAPTCHA', esc_html__( 'Google reCAPTCHA verification failed.', 'advanced-google-recaptcha' ) );
  }
}

/**
 * Hook captcha actions.
 *
 * @since 1.0.0
 */
function advanced_google_recaptcha_init() {
	if ( true !== advanced_google_recaptcha_is_key_setup_complete() ) {
		return;
	}

	$captcha_type = advanced_google_recaptcha_option( 'captcha_type' );

	$custom_hook_list = array();

	// Login.
	$enable_login = advanced_google_recaptcha_option( 'enable_login' );
	if ( 1 === absint( $enable_login ) ) {
		$custom_hook_list = array_merge(
			$custom_hook_list,
			array(
				'login_form',
			)
		);
	}

	// Register.
	$enable_register = advanced_google_recaptcha_option( 'enable_register' );
	if ( 1 === absint( $enable_register ) ) {
		$custom_hook_list = array_merge(
			$custom_hook_list,
			array(
				'register_form',
			)
		);
	}

	// Lost password.
	$enable_lost_password = advanced_google_recaptcha_option( 'enable_lost_password' );
	if ( 1 === absint( $enable_lost_password ) ) {
		$custom_hook_list = array_merge(
			$custom_hook_list,
			array(
				'lostpassword_form',
				'resetpass_form',
				'retrieve_password',
			)
		);
	}

	$custom_hook_list = apply_filters( 'advanced_google_recaptcha_filter_injection_hooks', $custom_hook_list );

	if ( ! empty( $custom_hook_list ) ) {
		foreach ( $custom_hook_list as $hook ) {
			if ( 'v2' === $captcha_type ) {
				add_action( $hook, 'advanced_google_recaptcha_display_wrapper' );
			} elseif ( 'v3' === $captcha_type ) {
				add_action( $hook, 'advanced_google_recaptcha_display_captcha_input' );
			}
		}
	}
}

add_action( 'init', 'advanced_google_recaptcha_init' );

/**
 * Setup custom admin notice.
 *
 * @since 1.0.9
 */
function advanced_google_recaptcha_setup_custom_notice() {
	\Nilambar\AdminNotice\Notice::init(
		array(
			'slug' => ADVANCED_GOOGLE_RECAPTCHA_SLUG,
			'name' => esc_html__( 'Advanced Google reCAPTCHA', 'advanced-google-recaptcha' ),
		)
	);

}

add_action( 'admin_init', 'advanced_google_recaptcha_setup_custom_notice' );
