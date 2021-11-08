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
$id = 'agenda-reus-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'agenda-reus';
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

	<div class="agenda-reus-header">
		<h2 class="agenda-reus-title">
			<?php echo $title; ?>
			<span class="agenda-reus-fecha"> - <?php echo $fecha; ?></span>
		</h2>

	</div>

	<?php if (have_rows('items_agenda')) : ?>
		<div class="agenda-reus-items">
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

					<?php
					$link1 = get_sub_field('enlace_1');
					$link2 = get_sub_field('enlace_2');
					?>

					<?php if ($link1 || $link2) :
						echo '<div class="evento-link">';
						if ($link1) :
							$link1_url = $link1['url'];
							$link1_title = $link1['title'] ?: 'Información';
							$link1_target = $link1['target'] ? $link1['target'] : '_self';

							echo '<a href="' . $link1_url . '" target="' . $link1_target . '" class="link1" title="Enlace a ' . $link1_title . '">' .  $link1_title . '</a>';
						endif;
						if ($link2) :
							$link2_url = $link2['url'];
							$link2_title = $link2['title'] ?: 'Información';
							$link2_target = $link2['target'] ? $link2['target'] : '_self';

							echo '<a href="' . $link2_url . '" target="' . $link2_target . '" class="link2" title="Enlace a ' . $link2_title . '">' .  $link2_title . '</a>';
						endif;
						echo '</div>';
					endif; ?>

				</div>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>

</div>