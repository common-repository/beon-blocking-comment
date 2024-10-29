<?php

class beonComment {

	protected $option_name = 'beon-comment';
	
	protected $data = array(
		
        'select_one' => '1',
		'select_two' => '0',
		'select_three' => 'spam',
		'select_four' => 'spam',
		'select_five' => '1',
		'select_six' => '0',
        'select_seven' => 'spam',
        'select_eight' => 'spam'
    );
	
	public function __construct() {
	
		//add_action('init', array($this, 'init')); //disable sementara soalnya gak tau funsinya apa
		
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'add_page'));
		
		register_activation_hook(BEON_COMMENT_FILE, array($this, 'activate'));
		
		register_deactivation_hook(BEON_COMMENT_FILE, array($this, 'deactivate'));
	
	}
	
	public function activate() {
        update_option($this->option_name, $this->data);
    }

    public function deactivate() {
        delete_option($this->option_name);
    }
	
	public function init() {
	
		
	
	}
	
	public function admin_init() {
	
		register_setting('beon_comment_option', $this->option_name, array($this, 'validate'));
	
	}
	
	public function add_page() {
	
		add_options_page('Beon Comment', 'Beon Comment Option', 'manage_options', 'beon_comment_option', array($this, 'options_do_page'));
	
	}
	
	public function validate($input) {
	
		$valid = array();
        $valid['select_one'] = sanitize_text_field($input['select_one']);
        $valid['select_two'] = sanitize_text_field($input['select_two']);
        $valid['select_three'] = sanitize_text_field($input['select_three']);
        $valid['select_four'] = sanitize_text_field($input['select_four']);
        $valid['select_five'] = sanitize_text_field($input['select_five']);
        $valid['select_six'] = sanitize_text_field($input['select_six']);
        $valid['select_seven'] = sanitize_text_field($input['select_seven']);
        $valid['select_eight'] = sanitize_text_field($input['select_eight']);

        if (strlen($valid['select_one']) == 0) {
            add_settings_error(
                    'select_one', 					// setting title
                    'select_one_error',			// error ID
                    'Please select valid option',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_one'] = $this->data['select_one'];
        }
		if (strlen($valid['select_two']) == 0) {
            add_settings_error(
                    'select_two', 					// setting title
                    'select_two_error',			// error ID
                    'Please select valid option',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_two'] = $this->data['select_two'];
        }
		if (strlen($valid['select_three']) == 0) {
            add_settings_error(
                    'select_three', 				// setting title
                    'select_three_error',			// error ID
                    'Please select valid option',	// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_three'] = $this->data['select_three'];
        }
		if (strlen($valid['select_four']) == 0) {
            add_settings_error(
                    'select_four', 					// setting title
                    'select_four_error',			// error ID
                    'Please select valid option',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_four'] = $this->data['select_four'];
        }
		if (strlen($valid['select_five']) == 0) {
            add_settings_error(
                    'select_five', 					// setting title
                    'select_five_error',			// error ID
                    'Please select valid option',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_five'] = $this->data['select_five'];
        }
		if (strlen($valid['select_six']) == 0) {
            add_settings_error(
                    'select_six', 					// setting title
                    'select_six_error',			// error ID
                    'Please select valid option',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_six'] = $this->data['select_six'];
        }
		if (strlen($valid['select_seven']) == 0) {
            add_settings_error(
                    'select_seven', 					// setting title
                    'select_seven_error',			// error ID
                    'Please select valid option',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_seven'] = $this->data['select_seven'];
        }
		if (strlen($valid['select_eight']) == 0) {
            add_settings_error(
                    'select_eight', 					// setting title
                    'select_eight_error',			// error ID
                    'Please select valid option',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['select_eight'] = $this->data['select_eight'];
        }
		
        return $valid;
	
	}
	
	public function options_do_page() {
	
		$options = get_option($this->option_name);
		//print_r($options);
		?>
		<style>
		.center{
			text-align: center;
		}
		.title-default{
			margin-bottom: 15px;
		}
		.form-table.beon-cm{
			width: 565px;
		}
		.right{
			float: left;
			padding-left: 50px;
		}
		.left{
			width: 565px;
			float: left;
		}
		</style>
        <div class="wrap">
            <h2>Beon Comment Protection Option</h2>
			<div class="left">
				<form method="post" action="options.php">
                <?php settings_fields('beon_comment_option'); ?>
                <table class="form-table beon-cm center" border="1">
					<tr>
						<th style="text-align: center;">Gravatar</th>
						<th style="text-align: center;">Ip Sender</th>
						<th style="text-align: center;">Content</th>
						<th style="text-align: center;">Action</th>
					</tr>
                    <tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Ready and IP Sender = Clear and Content = Clear</th>-->
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td>
							<select name="<?php echo $this->option_name?>[select_one]">
								<option value='1' <?php selected( $options['select_one'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_one'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_one'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                        
                    </tr>
					<tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Ready and IP Sender = Clear and Content = Blocked</th>-->
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
                        <td>
							<select name="<?php echo $this->option_name?>[select_two]">
								<option value='1' <?php selected( $options['select_two'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_two'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_two'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                    </tr>
					<tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Ready and IP Sender = Blocked and Content = Clear</th>-->
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
                        <td>
							<select name="<?php echo $this->option_name?>[select_three]">
								<option value='1' <?php selected( $options['select_three'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_three'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_three'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                    </tr>
					<tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Ready and IP Sender = Blocked and Content = Blocked</th>-->
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
                        <td>
							<select name="<?php echo $this->option_name?>[select_four]">
								<option value='1' <?php selected( $options['select_four'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_four'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_four'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                    </tr>
					<tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Non and IP Sender = Clear and Content = Clear</th>-->
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
                        <td>
							<select name="<?php echo $this->option_name?>[select_five]">
								<option value='1' <?php selected( $options['select_five'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_five'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_five'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                    </tr>
					<tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Non and IP Sender = Clear and Content = Blocked</th>-->
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
                        <td>
							<select name="<?php echo $this->option_name?>[select_six]">
								<option value='1' <?php selected( $options['select_six'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_six'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_six'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                    </tr>
					<tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Non and IP Sender = Blocked and Content = Clear</th>-->
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
                        <td>
							<select name="<?php echo $this->option_name?>[select_seven]">
								<option value='1' <?php selected( $options['select_seven'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_seven'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_seven'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                    </tr>
					<tr valign="top"><!--<th scope="row" style="width: 470px;">Gravatar = Non and IP Sender = Blocked and Content = Blocked </th>-->
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
                        <td>
							<select name="<?php echo $this->option_name?>[select_eight]">
								<option value='1' <?php selected( $options['select_eight'], 1 ); ?>>Approve</option>
								<option value='0' <?php selected( $options['select_eight'], 0 ); ?>>Moderator</option>
								<option value='spam' <?php selected( $options['select_eight'], 'spam' ); ?>>Spam</option>
							</select>
						</td>
                    </tr>
					
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            </form>
			</div>
			<div class="right">
				<div class="title-default">
					Default Setting on Our PLugin :
				</div>
				<div>
					<table class="center">
						<tr>
							<th>Gravatar</th>
							<th>Ip Sender</th>
							<th>Content</th>
							<th>Action</th>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td>Approve</td>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td>Moderation</td>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td>Spam</td>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td>Spam</td>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td>Approve</td>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td>Moderation</td>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td>Spam</td>
						</tr>
						<tr>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td>Spam</td>
						</tr>
					</table>
					<form method="post" action="options.php">
						<?php settings_fields('beon_comment_option'); ?>
						<input type="hidden" name="<?php echo $this->option_name?>[select_one]" value="1">
						<input type="hidden" name="<?php echo $this->option_name?>[select_two]" value="0">
						<input type="hidden" name="<?php echo $this->option_name?>[select_three]" value="spam">
						<input type="hidden" name="<?php echo $this->option_name?>[select_four]" value="spam">
						<input type="hidden" name="<?php echo $this->option_name?>[select_five]" value="1">
						<input type="hidden" name="<?php echo $this->option_name?>[select_six]" value="0">
						<input type="hidden" name="<?php echo $this->option_name?>[select_seven]" value="spam">
						<input type="hidden" name="<?php echo $this->option_name?>[select_eight]" value="spam">
						<p class="submit">
							<input type="submit" class="button-primary" value="<?php _e('Reset to Default') ?>" />
						</p>
					</form>
				</div>
			</div>
			<div class="cl"></div>
		</div>
        <?php
	
	}

}