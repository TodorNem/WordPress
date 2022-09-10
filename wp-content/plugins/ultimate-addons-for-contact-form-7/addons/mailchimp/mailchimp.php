<?php
if (!defined('ABSPATH')) {
  exit;
}
class UACF7_MAILCHIMP
{

  public $mailchimlConnection = '';
  public static $mailchimp = null;
  private $mailchimp_api = '';

  public function __construct()
  {
    require_once('inc/functions.php');
    add_action('wpcf7_editor_panels', array($this, 'uacf7_cf_add_panel'));
    add_action('uacf7_admin_tab_button', array($this, 'add_mailchimp_tab'), 10);
    add_action('uacf7_admin_tab_content', array($this, 'add_mailchimp_tab_content'));
    add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    add_action("wpcf7_before_send_mail", array($this, 'send_data'));
    add_action('wpcf7_after_save', array($this, 'uacf7_save_contact_form'));

    $this->get_api_key();
  }

  /* Mailchimp tab */
  public function add_mailchimp_tab()
  {
  ?>
    <a class="tablinks" onclick="uacf7_settings_tab(event, 'uacf7_mailchimp')">Mailchimp</a>
  <?php
  }

  /* Mailchimp tab content */
  public function add_mailchimp_tab_content()
  {
  ?>
    <div id="uacf7_mailchimp" class="uacf7-tabcontent uacf7-mailchimp">

      <form method="post" action="options.php">
        <?php
        settings_fields('uacf7_mailchimp_option');
        do_settings_sections('ultimate-mailchimp-admin');
        submit_button();
        ?>
      </form>

    </div>
  <?php
  }

  /* Check Internet connection */
  public static function is_internet_connected()
  {
    $connected = @fsockopen("www.example.com", 80);
    if ($connected) {
      return true;
      fclose($connected);
    } else {
      return false;
    }
  }

  /* Get mailchimp api key */
  public function get_api_key() {
    
    $mailchimp_options = get_option('uacf7_mailchimp_option_name');

    if( is_array($mailchimp_options) && !empty($mailchimp_options) ) {
      return $this->mailchimp_api = $mailchimp_options['uacf7_mailchimp_api_key'];
    }

    $this->mailchimp_connection();

  }

  /* mailchimp Connection check */
  public function mailchimp_connection()
  {

    $api_key = $this->mailchimp_api;

    if ($api_key != '') {

      $response = $this->set_config($api_key, 'ping');
      $response = json_decode($response);

      if (isset($response->health_status)) { //Display success message
        $this->$mailchimlConnection = true;
      } else {
        $this->$mailchimlConnection = false;
      }
    }
  }

  /* Mailchimp config set */
  private function set_config($api_key = '', $path = '')
  {
    $server_prefix = explode("-",$api_key);
    $server_prefix = $server_prefix[1];

    $url = "https://$server_prefix.api.mailchimp.com/3.0/$path";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
      "Authorization: Bearer $api_key"
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);

