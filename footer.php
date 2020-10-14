<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package simone
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<?php get_sidebar('footer'); ?>
	<div class="site-info">
		<a href="https://uned.ac.cr/" title="Sitio de la UNED">Universidad Estatal a Distancia <?php echo date('Y') ?></a>
		<span class="sep"> | </span>
		<a href="https://multimedia.uned.ac.cr/" title="Catálogo multimedia">Multimedia UNED</a>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>