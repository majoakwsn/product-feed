<?php

/* Podpina style */

function product_feed_load_styles() {
 	wp_enqueue_style( 'product-style' ,  plugins_url( '/product_feed/addons/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'product_feed_load_styles' );

/* Podpina skrypty */

function product_feed_load_scripts() {
	wp_enqueue_script( 'product-showoff' , plugins_url( '/product_feed/addons/jquery.jshowoff.js' ), array('jquery') );
    wp_enqueue_script( 'product-custom' , plugins_url( '/product_feed/addons/product_custom.js' ), array('jquery') );
}
add_action( 'wp_enqueue_scripts' , 'product_feed_load_scripts' );


/* Pobiera dane z XML */

function product_feed_get_feed() {	
	$feed_url = plugins_url('/product_feed/feed.xml' );
	$cu = curl_init($feed_url);
	curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
	$xml = curl_exec($cu);
	curl_close($cu);
	$xml = simplexml_load_string($xml);
	return $xml;
}

/* Zwraca wszystkie produkty */

function product_feed_get_all_products() {
	$products = product_feed_get_feed()->products->children();
	return $products;
}

/* Generuje produkty dla rotatora */

function product_feed_get_products_for_rotator() {
	$products = product_feed_get_all_products();
	$rotator_products = array();
	foreach ( $products as $product ) {
		$rotator_products[] = $product;
	}
	shuffle( $rotator_products );
	return $rotator_products;
}