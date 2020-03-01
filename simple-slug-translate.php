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
		$new_slug = isset( $_POST['post_name'] ) ? $_POST['post_name'] : 0;
		
		if ( $post_id ) { 
			$post_name = SlugChange( $new_slug ); 
		}
		
        return $post_name;
	}

	//კონვერტაცია
	function GeSlugConvert( $string )
	{
		$string = str_replace('ა', 'a', $string);
		$string = str_replace('ბ', 'b',$string);
		$string = str_replace('გ', 'g',$string);
		$string = str_replace('დ', 'd',$string);
		$string = str_replace('ე', 'e',$string);
		$string = str_replace('ვ', 'v',$string);
		$string = str_replace('ზ', 'z',$string);
		$string = str_replace('თ', 't',$string);
		$string = str_replace('ი', 'i',$string);
		$string = str_replace('კ', 'k',$string);
		$string = str_replace('ლ', 'l',$string);
		$string = str_replace('მ', 'm',$string);
		$string = str_replace('ნ', 'n',$string);
		$string = str_replace('ო', 'o',$string);
		$string = str_replace('პ', 'p',$string);
		$string = str_replace('ჟ', 'zh',$string);
		$string = str_replace('რ', 'r',$string);
		$string = str_replace('ს', 's',$string);
		$string = str_replace('ტ', 't',$string);
		$string = str_replace('უ', 'u',$string);
		$string = str_replace('ფ', 'f',$string);
		$string = str_replace('ქ', 'q',$string);
		$string = str_replace('ღ', 'gh',$string);
		$string = str_replace('ყ', 'k',$string);
		$string = str_replace('შ', 'sh',$string);
		$string = str_replace('ჩ', 'ch',$string);
		$string = str_replace('ც', 'ts',$string);
		$string = str_replace('ძ', 'dz',$string);
		$string = str_replace('წ', 'ts',$string);
		$string = str_replace('ჭ', 'ch',$string);
		$string = str_replace('ჯ' ,'j',$string);
		$string = str_replace('ჰ' ,'h',$string);

		return $string;
	}
	function SlugChange( $string ) {

		return GeSlugConvert( $string );
	}
