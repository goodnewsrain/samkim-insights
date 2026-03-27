<!-- ═══ FOOTER ═══ -->
<footer class="bg-black text-white">
    <div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">
        <div class="md:col-span-2">
            <div style="font-family:'Playfair Display',serif;" class="text-3xl font-black uppercase tracking-tight mb-1">Sam Kim</div>
            <div class="text-[9px] uppercase tracking-[.3em] text-red-500 font-black mb-5">Insights</div>
            <p class="text-gray-400 text-xs leading-relaxed max-w-xs">
                Associate Executive at San Francisco Presbytery · Professional IDI Facilitator · DEI Strategist · Founder, Jump Leadership LLC
            </p>
        </div>
        <div>
            <h5 class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-4">Navigate</h5>
            <ul class="space-y-2 text-xs text-gray-300">
                <li><a href="<?php echo home_url('/'); ?>" class="hover:text-red-400 transition-colors">Home</a></li>
                <li><a href="<?php echo home_url('/#insights'); ?>" class="hover:text-red-400 transition-colors">Insights</a></li>
                <li><a href="<?php echo home_url('/#blog'); ?>" class="hover:text-red-400 transition-colors">Blog</a></li>
                <li><a href="<?php echo home_url('/#workshop'); ?>" class="hover:text-red-400 transition-colors">IDI Workshop</a></li>
                <li><a href="<?php echo home_url('/#about'); ?>" class="hover:text-red-400 transition-colors">About</a></li>
                <li><a href="<?php echo home_url('/#contact'); ?>" class="hover:text-red-400 transition-colors">Contact</a></li>
            </ul>
        </div>
        <div>
            <h5 class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-4">Categories</h5>
            <ul class="space-y-2 text-xs text-gray-300">
                <li><a href="<?php echo get_category_link( get_term_by('slug','special-report','category') ); ?>" class="hover:text-red-400 transition-colors">Special Report</a></li>
                <li><a href="<?php echo get_category_link( get_term_by('slug','spotlight','category') ); ?>" class="hover:text-red-400 transition-colors">Spotlight</a></li>
                <li><a href="<?php echo get_category_link( get_term_by('slug','case-studies','category') ); ?>" class="hover:text-red-400 transition-colors">Case Studies &amp; Insights</a></li>
                <li><a href="<?php echo get_category_link( get_term_by('slug','deep-dive','category') ); ?>" class="hover:text-red-400 transition-colors">Deep Dive Blog</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-[10px] text-gray-600 uppercase tracking-widest">© <?php echo date('Y'); ?> Sam Kim. All Rights Reserved.</p>
            <div class="flex gap-6 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                <a href="#" class="hover:text-red-400 transition-colors">LinkedIn</a>
                <a href="#" class="hover:text-red-400 transition-colors">Instagram</a>
                <a href="mailto:skim@sfpby.org" class="hover:text-red-400 transition-colors">Email</a>
            </div>
        </div>
    </div>
</footer>

<!-- ═══ LOGIN MODAL (WordPress login form styled) ═══ -->
<?php if ( ! is_user_logged_in() ) : ?>
<div class="modal-overlay" id="modal-login">
  <div class="modal-box">
    <div class="flex items-center justify-between px-8 pt-8 pb-6 border-b border-gray-100">
      <div>
        <p class="text-[9px] uppercase tracking-[.2em] text-red-600 font-black mb-1">Member Portal</p>
        <h3 style="font-family:'Playfair Display',serif;" class="text-2xl font-black">Login</h3>
      </div>
      <button onclick="closeModal('login')" class="text-gray-400 hover:text-black text-2xl leading-none">&times;</button>
    </div>
    <div class="px-8 py-7">
      <?php
      wp_login_form([
        'redirect'       => home_url(),
        'label_username' => 'Email / Username',
        'label_password' => 'Password',
        'label_remember' => 'Remember Me',
        'label_log_in'   => 'Login →',
        'remember'       => true,
      ]);
      ?>
      <div class="mt-5 pt-5 border-t border-gray-100 text-center space-y-2">
        <a href="<?php echo wp_lostpassword_url(); ?>" class="block text-[10px] text-gray-400 hover:text-red-600 font-bold uppercase tracking-widest">Forgot Password?</a>
        <a href="<?php echo wp_registration_url(); ?>" class="block text-[10px] text-gray-400 hover:text-red-600 font-bold uppercase tracking-widest">Create Account →</a>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
