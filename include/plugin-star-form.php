<?php
if( !class_exists('StarForm') ) {

	class StarForm
	{
		public function __constructor()
		{
			if( isset( $_GET['starTitle'] ) ) {
				self::saveForm( $_GET['starTitle'] );
			}
		}

		public static function getForm()
		{
			$wrap_start = '<div class="wrap">';

			$h1 = '<h1 class="wp-heading-inline">unknown stars</h1>';

			$wrap_end = '</div>';

			$form_content = self::setFormContent();

			$form = $wrap_start . $h1 . $form_content . $wrap_end;

			return $form;
		}

		private static function setFormContent()
		{
			$form_beginn = '<form action="' . plugin_dir_url( dirname( __FILE__ ) ) . 'include/plugin-star-form.php" method="get" id="sForm">';

			$label = '<label for="starTitle">Seitentitel</label>';

			$input_text = '<input type="text" id="post-search-input" name="starTitle">';

			$input_submit = '<input type="submit" class="button action" value="save">';

			$form_end = '</form>';

			$content = $form_beginn . $label . $input_text . $input_submit . $form_end;

			return $content;
		}

		private static function saveForm($gets)
		{
			
 	global $wpdb;
 	$table_name = $wpdb->prefix . "posts";

 	$wpdb->insert(
 		$table_name,
 	$wp_data = array(
 			/*'post_date' 		=> date('Y-m-d H:i-s'),
 			'post_date_gmt' 	=> date('Y-m-d H:i-s'),*/
 			'post_content' 		=> '',
 			'post_title' 		=> $gets,
 			'comment_status' 	=> 'closed',
 			'ping_status' 		=> 'closed',
 			'post_name' 		=> $gets,
 			'post_parent'		=> 0,
 			'menu_order' 		=> 0,
 			'post_type' 		=> 'page'
 		),
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
 	);
		}
	}

}