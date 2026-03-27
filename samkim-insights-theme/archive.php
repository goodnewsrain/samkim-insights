<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-6 py-12">

    <!-- Archive header -->
    <div class="section-divider pt-8 mb-10">
        <p class="text-[9px] uppercase tracking-[.2em] text-red-600 font-black mb-1">
            <?php
            if ( is_category() ) echo 'Category';
            elseif ( is_tag() ) echo 'Tag';
            elseif ( is_author() ) echo 'Author';
            else echo 'Archive';
            ?>
        </p>
        <h1 style="font-family:'Playfair Display',serif;" class="text-4xl font-black mb-2">
            <?php the_archive_title(); ?>
        </h1>
        <?php if ( category_description() ) : ?>
        <p class="text-gray-500 text-sm mt-3 max-w-2xl"><?php echo category_description(); ?></p>
        <?php endif; ?>
    </div>

    <!-- Post grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
    <?php while ( have_posts() ) : the_post();
        $thumb = get_the_post_thumbnail_url( null, 'medium_large' ) ?: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=800';
        $cats  = get_the_category();
        $cat   = $cats ? $cats[0] : null;
    ?>
    <article class="card-hover cursor-pointer group bg-white border border-gray-200">
        <a href="<?php the_permalink(); ?>" class="img-zoom aspect-[4/3] block">
            <img src="<?php echo esc_url($thumb); ?>" class="w-full h-full object-cover" alt="">
        </a>
        <div class="p-5">
            <?php if ($cat) : ?>
            <a href="<?php echo get_category_link($cat->term_id); ?>"
               class="tag text-[9px] font-black uppercase text-red-600 tracking-widest"><?php echo esc_html($cat->name); ?></a>
            <?php endif; ?>
            <h2 class="text-lg font-bold leading-snug mt-2 mb-2 group-hover:text-red-700 transition-colors" style="font-family:'Playfair Display',serif;">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <p class="text-xs text-gray-500 leading-relaxed mb-4"><?php the_excerpt(); ?></p>
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-[10px] text-gray-400"><?php echo get_the_date('M j, Y'); ?></span>
                <a href="<?php the_permalink(); ?>" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:underline">Read →</a>
            </div>
        </div>
    </article>
    <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center gap-2 text-sm font-bold">
        <?php
        echo paginate_links([
            'prev_text' => '← Prev',
            'next_text' => 'Next →',
            'type'      => 'list',
        ]);
        ?>
    </div>

</main>

<?php get_footer(); ?>
