<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UACF7_COLUMN {
    
    private $hidden_fields = array();
    /*
    * Construct function
    */
    public function __construct() {
		global $pagenow;
		if( isset($_GET['page']) ){
    		if ( ($pagenow == 'admin.php') && ($_GET['page'] == 'wpcf7') || ($_GET['page'] == 'wpcf7-new') ) {
    			add_action( 'admin_enqueue_scripts', array( $this, 'admin_column_enqueue_script' ) );
    		}
		}
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_column_style' ) );
        add_action('wpcf7_init', array(__CLASS__, 'add_shortcodes'));
        add_action( 'admin_init', array( $this, 'tag_generator' ) );        
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_column_properties' ), 10, 2 );
        add_filter( 'wpcf7_contact_form_properties', array( $this, 'uacf7_row_properties' ), 10, 2 );
    }
    
    public function admin_column_enqueue_script() {
        wp_enqueue_script( 'uacf7-column', UACF7_ADDONS . '/column/assets/js/column-admin.js', array('jquery'), null, true );
        wp_enqueue_style( 'uacf7-column', UACF7_ADDONS . '/column/assets/css/column-admin.css' );
    }
    
    public function enqueue_column_style() {
        wp_enqueue_style( 'uacf7-column', UACF7_ADDONS . '/column/grid/columns.css' );
    }
    
    /*
    * Form tag
    */
    public static function add_shortcodes() {
        
        wpcf7_add_form_tag( 'uacf7-col', array( __CLASS__, 'column_tag_handler' ), true );
        
        wpcf7_add_form_tag( 'uacf7-row', array( __CLASS__, 'column_tag_handler' ), true );
    }
    
    public static function column_tag_handler( $tag ) {
        ob_start();
        $tag = new WPCF7_FormTag( $tag );
        ?>
        <div> 
        <?php $tag->content; ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /*
    * Generate tag - conditional
    */
    public function tag_generator() {
        if (! function_exists( 'wpcf7_add_tag_generator'))
            return;

        wpcf7_add_tag_generator('uacf7-col',
            __('Add column', 'ultimate-addons-cf7'),
            'uacf7-tg-pane-column',
            array($this, 'tg_pane_column')
        );

    }
    
    static function tg_pane_column( $contact_form, $args = '' ) {
        $args = wp_parse_args( $args, array() );
        $uacf7_field_type = 'uacf7-col';
        ?>
        <div class="control-box uacf7-column-control-box">
            <fieldset>
                <legend><?php echo esc_html__( "Generate tag: Column", "ultimate-addons-cf7" ); ?></legend>
                <table class="form-table">
                  
                   <h3><?php echo esc_html__('Contact form 7 columns / Grid Layout','ultimate-addons-cf7'); ?></h3>
                   <p><?php echo esc_html__('You can easily create two columns, three Columns even Four columns form with Contact form 7 using this feature. Just insert tag you need from below list.','ultimate-addons-cf7'); ?></p>
                   <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/columns-grid/" target="_blank">documentation</a>.</div>
                   <p></p>
                    <tbody>
                        <tr class="column-1 uacf7-column-select example-active" data-column-codes="[uacf7-row][uacf7-col col:12] --your code-- [/uacf7-col][/uacf7-row]">
                        	<th>
                        		<?php echo esc_html__('1 Column','ultimate-addons-cf7'); ?>
                        		<a class="button uacf7-column-button"><?php echo esc_html__('Insert tag','ultimate-addons-cf7'); ?></a>
                        	</th>
                        	<td class="uacf7_code">
<pre>
[uacf7-row]
	[uacf7-col col:12] --your code-- [/uacf7-col]
[/uacf7-row]
</pre>
                        	</td>
                        </tr>
                        <tr class="column-2 uacf7-column-select" data-column-codes="[uacf7-row][uacf7-col col:6] --your code-- [/uacf7-col][uacf7-col col:6] --your code-- [/uacf7-col][/uacf7-row]">
                        	<th>
                        		<?php echo esc_html__('2 Column','ultimate-addons-cf7'); ?>
                        		<a class="button uacf7-column-button"><?php echo esc_html__('Insert tag','ultimate-addons-cf7'); ?></a>
                        	</th>
                        	<td class="uacf7_code">
<pre>
[uacf7-row]
	[uacf7-col col:6] --your code-- [/uacf7-col]
	[uacf7-col col:6] --your code-- [/uacf7-col]
[/uacf7-row]
</pre>
                        	</td>
                        </tr>
                        <tr class="column-3 uacf7-column-select" data-column-codes="[uacf7-row][uacf7-col col:4] --your code-- [/uacf7-col][uacf7-col col:4] --your code-- [/uacf7-col][uacf7-col col:4] --your code-- [/uacf7-col][/uacf7-row]">
                        	<th>
                        		<?php echo esc_html__('3 Column','ultimate-addons-cf7'); ?>
                        		<a class="button uacf7-column-button"><?php echo esc_html__('Insert tag','ultimate-addons-cf7'); ?></a>
                        	</th>
                        	<td class="uacf7_code">
<pre>
[uacf7-row]
	[uacf7-col col:4] --your code-- [/uacf7-col]
	[uacf7-col col:4] --your code-- [/uacf7-col]
	[uacf7-col col:4] --your code-- [/uacf7-col]
[/uacf7-row]
</pre>
                        	</td>
                        </tr>
                        <tr class="column-4 uacf7-column-select" data-column-codes="[uacf7-row][uacf7-col col:3] --your code-- [/uacf7-col][uacf7-col col:3] --your code-- [/uacf7-col][uacf7-col col:3] --your code-- [/uacf7-col][uacf7-col col:3] --your code-- [/uacf7-col][/uacf7-row]">
                        	<th>
                        		<?php echo esc_html__('4 Column','ultimate-addons-cf7'); ?>
                        		<a class="button uacf7-column-button"><?php echo esc_html__('Insert tag','ultimate-addons-cf7'); ?></a>
                        	</th>
                        	<td class="uacf7_code">
<pre>
[uacf7-row]
	[uacf7-col col:3] --your code-- [/uacf7-col]
	[uacf7-col col:3] --your code-- [/uacf7-col]
	[uacf7-col col:3] --your code-- [/uacf7-col]
	[uacf7-col col:3] --your code-- [/uacf7-col]
[/uacf7-row]
</pre>
                        	</td>
                        </tr>
                        <tr style="display:inherit" class="column-pro-feature">
							<th class="column-1">
							Custom Column Width <span class="pro-link"><a style="color:red" href="#">(Pro)</a></span>
							<a class="button uacf7-column-button uacf7-custom-column-insert"><?php echo esc_html__('Insert tag','ultimate-addons-cf7'); ?></a>
							</th>
							<td>
								<span class="uacf7-custom-column"></span>
								<span style="display:block"><button class="add-custom-column button-primary">+Add Column</button></span>
							</td>
						</tr>
                    </tbody>
                </table>
                <div class="uacf7-doc-notice">Not sure how to set this? Check our step by step <a href="https://themefic.com/docs/ultimate-addons-for-contact-form-7/custom-columns-for-contact-form-7/" target="_blank">documentation</a>.</div>
            </fieldset>
        </div>

        <div class="insert-box uacf7-column-insert-box">
            <input type="text" name="<?php echo esc_attr($uacf7_field_type); ?>" class="tag code uacf7-column-tag-insert" readonly="readonly" onfocus="this.select()" />

            <div class="submitbox">
                <input type="button" class="button button-primary insert-tag uacf7-column-insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'ultimate-addons-cf7' ) ); ?>" />
            </div>
        </div>
        <?php
    }
    
    public function uacf7_column_properties($properties, $cfform) {
	
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];

            $form_parts = preg_split('/(\[\/?uacf7-col(?:\]|\s.*?\]))/',$form, -1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            ob_start();

            foreach ($form_parts as $form_part) {
                if (substr($form_part,0,11) == '[uacf7-col ') {
                    $tag_parts = explode(' ',rtrim($form_part,']'));

                    array_shift($tag_parts);
                    
                    $tag_html_type = 'div';
                    $ucaf7_column_class = '';
                    $uacf7_column_custom_width = '';
                    $col = '';
                    
                    foreach ($tag_parts as $i => $tag_part) {
                        
                        if( $tag_part == 'col:12' ){
                            $ucaf7_column_class = 'uacf7-col-12';
                        }
                        elseif($tag_part == 'col:6'){
                            $ucaf7_column_class = 'uacf7-col-6';
                        }
                        elseif($tag_part == 'col:4'){
                            $ucaf7_column_class = 'uacf7-col-4';
                        }
                        elseif($tag_part == 'col:3'){
                            $ucaf7_column_class = 'uacf7-col-3';
                        }
						else {
							$uacf7_column_custom_width = $tag_part;
						}
						
                    }
					
                    $html = '<div class="'.$ucaf7_column_class.'">';
					
					echo apply_filters( 'uacf7_column_custom_width', $html, $ucaf7_column_class, $uacf7_column_custom_width );
					
                } else if ($form_part == '[/uacf7-col]') {
                    echo '</div>';
                } else {
                    echo $form_part;
                }
            }

            $properties['form'] = ob_get_clean();
        }
        return $properties;
    }
    
    public function uacf7_row_properties($properties, $cfform) {
	
        if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) { 

            $form = $properties['form'];

            $form_parts = preg_split('/(\[\/?uacf7-row(?:\]|\s.*?\]))/',$form, -1,PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            ob_start();

            foreach ($form_parts as $form_part) {
                if (substr($form_part,0,10) == '[uacf7-row') {
                    $tag_parts = explode(' ',rtrim($form_part,']'));

                    array_shift($tag_parts);

                    echo '<div class="uacf7-row">';
                } else if ($form_part == '[/uacf7-row]') {
                    echo '</div>';
                } else {
                    echo $form_part;
                }
            }

            $properties['form'] = ob_get_clean();
        }
        return $properties;
    }
    

}
new UACF7_COLUMN();
