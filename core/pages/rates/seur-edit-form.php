<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function seur_edit_rate(){


	if( isset( $_GET[ 'edit_id' ] ) ) {
		global $wpdb;

		$id = sanitize_text_field ( $_GET[ 'edit_id' ] );

		$table = $wpdb->base_prefix . 'seur_custom_rates';

		//$getrate = $wpdb->get_results("SELECT * FROM tbl_employees WHERE emp_id=$id");
		$getrate = $wpdb->get_row( "SELECT * FROM " . $table . " WHERE ID = " . $id );

	}

?>
<style type="text/css">
#dis{
	display:none;
}
</style>

    <div id="dis">

	</div>


	 <form method='post' id='emp-UpdateForm' action='#'>

    <table class='table table-bordered'>
 		<input type='hidden' name='id' value='<?php echo $getrate->ID; ?>' />
        <tr>
            <td><?php _e('Rate', SEUR_TEXTDOMAIN ); ?></td>

	        <td>
	            <select title="<?php _e('Select Rate to apply', SEUR_TEXTDOMAIN ); ?>" name="rate">
				    <?php
						$tabla = $wpdb->prefix . SEUR_PLUGIN_SVPR;
						$sql   = "SELECT * FROM $tabla";
						$regs  = $wpdb->get_results( $sql );

						foreach ( $regs as $valor ) {

							if ( $getrate->rate == $valor->descripcion ){
								$selected = ' selected="selected"';
							} else {
								$selected = '';
							}

							echo '<option value="' . $valor->descripcion . '"'  . $selected . '>' . $valor->descripcion . '</option>';
						}
					?>
				</select>
            </td>
        </tr>

        <tr>
            <td><?php _e('Country', SEUR_TEXTDOMAIN ); ?></td>

            <td>
	            <select class="country" value="Select" title="<?php _e('Select Country', SEUR_TEXTDOMAIN ); ?>" name="country">
				    <?php
						echo '<option value="*">' . __( 'All Countries', SEUR_TEXTDOMAIN ) . '</option>';
						$countries = seur_get_countries();
						foreach ($countries as $country => $value )
						{

							if ( $getrate->country == $country ){
								$selected = ' selected="selected"';
							} else {
								$selected = '';
							}
							echo '<option value="' . $country  . '"' . $selected . '>' . $value . '</option>';
						}
						echo '<option value="REST">' . __( 'Rest of the World', SEUR_TEXTDOMAIN ) . '</option>';
					?>
				</select>
        </tr>

        <tr>
            <td><?php _e('State', SEUR_TEXTDOMAIN ); ?></td>

             <td id="states">
			 	<?php

				 	$country = $getrate->country;

					if( $country && $country != '* '){
						$states = seur_get_countries_states( $country );
					} else {
						$states = false;
					}

					if( $states && $states != '*') {

						echo '<select value="Select" title="' . __('Select State', SEUR_TEXTDOMAIN ) . '" name="state">';
						echo '<option value="*">' . __( 'All States', SEUR_TEXTDOMAIN ) . '</option>';
						$currentstate = $getrate->state;
						// Display city dropdown based on country name
						if( $currentstate && $currentstate != '*' ) {
							foreach( $states as $state => $value ){
								if ( $currentstate == $state ){
									$selected = ' selected="selected"';
								} else {
									$selected = '';
								}
								echo '<option value="' . $state . '"' . $selected . '>' . $value . '</option>';
							}
							echo "</select>";
						}
					}
					if ( $country == '*' ) {
						//campo
						echo '<input title="' . __( 'No needed', SEUR_TEXTDOMAIN ) . '" type="text" name="state" class="form-control" placeholder="' . __( 'No needed', SEUR_TEXTDOMAIN ) . '" value="*" readonly>';
					} ?>
             </td>

        </tr>

        <tr>
            <td><?php _e('Postcode', SEUR_TEXTDOMAIN ); ?></td>

            <td><input title="<?php _e('SEUR field description', SEUR_TEXTDOMAIN ); ?>" type='text' name='postcode' value='<?php echo $getrate->postcode ?>' class='form-control' placeholder='EX : 08023' required=""></td>
        </tr>

        <tr>
            <td><?php _e('Min Price', SEUR_TEXTDOMAIN ); ?></td>

            <td><input title="<?php _e('SEUR field description', SEUR_TEXTDOMAIN ); ?>" type='text' name='minprice' value='<?php echo $getrate->minprice ?>' class='form-control' placeholder='EX : 0' required=""></td>
        </tr>

        <tr>
            <td><?php _e('Max Price', SEUR_TEXTDOMAIN ); ?></td>

            <td><input title="<?php _e('SEUR field description', SEUR_TEXTDOMAIN ); ?>" type='text' name='maxprice' value='<?php echo $getrate->maxprice ?>' class='form-control' placeholder='EX : 100' required=""></td>
        </tr>

        <tr>
            <td><?php _e('Rate Price', SEUR_TEXTDOMAIN ); ?></td>

            <td><input title="<?php _e('SEUR field description', SEUR_TEXTDOMAIN ); ?>" type='text' name='rateprice' value='<?php echo $getrate->rateprice ?>' class='form-control' placeholder='EX : 5' required=""></td>
        </tr>

        <?php wp_nonce_field( 'edit_seur_rate', 'edit_rate_nonce_field' ); ?>

        <tr>
            <td colspan="2"><button type="submit" class="button button-primary btn btn-primary" name="btn-save" id="btn-save">Save this Record</button></td>
        </tr>

    </table>
</form>

<?php } ?>
