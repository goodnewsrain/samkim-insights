<?php get_header(); ?>

<main id="home" class="max-w-7xl mx-auto px-6 pt-10 pb-4">

<?php
/* ─── HERO: Latest Special Report ─── */
$hero_query = ski_get_posts( 'special-report', 1 );
if ( $hero_query->have_posts() ) :
    $hero_query->the_post();
    $thumb = get_the_post_thumbnail_url( null, 'large' ) ?: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=2070';
?>
<section class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-16">

    <!-- MAIN FEATURE -->
    <div class="lg:col-span-8">
        <a href="<?php the_permalink(); ?>" class="img-zoom aspect-[16/9] bg-gray-200 mb-6 block">
            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
        </a>
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <span class="tag bg-red-600 text-white text-[10px] font-black px-3 py-1 uppercase">Special Report</span>
                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest"><?php echo get_the_date('F j, Y'); ?></span>
            </div>
            <h1 class="text-4xl md:text-5xl leading-tight font-black hover:text-red-700 transition-colors">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h1>
            <p class="text-gray-600 text-lg leading-relaxed max-w-2xl"><?php the_excerpt(); ?></p>
            <div class="flex gap-3 pt-2">
                <a href="<?php the_permalink(); ?>" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:underline">Read Full Report →</a>
            </div>
        </div>
    </div>

    <!-- SIDEBAR: Must Read (recent posts across all categories) -->
    <aside class="lg:col-span-4 space-y-0 sticky-sidebar">
        <h3 class="text-xs font-black uppercase tracking-widest pb-3 border-b-2 border-black mb-6">Must Read</h3>
        <?php
        $must_read = new WP_Query(['posts_per_page' => 3, 'post_status' => 'publish', 'post__not_in' => [get_the_ID()]]);
        while ( $must_read->have_posts() ) : $must_read->the_post();
            $cats = get_the_category();
            $cat_name = $cats ? $cats[0]->name : '';
            $img = get_the_post_thumbnail_url( null, 'thumbnail' ) ?: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=400';
        ?>
        <div class="flex gap-4 items-start cursor-pointer group py-5 border-b border-gray-200">
            <a href="<?php the_permalink(); ?>" class="img-zoom w-24 h-20 bg-gray-200 shrink-0">
                <img src="<?php echo esc_url($img); ?>" class="w-full h-full object-cover" alt="">
            </a>
            <div>
                <span class="text-[9px] font-black uppercase tracking-widest text-red-600"><?php echo esc_html($cat_name); ?></span>
                <h4 class="font-bold text-sm leading-snug mt-1 group-hover:text-red-600 transition-colors">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
                <p class="text-xs text-gray-400 mt-1"><?php echo get_the_date('M j, Y'); ?></p>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>

        <!-- Newsletter CTA -->
        <div class="dark-box text-white p-7 mt-6">
            <p class="text-[9px] uppercase tracking-[.2em] text-red-400 font-black mb-2">Monthly Newsletter</p>
            <h4 style="font-family:'Playfair Display',serif;" class="text-xl font-bold mb-3 leading-tight">Monthly DEI<br>Insights</h4>
            <p class="text-xs text-gray-400 mb-5 leading-relaxed">Expert analysis and field reports — delivered to subscribers first.</p>
            <input type="email" placeholder="your@email.com"
                   class="w-full p-3 bg-white/10 text-white placeholder-gray-500 text-xs mb-3 border border-white/20 focus:outline-none focus:border-red-400">
            <button class="w-full bg-red-600 text-white py-3 font-black text-[10px] uppercase tracking-widest hover:bg-red-700 transition-colors">
                Subscribe Free →
            </button>
        </div>
    </aside>

</section>
<?php endif; wp_reset_postdata(); ?>

<!-- ═══ SPOTLIGHT ═══ -->
<div class="section-divider pt-8 mb-8 flex items-center justify-between">
    <h2 class="text-base font-black uppercase tracking-widest">Spotlight</h2>
    <a href="<?php echo get_category_link( get_term_by('slug','spotlight','category') ); ?>" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:underline">View All →</a>
</div>

<section class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
<?php
$spotlight = ski_get_posts( 'spotlight', 3 );
$s_idx = 0;
while ( $spotlight->have_posts() ) : $spotlight->the_post();
    $img = get_the_post_thumbnail_url( null, 'medium_large' ) ?: 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=800';
    $is_featured = ($s_idx === 1);
