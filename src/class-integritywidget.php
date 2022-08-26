<?php
/**
 * Class that defines a dashboard widget.
 *
 * @package Custom Child Theme Post types
 * @since 1.1.0
 */

/**
 * Defines base widget
 */
class IntegrityWidget {

	/**
	 * The id of this widget.
	 */
	const WID = 'exhibit_integrity';

	/**
	 * The required permission to access this page.
	 */
	const PERMS = 'manage_options';

	/**
	 * Hook to wp_dashboard_setup to add the widget.
	 */
	public static function init() {

		// Define the dashboard widget.
		if ( current_user_can( self::PERMS ) ) {
			wp_add_dashboard_widget(
				self::WID, // A unique slug/ID.
				'Exhibit data integrity', // Visible name for the widget.
				array( 'IntegrityWidget', 'widget' )  // Callback for the main widget content.
			);
		}
	}

	/**
	 * Load the widget code
	 */
	public static function widget() {

		// Check user capabilities.
		if ( ! current_user_can( self::PERMS ) ) {
			return;
		}

		$query = new WP_Query(
			array(
				'post_type' => 'exhibits',
				'posts_per_page' => 99,
			)
		);

		if ( function_exists( 'get_exhibit_location' ) ) {
			// Use the template to render widget output.
			require_once( plugin_dir_path( __FILE__ ) . '../templates/integrity-widget.php' );
		} else {
			// Use the template to render widget output.
			require_once( plugin_dir_path( __FILE__ ) . '../templates/integrity-widget-pending.php' );
		}
	}
}
