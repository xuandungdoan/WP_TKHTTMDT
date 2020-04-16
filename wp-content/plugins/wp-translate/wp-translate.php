<?php
/*
Plugin Name: WP Translate
Plugin URI: https://plugingarden.com/google-translate-wordpress-plugin/
Description: Makes your website available to the world using the powerful Google Translate API to make your content multilingual.
Author: HahnCreativeGroup
Text Domain: wp-translate
Domain Path: /languages
Version: 5.2.9
Author URI: https://plugingarden.com
*/

if (!class_exists("WP_Translate")) {
	class WP_Translate {
		public function __construct() {
			$this->plugin_name = plugin_basename(__FILE__);
			$this->current_version = '5.2.9';
			
			register_activation_hook( __FILE__,  array(&$this, 'wpTranslate_install') );
			add_action('init', array(&$this, 'wpTranslate_options_check') );
			add_action( 'plugins_loaded', array(&$this, 'wp_translate_load_textdomain') );
			add_action('wp_head', array(&$this, 'admin_positioning') );
			add_action('wp_footer', array(&$this, 'translate_Init') );
			add_action( 'widgets_init', array(&$this, 'register_wp_translation_widget') );
			add_action( 'admin_menu', array(&$this, 'add_wp_translate_menu') );
			add_action( 'admin_notices', array(&$this, 'wpt_upgrade_notice') );
			add_action( 'wp_ajax_wp_translate_settings', array(&$this, 'wp_translate_settings') );
			add_action( 'wp_ajax_wp_translate_notice', array(&$this, 'wp_translate_notice') );
			add_action( 'admin_footer', array(&$this, 'wp_translate_notice_javascript') );
			add_filter('plugin_row_meta', array(&$this, 'create_translate_plugin_links'), 10, 2);
		}
		
		public function wpTranslate_install() {
			$this->wpTranslate_options_check();
		}
		
		public function wpTranslate_options_check() {
			if(!defined('WPTRANSLATEOPTIONS')) {
				define('WPTRANSLATEOPTIONS', 'wpTranslateOptions');	
			}
			
			if(!get_option("wpTranslateOptions")) {
				$d = strtotime('+7 Days');
				$wpTranslateOptions = array(
								"default_language" => "auto",
								"tracking_enabled" => false,
								"tracking_id" => "", 
								"auto_display" => true,
								"exclude_mobile" => true,
								"upgrade_notice" => array(
									"count" => 0,
									"date" => date('Y-m-d', $d)
									)
								);
	
				add_option("wpTranslateOptions", $wpTranslateOptions);
			}
			else {
				$wpTranlsateOptions	= get_option("wpTranslateOptions");
				$keys = array_keys($wpTranlsateOptions);		
		
				if (!in_array('default_language', $keys)) {
					$wpTranlsateOptions['default_language'] = "auto";	
				}
				if (!in_array('tracking_enabled', $keys)) {
					$wpTranlsateOptions['tracking_enabled'] = false;	
				}
				if (!in_array('tracking_id', $keys)) {
					$wpTranlsateOptions['tracking_id'] = "";	
				}
				if (!in_array('auto_display', $keys)) {
					$wpTranlsateOptions['auto_display'] = true;	
				}
				if (!in_array('exclude_mobile', $keys)) {
					$wpTranlsateOptions['exclude_mobile'] = true;	
				}
				if (in_array('4-9-5_update_notice_seen', $keys)) {
					unset($wpTranlsateOptions['4-9-5_update_notice_seen']);
				}
				if (in_array('4-9-upgrade_notice', $keys)) {
					unset($wpTranlsateOptions['4-9-upgrade_notice']);	
				}
				if (!in_array('upgrade_notice', $keys)) {
					$d = strtotime('+5 Days');
					$wpTranlsateOptions['upgrade_notice'] = array(
									"count" => 0,
									"date" => date('Y-m-d', $d)
								);	
				}
		
				update_option("wpTranslateOptions", $wpTranlsateOptions);
			}
		}
		
		public function wp_translate_load_textdomain() {
			load_plugin_textdomain( 'wp-translate', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		}

		public function translate_Init() {
			$wpTranslateOptions = get_option("wpTranslateOptions");
			$doTranslate = true;
			if ($wpTranslateOptions["exclude_mobile"]) {		
				$agent = $_SERVER['HTTP_USER_AGENT'];
				if(preg_match('/iPhone|Android|Blackberry|Windows Phone/i', $agent)){
					$doTranslate = false;
				}
			}
			$agent = $_SERVER['HTTP_USER_AGENT'];  
			if($doTranslate){
			ob_start();
			?>
			<!-- WP Translate - https://plugingarden.com/google-translate-wordpress-plugin/ -->
			<script type='text/javascript'>
				function googleTranslateElementInit2() {
					new google.translate.TranslateElement({
						pageLanguage: '<?php echo esc_js($wpTranslateOptions["default_language"]); ?>',
						<?php if ($wpTranslateOptions["tracking_enabled"]) { ?>
						gaTrack: true,
						gaId: '<?php echo esc_js($wpTranslateOptions["tracking_id"]); ?>',
						<?php } ?>
						floatPosition: google.translate.TranslateElement.FloatPosition.TOP_RIGHT,
						autoDisplay: <?php echo ($wpTranslateOptions["auto_display"]) ? "true" : "false"; ?>
					}<?php if (true) {echo(", 'wp_translate'");} ?>);
				}
			</script><script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
			<style type="text/css">
				body {top:0 !important;}
			</style>
			<?php
			ob_end_flush();
			}	
		}
		
		public function register_wp_translation_widget() {
			require_once('classes/widget.php');
			register_widget( 'WP_Translate_Widget' );
		}
		
		public function admin_positioning() {
			if (current_user_can('manage_options')) {
				_e('<style>.goog-te-ftab-float {right: 250px !important;}</style>');	
			}
		}
		
		public function add_wp_translate_menu() {
			add_menu_page(__('WP Translate','wp-translate'), __('WP Translate','wp-translate'), 'manage_options', 'wptranslate-admin', array(&$this, 'show_translate_menu'), 'dashicons-admin-site' );
	
			wp_register_style( 'wp_translate_admin_stylesheet', WP_PLUGIN_URL.'/wp-translate/admin/wp-translate-style.css');
			wp_enqueue_style('wp_translate_admin_stylesheet');
		}

		function show_translate_menu() {
			include("admin/overview.php");	
			add_action( 'admin_footer', array(&$this, 'wp_translate_settings_javascript') );
		}
		
		public function wpt_upgrade_notice() {
			$wpTranlsateOptions	= get_option("wpTranslateOptions");
			$upgradeObject = $wpTranlsateOptions['upgrade_notice'];
			$today = strtotime(date('Y-m-d'));
			$noticeDate = strtotime($upgradeObject['date']);
			$showNotice = false;
	
			if ($today >= $noticeDate) {
				$showNotice = true;
			}
	
			if ($showNotice) {
			ob_start();
			?>
			<div id="wp-translate-notice" class="wp-core-ui notice is-dismissable" style="clear: both;">
				<div class="wp-translate-logo" id="wp-translate-notice-logo"></div>
				<div id="wp-translate-notice-content">
					<h3 style="padding:2px;font-weight:normal;margin:0;"><?php _e("Give Your Readers a Better Translation Experience with WP Translate Pro", 'wp-translate'); ?></h3>			
					<p><?php _e("Show country flag icons next to languages and remove Google branding.", 'wp-translate'); ?></p>
					<p><?php _e("WP Translate Pro is also Gutenberg ready! Comes with a custom block to use on pages that don't display widgets.", 'wp-translate'); ?></p>
					<p style="margin-top: 10px;"><a href="https://plugingarden.com/google-translate-wordpress-plugin/?src=wpt" class="button-primary" target="_blank"><?php _e('Check out WP Translate Pro', 'wp-translate'); ?></a></p>
				</div>
				<button id="wp-translate-notice-btn" class="notice-dismiss" style="position: relative; float: right;"></button>
				<div style="clear: both;"></div>
			</div>
			<?php
			ob_end_flush();
			}
		}
		
		public function wp_translate_settings() {
			check_ajax_referer( 'wp_translate', 'security' );
	
			$wpTranslateOptions['default_language'] = sanitize_text_field($_POST["default_language"]);
			$wpTranslateOptions['exclude_mobile'] = filter_var($_POST["excludeMobile"], FILTER_VALIDATE_BOOLEAN);
			$wpTranslateOptions['auto_display'] = filter_var($_POST["autoDisplay"], FILTER_VALIDATE_BOOLEAN);
			$wpTranslateOptions['tracking_id'] = sanitize_text_field($_POST["trackingId"]);	
			$wpTranslateOptions['tracking_enabled'] = filter_var($_POST["trackingEnabled"], FILTER_VALIDATE_BOOLEAN); 
	
			update_option(WPTRANSLATEOPTIONS, $wpTranslateOptions);
	
			$message = "WP Translate settings have been saved.";
    
			echo $message;

			wp_die(); // this is required to terminate immediately and return a proper response
		}

		public function wp_translate_settings_javascript() { 
			$ajax_nonce = wp_create_nonce( "wp_translate" );
			ob_start();
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {

				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
					jQuery('#btn-wp-transalate-settings').on('click', function() {
						var default_language = jQuery('#defaultLanguage option:selected').val();
						var trackingId = jQuery('#trackingId').val();
						var tracking_enabled = jQuery('#trackingEnabled').is(':checked');
						var excludeMobile = jQuery('#excludeMobile').is(':checked');
						var autoDisplay = jQuery('#autoDisplay').is(':checked');
			
						var data = {
							'action': 'wp_translate_settings',
							'security': '<?php echo $ajax_nonce; ?>',
							'default_language' : default_language,
							'excludeMobile' : excludeMobile,
							'autoDisplay' : autoDisplay,
							'trackingId': trackingId,
							'trackingEnabled' : tracking_enabled
						};
			
						jQuery('#wp-translate-update-status').show();
						jQuery.post(ajaxurl, data, function(response) {
							jQuery('#wp-translate-update-status').hide();								
						});
			
						return false;
					});
		
					jQuery('#wp-translate-notice-btn').on('click', function() {
						var data = {
							'action': 'wp_translate_notice',
							'security': '<?php echo $ajax_nonce; ?>'
						};
			
						jQuery('#wp-translate-notice').hide();
						
						jQuery.post(ajaxurl, data, function(response) {
							//reserved for future action
						});
					});
		
					});
			</script> <?php
			ob_end_flush();
		}
		
		public function wp_translate_notice() {
			check_ajax_referer( 'wp_translate', 'security' );
	
			$wpTranslateOptions	= get_option("wpTranslateOptions");
	
			$upgradeObject = $wpTranslateOptions['upgrade_notice'];
			$upgradeObject['count']++;
			$reShowTime = ($upgradeObject['count'] > 2) ? '+2 Months' : '+1 Month';
			$upgradeObject['date'] = date('Y-m-d', strtotime($reShowTime));
	
			$wpTranslateOptions['upgrade_notice'] = $upgradeObject;	
	
			update_option("wpTranslateOptions", $wpTranslateOptions);

			wp_die(); // this is required to terminate immediately and return a proper response
		}
 

		public function wp_translate_notice_javascript() { 
			$ajax_nonce = wp_create_nonce( "wp_translate" );
			ob_start();
			?>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
		
				jQuery('#wp-translate-notice-btn').on('click', function() {
					var data = {
						'action': 'wp_translate_notice',
						'security': '<?php echo $ajax_nonce; ?>'
					};
			
					jQuery('#wp-translate-notice').hide();
			
					jQuery.post(ajaxurl, data, function(response) {
				
					});
				});		
			});
			</script> <?php
			ob_end_flush();
		}
		
		public function create_translate_plugin_links($links, $file) {			
			if ( $file == plugin_basename(__FILE__) ) {			
				$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EJVXJP3V8GE2J">' . __('Donate', 'wp-translate') . '</a>';
			}
			return $links;
		}
	}
}
if (class_exists("WP_Translate")) {
    global $WP_Translate;
	$WP_Translate = new WP_Translate();
}
?>