    return $resp;
  }

  /* Mailchimp connection status */
  public function connection_status()
  {
    $api_key = $this->mailchimp_api;
    $status = '';
    if ($api_key != '') {

      $response = $this->set_config($api_key, 'ping');
      $response = json_decode($response);

      
      $status .= '<span class="status-title"><strong>' . esc_html__('Status: ', 'ultimate-addons-cf7') . '</strong>';

      if ($this->is_internet_connected() == false) { //Checking internet connection
        $status .= '<span class="status-error">' . esc_html__('Can\'t connect to the server. Please check internet connection.', 'ultimate-addons-cf7') . '</span>';
      }

      if (isset($response->health_status)) { //Display success message
        $status .= '<span class="status-success">' . esc_html($response->health_status) . '</span>';
      }

      if (isset($response->title)) { //Display error title
        $status .= '<span class="status-error">' . esc_html($response->title) . '</span>';
      }

      $status .= '</span>';

      if (isset($response->detail)) { //Display error mdetails
        $status .= '<span class="status-details status-error">' . esc_html($response->detail) . '</span>';
      }
    } else {
      $status .= '<span class="status-details">' . esc_html('Please enter your Mailchimp API key.', 'ultimate-addons-cf7') . '</span>';
    }

    return $status;
  }

  /* Create tab panel */
  public function uacf7_cf_add_panel($panels)
  {

    $panels['uacf7-mailchimp-panel'] = array(
      'title'    => __('UACF7 Mailchimp', 'ultimate-addons-cf7'),
      'callback' => array($this, 'uacf7_create_mailchimp_panel_fields'),
    );
    return $panels;
  }

  /* Mailchimp form settings fields */
  public function uacf7_create_mailchimp_panel_fields($post)
  {
    require_once( 'inc/template/form-fields.php' );
  }

  /* Save form data */
  public function uacf7_save_contact_form($post)
  {
    if (!isset($_POST) || empty($_POST)) {
      return;
    }

    if (!wp_verify_nonce($_POST['uacf7_mailchimp_nonce'], 'uacf7_mailchimp_nonce_action')) {
      return;
    }

    update_post_meta( $post->id(), 'uacf7_mailchimp_form_enable', sanitize_text_field($_POST['uacf7_mailchimp_form_enable']) );
    update_post_meta( $post->id(), 'uacf7_mailchimp_form_type', sanitize_text_field($_POST['uacf7_mailchimp_form_type']) );
    update_post_meta( $post->id(), 'uacf7_mailchimp_audience', sanitize_text_field($_POST['uacf7_mailchimp_audience']) );
    update_post_meta( $post->id(), 'uacf7_mailchimp_subscriber_email', sanitize_text_field($_POST['uacf7_mailchimp_subscriber_email']) );
    update_post_meta( $post->id(), 'uacf7_mailchimp_subscriber_fname', sanitize_text_field($_POST['uacf7_mailchimp_subscriber_fname']) );
    update_post_meta( $post->id(), 'uacf7_mailchimp_subscriber_lname', sanitize_text_field($_POST['uacf7_mailchimp_subscriber_lname']) );

    $all_fields = $post->scan_form_tags();
    $x = 1;
    $data = [];
    foreach( $all_fields as $field ) {
      if( $field['type'] != 'submit' ){
        if( !empty( $_POST['uacf7_mailchimp_extra_field_mailtag_'.$x] ) && !empty( $_POST['uacf7_mailchimp_extra_field_mergefield_'.$x] ) ){

          $data[$x] = array(
            'mailtag' => sanitize_text_field($_POST['uacf7_mailchimp_extra_field_mailtag_'.$x]),
            'mergefield' => sanitize_text_field($_POST['uacf7_mailchimp_extra_field_mergefield_'.$x])
          );

        }

        $x++;
      }
    }

    update_post_meta( $post->id(), 'uacf7_mailchimp_merge_fields', $data );

  }

  /* Add members to mailchimp */
  public function add_members( $id, $audience, $posted_data ) {

    $api_key = $this->mailchimp_api;

    $subscriber_email = get_post_meta( $id, 'uacf7_mailchimp_subscriber_email', true );
    $subscriber_email = !empty($subscriber_email) ? $posted_data[$subscriber_email] : '';

    if( $this->$mailchimlConnection == true && $api_key != '' && $subscriber_email != '' ) {
      
      $server_prefix = explode("-",$api_key);
      $server_prefix = $server_prefix[1];
      $subscriber_fname = get_post_meta( $id, 'uacf7_mailchimp_subscriber_fname', true );
      $subscriber_fname = !empty($subscriber_fname) ? $posted_data[$subscriber_fname] : '';

      $subscriber_lname = get_post_meta( $id, 'uacf7_mailchimp_subscriber_lname', true );
      $subscriber_lname = !empty($subscriber_lname) ? $posted_data[$subscriber_lname] : '';

      $extra_fields = empty(get_post_meta( $id, 'uacf7_mailchimp_merge_fields', true )) ? array() : get_post_meta( $id, 'uacf7_mailchimp_merge_fields', true );
      
      $extra_merge_fields = '';
      foreach( $extra_fields as $extra_field ){
        $extra_merge_fields .= '"'.$extra_field['mergefield'] . '": "' . $posted_data[$extra_field['mailtag']].'",';
      }
      $extra_merge_fields = trim($extra_merge_fields,',');

      if( $extra_merge_fields != '' ){
        $extra_merge_fields = ','.$extra_merge_fields;
      }

      $url = "https://$server_prefix.api.mailchimp.com/3.0/lists/".$audience."/members";

      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      $headers = array(
        "Authorization: Bearer $api_key",
        "Content-Type: application/json",
      );
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

      //Mailchimp data
      $data = '{"email_address":"'.sanitize_email($subscriber_email).'","status":"subscribed","merge_fields":{"FNAME": "'.sanitize_text_field($subscriber_fname).'", "LNAME": "'.sanitize_text_field($subscriber_lname).'"'.$extra_merge_fields.'},"vip":false,"location":{"latitude":0,"longitude":0}}';
      
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

      //for debug only!
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $resp = curl_exec($curl);
      curl_close($curl);

      return $resp;
    }
    
  }

  /* Send data before sent email */
  public function send_data($cf7)
  {
    // get the contact form object
    $wpcf = WPCF7_Submission::get_instance();

    $posted_data = $wpcf->get_posted_data();

    $id = $cf7->id();
    
    $form_enable = get_post_meta( $id, 'uacf7_mailchimp_form_enable', true );
    $form_type = get_post_meta( $id, 'uacf7_mailchimp_form_type', true );
    $audience = get_post_meta( $id, 'uacf7_mailchimp_audience', true );

    if( $form_enable == 'enable' && $form_type == 'subscribe' && $audience != '' ){

      //$wpcf->skip_mail = true;
      $response = $this->add_members( $id, $audience, $posted_data );
      
    }
  }

  /* Enqueue admin scripts */
  public function admin_scripts()
  {
    wp_enqueue_style('mailchimp-css', UACF7_ADDONS . '/mailchimp/assets/css/admin-style.css');
  }
}
new UACF7_MAILCHIMP();
