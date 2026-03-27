<?php get_header(); ?>

<?php while ( have_posts() ) : the_post();
    $thumb = get_the_post_thumbnail_url( null, 'large' );
    $cats  = get_the_category();
    $cat   = $cats ? $cats[0] : null;
?>

<main class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

        <!-- Article -->
        <article class="lg:col-span-8">

            <!-- Category + Date -->
            <div class="flex items-center gap-3 mb-5">
                <?php if ($cat) : ?>
                <a href="<?php echo get_category_link($cat->term_id); ?>"
                   class="tag bg-red-600 text-white text-[10px] font-black px-3 py-1 uppercase">
                   <?php echo esc_html($cat->name); ?>
                </a>
                <?php endif; ?>
                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest"><?php echo get_the_date('F j, Y'); ?></span>
            </div>

            <!-- Title -->
            <h1 style="font-family:'Playfair Display',serif;"
                class="text-4xl md:text-5xl font-black leading-tight mb-6">
                <?php the_title(); ?>
            </h1>

            <!-- Author -->
            <div class="flex items-center gap-4 pb-6 mb-8 border-b-2 border-black">
                <div class="user-avatar text-sm"><?php echo strtoupper(substr(get_the_author(), 0, 1)); ?></div>
                <div>
                    <div class="text-sm font-bold"><?php the_author(); ?></div>
                    <div class="text-xs text-gray-400"><?php echo get_the_date('F j, Y'); ?></div>
                </div>
            </div>

            <!-- Featured image -->
            <?php if ($thumb) : ?>
            <div class="img-zoom aspect-[16/9] mb-10">
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
            </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <!-- Tags -->
            <?php the_tags('<div class="mt-10 pt-6 border-t border-gray-200 flex flex-wrap gap-2">', '', '</div>'); ?>

            <!-- Back link -->
            <div class="mt-10">
                <a href="<?php echo home_url('/'); ?>" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:underline">← Back to Home</a>
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 sticky-sidebar">
            <h3 class="text-xs font-black uppercase tracking-widest pb-3 border-b-2 border-black mb-6">More Articles</h3>
            <?php
            $related = new WP_Query([
                'posts_per_page' => 4,
                'post__not_in'   => [get_the_ID()],
                'category__in'   => wp_get_post_categories(get_the_ID()),
                'post_status'    => 'publish',
                'orderby'        => 'date',
            ]);
            while ($related->have_posts()) : $related->the_post();
                $rimg = get_the_post_thumbnail_url(null, 'thumbnail') ?: '';
                $rcats = get_the_category();
                $rcat = $rcats ? $rcats[0]->name : '';
            ?>
            <div class="flex gap-4 items-start py-5 border-b border-gray-200 group">
                <?php if ($rimg) : ?>
                <a href="<?php the_permalink(); ?>" class="img-zoom w-20 h-16 shrink-0">
                    <img src="<?php echo esc_url($rimg); ?>" class="w-full h-full object-cover" alt="">
                </a>
                <?php endif; ?>
                <div>
                    <span class="text-[9px] font-black uppercase tracking-widest text-red-600"><?php echo esc_html($rcat); ?></span>
                    <h5 class="text-sm font-bold leading-snug mt-1 group-hover:text-red-600 transition-colors">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h5>
                    <p class="text-xs text-gray-400 mt-1"><?php echo get_the_date('M j, Y'); ?></p>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>

            <!-- Newsletter -->
            <div class="dark-box text-white p-7 mt-6">
                <p class="text-[9px] uppercase tracking-[.2em] text-red-400 font-black mb-2">Newsletter</p>
                <h4 style="font-family:'Playfair Display',serif;" class="text-lg font-bold mb-3">Monthly DEI Insights</h4>
                <input type="email" placeholder="your@email.com"
                       class="w-full p-3 bg-white/10 text-white placeholder-gray-500 text-xs mb-3 border border-white/20 focus:outline-none focus:border-red-400">
                <button class="w-full bg-red-600 text-white py-3 font-black text-[10px] uppercase tracking-widest hover:bg-red-700">Subscribe →</button>
            </div>
        </aside>

    </div>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
