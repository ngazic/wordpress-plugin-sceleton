<?php
/* 
THIS FILE TRIGGERS ON PLUGIN UNINSTALL
USES FOR CLEAR DATABASE DATA    
*/

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}
 
//THERE ARE 2 WAYS FOR CLEARING DATABASE DATA get_post() or $wpdb 
//Clear database stored data
// $books = get_post( array('post_type' => 'book', 'numberposts' => -1));
// foreach($books as $book) {
// 	wp_delete_post( $book->ID, true );
// }

//acces the database via SQL
global $wpdb;
$wpdb->query("DELETE FROM ".$wpdb->prefix."posts WHERE post_type = 'book'");
$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM ".$wpdb->prefix."term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");