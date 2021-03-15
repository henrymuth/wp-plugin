<?php
// Wird das Plugin aktiviert
register_activation_hook(plugin_dir_url(__FILE__), 'hm_active');

// Wird das Plugin deaktiviert
register_deactivation_hook(plugin_dir_url(__FILE__), 'hm_deactivate');

// Wird das Plugin deinstalliert
register_uninstall_hook(__FILE__, 'hm_uninstall');

/**
* Beim aktivieren des Plugins
*/
function hm_active()
{
	add_action( 'init', 'wpstar_create_new_page' );
}
//add_action( 'all', create_function( '', 'var_dump( current_filter());' ) );
//do_action( 'wpstar_create_new_page' );

function wpstar_create_new_page() {
	
		$wp_data = array(
					'ID'				=> '',
		 			'post_title' 		=> 'Star overview',
		 			'post_status'		=> 'draft',
		 			'comment_status' 	=> 'closed',
		 			'ping_status' 		=> 'closed',
		 			'post_name' 		=> 'star-overview',
		 			'post_parent'		=> 0,
		 			'menu_order' 		=> 0,
		 			'post_type' 		=> 'page'
		 );

		$post_id = wp_insert_post($wp_data);
		if(!is_wp_error($post_id)){
			//the post is valid
		}else{
			  //there was an error in the post insertion, 
			echo $post_id->get_error_message();
		}
}

add_action( 'activated_plugin', 'hm_do_activate_plugin' );

function hm_do_activate_plugin()
{
	global $wpdb;

	$post = $wpdb->get_row("select * form " . $wpdb->prefix . "posts where post_title = 'Automatisch gespeicherter Entwurf'");

	$post_id = $post->ID;

	if( is_admin() ) {
		$wpdb->query($wpdb->prepare("update " . $wpdb->prefix . "posts set post_status = 'draft', post_title = '" . PLUGIN_NAME . "' where ID = " . $post_id . "'"));
	}
}

add_action( 'deactivated_plugin', 'hm_do_deactivate_plugin' );

function hm_do_deactivate_plugin()
{
	global $wpdb;

	$post= $wpdb->get_row("select * form " . $wpdb->prefix . "posts where post_title = 'Star overview'");


	if( is_admin() ) {

		$wpdb->query($wpdb->prepare("update wp_posts set post_status = 'draft' where post_title = 'Star overview'"));
	}
}

/**
* Beim deaktivieren des Plugins
*/
function hm_deactivate()
{
	add_action('delete_post', 'hm_delete_star');
}

function hm_delete_star()
{
	$starID = get_pages( array( 'post_title' => 'Star overview') );

	foreach ($starID as $value) {
		if( $value->post_title == 'Star overview') {
			wp_delete_attachment( $value->ID, true);
		}
	}
}

/**
* Erstellen einer Tabelle mit einer Übersicht der Künstler
*/

add_filter('the_content', 'getTable', 0);

function getTable($content)
{
	if ( is_page() ) {
		if( strpos($_SERVER['REQUEST_URI'], PLUGIN_URI) !== false ) {
			if( class_exists( 'getData') ) {
				$ds = getData::setJsonData();
				$text = $content;

				$star_tabel_start = '<div class="stars">
					<table>
						<tr>
							<th>Name</th>
						    <th>Username</th>
						    <th>E - Mail</th>
		      			</tr>';
		      	$star_table_content = '';

		      	foreach ($ds as $key => $value) {

		      		$star_table_content .= '<tr>
		      			<td id="' . $value["id"] . '" class="tabStars">
		      			' . $value["name"] . '</td>
		      			<td id="' . $value["id"] . '" class="tabStars">
		      			' . $value["username"] . '</td>
		      			<td id="' . $value["id"] . '" class="tabStars">
		      			' . $value["email"] . '</td>
		      		</tr>';
		      	}

				$star_table_end = '</table>
					<div class="dialogs"></div>
				</div>';

				$content = $text . $star_tabel_start . $star_table_content . $star_table_end;

				return $content;
			}
		} else {
			return $content;
		}
	} else {
		return $content;
	}
}
