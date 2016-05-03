<?php
/*
Plugin Name: FacetWP - Conditional Logic
Description: Toggle facets based on certain conditions
Version: 1.0
Author: FacetWP, LLC
Author URI: https://facetwp.com/
GitHub Plugin URI: https://github.com/FacetWP/facetwp-conditional-logic

Copyright 2016 FacetWP, LLC

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

defined( 'ABSPATH' ) or exit;

class FacetWP_Conditional_Logic_Addon
{

    public $rules;
    public $facets = array();
    public $templates = array();


    function __construct() {

        define( 'FWPCL_VERSION', '1.0' );
        define( 'FWPCL_DIR', dirname( __FILE__ ) );
        define( 'FWPCL_URL', plugins_url( '', __FILE__ ) );
        define( 'FWPCL_BASENAME', plugin_basename( __FILE__ ) );

        add_action( 'init', array( $this, 'init' ), 12 );
    }


    function init() {
        if ( ! function_exists( 'FWP' ) ) {
            return;
        }

        // ajax
        add_action( 'wp_ajax_fwpcl_import', array( $this, 'import' ) );

        // wp hooks
        add_action( 'wp_footer', array( $this, 'render_js' ), 25 );
        add_action( 'wp_ajax_fwpcl_save', array( $this, 'save_rules' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

        $this->facets = FWP()->helper->get_facets();
        $this->templates = FWP()->helper->get_templates();

        // load settings
        $rulesets = get_option( 'fwpcl_rulesets' );
        $this->rulesets = empty( $rulesets ) ? array() : json_decode( $rulesets, true );

        // register frontend script
        wp_register_script( 'fwpcl-front-handler', FWPCL_URL . '/assets/js/front.js', array( 'jquery' ), FWPCL_VERSION, true );

        // do rules on front
        add_action( 'wp_footer', array( $this, 'render_js' ) );
    }


    function import() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $rulesets = stripslashes( $_POST['import_code'] );
        update_option( 'fwpcl_rulesets', $rulesets );
        _e( 'All done!', 'fwpcl' );
        exit;
    }


    function save_rules() {
        if ( current_user_can( 'manage_options' ) ) {
            $rulesets = stripslashes( $_POST['data'] );
            $json_test = json_decode( $rulesets, true );

            // check for valid JSON
            if ( is_array( $json_test ) ) {
                update_option( 'fwpcl_rulesets', $rulesets );
                _e( 'Rules saved', 'fwpcl' );
            }
            else {
                _e( 'Error: invalid JSON', 'fwpcl' );
            }
        }
        exit;
    }


    function admin_menu() {
        add_options_page( 'FacetWP Logic', 'FacetWP Logic', 'manage_options', 'fwpcl-admin', array( $this, 'settings_page' ) );
    }


    function enqueue_scripts( $hook ) {
        if ( 'settings_page_fwpcl-admin' == $hook ) {
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_style( 'media-views' );
        }
    }


    function settings_page() {
        include( dirname( __FILE__ ) . '/page-settings.php' );
    }


    function render_js() {
        wp_enqueue_script( 'fwpcl-front-handler' );
        wp_localize_script( 'fwpcl-front-handler', 'FWPCL', $this->rulesets );
    }
}


new FacetWP_Conditional_Logic_Addon();
