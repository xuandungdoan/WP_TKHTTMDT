<?php

namespace LocoAutoTranslateAddon\Core;

if ( !class_exists( 'Settings_API' ) ):
class Settings_API {
    /**
     * settings sections array
     *
     * @var array
     */
    protected $settings_sections = array();

    /**
     * Settings fields array
     *
     * @var array
     */
    protected $settings_fields = array();

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    /**
     * Enqueue scripts and styles
     */
    function admin_enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );

        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_style('atlt-custom-style', ATLT_URL.'/assets/admin/custom-styles.css', null);
     
    }

    /**
     * Set settings sections
     *
     * @param array   $sections setting sections array
     */
    function set_sections( $sections ) {
        $this->settings_sections = $sections;

        return $this;
    }

    /**
     * Add a single section
     *
     * @param array   $section
     */
    function add_section( $section ) {
        $this->settings_sections[] = $section;

        return $this;
    }

    /**
     * Set settings fields
     *
     * @param array   $fields settings fields array
     */
    function set_fields( $fields ) {
        $this->settings_fields = $fields;

        return $this;
    }

    function add_field( $section, $field ) {
        $defaults = array(
            'name'  => '',
            'label' => '',
            'desc'  => '',
            'type'  => 'text'
        );

        $arg = wp_parse_args( $field, $defaults );
        $this->settings_fields[$section][] = $arg;

        return $this;
    }

    /**
     * Initialize and registers the settings sections and fileds to WordPress
     *
     * Usually this should be called at `admin_init` hook.
     *
     * This function gets the initiated settings sections and fields. Then
     * registers them to WordPress and ready for use.
     */
    function admin_init() {
        //register settings sections
        foreach ( $this->settings_sections as $section ) {
            if ( false == get_option( $section['id'] ) ) {
                add_option( $section['id'] );
            }

            if ( isset($section['desc']) && !empty($section['desc']) ) {
                $section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
                $callback = function() use ( $section ) {
		    echo str_replace( '"', '\"', $section['desc'] );
		};
            } else if ( isset( $section['callback'] ) ) {
                $callback = $section['callback'];
            } else {
                $callback = null;
            }

            add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
        }

        //register settings fields
        foreach ( $this->settings_fields as $section => $field ) {
            foreach ( $field as $option ) {

                $name = $option['name'];
                $type = isset( $option['type'] ) ? $option['type'] : 'text';
                $label = isset( $option['label'] ) ? $option['label'] : '';
                $callback = isset( $option['callback'] ) ? $option['callback'] : array( $this, 'callback_' . $type );

                $args = array(
                    'id'                => $name,
                    'class'             => isset( $option['class'] ) ? $option['class'] : $name,
                    'label_for'         => "{$section}[{$name}]",
                    'desc'              => isset( $option['desc'] ) ? $option['desc'] : '',
                    'name'              => $label,
                    'section'           => $section,
                    'size'              => isset( $option['size'] ) ? $option['size'] : null,
                    'options'           => isset( $option['options'] ) ? $option['options'] : '',
                    'std'               => isset( $option['default'] ) ? $option['default'] : '',
                    'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
                    'type'              => $type,
                    'placeholder'       => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
                    'min'               => isset( $option['min'] ) ? $option['min'] : '',
                    'max'               => isset( $option['max'] ) ? $option['max'] : '',
                    'step'              => isset( $option['step'] ) ? $option['step'] : '',
                );

                add_settings_field( "{$section}[{$name}]", $label, $callback, $section, $section, $args );
            }
        }

        // creates our settings in the options table
        foreach ( $this->settings_sections as $section ) {
            register_setting( $section['id'], $section['id'], array( $this, 'sanitize_options' ) );
        }
    }

    /**
     * Get field description for display
     *
     * @param array   $args settings field args
     */
    public function get_field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) {
            $desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
        } else {
            $desc = '';
        }

        return $desc;
    }

    /**
     * Displays a text field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_text( $args ) {

        $value       = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'text';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';

        $html        = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder );
        $html       .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a url field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_url( $args ) {
        $this->callback_text( $args );
    }

    /**
     * Displays a number field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_number( $args ) {
        $value       = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $type        = isset( $args['type'] ) ? $args['type'] : 'number';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
        $min         = ( $args['min'] == '' ) ? '' : ' min="' . $args['min'] . '"';
        $max         = ( $args['max'] == '' ) ? '' : ' max="' . $args['max'] . '"';
        $step        = ( $args['step'] == '' ) ? '' : ' step="' . $args['step'] . '"';

        $html        = sprintf( '<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step );
        $html       .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a checkbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_checkbox( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );

        $html  = '<fieldset>';
        $html  .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
        $html  .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
        $html  .= sprintf( '%1$s</label>', $args['desc'] );
        $html  .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a multicheckbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_multicheck( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';
        $html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id'] );
        foreach ( $args['options'] as $key => $label ) {
            $checked = isset( $value[$key] ) ? $value[$key] : '0';
            $html    .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
            $html    .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
            $html    .= sprintf( '%1$s</label><br>',  $label );
        }

        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a radio button for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_radio( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $html  = '<fieldset>';

        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">',  $args['section'], $args['id'], $key );
            $html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
            $html .= sprintf( '%1$s</label><br>', $label );
        }

        $html .= $this->get_field_description( $args );
        $html .= '</fieldset>';

        echo $html;
    }

    /**
     * Displays a selectbox for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_select( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $html  = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );

        foreach ( $args['options'] as $key => $label ) {
            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
        }

        $html .= sprintf( '</select>' );
        $html .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_textarea( $args ) {

        $value       = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size        = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="'.$args['placeholder'].'"';

        $html        = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>', $size, $args['section'], $args['id'], $placeholder, $value );
        $html        .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays the html for a settings field
     *
     * @param array   $args settings field args
     * @return string
     */
    function callback_html( $args ) {
        echo $this->get_field_description( $args );
    }

    /**
     * Displays a rich text textarea for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_wysiwyg( $args ) {

        $value = $this->get_option( $args['id'], $args['section'], $args['std'] );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '500px';

        echo '<div style="max-width: ' . $size . ';">';

        $editor_settings = array(
            'teeny'         => true,
            'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
            'textarea_rows' => 10
        );

        if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
            $editor_settings = array_merge( $editor_settings, $args['options'] );
        }

        wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

        echo '</div>';

        echo $this->get_field_description( $args );
    }

    /**
     * Displays a file upload field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_file( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
        $id    = $args['section']  . '[' . $args['id'] . ']';
        $label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File' );

        $html  = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
        $html  .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a password field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_password( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
        $html  .= $this->get_field_description( $args );

        echo $html;
    }

    /**
     * Displays a color picker field for a settings field
     *
     * @param array   $args settings field args
     */
    function callback_color( $args ) {

        $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
        $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

        $html  = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
        $html  .= $this->get_field_description( $args );

        echo $html;
    }


    /**
     * Displays a select box for creating the pages select box
     *
     * @param array   $args settings field args
     */
    function callback_pages( $args ) {

        $dropdown_args = array(
            'selected' => esc_attr($this->get_option($args['id'], $args['section'], $args['std'] ) ),
            'name'     => $args['section'] . '[' . $args['id'] . ']',
            'id'       => $args['section'] . '[' . $args['id'] . ']',
            'echo'     => 0
        );
        $html = wp_dropdown_pages( $dropdown_args );
        echo $html;
    }

    /**
     * Sanitize callback for Settings API
     *
     * @return mixed
     */
    function sanitize_options( $options ) {

        if ( !$options ) {
            return $options;
        }

        foreach( $options as $option_slug => $option_value ) {
            $sanitize_callback = $this->get_sanitize_callback( $option_slug );

            // If callback is set, call it
            if ( $sanitize_callback ) {
                $options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
                continue;
            }
        }

        return $options;
    }

    /**
     * Get sanitization callback for given option slug
     *
     * @param string $slug option slug
     *
     * @return mixed string or bool false
     */
    function get_sanitize_callback( $slug = '' ) {
        if ( empty( $slug ) ) {
            return false;
        }

        // Iterate over registered fields and see if we can find proper callback
        foreach( $this->settings_fields as $section => $options ) {
            foreach ( $options as $option ) {
                if ( $option['name'] != $slug ) {
                    continue;
                }

                // Return the callback name
                return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
            }
        }

        return false;
    }

    /**
     * Get the value of a settings field
     *
     * @param string  $option  settings field name
     * @param string  $section the section name this field belongs to
     * @param string  $default default text if it's not found
     * @return string
     */
    function get_option( $option, $section, $default = '' ) {

        $options = get_option( $section );

        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }

        return $default;
    }

    /**
     * Show navigations as tab
     *
     * Shows all the settings section labels as tab
     */
    function show_navigation() {
        $html = '<h2 class="nav-tab-wrapper">';

        $count = count( $this->settings_sections );

        // don't show the navigation if only one section exists
        if ( $count === 1 ) {
            return;
        }

        foreach ( $this->settings_sections as $tab ) {
            $html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
        }

        $html .= '</h2>';

        echo $html;
    }

    /**
     * Show the section settings forms
     *
     * This function displays every sections in a different form
     */
    function show_forms($savebtn='',$showSaveBtn=true) {
        ?>
        <div class="metabox-holder">
            <?php foreach ( $this->settings_sections as $form ) { ?>
                <div  style="width:80%;float:left;" id="<?php echo $form['id']; ?>" class="group" style="display: none;">
                    <form method="post" action="options.php">
                        <?php
                        do_action( 'wsa_form_top_' . $form['id'], $form );
                        settings_fields( $form['id'] );
                        do_settings_sections( $form['id'] );
                        do_action( 'wsa_form_bottom_' . $form['id'], $form );
                        if ( isset( $this->settings_fields[ $form['id'] ] ) ):
                        ?>
                        <div style="padding-left: 10px">
                            <?php if($showSaveBtn==true) submit_button($savebtn); ?>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            <?php } ?>
        </div>
        <div style="max-width:320px;float:right;" class="loco-settings-custom-sidebar">
       
        <?php
            $license_key=get_option("LocoAutomaticTranslateAddonPro_lic_Key","");
            $is_pro_active=is_plugin_active('loco-automatic-translate-addon-pro/loco-automatic-translate-addon-pro.php');
            $license_type=get_option('atlt-type');
            $download_url =esc_url( add_query_arg( 'license-key',$license_key , 'https://locotranslate.com/data/download-plugin.php' ) );

            if($license_type=='pro' && $license_key!= '' && $is_pro_active) {
                ?>
                <h2>Welcome! Loco Automatic Translate Addon</h2>
                <p>Dear Premium User,<br/><br/>We know that machine translation is not perfect as compare to human translation but you can save a lot of your valuable time using automated translations. If you face any issue while using this plugin, you can contact our premium support staff below.</p>
                <p><a href="mailto:contact@coolplugins.net" class="button button-secondary">Contact@CoolPlugins.net</a></p>
                <p>We hope our plugin helped you a little by automating your plugins and themes strings translation process. If you like it, please share some feedback for our team below.</p>
                <p><a href="https://wordpress.org/support/plugin/automatic-translator-addon-for-loco-translate/reviews/#new-post" class="button button-primary">Submit Review! ★★★★★</a></p>
                <h2>Important Notice & Links</h2>
                <p>Plugin do not provide any free translation limit, it only provides setting panel to use third party translate APIs. All free characters translation limit provided by third party translate API providers - <strong>Google, Microsoft, Yandex etc.</strong> You can grab translate API keys from these providers by following below instructions.</p>
                <p><a style="font-size:12px" href="https://locotranslate.com/howto-generate-google-translate-api-key/" target="_blank" class="button button-secondary">Generate Google Translate API Key</a></p>
                <p><a style="font-size:12px" href="https://locotranslate.com/how-to-generate-microsoft-translator-api-key/" target="_blank" class="button button-secondary">Generate Microsoft Translate API Key</a></p>
                <p><a style="font-size:12px" href="https://tech.yandex.com/translate/" target="_blank" class="button button-secondary">Generate Yandex Translate API Key</a></p>
            <?php
            }
            else if($is_pro_active && $license_key== ''){
                ?>
                <h2>Enter License Key</h2>
                <p>Dear User,<br/><br/>You have installed and activated <strong>Loco Automatic Translate Addon Pro</strong> plugin but didn't enter pro license key. Please add pro license key to enjoy all premium features.</p>
                <p><a href="?page=loco-atlt-register" class="button button-primary">Enter License Key</a></p>
            <?php
            }
            else if($is_pro_active==false && $license_key!= ''){
                ?>
                <h2>Install Loco Automatic Translate Addon Pro</h2>
                <p>Dear User,<br/><br/>You have activated pro license but didn't install <strong>Loco Automatic Translate Addon Pro</strong> plugin files. Please install and activate Loco Automatic Translate Addon Pro to enjoy all premium features.</p>
                <p><a href="<?php echo $download_url ?>" target="_blank" class="button button-primary">Download Pro Plugin</a></p>
                <p>or visit<br/><a href="https://locotranslate.com/my-account/downloads/" target="_blank">https://locotranslate.com/my-account/downloads/</a></p>
            <?php
            }
            else {
                ?>
                <h2>Welcome! Loco Automatic Translate Addon</h2>
                <p>Dear User,<br/><br/>You are currently using Loco Automatic Translate Addon free license. If you face any issue, please submit a support ticket below.</p>
                <p><a href="https://wordpress.org/support/plugin/automatic-translator-addon-for-loco-translate/" target="_blank" class="button button-secondary">Submit Support Ticket</a><br/>(Response time - 4 to 7 days for free users)</p>
                <h2>Upgrade Pro! Use Awesome Features</h2>
                <ul>
                    <li>Google Translate API.</li>
                    <li>Microsoft Translate API.</li>
                    <li>Google & Microsoft automated translations are 70% better than Yandex.</li>
                    <li>Google Translate provides 500,000 Char / Month free for automated translations while Microsoft Translate provides free 2,000,000 Char / Month</li>
                    <li>Reset translations with one click.</li>
                    <li>HTML translations support via Yandex API.</li>
                    <li>Regular updates with new features</li>
                    <li>Premium support via email.</li>
                </ul>
                <p><a href="https://locotranslate.com/addon/loco-automatic-translate-premium-license-key/" target="_blank" class="button button-primary">Buy Pro ($12 - $89)</a></p>
            <?php
            }
            ?>
        </div>

        <?php
        $this->script();
    }

    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script() {
        ?>
        <script>
            jQuery(document).ready(function($) {
                //Initiate Color Picker
                $('.wp-color-picker-field').wpColorPicker();

                // Switches option sections
                $('.group').hide();
                var activetab = '';
                if (typeof(localStorage) != 'undefined' ) {
                    activetab = localStorage.getItem("activetab");
                }

                //if url has section id as hash then set it as active or override the current local storage value
                if(window.location.hash){
                    activetab = window.location.hash;
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", activetab);
                    }
                }

                if (activetab != '' && $(activetab).length ) {
                    $(activetab).fadeIn();
                } else {
                    $('.group:first').fadeIn();
                }
                $('.group .collapsed').each(function(){
                    $(this).find('input:checked').parent().parent().parent().nextAll().each(
                    function(){
                        if ($(this).hasClass('last')) {
                            $(this).removeClass('hidden');
                            return false;
                        }
                        $(this).filter('.hidden').removeClass('hidden');
                    });
                });

                if (activetab != '' && $(activetab + '-tab').length ) {
                    $(activetab + '-tab').addClass('nav-tab-active');
                }
                else {
                    $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
                }
                $('.nav-tab-wrapper a').click(function(evt) {
                    $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active').blur();
                    var clicked_group = $(this).attr('href');
                    if (typeof(localStorage) != 'undefined' ) {
                        localStorage.setItem("activetab", $(this).attr('href'));
                    }
                    $('.group').hide();
                    $(clicked_group).fadeIn();
                    evt.preventDefault();
                });

                $('.wpsa-browse').on('click', function (event) {
                    event.preventDefault();

                    var self = $(this);

                    // Create the media frame.
                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: self.data('uploader_title'),
                        button: {
                            text: self.data('uploader_button_text'),
                        },
                        multiple: false
                    });

                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();
                        self.prev('.wpsa-url').val(attachment.url).change();
                    });

                    // Finally, open the modal
                    file_frame.open();
                });
        });
        </script>
        <?php
        $this->_style_fix();
    }

    function _style_fix() {
        global $wp_version;

        if (version_compare($wp_version, '3.8', '<=')):
        ?>
        <style type="text/css">
            /** WordPress 3.8 Fix **/
            .form-table th { padding: 20px 10px; }
            #wpbody-content .metabox-holder { padding-top: 5px; }
        </style>
        <?php
        endif;
    }

}

endif;