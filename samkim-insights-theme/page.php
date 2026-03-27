<?php get_header(); ?>

<main class="max-w-4xl mx-auto px-6 py-12">
    <?php while ( have_posts() ) : the_post(); ?>
    <article>
        <h1 style="font-family:'Playfair Display',serif;"
            class="text-4xl font-black mb-8 pb-6 border-b-2 border-black">
            <?php the_title(); ?>
        </h1>
        <div class="post-content">
            <?php the_content(); ?>
        </div>
    </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
