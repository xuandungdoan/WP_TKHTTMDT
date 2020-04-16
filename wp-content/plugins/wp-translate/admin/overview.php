<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
	
$wpTranslateOptions = get_option("wpTranslateOptions");
ob_start();
?>
<div id='wrap'>
	<div class="wpt-divider first">
		<h1 class="wp-heading-inline"><?php _e('WP Translate', 'wp-translate'); ?></h1>
	</div>
	<div id="wpt-left-column">	
	<div class="wp-translate-settings-wrap">
	<p><?php _e("Want to display a drop-down list of translation options in the sidebar?", 'wp-translate'); ?> <a href="<?php echo get_site_url().'/wp-admin/widgets.php'; ?>"><?php _e('WP Translate Widget', 'wp-translate'); ?></a></p>
	</div>
	<div class="wp-translate-settings-wrap">
	<h2><?php _e('Settings', 'wp-translate'); ?></h2>	
    <form name="wp_translate_settings_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
    <input type="hidden" name="editOptions" vale="true" />
	<?php wp_nonce_field('wp_translate','wp_translate'); ?>
    <div class="wpt-setting-label-wrap">
		<?php _e('Default Language', 'wp-translate'); ?>
	</div>
	<div class="wpt-setting-value-wrap">
		<select id="defaultLanguage" name="defaultLanguage">
			<option value="auto" <?php if($wpTranslateOptions['default_language'] == 'auto') echo esc_attr('selected'); ?>><?php _e("Detect language", 'wp-translate'); ?></option>
			<option value="af" <?php if($wpTranslateOptions['default_language'] == 'af') echo esc_attr('selected'); ?>><?php _e("Afrikaans", 'wp-translate'); ?></option>
			<option value="sq" <?php if($wpTranslateOptions['default_language'] == 'sq') echo esc_attr('selected'); ?>><?php _e("Albanian", 'wp-translate'); ?></option>
			<option value="ar" <?php if($wpTranslateOptions['default_language'] == 'ar') echo esc_attr('selected'); ?>><?php _e("Arabic", 'wp-translate'); ?></option>
			<option value="hy" <?php if($wpTranslateOptions['default_language'] == 'hy') echo esc_attr('selected'); ?>><?php _e("Armenian", 'wp-translate'); ?></option>
			<option value="az" <?php if($wpTranslateOptions['default_language'] == 'az') echo esc_attr('selected'); ?>><?php _e("Azerbaijani", 'wp-translate'); ?></option>
			<option value="eu" <?php if($wpTranslateOptions['default_language'] == 'eu') echo esc_attr('selected'); ?>><?php _e("Basque", 'wp-translate'); ?></option>
			<option value="be" <?php if($wpTranslateOptions['default_language'] == 'be') echo esc_attr('selected'); ?>><?php _e("Belarusian", 'wp-translate'); ?></option>
			<option value="bn" <?php if($wpTranslateOptions['default_language'] == 'bn') echo esc_attr('selected'); ?>><?php _e("Bengali", 'wp-translate'); ?></option>
			<option value="bg" <?php if($wpTranslateOptions['default_language'] == 'bg') echo esc_attr('selected'); ?>><?php _e("Bulgarian", 'wp-translate'); ?></option>
			<option value="ca" <?php if($wpTranslateOptions['default_language'] == 'ca') echo esc_attr('selected'); ?>><?php _e("Catalan", 'wp-translate'); ?></option>
			<option value="ceb" <?php if($wpTranslateOptions['default_language'] == 'ceb') echo esc_attr('selected'); ?>><?php _e("Cebuano", 'wp-translate'); ?></option>
			<option value="ny" <?php if($wpTranslateOptions['default_language'] == 'ny') echo esc_attr('selected'); ?>><?php _e("Chichewa", 'wp-translate'); ?></option>
			<option value="zh-CN" <?php if($wpTranslateOptions['default_language'] == 'zh-CN') echo esc_attr('selected'); ?>><?php _e("Chinese (Simplified)", 'wp-translate'); ?></option>
			<option value="zh-TW" <?php if($wpTranslateOptions['default_language'] == 'zh-TW') echo esc_attr('selected'); ?>><?php _e("Chinese (Traditional)", 'wp-translate'); ?></option>
			<option value="co" <?php if($wpTranslateOptions['default_language'] == 'co') echo esc_attr('selected'); ?>><?php _e("Corsican", 'wp-translate'); ?></option>
			<option value="hr" <?php if($wpTranslateOptions['default_language'] == 'hr') echo esc_attr('selected'); ?>><?php _e("Croatian", 'wp-translate'); ?></option>
			<option value="cs" <?php if($wpTranslateOptions['default_language'] == 'cs') echo esc_attr('selected'); ?>><?php _e("Czech", 'wp-translate'); ?></option>
			<option value="da" <?php if($wpTranslateOptions['default_language'] == 'da') echo esc_attr('selected'); ?>><?php _e("Danish", 'wp-translate'); ?></option>
			<option value="nl" <?php if($wpTranslateOptions['default_language'] == 'nl') echo esc_attr('selected'); ?>><?php _e("Dutch", 'wp-translate'); ?></option>
			<option value="en" <?php if($wpTranslateOptions['default_language'] == 'en') echo esc_attr('selected'); ?>><?php _e("English", 'wp-translate'); ?></option>
			<option value="eo" <?php if($wpTranslateOptions['default_language'] == 'eo') echo esc_attr('selected'); ?>><?php _e("Esperanto", 'wp-translate'); ?></option>
			<option value="et" <?php if($wpTranslateOptions['default_language'] == 'et') echo esc_attr('selected'); ?>><?php _e("Estonian", 'wp-translate'); ?></option>
			<option value="tl" <?php if($wpTranslateOptions['default_language'] == 'tl') echo esc_attr('selected'); ?>><?php _e("Filipino", 'wp-translate'); ?></option>
			<option value="fi" <?php if($wpTranslateOptions['default_language'] == 'fi') echo esc_attr('selected'); ?>><?php _e("Finnish", 'wp-translate'); ?></option>
			<option value="fr" <?php if($wpTranslateOptions['default_language'] == 'fr') echo esc_attr('selected'); ?>><?php _e("French", 'wp-translate'); ?></option>
			<option value="gl" <?php if($wpTranslateOptions['default_language'] == 'gl') echo esc_attr('selected'); ?>><?php _e("Galician", 'wp-translate'); ?></option>
			<option value="ka" <?php if($wpTranslateOptions['default_language'] == 'ka') echo esc_attr('selected'); ?>><?php _e("Georgian", 'wp-translate'); ?></option>
			<option value="de" <?php if($wpTranslateOptions['default_language'] == 'de') echo esc_attr('selected'); ?>><?php _e("German", 'wp-translate'); ?></option>
			<option value="el" <?php if($wpTranslateOptions['default_language'] == 'el') echo esc_attr('selected'); ?>><?php _e("Greek", 'wp-translate'); ?></option>
			<option value="gu" <?php if($wpTranslateOptions['default_language'] == 'gu') echo esc_attr('selected'); ?>><?php _e("Gujarati", 'wp-translate'); ?></option>
			<option value="ht" <?php if($wpTranslateOptions['default_language'] == 'ht') echo esc_attr('selected'); ?>><?php _e("Haitian Creole", 'wp-translate'); ?></option>
			<option value="ha" <?php if($wpTranslateOptions['default_language'] == 'ha') echo esc_attr('selected'); ?>><?php _e("Hausa", 'wp-translate'); ?></option>
			<option value="haw" <?php if($wpTranslateOptions['default_language'] == 'haw') echo esc_attr('selected'); ?>><?php _e("Hawaii", 'wp-translate'); ?></option>
			<option value="iw" <?php if($wpTranslateOptions['default_language'] == 'iw') echo esc_attr('selected'); ?>><?php _e("Hebrew", 'wp-translate'); ?></option>
			<option value="hi" <?php if($wpTranslateOptions['default_language'] == 'hi') echo esc_attr('selected'); ?>><?php _e("Hindi", 'wp-translate'); ?></option>
			<option value="hmn" <?php if($wpTranslateOptions['default_language'] == 'hmn') echo esc_attr('selected'); ?>><?php _e("Hmong", 'wp-translate'); ?></option>
			<option value="hu" <?php if($wpTranslateOptions['default_language'] == 'hu') echo esc_attr('selected'); ?>><?php _e("Hungarian", 'wp-translate'); ?></option>
			<option value="is" <?php if($wpTranslateOptions['default_language'] == 'is') echo esc_attr('selected'); ?>><?php _e("Icelandic", 'wp-translate'); ?></option>
			<option value="id" <?php if($wpTranslateOptions['default_language'] == 'id') echo esc_attr('selected'); ?>><?php _e("Indonesian", 'wp-translate'); ?></option>
			<option value="ga" <?php if($wpTranslateOptions['default_language'] == 'ga') echo esc_attr('selected'); ?>><?php _e("Irish", 'wp-translate'); ?></option>
			<option value="it" <?php if($wpTranslateOptions['default_language'] == 'it') echo esc_attr('selected'); ?>><?php _e("Italian", 'wp-translate'); ?></option>
			<option value="ja" <?php if($wpTranslateOptions['default_language'] == 'ja') echo esc_attr('selected'); ?>><?php _e("Japanese", 'wp-translate'); ?></option>
			<option value="jw" <?php if($wpTranslateOptions['default_language'] == 'jw') echo esc_attr('selected'); ?>><?php _e("Javanese", 'wp-translate'); ?></option>
			<option value="kn" <?php if($wpTranslateOptions['default_language'] == 'kn') echo esc_attr('selected'); ?>><?php _e("Kannada", 'wp-translate'); ?></option>
			<option value="kk" <?php if($wpTranslateOptions['default_language'] == 'kk') echo esc_attr('selected'); ?>><?php _e("Kazakh", 'wp-translate'); ?></option>
			<option value="km" <?php if($wpTranslateOptions['default_language'] == 'km') echo esc_attr('selected'); ?>><?php _e("Khmer", 'wp-translate'); ?></option>
			<option value="ko" <?php if($wpTranslateOptions['default_language'] == 'ko') echo esc_attr('selected'); ?>><?php _e("Korean", 'wp-translate'); ?></option>
			<option value="ku" <?php if($wpTranslateOptions['default_language'] == 'ku') echo esc_attr('selected'); ?>><?php _e("Kurdish (Kurmanji)", 'wp-translate'); ?></option>
			<option value="ky" <?php if($wpTranslateOptions['default_language'] == 'ky') echo esc_attr('selected'); ?>><?php _e("Kyrgyz", 'wp-translate'); ?></option>
			<option value="lo" <?php if($wpTranslateOptions['default_language'] == 'lo') echo esc_attr('selected'); ?>><?php _e("Lao", 'wp-translate'); ?></option>
			<option value="la" <?php if($wpTranslateOptions['default_language'] == 'la') echo esc_attr('selected'); ?>><?php _e("Latin", 'wp-translate'); ?></option>
			<option value="lv" <?php if($wpTranslateOptions['default_language'] == 'lv') echo esc_attr('selected'); ?>><?php _e("Latvian", 'wp-translate'); ?></option>
			<option value="lt" <?php if($wpTranslateOptions['default_language'] == 'lt') echo esc_attr('selected'); ?>><?php _e("Lithuanian", 'wp-translate'); ?></option>
			<option value="lb" <?php if($wpTranslateOptions['default_language'] == 'lb') echo esc_attr('selected'); ?>><?php _e("Luxembourgish", 'wp-translate'); ?></option>
			<option value="mk" <?php if($wpTranslateOptions['default_language'] == 'mk') echo esc_attr('selected'); ?>><?php _e("Macedonian", 'wp-translate'); ?></option>
			<option value="mg" <?php if($wpTranslateOptions['default_language'] == 'mg') echo esc_attr('selected'); ?>><?php _e("Malagasy", 'wp-translate'); ?></option>
			<option value="ms" <?php if($wpTranslateOptions['default_language'] == 'ms') echo esc_attr('selected'); ?>><?php _e("Malay", 'wp-translate'); ?></option>
			<option value="ml" <?php if($wpTranslateOptions['default_language'] == 'ml') echo esc_attr('selected'); ?>><?php _e("Malayalam", 'wp-translate'); ?></option>
			<option value="mt" <?php if($wpTranslateOptions['default_language'] == 'mt') echo esc_attr('selected'); ?>><?php _e("Maltese", 'wp-translate'); ?></option>
			<option value="mi" <?php if($wpTranslateOptions['default_language'] == 'mi') echo esc_attr('selected'); ?>><?php _e("Maori", 'wp-translate'); ?></option>
			<option value="mr" <?php if($wpTranslateOptions['default_language'] == 'mr') echo esc_attr('selected'); ?>><?php _e("Marathi", 'wp-translate'); ?></option>
			<option value="mn" <?php if($wpTranslateOptions['default_language'] == 'mn') echo esc_attr('selected'); ?>><?php _e("Mongolian", 'wp-translate'); ?></option>
			<option value="my" <?php if($wpTranslateOptions['default_language'] == 'my') echo esc_attr('selected'); ?>><?php _e("Myanmar (Burmese)", 'wp-translate'); ?></option>
			<option value="ne" <?php if($wpTranslateOptions['default_language'] == 'ne') echo esc_attr('selected'); ?>><?php _e("Nepali", 'wp-translate'); ?></option>
			<option value="no" <?php if($wpTranslateOptions['default_language'] == 'no') echo esc_attr('selected'); ?>><?php _e("Norwegian", 'wp-translate'); ?></option>
			<option value="ps" <?php if($wpTranslateOptions['default_language'] == 'ps') echo esc_attr('selected'); ?>><?php _e("Pashto", 'wp-translate'); ?></option>
			<option value="fa" <?php if($wpTranslateOptions['default_language'] == 'fa') echo esc_attr('selected'); ?>><?php _e("Persian", 'wp-translate'); ?></option>
			<option value="pl" <?php if($wpTranslateOptions['default_language'] == 'pl') echo esc_attr('selected'); ?>><?php _e("Polish", 'wp-translate'); ?></option>
			<option value="pt" <?php if($wpTranslateOptions['default_language'] == 'pt') echo esc_attr('selected'); ?>><?php _e("Portuguese", 'wp-translate'); ?></option>
			<option value="ro" <?php if($wpTranslateOptions['default_language'] == 'ro') echo esc_attr('selected'); ?>><?php _e("Romanian", 'wp-translate'); ?></option>
			<option value="ru" <?php if($wpTranslateOptions['default_language'] == 'ru') echo esc_attr('selected'); ?>><?php _e("Russian", 'wp-translate'); ?></option>
			<option value="sm" <?php if($wpTranslateOptions['default_language'] == 'sm') echo esc_attr('selected'); ?>><?php _e("Samoan", 'wp-translate'); ?></option>
			<option value="gd" <?php if($wpTranslateOptions['default_language'] == 'gd') echo esc_attr('selected'); ?>><?php _e("Scots Gaelic", 'wp-translate'); ?></option>
			<option value="sr" <?php if($wpTranslateOptions['default_language'] == 'sr') echo esc_attr('selected'); ?>><?php _e("Serbian", 'wp-translate'); ?></option>
			<option value="st" <?php if($wpTranslateOptions['default_language'] == 'st') echo esc_attr('selected'); ?>><?php _e("Sesotho", 'wp-translate'); ?></option>
			<option value="sn" <?php if($wpTranslateOptions['default_language'] == 'sn') echo esc_attr('selected'); ?>><?php _e("Shona", 'wp-translate'); ?></option>
			<option value="sd" <?php if($wpTranslateOptions['default_language'] == 'sd') echo esc_attr('selected'); ?>><?php _e("Sindhi", 'wp-translate'); ?></option>
			<option value="si" <?php if($wpTranslateOptions['default_language'] == 'si') echo esc_attr('selected'); ?>><?php _e("Sinhala", 'wp-translate'); ?></option>
			<option value="sk" <?php if($wpTranslateOptions['default_language'] == 'sk') echo esc_attr('selected'); ?>><?php _e("Slovak", 'wp-translate'); ?></option>
			<option value="sl" <?php if($wpTranslateOptions['default_language'] == 'sl') echo esc_attr('selected'); ?>><?php _e("Slovenian", 'wp-translate'); ?></option>
			<option value="so" <?php if($wpTranslateOptions['default_language'] == 'so') echo esc_attr('selected'); ?>><?php _e("Somali", 'wp-translate'); ?></option>
			<option value="es" <?php if($wpTranslateOptions['default_language'] == 'es') echo esc_attr('selected'); ?>><?php _e("Spanish", 'wp-translate'); ?></option>
			<option value="su" <?php if($wpTranslateOptions['default_language'] == 'su') echo esc_attr('selected'); ?>><?php _e("Sudanese", 'wp-translate'); ?></option>
			<option value="sw" <?php if($wpTranslateOptions['default_language'] == 'sw') echo esc_attr('selected'); ?>><?php _e("Swahili", 'wp-translate'); ?></option>
			<option value="sv" <?php if($wpTranslateOptions['default_language'] == 'sv') echo esc_attr('selected'); ?>><?php _e("Swedish", 'wp-translate'); ?></option>
			<option value="tg" <?php if($wpTranslateOptions['default_language'] == 'tg') echo esc_attr('selected'); ?>><?php _e("Tajik", 'wp-translate'); ?></option>
			<option value="tl" <?php if($wpTranslateOptions['default_language'] == 'tl') echo esc_attr('selected'); ?>><?php _e("Tamil", 'wp-translate'); ?></option>
			<option value="te" <?php if($wpTranslateOptions['default_language'] == 'te') echo esc_attr('selected'); ?>><?php _e("Telugu", 'wp-translate'); ?></option>
			<option value="th" <?php if($wpTranslateOptions['default_language'] == 'th') echo esc_attr('selected'); ?>><?php _e("Thai", 'wp-translate'); ?></option>
			<option value="tr" <?php if($wpTranslateOptions['default_language'] == 'tr') echo esc_attr('selected'); ?>><?php _e("Turkish", 'wp-translate'); ?></option>
			<option value="uk" <?php if($wpTranslateOptions['default_language'] == 'uk') echo esc_attr('selected'); ?>><?php _e("Ukrainian", 'wp-translate'); ?></option>
			<option value="ur" <?php if($wpTranslateOptions['default_language'] == 'ur') echo esc_attr('selected'); ?>><?php _e("Urdu", 'wp-translate'); ?></option>
			<option value="uz" <?php if($wpTranslateOptions['default_language'] == 'uz') echo esc_attr('selected'); ?>><?php _e("Uzbek", 'wp-translate'); ?></option>
			<option value="vi" <?php if($wpTranslateOptions['default_language'] == 'vi') echo esc_attr('selected'); ?>><?php _e("Vietnamese", 'wp-translate'); ?></option>
			<option value="cy" <?php if($wpTranslateOptions['default_language'] == 'cy') echo esc_attr('selected'); ?>><?php _e("Welsh", 'wp-translate'); ?></option>
			<option value="xh" <?php if($wpTranslateOptions['default_language'] == 'xh') echo esc_attr('selected'); ?>><?php _e("Xhosa", 'wp-translate'); ?></option>
			<option value="yi" <?php if($wpTranslateOptions['default_language'] == 'yi') echo esc_attr('selected'); ?>><?php _e("Yiddish", 'wp-translate'); ?></option>
			<option value="yo" <?php if($wpTranslateOptions['default_language'] == 'yo') echo esc_attr('selected'); ?>><?php _e("Yoruba", 'wp-translate'); ?></option>
			<option value="zu" <?php if($wpTranslateOptions['default_language'] == 'zu') echo esc_attr('selected'); ?>><?php _e("Zulu", 'wp-translate'); ?></option>
		</select>
	</div>    	
	<div class="wpt-setting-label-wrap"><?php _e('Exclude from Mobile Browsers', 'wp-translate'); ?></div>
	<div class="wpt-setting-value-wrap"><input type="checkbox" id="excludeMobile" name="excludeMobile" value="true"<?php echo ($wpTranslateOptions['exclude_mobile']) ? " checked='yes'" : ""; ?> /></div>	
	<div class="wpt-setting-label-wrap"><?php _e('Toolbar Auto Display', 'wp-translate'); ?></div>
	<div class="wpt-setting-value-wrap"><input type="checkbox" id="autoDisplay" name="autoDisplay" value="true"<?php echo ($wpTranslateOptions['auto_display']) ? " checked='yes'" : ""; ?> /></div>    
	<div class="wpt-divider"><h3><?php _e('Translation Tracking - Google Analytics', 'wp-translate'); ?></h3></div>
    <div class="wpt-setting-label-wrap"><?php _e('Tracking enabled', 'wp-translate'); ?></div> 
	<div class="wpt-setting-value-wrap"><input type="checkbox" id="trackingEnabled" name="trackingEnabled" value="true"<?php echo ($wpTranslateOptions['tracking_enabled']) ? " checked='yes'" : ""; ?> /></div>    
    <div class="wpt-setting-label-wrap"><?php _e('Tracking ID (UA#)', 'wp-translate'); ?></div>
	<div class="wpt-setting-value-wrap"><input type="text" id="trackingId" name="trackingId" value="<?php echo esc_attr($wpTranslateOptions['tracking_id']); ?>" /></div>
    <div class="wpt-divider"><p class="major-publishing-actions"><input type="submit" name="Submit" id="btn-wp-transalate-settings" class="button-primary" value="<?php _e('Save Settings', 'wp-translate'); ?>" /></p></div>
    </form>
	</div>
	</div>
	<div id="wpt-right-column">
        <div class="wp-translate-settings-wrap">                
			<a href="https://plugingarden.com/google-translate-wordpress-plugin/?src=wpt" target="_blank"><div class="wp-translate-logo"></div></a>
			<p><strong>WP Translate Pro</strong><br/><em><?php _e("Show country flag icons next to languages and remove Google branding.", 'wp-translate'); ?></em><br/><a href="https://plugingarden.com/google-translate-wordpress-plugin/?src=wpt" target="_blank"><?php _e('See it in action', 'wp-translate'); ?></a>!</p>
			<p><em><?php _e("Pro version is Gutenberg ready! Comes with a custom block for adding shortcodes to pages that don't display sidebar widgets.", 'wp-translate'); ?></em></p>
			<p><strong><a href="https://plugingarden.com/google-translate-wordpress-plugin/?src=wpt" target="_blank"><?php _e('Upgrade to WP Translate Pro', 'wp-translate'); ?></a></strong></p>
			<!--<p><strong><?php _e('WP Easy Gallery Pro', 'wp-translate'); ?></strong><br /><em><?php _e('Pro Features include: Multi-image uploader, Enhanced admin section for easier navigation, Image preview pop-up, and more', 'wp-translate'); ?>...</em></p>
			<p><a href="https://plugingarden.com/wordpress-gallery-plugin/?src=wpt" target="_blank"><img src="https://plugingarden.com/wp-content/uploads/2017/08/WP-Easy-Gallery-Pro_200x160.gif" width="200" height="160" border="0" alt="WP Easy Gallery Pro"></a></p>
			<p><strong><?php _e('Try Custom Post Donations Premium', 'wp-translate'); ?></strong><br /><em><?php _e('This WordPress plugin will allow you to create unique customized PayPal donation widgets to insert into your WordPress posts or pages and accept donations. Features include: Multiple Currencies, Multiple PayPal accounts, Custom donation form display titles, and more.', 'wp-translate'); ?></em></p>
			<p><a href="https://plugingarden.com/wordpress-paypal-plugin/?src=wpt" target="_blank"><img src="https://plugingarden.com/wp-content/uploads/2017/08/CustomPostDonationsPro-200x400v4.png" width="200" height="400" alt="Custom Post Donations Pro" border="0"></a></p>
			<p><strong><?php _e('Try Email Obfuscate', 'wp-translate'); ?></strong><br /><em><?php _e('Email Obfuscate is a Lightweight WordPress/jQuery plugin that prevents spam-bots from harvesting your email addresses by dynamically obfuscating email addresses on your site.', 'wp-translate'); ?></em><br /><a href="http://codecanyon.net/item/wordpressjquery-email-obfuscate-plugin/721738?ref=HahnCreativeGroup" target="_blank">Email Obfuscate Plugin</a></p>
			<p><a href="http://codecanyon.net/item/wordpressjquery-email-obfuscate-plugin/721738?ref=HahnCreativeGroup" target="_blank"><img alt="WordPress/jQuery Email Obfuscate Plugin - CodeCanyon Item for Sale" border="0" class="landscape-image-magnifier preload no_preview" height="80" src="<?php echo plugins_url( '/images/WordPress-Email-Obfuscate_thumb_80x80.jpg', __FILE__ ); ?>" title="" width="80"></a></p>-->
			<hr/>
			<p><a href="https://www.plugingarden.com/refer/elegant-themes" target="_blank" rel="nofollow"><img style="border:0px" src="https://www.elegantthemes.com/affiliates/media/banners/300x250.gif" width="300" height="250" alt=""></a></p>
			<hr/>
			<p><em><?php _e('Please consider making a donation for the continued development of this plugin. Thank you.', 'wp-translate'); ?></em></p>
			<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EJVXJP3V8GE2J" target="_blank"><img src="<?php echo plugins_url( '/images/btn_donateCC_LG.gif', __FILE__ ); ?>" border="0" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></a></p>
		</div>
</div>
<div id="wp-translate-update-status"><div id="loading-image-wrap"><img src="<?php echo WP_PLUGIN_URL; ?>/wp-translate/admin/images/loading_spinner.gif" width="75" height="75" /></div>
</div><?php ob_end_flush(); ?>