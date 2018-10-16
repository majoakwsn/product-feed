<?php

/* Klasa widgetu */

class product_feed_widget_rotator extends WP_widget {
    /*Konstruktor*/
	function __construct() {
		parent::__construct(
			'product_feed_widget',
			'Product Feed',
			array( 'description' => 'Plugin wyświetlający produkty z pliku XML' )
		);	
	}
    
    /*Główna funkcja widgetu*/
    
	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title' , $instance['title'] );

        echo '<div class="product-widget-body">';
        echo '<div class="product-widget-wrapper">';
        
		if ( $instance['title'] ) {
			echo '<div class="product-widget-title"><h2>' . $title . '</h2></div>';
		} else {
            echo '<span class="product-widget-no-title"></span>';
        }

        $products = product_feed_get_products_for_rotator();
        $products = array_slice($products, 0, 10 );
        
        echo '<div class="product-widget-rotator">';
        
        foreach ( $products as $product ) {
			echo '<div class="product">';
					echo '<img src="' . $product->photos->photo . '" alt="' . $product->name . '" />'; 
		echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    /*Formularz opcji widgetu*/
    
	function form( $instance){
		$defaults = array( 'title' => 'Polecane produkty:' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>	

    <!-- Tytuł widgetu -->

	<p>
		<label for="title">Tytuł</label>	
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"/>
	</p>

    
    <?php
	}
    
    /*Aktualizacja instancji widgetu*/
    
	function update( $new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title']);
		return $instance;
	}
}

/* Rejestracja widgetu */

function product_feed_load_widget_rotator() {
    register_widget( 'product_feed_widget_rotator' );
}

add_action( 'widgets_init' , 'product_feed_load_widget_rotator' );
