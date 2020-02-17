<?php
/*
Plugin Name: PMPro Customizations
Plugin URI: https://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Customizations for my Paid Memberships Pro Setup
Version: .1
Author: Paid Memberships Pro
Author URI: https://www.paidmembershipspro.com
*/
 
//Function for extra fields in PMP profiles

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>IFAJ profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="country">Country</label></th>

			<td>
				<input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter country where your guild is.</span>
			</td>
		</tr>
		<tr>
			<th><label for="title2">Title</label></th>

			<td>
				<input type="text" name="title2" id="title2" value="<?php echo esc_attr( get_the_author_meta( 'title2', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter your title or position.</span>
			</td>
		</tr>
		<tr>
			<th><label for="organization">Organization</label></th>

			<td>
				<input type="text" name="organization" id="organization" value="<?php echo esc_attr( get_the_author_meta( 'organization', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter the organization you are with.</span>
			</td>
		</tr>
		<tr>
			<th><label for="freelance">I do freelance work?</label></th>

			<td>
				<input type="text" name="freelance" id="freelance" value="<?php echo esc_attr( get_the_author_meta( 'freelance', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Answer yes or no if you are available for freelance work freelance.</span>
			</td>
		</tr>
		<tr>
			<th><label for="format">I produce work in the following formats:</label></th>

			<td>
				<input type="text" name="format" id="format" value="<?php echo esc_attr( get_the_author_meta( 'format', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter one or more keywords that summarize format of work you do.</span>
			</td>
		</tr>
		<tr>
			<th><label for="expertise">Areas of expertise</label></th>

			<td>
				<input type="text" name="expertise" id="expertise" value="<?php echo esc_attr( get_the_author_meta( 'expertise', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter one or more keywords that summarize your areas of expertise.</span>
			</td>
		</tr>

	</table>
<?php }

//saving extra fields in PMP profiles

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'country', $_POST['country'] );
	update_usermeta( $user_id, 'title2', $_POST['title2'] );
	update_usermeta( $user_id, 'organization', $_POST['organization'] );
	update_usermeta( $user_id, 'freelance', $_POST['freelance'] );
	update_usermeta( $user_id, 'format', $_POST['format'] );
	update_usermeta( $user_id, 'expertise', $_POST['expertise'] );

}
  
  //Updates user profile last saved date in user meta
//Sorts the PMPro Member Directory by last updated

//Taken from: https://wordpress.stackexchange.com/questions/216609/last-modified-field-for-user-profile

function update_profile_modified( $user_id ) {
  update_user_meta( $user_id, 'user_profile_updated', current_time( 'mysql' ) );
}

add_action( 'profile_update', 'update_profile_modified', 10, 1);

function my_pmpro_member_directory_sql($sqlQuery, $levels, $s, $pn, $limit, $start, $end, $order_by, $order)
{
	global $wpdb;
	
	if($s)
	{
		$sqlQuery = 
		
		"SELECT SQL_CALC_FOUND_ROWS 
		u.ID, 
		u.user_login, 
		u.user_email, 
		u.user_nicename, 
		u.display_name, 
		UNIX_TIMESTAMP(u.user_registered) as joindate, 
		mu.membership_id, 
		mu.initial_payment, 
		mu.billing_amount, 
		mu.cycle_period, 
		mu.cycle_number, 
		mu.billing_limit, 
		mu.trial_amount, 
		mu.trial_limit, 
		UNIX_TIMESTAMP(mu.startdate) as startdate, 
		UNIX_TIMESTAMP(mu.enddate) as enddate, 
		m.name as membership, 
		umf.meta_value as first_name, 
		uml.meta_value as last_name,
		umz.meta_value as user_profile_updated
		
		FROM $wpdb->users u 
		
		LEFT JOIN $wpdb->usermeta umh ON umh.meta_key = 'pmpromd_hide_directory' AND u.ID = umh.user_id 
		LEFT JOIN $wpdb->usermeta umf ON umf.meta_key = 'first_name' AND u.ID = umf.user_id 
		LEFT JOIN $wpdb->usermeta uml ON uml.meta_key = 'last_name' AND u.ID = uml.user_id 
		LEFT JOIN $wpdb->usermeta umz ON umz.meta_key = 'user_profile_updated' AND u.ID = umz.user_id 
		LEFT JOIN $wpdb->usermeta um ON u.ID = um.user_id 
		LEFT JOIN $wpdb->pmpro_memberships_users mu ON u.ID = mu.user_id 
		LEFT JOIN $wpdb->pmpro_membership_levels m ON mu.membership_id = m.id 
				
		WHERE mu.status = 'active' 
		AND (umh.meta_value IS NULL OR umh.meta_value <> '1') 
		AND mu.membership_id > 0 AND ";
		
		$sqlQuery .= "(u.user_login LIKE '%" . esc_sql($s) . "%' OR u.user_email LIKE '%" . esc_sql($s) . "%' OR u.display_name LIKE '%" . esc_sql($s) . "%' OR um.meta_value LIKE '%" . esc_sql($s) . "%') ";
		if($levels)
			$sqlQuery .= " AND mu.membership_id IN(" . esc_sql($levels) . ") ";
		$sqlQuery .= "GROUP BY u.ID ORDER BY ". esc_sql($order_by) . " " . $order;
	}
	else
	{
		$sqlQuery = 
		
		"SELECT SQL_CALC_FOUND_ROWS u.ID, 
		u.user_login, 
		u.user_email, 
		u.user_nicename, 
		u.display_name, 
		UNIX_TIMESTAMP(u.user_registered) as joindate, 
		mu.membership_id, 
		mu.initial_payment, 
		mu.billing_amount, 
		mu.cycle_period, 
		mu.cycle_number, 
		mu.billing_limit, 
		mu.trial_amount, 
		mu.trial_limit, 
		UNIX_TIMESTAMP(mu.startdate) as startdate, 
		UNIX_TIMESTAMP(mu.enddate) as enddate, 
		m.name as membership, 
		umf.meta_value as first_name, 
		uml.meta_value as last_name,
		umz.meta_value as user_profile_updated
 
		
		FROM $wpdb->users u 
		
		LEFT JOIN $wpdb->usermeta umh ON umh.meta_key = 'pmpromd_hide_directory' AND u.ID = umh.user_id 
		LEFT JOIN $wpdb->usermeta umf ON umf.meta_key = 'first_name' AND u.ID = umf.user_id 
		LEFT JOIN $wpdb->usermeta uml ON uml.meta_key = 'last_name' AND u.ID = uml.user_id 
		LEFT JOIN $wpdb->usermeta umz ON umz.meta_key = 'user_profile_updated' AND u.ID = umz.user_id 
		LEFT JOIN $wpdb->pmpro_memberships_users mu ON u.ID = mu.user_id 
		LEFT JOIN $wpdb->pmpro_membership_levels m ON mu.membership_id = m.id";
		
		$sqlQuery .= " WHERE mu.status = 'active' AND (umh.meta_value IS NULL OR umh.meta_value <> '1') AND mu.membership_id > 0 ";
		if($levels)
			$sqlQuery .= " AND mu.membership_id IN(" . esc_sql($levels) . ") ";
		$sqlQuery .= "ORDER BY ". esc_sql($order_by) . " " . esc_sql($order);
	}
	$sqlQuery .= " LIMIT $start, $limit";
	
	return $sqlQuery;
}
	
add_filter("pmpro_member_directory_sql", "my_pmpro_member_directory_sql", 10, 9);

?>