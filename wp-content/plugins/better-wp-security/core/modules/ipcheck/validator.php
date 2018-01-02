<?php

class ITSEC_Network_Brute_Force_Validator extends ITSEC_Validator {
	public function get_id() {
		return 'network-brute-force';
	}
	
	protected function sanitize_settings() {
		$previous_settings = ITSEC_Modules::get_settings( $this->get_id() );
		$this->settings = array_merge( $previous_settings, $this->settings );
		
		if ( isset( $this->settings['email'] ) ) {
			$this->sanitize_setting( 'email', 'email', __( 'Email Address', 'better-wp-security' ) );
			$this->vars_to_skip_validate_matching_fields[] = 'email';
		}
		
		$this->sanitize_setting( 'bool', 'updates_optin', __( 'Receive Email Updates', 'better-wp-security' ) );
		
		$this->sanitize_setting( 'string', 'api_key', __( 'API Key', 'better-wp-security' ) );
		$this->sanitize_setting( 'string', 'api_secret', __( 'API Secret', 'better-wp-security' ) );
		$this->sanitize_setting( 'bool', 'enable_ban', __( 'Ban Reported IPs', 'better-wp-security' ) );
	}
	
	protected function validate_settings() {
		if ( ! $this->can_save() ) {
			return;
		}
		
		
		if ( isset( $this->settings['email'] ) ) {
			require_once( dirname( __FILE__ ) . '/utilities.php' );
			
			$key = ITSEC_Network_Brute_Force_Utilities::get_api_key( $this->settings['email'], $this->settings['updates_optin'] );
			
			if ( is_wp_error( $key ) ) {
				$this->set_can_save( false );
				$this->add_error( $key );
			} else {
				$secret = ITSEC_Network_Brute_Force_Ut