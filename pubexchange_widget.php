<?php
/**
 * Plugin Name: PubExchange
 * Plugin URI: https://www.pubexchange.com
 * Description: PubExchange
 * Version: 2.0.7
 * Author: PubExchange
 */

include_once('widget.php');

if (!class_exists('PubExchangeWP')) {
    class PubExchangeWP
    {
        public function __construct()
        {
            global $wpdb;

            //initialize plugin constant
            DEFINE('PubExchangeWP', true);

            $this->plugin_name = plugin_basename(__FILE__);
            $this->plugin_directory = plugin_dir_path(__FILE__);
            $this->plugin_url = trailingslashit(WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));

            $this->settings = new stdClass();
            $this->settings->pubexchange_publication_id = get_option("pubexchange_publication_id");
            $this->settings->pubexchange_widget_id = get_option("pubexchange_widget_id");
            $this->settings->pubexchange_widget_number = get_option("pubexchange_widget_number");
            $this->settings->pubexchange_link_discovery = get_option("pubexchange_link_discovery");
            $this->settings->pubexchange_lazy_load = get_option("pubexchange_lazy_load");

            // Enable sidebar widgets
            if($this->settings->pubexchange_publication_id){
                //register PubExchange widget
                add_action('widgets_init', function() { register_widget( 'WP_Widget_PubExchange' ); } );
            }

            if (is_admin()) {
                //add menu for plugin
                add_action('admin_menu', array(&$this, 'admin_generate_menu') );
                add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
            } elseif ($this->settings->pubexchange_publication_id) {
                add_action('wp_head', array(&$this, 'pubexchange_header_meta_tags'));
                add_action('wp_footer', array(&$this, 'pubexchange_footer_load_js'));
                add_filter('the_content', array(&$this, 'load_pubexchange_content'));
            }
        }

        function plugin_action_links($links, $file) {
            static $this_plugin;

            if (!$this_plugin) {
                $this_plugin = plugin_basename(__FILE__);
            }

            if ($file == $this_plugin) {
                $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=pubexchange_widget">Settings</a>';
                array_unshift($links, $settings_link);
            }

            return $links;
        }

        private function should_show_content_widget(){
            $retVal = (($this->settings->pubexchange_publication_id) && is_single());
            return $retVal;
        }

        private function should_show_sidebar_widget(){
            $retVal = (($this->settings->pubexchange_publication_id) && is_active_widget( false, false, PUBEXCHANGE_WIDGET_BASE_ID, true ));
            return $retVal;
        }

        // Determine if a pubexchange widget should be added somewhere on the current page (content or sidebar)
        function is_widget_on_page(){
            return  $this->should_show_content_widget() || $this->should_show_sidebar_widget();
        }

        // return the head loader script
        function pubexchange_header_meta_tags() {
            if (is_single()) {
                global $post;

                $url = "";
                if (($thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' )) OR ($thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ))) {
                    $url = $thumb[0];

                    // if Jetpack enabled site, load thumbnail using WP Photon (https://developer.wordpress.com/docs/photon/)
                    if (class_exists("Jetpack", false)) {
                        $site_parsed = parse_url(site_url());
                        $thumb_parsed = parse_url($url);

                        if ($site_parsed && $thumb_parsed && ($site_parsed['host'] == $thumb_parsed["host"])) {
                            $url = "https://i0.wp.com/".$thumb_parsed["host"].$thumb_parsed["path"]."?w=300";
                        }
                    }
                }

                if (!empty($url)) {
                    echo "<meta name=\"pubexchange:image\" content=\"".$url."\">\n";
                }
                if ($headline = get_the_title( $post->ID )) {
                    echo "<meta name=\"pubexchange:title\" content=\"".substr(addcslashes($headline, '"\\/'),0,255)."\">\n";
                }
            }
        }

        function pubexchange_footer_load_js() {
            if ($this->is_widget_on_page()){
                $script_content = str_replace(array('{{PUBLICATION_ID}}','{{LAZY_LOAD}}','{{LINK_DISCOVERY}}'), array($this->settings->pubexchange_publication_id, ($this->settings->pubexchange_lazy_load ? 'true' : 'false'), ($this->settings->pubexchange_link_discovery ? 'true' : 'false')), file_get_contents($this->plugin_directory.'js/pubexchange_script.js'));
                echo '<script type="text/javascript">'.$script_content.'</script>';
            }
        }

        function load_pubexchange_content($content)
        {
            if (($this->should_show_content_widget()) && ($this->settings->pubexchange_widget_id) && ($this->settings->pubexchange_widget_number)) {
                $pubexchange_div_tag = '<div class="pubexchange_module" id="pubexchange_'. $this->settings->pubexchange_widget_id . '" data-pubexchange-module-id="'.$this->settings->pubexchange_widget_number.'"></div>';
                $content = $content.$pubexchange_div_tag;
            }
            return $content;
        }

        function admin_generate_menu(){
            global $current_user;
            add_options_page('PubExchange', 'PubExchange', 'manage_options', 'pubexchange_widget', array(&$this, 'admin_pubexchange_settings'));
        }

        function admin_pubexchange_settings(){
            $pubexchange_errors = array();
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                if(trim($_POST['pubexchange_publication_id']) == ''){
                    $pubexchange_errors[] = "Please add a 'Publication ID' in order to apply changes to your widgets";

                } elseif((trim($_POST['pubexchange_widget_id']) == '')&&(trim($_POST['pubexchange_widget_number']) != '')){
                    $pubexchange_errors[] = "Please add a 'Widget ID' in order to display a widget below your content";

                } elseif((trim($_POST['pubexchange_widget_id']) != '')&&(trim($_POST['pubexchange_widget_number']) == '')){
                    $pubexchange_errors[] = "Please add a 'Widget Number' in order to display a widget below your content";

                } elseif ((trim($_POST['pubexchange_widget_number']) != '') && (filter_var(trim($_POST['pubexchange_widget_number']), FILTER_VALIDATE_INT, array('options' => array('min_range' => 0))) === FALSE)) {
                    $pubexchange_errors[] = "'Widget Number' must be an integer";

                } else  {
                    // update database
                    update_option("pubexchange_publication_id", trim($_POST['pubexchange_publication_id']));
                    update_option("pubexchange_widget_id", trim($_POST['pubexchange_widget_id']));
                    update_option("pubexchange_widget_number", trim($_POST['pubexchange_widget_number']));
                    update_option("pubexchange_lazy_load", $_POST['pubexchange_lazy_load']);
                    update_option("pubexchange_link_discovery", $_POST['pubexchange_link_discovery']);
                }
            }

            // update local settings
            $settings = array(
                "pubexchange_publication_id" => get_option("pubexchange_publication_id"),
                "pubexchange_widget_id" => get_option("pubexchange_widget_id"),
                "pubexchange_widget_number" => get_option("pubexchange_widget_number"),
                "pubexchange_lazy_load" => get_option("pubexchange_lazy_load"),
                "pubexchange_link_discovery" => get_option("pubexchange_link_discovery")
            );

            include_once('settings.php');
        }
    }
}

global $pubexchangeWP;
$pubexchangeWP = new PubExchangeWP();