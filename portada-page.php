<?php

/* Template Name: Portada de visita */

get_header(); ?>


<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php

        $escCarrera = get_field('escuela_y_carrera', 'option');
        $escuela = $escCarrera['escuela'];
        $carreraEca = $escCarrera['carrera-eca'];
        $carreraEsch = $escCarrera['carrera-ecsh'];
        $carreraEce = $escCarrera['carrera-ece'];
        $carreraEcen = $escCarrera['carrera-ecen'];
        $fechaI = get_field('fecha_inicio', 'option');
        $fechaF = get_field('fecha_final', 'option');
        $desc = get_field('desc', 'option');

        // do something with $variable
        if ($escCarrera) : ?>

            <div class="entry-header" align="center">

                <?php if ($escuela['value'] == 'eca') : ?>
                    <div class="logo-escuela">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/eca.svg" alt="<?php echo $escuela['label']; ?>">
                    </div>

                <?php elseif ($escuela['value'] == 'ecsh') : ?>
                    <div class="logo-escuela">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ecsh.svg" alt="<?php echo $escuela['label']; ?>">
                    </div>

                <?php elseif ($escuela['value'] == 'ece') : ?>
                    <div class="logo-escuela">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ece.svg" alt="<?php echo $escuela['label']; ?>">
                    </div>

                <?php elseif ($escuela['value'] == 'ecen') : ?>
                    <div class="logo-escuela">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ecen.svg" alt="<?php echo $escuela['label']; ?>">
                    </div>

                <?php endif; ?>

                <p class="label-carrera">Carrera(s):</p>

                <h1 class="entry-title carrera">
                    <?php

                    if ($escuela['value'] == 'eca') :
                        echo '<span>' . implode('</span><span>', $carreraEca) . '</span>';
                    elseif ($escuela['value'] == 'ecsh') :
                        echo '<span>' . implode('</span><span>', $carreraEsch) . '</span>';
                    elseif ($escuela['value'] == 'ece') :
                        echo '<span>' . implode('</span><span>', $carreraEce) . '</span>';
                    elseif ($escuela['value'] == 'ecen') :
                        echo '<span>' . implode('</span><span>', $carreraEcen) . '</span>';
                    endif; ?>

                </h1>

                <?php if ($fechaI && !$fechaF) : ?>
                    <p class="fechas">
                        <i class="fa fa-calendar-o"></i>
                        <date><?php echo $fechaI; ?></date>
                    </p>
                <?php elseif ($fechaI && $fechaF) : ?>
                    <p class="fechas">
                        <i class="fa fa-calendar"></i>
                        <date><?php echo $fechaI; ?></date> -
                        <date><?php echo $fechaF; ?></date>
                    </p>
                <?php endif; ?>

            <?php endif; ?>
            </div>


            <div class="entry-content">
                <?php if ($desc) : echo $desc;
                endif; ?>
            </div>

            <?php

            // Load value (array of ids).
            $image_ids = get_field('galeria', 'option', false);
            if ($image_ids) : ?>
                <div class="galeria">
                    <?php
                    $shortcode = '[gallery link="file" ids="' . implode(',', $image_ids) . '"]';
                    echo do_shortcode($shortcode); ?>
                </div>
            <?php endif; ?>

            <div class="entry-footer">
                <?php
                $creditos = get_field('creditos', 'option');
                if ($creditos) : echo $creditos;
                endif; ?>
            </div>


    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>