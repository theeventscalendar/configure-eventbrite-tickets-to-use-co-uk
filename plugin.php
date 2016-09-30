<?php
/**
 * Plugin Name: The Events Calendar Extension: Make Eventbrite Tickets Use Eventbrite.co.uk
 * Description: Make Eventbrite Tickets use eventbrite.co.uk instead of the default, eventbrite.com.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Make_Eventbrite_Tickets_Use_Co_Uk {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main'                      => '4.2'
        'Tribe__Events__Tickets__Eventbrite__Main' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_filter( 'tribe-eventbrite-base_api_url', array( $this, 'use_co_uk' ) );
    }

    /**
     * Use eventbrite.co.uk for Eventbrite Tickets
     *
     * @param string $url
     * @return string
     */
    public function use_co_uk( $url ) {
        return str_replace( '.com', '.co.uk', $url );
    }
}

new Tribe__Extension__Make_Eventbrite_Tickets_Use_Co_Uk();
