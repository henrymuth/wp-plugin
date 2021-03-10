<?php
// Wird das Plugin aktiviert
register_activation_hook(__FILE__, 'hm_activate');

// Wird das Plugin deaktiviert
register_deactivation_hook(__FILE__, 'hm_deactivate');

// Wird das Plugin deinstalliert
register_uninstall_hook(__FILE__, 'hm_uninstall');

/**
* Beim aktivieren des Plugins
*/
function hm_activate()
{
	add_action( 'admin_menu', 'start_mplugin' );
}

function start_mplugin()
{
 	/*global $wpdb;
 	$table_name = $wpdb->prefix . "wp_posts";

 	$wpdb->insert(
 		$table_name,*/
 	$wp_data = array(
 			'post_date' 		=> date('Y-m-d H:i-s'),
 			'post_date_gmt' 	=> date('Y-m-d H:i-s'),
 			'post_content' 		=> '',
 			'post_title' 		=> 'Star overview',
 			'comment_status' 	=> 'closed',
 			'ping_status' 		=> 'closed',
 			'post_name' 		=> 'star-overview',
 			'post_parent'		=> 0,
 			'menu_order' 		=> 0,
 			'post_type' 		=> 'page'
 		);
 	echo wp_insert_post($wp_data, $wp_error = true);
 	/*,
 		array(
 			'%d',	//post_date
 			'%d',	//post_date_gmt
 			'%s',	//post_content
 			'%s',	//post_title
 			'%s',	//comment_status
 			'%s',	//ping_status
 			'%s',	//post_name
 			'%s',	//post_name
 			'%i', 	//menu_order
 			'%s'	//post_type
 		)
 	);*/
}

/**
* Beim deaktivieren des Plugins
*/
function hm_deactivate()
{
	global $wpdb;

	$wpdb->delete($wpdb->prefix() . 'posts',
		array('post_title' => 'Star overview')
	);
}

/**
* Erstellen einer Tabelle mit einer Übersicht der Künstler
*/

add_filter('the_content', 'getTable', 0);

function getTable($content)
{
	if ( is_page() ) {
		if( strpos($_SERVER['REQUEST_URI'], PLUGIN_URI) !== false ) {
			$ds = getData::setJsonData();
			?>
			<?= $content; ?>
			<div class="stars">
				<table>
					<tr>
						<th>Name</th>
					    <th>Username</th>
					    <th>E - Mail</th>
	      			</tr>
	      			<?php foreach ($ds as $key => $value) : ?>
	      				<tr>
	      					<td id="<?= $value['id']; ?>" class="tabStars"><?= $value['name']; ?></td>
	      					<td id="<?= $value['id']; ?>" class="tabStars"><?= $value['username']; ?></td>
	      					<td id="<?= $value['id']; ?>" class="tabStars"><?= $value['email']; ?></td>
	      				</tr>
	      			<?php endforeach; ?>
				</table>
				<div class="dialogs"></div>
			</div>
			<?php
		} else {
			return $content;
		}
	} else {
		return $content;
	}
}