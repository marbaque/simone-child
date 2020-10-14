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
$id = 'agenda-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'agenda';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('titulo_agenda') ?: 'Título de la agenda';
$fecha = get_field('fecha_agenda') ?: 'Fecha';
$agendaItems = get_field('items_agenda') ?: 'Aquí van los ítems de la agenda';

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

	<div class="agenda-header">
		<h2 class="agenda-title">
			<?php echo $title; ?>
			<span class="agenda-fecha"> - <?php echo $fecha; ?></span>
		</h2>

	</div>

	<?php if (have_rows('items_agenda')) : ?>
		<div class="agenda-items">
			<?php while (the_repeater_field('items_agenda')) : ?>
				<div class="evento">
					<div class="evento-time">
						<time><?php the_sub_field('hora1_evento'); ?></time> -
						<time><?php the_sub_field('hora2_evento'); ?></time>
					</div>

					<div class="evento-info">
						<span class="evento-title"><?php the_sub_field('item_evento'); ?></span>
						<span class="evento-desc"><?php the_sub_field('info_evento'); ?></span>
					</div>

					<?php if (get_sub_field('pagina_evento')) : ?>
						<div class="evento-link">
							<a href="<?php echo get_sub_field('pagina_evento')['url']; ?>" title="Más información del evento">
								<?php echo get_sub_field('pagina_evento')['title']; ?></a>
						</div>
					<?php endif; ?>

				</div>

			<?php endwhile; ?>
		</div>

	<?php endif; ?>

</div>