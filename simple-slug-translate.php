<?php
/**
 * Plugin Name:     GeoSlug Translation
 * Plugin URI:      https://github.com/kvachakhia/geoslug-translate
 * Description:     ქართული სიტყვების გადათარგმნა ლათინურზე
 * Version:         1.0
 * Author:          Dimitri Kvachakhia
 * Author URI:      https://dima.ge
 * Text Domain:     geoslug
 */

	//Slug დამატება
	add_filter('wp_insert_post_data', 'AppendSlug', 3);
	function AppendSlug($data) {  
		$data['post_name']= SlugChange( $data['post_name'] );
		
		return $data; 
	}
	
	//დამუშავებული Slug-ის მიღება პოსტის დამატებისას/რედაქტირებსას
	add_action( 'wp_ajax_sample-permalink', 'AjaxPermalink',1);   
	function AjaxPermalink($data) {

        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $post_name = isset($_POST['new_slug'])? $_POST['new_slug'] : null;
        $new_title = isset($_POST['new_title'])? $_POST['new_title'] : null;
        $chosen = (isset($post_name) ? $post_name : $new_title );
		$_POST['new_slug'] = SlugChange($chosen);
		
	}
	
	//slug შენახვა
	add_filter('name_save_pre', 'FilterName'); 
	function FilterName( $post_name ) {
		 
        $post_id = isset( $_POST['post_ID'] ) ? intval( $_POST['post_ID'] ) : 0;
		$new_slug = isset( $_POST['post_title'] ) ? $_POST['post_title'] : 0;
		
		if ( $post_id ) { 
			$post_name = SlugChange( $new_slug ); 
		}
		
        return $post_name;
	}

	//კონვერტაცია
	function GeSlugConvert( $string )
	{

		$georgian = [
			'ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 
			'ჩ','ხ', 'ც', 'ძ', 'წ', 'ჭ', 'ჯ' ,'ჰ'
		];

		$english = [
			'a', 'b','g','d','e','v','z','t','i','k','l','m','n','o','p','zh','r','s','t','u','f','q','gh','k','sh',
			'ch','kh','ts','dz','ts','ch','j','h',
		];

		$string = str_replace($georgian, $english, $string);

		return $string;
	}
	function SlugChange( $string ) {

		return GeSlugConvert( $string );
	}
