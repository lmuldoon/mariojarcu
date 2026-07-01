<?php

/**
 * The template for displaying the footer.
 */

?>
<?php get_template_part( 'template-parts/wrapper/end' ); ?>

<footer class="site-footer">
    <div class="container container--wide">

        <div class="site-footer__inner animated">

            <!-- Brand -->
            <div class="site-footer__brand">
                <a class="site-footer__logo" href="<?php echo esc_url( home_url() ); ?>" aria-label="Mario Jarcu Salon Concept">
                    <?php include_asset('images/logos/logo-lockup-dark.svg'); ?>
                </a>
                <p class="site-footer__tagline">A gentleman's salon in the heart of Rugby. Precision cuts, hot towel shaves, and the hour you deserve.</p>
            </div>

            <!-- Site nav -->
            <div class="site-footer__col">
                <span class="site-footer__col-label">Site</span>
                <?php wp_nav_menu( [
                    'theme_location' => 'header-menu',
                    'container'      => false,
                    'menu_class'     => 'site-footer__links',
                    'fallback_cb'    => false,
                ] ); ?>
            </div>

            <!-- Visit -->
            <div class="site-footer__col">
                <span class="site-footer__col-label">Visit</span>
                <address class="site-footer__address">
                    <p>1 Craven Road</p>
                    <p>Rugby</p>
                    <p>CV21 3JX</p>
                </address>
            </div>

            <!-- Follow -->
            <div class="site-footer__col">
                <span class="site-footer__col-label">Follow</span>
                <ul class="site-footer__links">
                    <li><a class="site-footer__link" href="https://mariojarcusalonconcept.booksy.com/a/" target="_blank" rel="noopener noreferrer">Booksy</a></li>
                    <li><a class="site-footer__link" href="https://www.facebook.com/MarioJarcuSalonConcept" target="_blank" rel="noopener noreferrer">Facebook</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom bar -->
        <div class="site-footer__bottom animated">
            <p class="site-footer__copy">&copy; <?php
$year = (int) date('Y');
$romans = [1000=>'M',900=>'CM',500=>'D',400=>'CD',100=>'C',90=>'XC',50=>'L',40=>'XL',10=>'X',9=>'IX',5=>'V',4=>'IV',1=>'I'];
$result = '';
foreach ($romans as $value => $numeral) {
    while ($year >= $value) { $result .= $numeral; $year -= $value; }
}
echo $result;
?> Mario Jarcu Salon Concept &nbsp;&middot;&nbsp; Rugby &nbsp;&middot;&nbsp; Warwickshire &nbsp;&middot;&nbsp; United Kingdom</p>
            <div class="site-footer__bottom-links">
                <a class="site-footer__policy" href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a>
                <a class="site-footer__policy" href="https://lukemuldoon.co.uk/" target="_blank" rel="noopener noreferrer">Site by Luke Muldoon</a>
            </div>
        </div>

    </div>
</footer><!-- /.site-footer -->

<?php wp_footer(); ?>
</body>
</html>
