<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="toast"></div>

<!-- ═══ TOP BAR ═══ -->
<div class="bg-black text-white text-[10px] uppercase tracking-widest py-1.5 px-6 flex justify-between items-center">
    <span class="hidden md:block">Associate Executive · San Francisco Presbytery</span>
    <span><?php echo date_i18n('l, F j, Y'); ?></span>
    <div class="hidden md:flex items-center gap-4">
        <a href="#" class="hover:text-red-400 transition-colors">LinkedIn</a>
        <span class="opacity-30">|</span>
        <a href="#" class="hover:text-red-400 transition-colors">Instagram</a>
        <span class="opacity-30">|</span>
        <a href="mailto:skim@sfpby.org" class="hover:text-red-400 transition-colors">Contact</a>
    </div>
</div>

<!-- ═══ NAVBAR ═══ -->
<nav class="bg-white border-b-2 border-black sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="<?php echo home_url('/'); ?>" class="flex flex-col leading-none">
            <span style="font-family:'Playfair Display',serif;" class="text-3xl font-black tracking-tight uppercase">Sam Kim</span>
            <span class="text-[10px] uppercase tracking-[.3em] text-red-600 font-bold mt-0.5">Insights</span>
        </a>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-8 text-[11px] font-bold uppercase tracking-widest">
            <a href="<?php echo home_url('/'); ?>" class="nav-link hover:text-red-600 transition-colors">Home</a>
            <a href="<?php echo home_url('/#insights'); ?>" class="nav-link hover:text-red-600 transition-colors">Insights</a>
            <a href="<?php echo home_url('/#blog'); ?>" class="nav-link hover:text-red-600 transition-colors">Blog</a>
            <a href="<?php echo home_url('/#workshop'); ?>" class="nav-link hover:text-red-600 transition-colors">IDI Workshop</a>
            <div class="nav-dropdown">
                <a href="<?php echo home_url('/#about'); ?>" class="nav-link hover:text-red-600 transition-colors cursor-pointer">
                    About <span class="nav-arrow">▼</span>
                </a>
                <div class="nav-dropdown-menu">
                    <a href="<?php echo home_url('/#about'); ?>" class="nav-dropdown-item">About</a>
                    <a href="<?php echo home_url('/menu-1/'); ?>" class="nav-dropdown-item">Menu 1</a>
                    <a href="<?php echo home_url('/menu-2/'); ?>" class="nav-dropdown-item">Menu 2</a>
                </div>
            </div>
            <a href="<?php echo home_url('/#contact'); ?>" class="bg-red-600 text-white px-5 py-2.5 hover:bg-red-700 transition-colors">Contact</a>

            <!-- Guest buttons -->
            <?php if ( ! is_user_logged_in() ) : ?>
            <div id="auth-guest" class="flex items-center gap-2">
                <button onclick="openModal('login')" class="text-[11px] font-bold uppercase tracking-widest px-4 py-2 border-2 border-black hover:bg-black hover:text-white transition-colors">Login</button>
                <a href="<?php echo wp_registration_url(); ?>" class="text-[11px] font-bold uppercase tracking-widest px-4 py-2 bg-black text-white hover:bg-red-600 transition-colors">Sign Up</a>
            </div>
            <?php else :
                $user = wp_get_current_user();
                $initials = strtoupper( substr($user->display_name, 0, 1) );
            ?>
            <div id="auth-user" class="relative">
                <div class="user-avatar" onclick="toggleDropdown()"><?php echo esc_html($initials); ?></div>
                <div class="dropdown-menu" id="user-dropdown">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="text-[10px] font-black uppercase tracking-widest text-gray-400">Signed In</div>
                        <div class="text-sm font-bold mt-0.5 truncate"><?php echo esc_html($user->display_name); ?></div>
                    </div>
                    <?php if ( current_user_can('administrator') ) : ?>
                    <a class="dropdown-item" href="<?php echo admin_url(); ?>">Dashboard</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="<?php echo wp_logout_url( home_url() ); ?>">Sign Out</a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Mobile hamburger -->
        <button id="hamburger" class="md:hidden flex flex-col gap-1.5 p-2" onclick="toggleMenu()">
            <span class="w-6 h-0.5 bg-black block"></span>
            <span class="w-6 h-0.5 bg-black block"></span>
            <span class="w-6 h-0.5 bg-black block"></span>
        </button>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="flex-col bg-white border-t border-gray-200 px-6 py-4 space-y-4 text-sm font-bold uppercase tracking-widest">
        <a href="<?php echo home_url('/'); ?>" onclick="toggleMenu()" class="block hover:text-red-600">Home</a>
        <a href="<?php echo home_url('/#insights'); ?>" onclick="toggleMenu()" class="block hover:text-red-600">Insights</a>
        <a href="<?php echo home_url('/#blog'); ?>" onclick="toggleMenu()" class="block hover:text-red-600">Blog</a>
        <a href="<?php echo home_url('/#workshop'); ?>" onclick="toggleMenu()" class="block hover:text-red-600">IDI Workshop</a>
        <a href="<?php echo home_url('/#about'); ?>" onclick="toggleMenu()" class="block hover:text-red-600">About</a>
        <a href="<?php echo home_url('/menu-1/'); ?>" onclick="toggleMenu()" class="block hover:text-red-600 pl-4 text-gray-500">└ Menu 1</a>
        <a href="<?php echo home_url('/menu-2/'); ?>" onclick="toggleMenu()" class="block hover:text-red-600 pl-4 text-gray-500">└ Menu 2</a>
        <a href="<?php echo home_url('/#contact'); ?>" onclick="toggleMenu()" class="block text-red-600">Contact</a>
        <?php if ( ! is_user_logged_in() ) : ?>
        <button onclick="openModal('login')" class="block text-left hover:text-red-600">Login</button>
        <a href="<?php echo wp_registration_url(); ?>" class="block hover:text-red-600">Sign Up</a>
        <?php else : ?>
        <a href="<?php echo wp_logout_url( home_url() ); ?>" class="block text-red-600">Sign Out</a>
        <?php endif; ?>
    </div>
