<?php
/**
 * Created by PhpStorm.
 * User: jesper
 * Date: 15-03-02
 * Time: 16:29
 */

class BillmateCommon {

	private $options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	public function page_init() {
		register_setting(
			'billmate_common', // Option group
			'billmate_common_settings', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_credentials', // ID
			'My Custom Settings', // Title
			array( $this, 'print_section_info' ), // Callback
			'billmate-settings' // Page
		);

		add_settings_field(
			'eid', // ID
			__('Billmate ID'), // Title
			array( $this, 'eid_callback' ), // Callback
			'billmate-settings', // Page
			'setting_credentials' // Section
		);

		add_settings_field(
			'seecret',
			__('Secret'),
			array( $this, 'secret_callback' ),
			'billmate-settings',
			'setting_credentials'
		);
	}

	public function add_plugin_page() {
		add_options_page(
			'Billmate Common',
			'Billmate Settings',
			'manage_options',
			'billmate-settings',
			array( $this, 'create_admin_page' )
		);
	}

	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'billmate_common_settings' );
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2>My Settings</h2>
			<form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( 'billmate_common' );
				do_settings_sections( 'billmate-settings' );
				submit_button();
				?>
			</form>
		</div>
	<?php
	}
}