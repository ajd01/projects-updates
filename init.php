<?php
/*
Plugin Name: Proyect Progress
Description: Report progress of your proyects to all your clients in the most easy way posible.
Version: 1.0
Author: ajdla
Author URI: https://github.com/ajd01
*/

function do_install() {

    global $wpdb;

	$table_ = $wpdb->prefix . "_pp_clients";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_ (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(255) CHARACTER SET utf8 NOT NULL,
			`mail` varchar(255) CHARACTER SET utf8 NOT NULL,
			`address` varchar(255) CHARACTER SET utf8 NOT NULL,
			`user` varchar(255) CHARACTER SET utf8 NOT NULL,
			`password` varchar(255) CHARACTER SET utf8 NOT NULL,
			`status` INT DEFAULT 1,
			`create` TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,			
			`last_modification` TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		  ) $charset_collate; ";

	$table_ = $wpdb->prefix . "_pp_proyect";
	$sql .= "CREATE TABLE $table_ (
		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(255) CHARACTER SET utf8 NOT NULL,
		`client_id` INT(11) NOT NULL,
		`date_start` DATETIME,
		`date_end` DATETIME,
		`city` varchar(255) CHARACTER SET utf8 NOT NULL,
		`country` varchar(255) CHARACTER SET utf8 NOT NULL,
		`status` INT DEFAULT 1,
		`create` TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
		`last_modification` TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	  ) $charset_collate; ";
	
	$table_ = $wpdb->prefix . "_pp_proyect_updates";
	$sql .= "CREATE TABLE $table_ (
		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`id_proyect` INT(11) NOT NULL,
		`note` varchar(255) CHARACTER SET utf8 NOT NULL,
		`progress` int(255) NOT NULL,
		`date` TIMESTAMP  DEFAULT CURRENT_TIMESTAMP,
		`last_modification` TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	  ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'do_install');

//menu items
add_action('admin_menu','add_menu_pp');
function add_menu_pp() {
	
	//this is the main item for the menu
	add_menu_page('Proyects', //page title
				'Proyects', //menu title
				'manage_options', //capabilities
				'proyects_progress', //menu slug
				'pp_proyects_list', //function
				'dashicons-feedback' //icon
	);
	
	//this is a submenu
	add_submenu_page('proyects_progress', //parent slug
				'Client List', //page title
				'Client List', //menu title
				'manage_options', //capability
				'client_list', //menu slug
				'client_list'); //function
	
	add_submenu_page(null, 'add_proyect', 'add_proyect', 'manage_options', 'add_proyect', 'add_proyect'); 
	add_submenu_page(null, 'add_progress', 'add_progress', 'manage_options', 'add_progress', 'add_progress'); 
	add_submenu_page(null, 'add_client', 'add_client', 'manage_options', 'add_client', 'add_client'); 
	add_submenu_page(null, 'change_client_password', 'change_client_password', 'manage_options', 'change_client_password', 'change_client_password'); 
}

define('ROOTDIR_PP', plugin_dir_path(__FILE__));

require_once(ROOTDIR_PP . 'pp-proyects-list.php');
require_once(ROOTDIR_PP . 'pp-client-list.php');
require_once(ROOTDIR_PP . 'pp-create.php');
require_once(ROOTDIR_PP . 'pp-update.php');
require_once(ROOTDIR_PP . 'pp-footer-fucntion.php');
require_once(ROOTDIR_PP . 'pp_front_end.php');