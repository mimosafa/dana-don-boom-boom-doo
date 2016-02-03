<?php
/**
 * Plugin Name: Dana Don Boom Boom Doo
 * Version: 0.1-alpha
 * Description: Help WordPress development.
 * Author: Toshimichi Mimoto
 * Author URI: http://mimosafa.me
 * Plugin URI: https://github.com/mimosafa/dana-don-boom-boom-doo
 * Text Domain: dana-don-boom-boom-doo
 * Domain Path: /languages
 * @package Dana-don-boom-boom-doo
 */

if ( DanaDonBoomBoomDooRequirements::check() ) {
	define( 'DANA_DON_BOOM_BOOM_DOO', true );
	require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Dana Don Boom Boom Doo plugin requirements check.
 *
 * @since 0.0
 */
class DanaDonBoomBoomDooRequirements {

	/**
	 * Required PHP & WordPress versions.
	 */
	const PHP = '5.4';
	const WP  = '4.4';

	/**
	 * Current PHP & WordPress versions.
	 *
	 * @var string
	 */
	private $php;
	private $wp;

	/**
	 * @var WP_Error
	 */
	private $e;

	public static function check() {
		static $instance;
		if ( ! $instance ) {
			$instance = new self();
			return $instance->compare();
		}
		return true;
	}

	private function __construct() {
		$this->php = PHP_VERSION;
		$this->wp  = $GLOBALS['wp_version'];
		$this->e = new WP_Error();
	}

	private function compare() {
		if ( version_compare( $this->php, self::PHP, '<' ) ) {
			$this->e->add(
				'error', 'Dana Don Boom Boom Doo plugin cannot be activated.'
			);
		}
		if ( version_compare( $this->wp, self::WP, '<' ) ) {
			$this->e->add(
				'error', 'Dana Don Boom Boom Doo plugin cannot be activated.'
			);
		}
		if ( $this->e->get_error_code() ) {
			add_action( 'admin_init', [ $this, 'error_message' ] );
			return false;
		}
		return true;
	}

	public function error_message() {
		foreach ( $this->e->get_error_messages() as $message ) {
			add_settings_error(
				'dana-don-boom-boom-doo-requirement', 'plugin_requirement', $message, 'error'
			);
		}
		add_action( 'admin_notices', [ $this, 'show_error'] );
	}

	public function show_error() {
		settings_errors( 'dana-don-boom-boom-doo-requirement' );
	}

}
