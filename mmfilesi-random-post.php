<?php /*
Plugin Name: mmfilesi-random-post
Plugin URI: http://www.mmfilesi.com
Description: select random post
Version: 1.0
Author: mmfilesi
Author URI: http://www.mmfilesi.com
Tested up to: 3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/ 


/* mmfilesi-random-post  */

class mmfilesi_random_post_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'mmfilesi_random_post_widget', // $id_base
			'mmfilesi random', // $name
			array( 'description' => __( 'Widget to display random post', 'mmfilesi-random-post' ), ) // $widget_options
		);		 
	}

	public function widget( $args, $instance ) {
		extract($args);
		extract($instance);
		
	
	$mmfilesi_muestra_plugin = 1;
	
	if (is_home() && $mmfilesi_comprueba_portada == false) {
	$mmfilesi_muestra_plugin = 0;
	}
	
	
	if ((is_home() || is_single()) && $mmfilesi_muestra_plugin == 1 ) {
	
	echo $before_widget.$before_title;
	echo $mmfilesi_random_titulo;
	echo $after_title;
	
	
	switch ($mmfilesi_orden_post) {
    case 1:
        $mmfilesi_orden_post="&orderby=rand";
        break;
    case 2:
        $mmfilesi_orden_post="&order=ASC";
        break;
    case 3:
        $mmfilesi_orden_post="&order=DESC";
        break;
	}

	?><nav id="post_aleatorios_contenedor"><?php
	
	$categorias = get_the_category();
	foreach($categorias as $categoria) {
	$id_categoria = $categoria->cat_ID;
	$nombre_categoria = $categoria->cat_name;
	$enlace_categoria = get_category_link($categoria->term_id);
	$categoria = '&cat='.$id_categoria;
	
	?><h5><a href="<?php echo $enlace_categoria ?>"><?php echo $nombre_categoria ?></a></h5>

	<?php $contador_ids=0;			
	$query_post = new WP_Query('post_status=publish'.$mmfilesi_orden_post.$categoria.'&posts_per_page='.$mmfilesi_numero_de_post_aleatorios);
	if ( have_posts() ) : while ($query_post->have_posts() ) : $query_post->the_post();
	$titulo = get_the_title();
	$enlace = get_permalink(); 
	$sumario = get_the_excerpt();
	?>	
	
	<div class="fila_aleatorios" id="fila_invisible<?php echo $contador_ids ?>">
	
	<!-- picture / imágenes -->	
	<?php if ($mmfilesi_comprueba_imagen == true) { ?>	
	<div class="post_aleatorios_col_izda">	
	<a href="<?php echo $enlace ?>" rel="nofollow">
		<?php if (has_post_thumbnail()) :		
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id); ?>
		<img src="<?php echo $image_url[0]; ?>" class="post_aleatorios_imagen">
		<?php else : ?>
		<img src="<?php echo plugins_url(); ?>/mmfilesi-random-post/img/picture_default.png" class="post_aleatorios_imagen" />
		<?php endif; ?>	
	</a>		
	</div> <!-- #post_aleatorios_col_izda -->
	<?php } ?>
	<!-- #picture / imágenes -->
	
	<?php if ($mmfilesi_comprueba_imagen == true) { ?>	
	<div class="post_aleatorios_titulo">
	<?php } else { ?>
	<div class="post_aleatorios_titulo_sin_imagenes">
	<?php } ?>
	<a href="<?php echo $enlace ?>" rel="nofollow"><?php echo $titulo ?> </a>
	</div> <!-- #post_aleatorios_col_izda -->
	
	<div class="post_aleatorios_sumario" id="fila_invisible<?php echo $contador_ids ?>_op">
	<?php echo $sumario; ?>
	<a href="<?php echo $enlace ?>" rel="nofollow"> + </a>	
	</div> <!-- #post_aleatorios_sumario -->
	
	</div> <!-- #fila_aleatorios -->
	<?php
	$contador_ids++;
	endwhile; 
	endif;
	wp_reset_query(); 
	?>
	
	

<?php 

} // cierra el foreach 

?></nav> <?php 
	
	// Lo que va después del widget. 

	echo $after_widget; 
} // cierra el if inicial
	
} // cierra la función

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['mmfilesi_random_titulo'] = strip_tags( $new_instance['mmfilesi_random_titulo'] );
		$instance['mmfilesi_numero_de_post_aleatorios'] = strip_tags( $new_instance['mmfilesi_numero_de_post_aleatorios'] );
		$instance['mmfilesi_comprueba_portada'] = strip_tags( $new_instance['mmfilesi_comprueba_portada'] );
		$instance['mmfilesi_comprueba_imagen'] = strip_tags( $new_instance['mmfilesi_comprueba_imagen'] );	
		$instance['mmfilesi_orden_post'] = strip_tags( $new_instance['mmfilesi_orden_post'] );		
		return $instance;
	}


	public function form( $instance ) {
	
	// inicializamos un valor x default si no existen
	
		if ( isset( $instance[ 'mmfilesi_random_titulo' ] ) ) {
			$mmfilesi_random_titulo = $instance[ 'mmfilesi_random_titulo' ];
		}
		else {
			$mmfilesi_random_titulo = __( 'Random post', 'mmfilesi-random-post' );
		}
		
		if ( isset( $instance[ 'mmfilesi_numero_de_post_aleatorios' ] ) ) {
			$mmfilesi_numero_de_post_aleatorios = $instance[ 'mmfilesi_numero_de_post_aleatorios' ];
		}
		else {
			$mmfilesi_numero_de_post_aleatorios = 1;
		}
		if ( isset( $instance[ 'mmfilesi_comprueba_imagen' ] ) ) {
			$mmfilesi_comprueba_imagen = $instance[ 'mmfilesi_comprueba_imagen' ];
		}
		else {
			$mmfilesi_comprueba_imagen = 1;
		}
		
		if ( isset( $instance[ 'mmfilesi_comprueba_portada' ] ) ) {
			$mmfilesi_comprueba_portada = $instance[ 'mmfilesi_comprueba_portada' ];
		}
		else {
			$mmfilesi_comprueba_portada = 1;
		}
		
		if ( isset( $instance[ 'mmfilesi_orden_post' ] ) ) {
			$mmfilesi_orden_post = $instance[ 'mmfilesi_orden_post' ];
		}
		else {
			$mmfilesi_orden_post = '1';
		}
		?>
		
		
		
		<p>
		<label for="<?php echo $this->get_field_id( 'mmfilesi_random_titulo' ); ?>"><?php _e('Title:', 'mmfilesi-random-post'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'mmfilesi_random_titulo' ); ?>" name="<?php echo $this->get_field_name( 'mmfilesi_random_titulo' ); ?>" type="text" value="<?php echo esc_attr( $mmfilesi_random_titulo ); ?>" placeholder="<?php _e('e.g. Random post...', 'mmfilesi-random-post') ?>"/>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'mmfilesi_numero_de_post_aleatorios' ); ?>"><?php _e('Number of post (-1 for all post):', 'mmfilesi-random-post'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'mmfilesi_numero_de_post_aleatorios' ); ?>" name="<?php echo $this->get_field_name('mmfilesi_numero_de_post_aleatorios'); ?>" type="text" value="<?php echo esc_attr( $mmfilesi_numero_de_post_aleatorios ); ?>" placeholder="<?php _e('e.g. 3', 'mmfilesi-random-post') ?>" size="3"/>
		</p>		
		
		
		<p>
		<label for="<?php echo $this->get_field_id( 'mmfilesi_orden_post' ); ?>"><b><?php _e('Order by...', 'mmfilesi-random-post'); ?><br /></b></label> 
		<input type="radio" name="<?php echo $this->get_field_name( 'mmfilesi_orden_post' ); ?>" value="1" <?php  if ($mmfilesi_orden_post == 1) { echo "checked"; } ?> />  <?php  _e('Random', 'mmfilesi-random-post'); ?><br />
		<input type="radio" name="<?php echo $this->get_field_name( 'mmfilesi_orden_post' ); ?>" value="2" <?php  if ($mmfilesi_orden_post == 2) { echo "checked"; } ?> />  <?php  _e('more older first', 'mmfilesi-random-post'); ?><br />
		<input type="radio" name="<?php echo $this->get_field_name( 'mmfilesi_orden_post' ); ?>" value="3" <?php  if ($mmfilesi_orden_post == 3) { echo "checked"; } ?> />  <?php  _e('more recent first', 'mmfilesi-random-post'); ?><br />
		</p>
		
		<p>
        <input id="<?php echo $this->get_field_id('mmfilesi_comprueba_imagen'); ?>" name="<?php echo $this->get_field_name('mmfilesi_comprueba_imagen'); ?>" type="checkbox" value="1" <?php checked( '1', $mmfilesi_comprueba_imagen ); ?>/>
        <label for="<?php echo $this->get_field_id('mmfilesi_comprueba_imagen'); ?>"><?php  _e('Thumbnails', 'mmfilesi-random-post'); ?></label>
		</p>
				
		<p>
        <input id="<?php echo $this->get_field_id('mmfilesi_comprueba_portada'); ?>" name="<?php echo $this->get_field_name('mmfilesi_comprueba_portada'); ?>" type="checkbox" value="1" <?php checked( '1', $mmfilesi_comprueba_portada ); ?>/>
        <label for="<?php echo $this->get_field_id('mmfilesi_comprueba_portada'); ?>"><?php  _e('In home', 'mmfilesi-random-post'); ?></label>
		</p>
	<?php 
	}

} // class mmfilesi_random_post_widget