</nav>

<!-- ═══ TICKER ═══ -->
<div class="bg-white border-b border-gray-300 py-2 flex items-center">
    <span class="bg-red-600 text-white px-4 py-1 text-[10px] font-black uppercase tracking-widest shrink-0 ml-4 mr-4">Breaking</span>
    <div class="ticker-wrap flex-1">
        <div class="ticker-inner text-xs font-semibold text-gray-700 tracking-tight">
            SF Presbytery Racial Demographics Report Coming Soon &nbsp;&nbsp;•&nbsp;&nbsp; IDI Leadership Workshop — April Sessions Now Open &nbsp;&nbsp;•&nbsp;&nbsp; New Article: Church Innovation Through a DEI Lens &nbsp;&nbsp;•&nbsp;&nbsp; 2027 Italy–Switzerland Global Mission Trip Announced &nbsp;&nbsp;•&nbsp;&nbsp; New PCUSA Multiracial Church Case Study Published &nbsp;&nbsp;•&nbsp;&nbsp; Jump Leadership LLC Launches New Consulting Program &nbsp;&nbsp;•&nbsp;&nbsp; SF Presbytery Racial Demographics Report Coming Soon &nbsp;&nbsp;•&nbsp;&nbsp; IDI Leadership Workshop — April Sessions Now Open &nbsp;&nbsp;•&nbsp;&nbsp; New Article: Church Innovation Through a DEI Lens &nbsp;&nbsp;•&nbsp;&nbsp; 2027 Italy–Switzerland Global Mission Trip Announced &nbsp;&nbsp;•&nbsp;&nbsp; New PCUSA Multiracial Church Case Study Published &nbsp;&nbsp;•&nbsp;&nbsp; Jump Leadership LLC Launches New Consulting Program
        </div>
    </div>
</div>

<!-- ═══ CATEGORY BAR ═══ -->
<div class="bg-white cat-bar">
    <div class="max-w-7xl mx-auto px-6 flex gap-8 overflow-x-auto text-[11px] font-black uppercase tracking-widest">
        <a href="<?php echo home_url('/'); ?>" class="cat-item whitespace-nowrap text-decoration-none">All</a>
        <a href="<?php echo get_category_link( get_term_by('slug','special-report','category') ); ?>" class="cat-item whitespace-nowrap">Special Report</a>
        <a href="<?php echo get_category_link( get_term_by('slug','spotlight','category') ); ?>" class="cat-item whitespace-nowrap">Spotlight</a>
        <a href="<?php echo get_category_link( get_term_by('slug','case-studies','category') ); ?>" class="cat-item whitespace-nowrap">Case Studies &amp; Insights</a>
        <a href="<?php echo get_category_link( get_term_by('slug','deep-dive','category') ); ?>" class="cat-item whitespace-nowrap">Deep Dive Blog</a>
    </div>
</div>