?>
<article class="card-hover cursor-pointer group <?php echo $is_featured ? 'bg-black text-white' : 'bg-white border border-gray-200'; ?>">
    <a href="<?php the_permalink(); ?>" class="img-zoom <?php echo $is_featured ? 'h-48' : 'aspect-[4/3]'; ?> block">
        <img src="<?php echo esc_url($img); ?>" class="w-full h-full object-cover <?php echo $is_featured ? 'opacity-50' : ''; ?>" alt="">
    </a>
    <div class="p-5">
        <?php
        $cats = get_the_category();
        $subcat = $cats && count($cats) > 1 ? $cats[1]->name : ($cats ? $cats[0]->name : '');
        ?>
        <span class="tag text-[9px] font-black uppercase tracking-widest <?php echo $is_featured ? 'text-red-400' : 'text-red-600'; ?>"><?php echo esc_html($subcat); ?></span>
        <h4 class="text-lg font-bold leading-snug mt-2 mb-2 <?php echo $is_featured ? 'group-hover:text-red-300' : 'group-hover:text-red-700'; ?> transition-colors" style="font-family:'Playfair Display',serif;">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h4>
        <p class="text-xs <?php echo $is_featured ? 'text-gray-400' : 'text-gray-500'; ?> leading-relaxed"><?php the_excerpt(); ?></p>
        <div class="mt-4 pt-4 border-t <?php echo $is_featured ? 'border-white/10' : 'border-gray-100'; ?> flex items-center justify-between">
            <span class="text-[10px] <?php echo $is_featured ? 'text-gray-500' : 'text-gray-400'; ?>"><?php echo get_the_date('M j, Y'); ?></span>
        </div>
    </div>
</article>
<?php $s_idx++; endwhile; wp_reset_postdata(); ?>
</section>

<!-- ═══ CASE STUDIES & INSIGHTS ═══ -->
<div id="insights" class="section-divider pt-8 mb-8 flex items-center justify-between">
    <h2 class="text-base font-black uppercase tracking-widest">Case Studies &amp; Insights</h2>
    <a href="<?php echo get_category_link( get_term_by('slug','case-studies','category') ); ?>" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:underline">View All →</a>
</div>

<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
<?php
$case_studies = ski_get_posts( 'case-studies', 4 );
while ( $case_studies->have_posts() ) : $case_studies->the_post();
    $img = get_the_post_thumbnail_url( null, 'medium' ) ?: 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=600';
    $cats = get_the_category();
    $subcat = $cats && count($cats) > 1 ? $cats[1]->name : ($cats ? $cats[0]->name : '');
?>
<article class="cursor-pointer group">
    <a href="<?php the_permalink(); ?>" class="img-zoom aspect-square bg-gray-200 mb-4 block">
        <img src="<?php echo esc_url($img); ?>" class="w-full h-full object-cover" alt="">
    </a>
    <span class="tag text-[9px] font-black text-red-600 uppercase tracking-widest"><?php echo esc_html($subcat); ?></span>
    <h4 class="text-sm font-bold leading-snug mt-1 group-hover:text-red-600 transition-colors" style="font-family:'Playfair Display',serif;">
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h4>
    <p class="text-xs text-gray-400 mt-1"><?php echo get_the_date('M Y'); ?></p>
</article>
<?php endwhile; wp_reset_postdata(); ?>
</section>

<!-- ═══ PULL QUOTE ═══ -->
<div class="pullquote pl-8 py-2 mb-16 max-w-3xl mx-auto">
    <blockquote style="font-family:'Playfair Display',serif;" class="text-2xl md:text-3xl font-bold italic text-gray-800 leading-snug mb-4">
        "True inclusion is not simply gathering diverse people into the same space. It demands a fundamental transformation of systems, theology, and leadership."
    </blockquote>
    <cite class="text-sm font-bold not-italic text-gray-500">— Sam Kim, Associate Executive · San Francisco Presbytery</cite>
</div>

<!-- ═══ IDI WORKSHOP ═══ -->
<section id="workshop" class="bg-white border border-gray-200 p-10 md:p-16 mb-16 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
    <div>
        <span class="tag text-[9px] font-black uppercase tracking-widest text-red-600">IDI Workshop</span>
        <h2 class="text-3xl md:text-4xl font-black mt-3 mb-5 leading-tight">
            Intercultural Development Inventory<br>
            <span class="text-red-600">Leadership Workshop</span>
        </h2>
        <p class="text-gray-600 text-sm leading-relaxed mb-6">
            The IDI (Intercultural Development Inventory) is a validated tool used by over 2 million people worldwide. As a certified IDI Qualified Administrator, Sam Kim delivers customized workshops for church leaders, nonprofits, and organizations.
        </p>
        <ul class="space-y-3 mb-8 text-sm">
            <li class="flex items-start gap-3"><span class="text-red-600 font-black mt-0.5">✓</span><span>Individual IDI assessment with 1-on-1 debrief session</span></li>
            <li class="flex items-start gap-3"><span class="text-red-600 font-black mt-0.5">✓</span><span>Team & organizational group workshops (half-day · full-day)</span></li>
            <li class="flex items-start gap-3"><span class="text-red-600 font-black mt-0.5">✓</span><span>Ongoing intercultural development planning</span></li>
        </ul>
        <div class="flex gap-4">
            <a href="#contact" class="bg-red-600 text-white px-7 py-3 font-black text-[10px] uppercase tracking-widest hover:bg-red-700 transition-colors">Book a Session</a>
            <a href="#" class="border-2 border-black text-black px-7 py-3 font-black text-[10px] uppercase tracking-widest hover:bg-black hover:text-white transition-colors">Learn More</a>
        </div>
    </div>
    <div class="relative">
        <div class="img-zoom aspect-[4/3]">
            <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&q=80&w=1000"
                 class="w-full h-full object-cover" alt="IDI Workshop">
        </div>
        <div class="absolute -bottom-4 -left-4 bg-red-600 text-white p-5">
            <div class="text-3xl font-black">2M+</div>
            <div class="text-xs uppercase tracking-widest mt-1">Global IDI Users</div>
        </div>
    </div>