// cargamos las css

  function load_mmfilesi_random_style() {        
        wp_register_style( 'mmfilesi-random-post-style', plugins_url('mmfilesi-random-post-style.css', __FILE__) );
        wp_enqueue_style( 'mmfilesi-random-post-style' );
	}

    add_action( 'wp_enqueue_scripts', 'load_mmfilesi_random_style' );
 
// Cargamos jQuery y las funciones .js

function mmf_random_post() {
	wp_enqueue_script( 'jquery' ); // carga jquery con el tema
	wp_enqueue_script( 'mmf_random_post', plugins_url('js/mmf_random_post.js', __FILE__));	
}    
add_action('wp_enqueue_scripts', 'mmf_random_post'); 

// Cargamos la traducción automática


/* function mmf_random_post_translation() {
  load_plugin_textdomain( 'mmfilesi-random-post', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}
add_action('plugins_loaded', 'mmf_random_post_translation'); */

/* function init() {
	if ( !defined('WP_PLUGIN_DIR') ) {
		load_plugin_textdomain('mmfilesi-random-post', str_replace( ABSPATH, '', dirname(__FILE__)));
	} else {
		load_plugin_textdomain('mmfilesi-random-post', false, dirname(plugin_basename(__FILE__)));
	}
}
 */
 
 function traduccion_mmfilesi_random() {
load_plugin_textdomain('mmfilesi-random-post', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action('init', 'traduccion_mmfilesi_random');

// lo rgistramos

function widget_register_mmfilesi_random_post() {
    register_widget('mmfilesi_random_post_widget'); // ID
}
add_action('widgets_init', 'widget_register_mmfilesi_random_post');

?>