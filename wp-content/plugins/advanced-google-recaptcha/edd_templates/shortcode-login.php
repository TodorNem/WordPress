<?php
/**
 * This template is used to display the login form with [edd_login].
 *
 * @package Advanced_Google_Recaptcha
 */

global $edd_login_redirect;

if ( ! is_user_logged_in() ) :

	// Show any error messages after form submission.
	edd_print_errors(); ?>
	<form id="edd_login_form" class="edd_form" action="" method="post">
		<fieldset>
			<legend><?php esc_html_e( 'Log into Your Account', 'advanced-google-recaptcha' ); ?></legend>
			<?php do_action( 'edd_login_fields_before' ); ?>
			<p class="edd-login-username">
				<label for="edd_user_login"><?php esc_html_e( 'Username or Email', 'advanced-google-recaptcha' ); ?></label>
				<input name="edd_user_login" id="edd_user_login" class="edd-required edd-input" type="text"/>
			</p>
			<p class="edd-login-password">
				<label for="edd_user_pass"><?php esc_html_e( 'Password', 'advanced-google-recaptcha' ); ?></label>
				<input name="edd_user_pass" id="edd_user_pass" class="edd-password edd-required edd-input" type="password"/>
			</p>

			<?php do_action( 'advanced_google_recaptcha_edd_login_fields_after_password' ); ?>

			<p class="edd-login-remember">
				<label><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e( 'Remember Me', 'advanced-google-recaptcha' ); ?></label>
			</p>
			<p class="edd-login-submit">
				<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_login_redirect ); ?>"/>
				<input type="hidden" name="edd_login_nonce" value="<?php echo esc_attr( wp_create_nonce( 'edd-login-nonce' ) ); ?>"/>
				<input type="hidden" name="edd_action" value="user_login"/>
				<input id="edd_login_submit" type="submit" class="edd-submit" value="<?php esc_attr_e( 'Log In', 'advanced-google-recaptcha' ); ?>"/>
			</p>
			<p class="edd-lost-password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
					<?php esc_html_e( 'Lost Password?', 'advanced-google-recaptcha' ); ?>
				</a>
			</p>
			<?php do_action( 'edd_login_fields_after' ); ?>
		</fieldset>
	</form>
<?php else : ?>

	<?php do_action( 'edd_login_form_logged_in' ); ?>

<?php endif; ?>