</section>

<!-- ═══ DEEP DIVE BLOG ═══ -->
<div id="blog" class="section-divider pt-8 mb-8 flex items-center justify-between">
    <h2 class="text-base font-black uppercase tracking-widest">Deep Dive Blog</h2>
    <a href="<?php echo get_category_link( get_term_by('slug','deep-dive','category') ); ?>" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:underline">All Posts →</a>
</div>

<section class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-16">
<?php
$blog = ski_get_posts( 'deep-dive', 5 );
$b_idx = 0;
$first_post = null;
$rest_posts = [];
while ( $blog->have_posts() ) {
    $blog->the_post();
    if ($b_idx === 0) { $first_post = get_post(); $first_id = get_the_ID(); }
    else { $rest_posts[] = get_post(); }
    $b_idx++;
}
wp_reset_postdata();

if ( $first_post ) :
    setup_postdata($first_post);
    $img = get_the_post_thumbnail_url( $first_post->ID, 'large' ) ?: 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&q=80&w=1200';
    $cats = get_the_category($first_post->ID);
    $subcat = $cats && count($cats) > 1 ? $cats[1]->name : ($cats ? $cats[0]->name : 'Deep Dive Blog');
?>
<!-- Main Blog Post -->
<div class="lg:col-span-7">
    <article class="cursor-pointer group">
        <a href="<?php echo get_permalink($first_post->ID); ?>" class="img-zoom aspect-[16/9] mb-6 block">
            <img src="<?php echo esc_url($img); ?>" class="w-full h-full object-cover" alt="">
        </a>
        <div class="flex items-center gap-3 mb-3">
            <span class="bg-black text-white text-[9px] font-black px-3 py-1 uppercase tracking-widest">Featured</span>
            <span class="text-[9px] text-gray-400 uppercase font-bold tracking-widest"><?php echo esc_html($subcat); ?></span>
            <span class="text-[9px] text-gray-400">·</span>
            <span class="text-[9px] text-gray-400"><?php echo get_the_date('F j, Y', $first_post->ID); ?></span>
        </div>
        <h3 class="text-2xl md:text-3xl font-bold leading-tight mb-3 group-hover:text-red-700 transition-colors" style="font-family:'Playfair Display',serif;">
            <a href="<?php echo get_permalink($first_post->ID); ?>"><?php echo get_the_title($first_post->ID); ?></a>
        </h3>
        <p class="text-gray-600 text-sm leading-relaxed mb-4"><?php echo get_the_excerpt($first_post->ID); ?></p>
        <a href="<?php echo get_permalink($first_post->ID); ?>" class="text-[10px] font-black uppercase tracking-widest text-red-600 hover:underline">Read Full Article →</a>
    </article>
</div>

<!-- Blog List -->
<div class="lg:col-span-5 space-y-0">
    <h4 class="text-xs font-black uppercase tracking-widest border-b-2 border-black pb-3 mb-0">Recent Posts</h4>
    <?php foreach ($rest_posts as $rp) :
        $rimg = get_the_post_thumbnail_url( $rp->ID, 'thumbnail' ) ?: 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&q=80&w=300';
        $rcats = get_the_category($rp->ID);
        $rsubcat = $rcats && count($rcats) > 1 ? $rcats[1]->name : ($rcats ? $rcats[0]->name : '');
    ?>
    <article class="cursor-pointer group flex gap-4 py-5 border-b border-gray-200">
        <a href="<?php echo get_permalink($rp->ID); ?>" class="img-zoom w-20 h-16 shrink-0">
            <img src="<?php echo esc_url($rimg); ?>" class="w-full h-full object-cover" alt="">
        </a>
        <div>
            <span class="text-[9px] font-black text-red-600 uppercase tracking-widest"><?php echo esc_html($rsubcat); ?></span>
            <h5 class="text-sm font-bold leading-snug mt-0.5 group-hover:text-red-600 transition-colors">
                <a href="<?php echo get_permalink($rp->ID); ?>"><?php echo get_the_title($rp->ID); ?></a>
            </h5>
            <p class="text-[10px] text-gray-400 mt-1"><?php echo get_the_date('M j, Y', $rp->ID); ?></p>
        </div>
    </article>
    <?php endforeach; ?>
