<?php
/*
** Este es un tema hijo del tema Simone
*/

// Incluir estilos del tema principal
add_action('wp_enqueue_scripts', 'simone_child_enqueue_parent_styles');

function simone_child_enqueue_parent_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

// Sincronizar campos personalizados
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
 
function my_acf_json_save_point( $path ) {
    
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    
    
    // return
    return $path;
    
}

// Ajustes generales de la visita con ACF
if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title'     => 'Datos generales de la visita',
		'menu_title'    => 'Portada',
		'menu_slug'     => 'visita-general-settings',
		'capability'    => 'edit_posts',
		'redirect'        => false,
		'position'      => '2.1',
		'icon_url'      => 'dashicons-nametag',
		'update_button' => __('Actualizar', 'acf'),
		'updated_message' => __("Se actualizaron los datos de la visita", 'acf'),
	));
}

// Registrar bloques para ACF
add_action('acf/init', 'my_acf_init_block_types');

function my_acf_init_block_types()
{

	// Check function exists.
	if (function_exists('acf_register_block_type')) {

		// Registrar un bloque de agenda
		acf_register_block_type(array(
			'name'              => 'agenda',
			'title'             => __('Agenda de visita'),
			'description'       => __('Un bloque para agenda de visitas.'),
			'render_template'   => 'template-parts/blocks/agenda/agenda.php',
			'enqueue_style' 	  => get_stylesheet_directory_uri()  . '/template-parts/blocks/agenda/agenda.css?v=1',
			'category'          => 'formatting',
			'icon'              => 'calendar-alt',
			'keywords'          => array('agenda', 'evento'),
    ));
    
    // Registrar un bloque de agenda con dos enlaces a reuniones
		acf_register_block_type(array(
			'name'              => 'agenda-reus',
			'title'             => __('Agenda de visita con reuniones'),
			'description'       => __('Un bloque para agenda de visitas con dos enlaces.'),
			'render_template'   => 'template-parts/blocks/agenda-reus/agenda-reus.php',
			'enqueue_style' 	  => get_stylesheet_directory_uri()  . '/template-parts/blocks/agenda-reus/agenda-reus.css?v=1',
			'category'          => 'formatting',
			'icon'              => 'calendar-alt',
			'keywords'          => array('agenda', 'evento', 'zoom'),
		));

		// Register a testimonial block.
		acf_register_block_type(array(
			'name'              => 'testimonial',
			'title'             => __('Testimonio'),
			'description'       => __('Un bloque personalizado para testimonios.'),
			'render_template'   => 'template-parts/blocks/testimonial/testimonial.php',
			'enqueue_style' 	=> get_stylesheet_directory_uri()  . '/template-parts/blocks/testimonial/testimonial.css',
			'category'          => 'formatting',
			'icon'              => 'admin-comments',
			'keywords'          => array('testimonial', 'quote'),
		));

		// Register a site block
		acf_register_block_type(array(
			'name'              => 'sitios',
			'title'             => __('Galería de sitios'),
			'description'       => __('Un bloque personalizado para sitios.'),
			'render_template'   => 'template-parts/blocks/sitios/sitios.php',
			'enqueue_style' 	=> get_stylesheet_directory_uri()  . '/template-parts/blocks/sitios/sitios.css',
			'category'          => 'formatting',
			'icon'              => 'store',
			'keywords'          => array('posts', 'gallery'),
		));
	}
}

// Añadir soporte de Videos responsive
add_action( 'after_setup_theme', function() {
  add_theme_support( 'responsive-embeds' );
} );

/* 
** Migajas personalizadas 
*/
function simonechild_breadcrumbs() {
  
  $delimiter = '<span class="separator">></span>';
  $name = 'Inicio'; //text for the 'Home' link
  $currentBefore = '<li><span class="current-item">';
  $currentAfter = '</span></li>';
  
  if ( !is_home() && !is_front_page() || is_paged() ) {
  
    echo '<ul id="breadcrumbs">';
  
    global $post;
    $home = get_bloginfo('url');
    echo '<li><a href="' . $home . '">' . $name . '</a></li>' . $delimiter;
  
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter));
      echo $currentBefore . 'Archivado en categoría &#39;';
      single_cat_title();
      echo '&#39;' . $currentAfter;
  
    } elseif ( is_day() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>' . $delimiter;
      echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li>' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
  
    } elseif ( is_month() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>' . $delimiter;
      echo $currentBefore . get_the_time('F') . $currentAfter;
  
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
  
    } elseif ( is_single() && !is_attachment() ) {
      echo '<li>';
      if (has_category()) {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . '</li>' . $delimiter);
      }
      echo $currentBefore;
      the_title();
      echo $currentAfter;
      
			
  
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);

      if (has_category()) {
        $cat = get_the_category($parent->ID); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      }
      
      echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>' . $delimiter;
      echo $currentBefore;
      the_title();
      echo $currentAfter;
      
  
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
  
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter;
      echo $currentBefore;
      the_title();
      echo $currentAfter;
  
    } elseif ( is_search() ) {
      echo $currentBefore . 'Resultados para &#39;' . get_search_query() . '&#39;' . $currentAfter;
  
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Entradas etiquetadas como &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
  
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Entradas publicadas por ' . $userdata->display_name . $currentAfter;
  
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
  
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )   
      
        echo $currentBefore . ' (';
        echo __('Página') . ' ' . get_query_var('paged');

        if ( is_category() || 
        is_day() || is_month() || is_year() || 
        is_search() || is_tag() || is_author() ) 
          
          echo ')' . $currentAfter;
    }
  
    echo '</ul>';
  
  }
}

