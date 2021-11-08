<?php

/**
 * Agenda Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'sitios-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'sitios-container';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
	<?php if (have_rows('mu_sitios')) : ?>
		<?php while (the_repeater_field('mu_sitios')) : ?>
			<div class="item-sitio">

				<?php 
				$link = get_sub_field('mu_enlace');
				if( $link ): 
					$link_url = $link['url'];
					$link_title = $link['title'];
					$link_target = $link['target'] ? $link['target'] : '_self';
				endif; ?>

				<a href="<?= $link_url; ?>" target="<?= $link_target; ?>" title="<?= $link_title; ?>">
					<div class="portada-sitio">

						<?php
						$image = get_sub_field('mu_portada');
						$size = 'large'; // (thumbnail, medium, large, full or custom size)
						if ($image) {
							echo wp_get_attachment_image($image, $size);
						} else {
							echo '<img src="' . get_stylesheet_directory_uri()  . '/template-parts/blocks/sitios/sitio-uned.png' . '">';
						}
						?>
					</div>
				</a>

				<div class="texto-sitio">

					<h3 class="nombre-sitio">
					<a href="<?= $link_url; ?>" target="<?= $link_target; ?>" title="<?= $link_title; ?>">
							<?php the_sub_field('mu_nombre'); ?>
						</a>
					</h3>
					<p><?php echo the_sub_field('mu_info'); ?></p>
				</div>


			</div>
		<?php endwhile; ?>
	<?php endif; ?>

</div>