</div>
<?php endif; wp_reset_postdata(); ?>
</section>

<!-- ═══ ABOUT ═══ -->
<section id="about" class="bg-black text-white p-10 md:p-16 mb-16 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
    <div class="img-zoom aspect-square max-w-sm mx-auto md:mx-0">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/samkim-photo.jpg"
             onerror="this.src='https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=800'"
             class="w-full h-full object-cover" alt="Sam Kim">
    </div>
    <div>
        <span class="tag text-[9px] font-black uppercase tracking-widest text-red-400">About Sam Kim</span>
        <h2 class="text-3xl md:text-4xl font-black mt-3 mb-6 leading-tight">
            A Leader Who Drives<br>Transformation Beyond Diversity
        </h2>
        <p class="text-gray-300 text-sm leading-relaxed mb-4">
            As Associate Executive of the San Francisco Presbytery (PCUSA) and a certified IDI Qualified Administrator, Sam Kim draws on over 20 years of experience to help churches and nonprofits develop intercultural competence.
        </p>
        <p class="text-gray-300 text-sm leading-relaxed mb-6">
            As the founder of Jump Leadership LLC, he brings distinct expertise in DEI strategy, leadership coaching, and organizational change management. He is currently a doctoral candidate researching the intersection of intercultural competence and theology.
        </p>
        <div class="grid grid-cols-3 gap-6 border-t border-white/10 pt-6">
            <div><div class="text-2xl font-black text-red-400">20+</div><div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Years Experience</div></div>
            <div><div class="text-2xl font-black text-red-400">500+</div><div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Leaders Coached</div></div>
            <div><div class="text-2xl font-black text-red-400">50+</div><div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Organizations</div></div>
        </div>
    </div>
</section>

<!-- ═══ CONTACT ═══ -->
<section id="contact" class="mb-16 grid grid-cols-1 md:grid-cols-2 gap-0 border border-gray-200">
    <div class="bg-red-600 text-white p-10 md:p-16 flex flex-col justify-center">
        <span class="tag text-[9px] font-black uppercase tracking-widest text-red-200 mb-3">Get In Touch</span>
        <h2 class="text-3xl md:text-4xl font-black mb-6 leading-tight">Let's Build<br>Change Together</h2>
        <p class="text-red-100 text-sm leading-relaxed mb-8">IDI workshops, DEI consulting, speaking engagements, and writing requests are always welcome. The first consultation is free.</p>
        <div class="space-y-4 text-sm">
            <div class="flex items-center gap-3">
                <span class="text-red-200 font-bold text-xs uppercase tracking-widest w-16">Email</span>
                <a href="mailto:skim@sfpby.org" class="hover:underline">skim@sfpby.org</a>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-red-200 font-bold text-xs uppercase tracking-widest w-16">Location</span>
                <span>San Francisco Bay Area, CA</span>
            </div>
        </div>
    </div>
    <div class="bg-white p-10 md:p-16">
        <form class="space-y-5" method="post" action="">
            <?php wp_nonce_field('ski_contact', 'ski_contact_nonce'); ?>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest block mb-2">First Name</label>
                    <input type="text" name="fname" class="w-full border border-gray-300 p-3 text-sm focus:outline-none focus:border-black">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest block mb-2">Last Name</label>
                    <input type="text" name="lname" class="w-full border border-gray-300 p-3 text-sm focus:outline-none focus:border-black">
                </div>
            </div>
            <div>
                <label class="text-[10px] font-black uppercase tracking-widest block mb-2">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 p-3 text-sm focus:outline-none focus:border-black">
            </div>
            <div>
                <label class="text-[10px] font-black uppercase tracking-widest block mb-2">Subject</label>
                <select name="subject" class="w-full border border-gray-300 p-3 text-sm focus:outline-none focus:border-black bg-white">
                    <option>IDI Workshop Inquiry</option>
                    <option>DEI Consulting</option>
                    <option>Speaking Request</option>
                    <option>Other</option>
                </select>
            </div>
            <div>
                <label class="text-[10px] font-black uppercase tracking-widest block mb-2">Message</label>
                <textarea name="message" rows="4" class="w-full border border-gray-300 p-3 text-sm focus:outline-none focus:border-black resize-none"></textarea>
            </div>
            <button type="submit" class="w-full bg-black text-white py-4 font-black text-[10px] uppercase tracking-widest hover:bg-red-600 transition-colors">
                Send Message →
            </button>
        </form>
    </div>
</section>

</main>

<?php get_footer(); ?>
