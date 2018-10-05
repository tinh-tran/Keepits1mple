 <?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 *
 * @package s1mpl3
 */

?> 
   <!-- Footer
   ================================================== -->
   <footer>

      <div class="row"> 

      	<div class="twelve columns">	
				<ul class="social-links">
               <li><a href="#"><i class="fa fa-facebook"></i></a></li>
               <li><a href="#"><i class="fa fa-twitter"></i></a></li>
               <li><a href="#"><i class="fa fa-google-plus"></i></a></li>               
               <li><a href="#"><i class="fa fa-github-square"></i></a></li>
               <li><a href="#"><i class="fa fa-instagram"></i></a></li>
               <li><a href="#"><i class="fa fa-flickr"></i></a></li>               
               <li><a href="#"><i class="fa fa-skype"></i></a></li>
            </ul>			
      	</div>
      	<!-- footer 1 -->
         <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-about-sidebar') ) : ?>
         <?php endif; ?>
         <!-- footer 2 -->
         <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-photo-sidebar') ) : ?>
         <?php endif; ?>
          <!-- footer 3 -->
         <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-menu-sidebar') ) : ?>
         <?php endif; ?>
         <p class="copyright">&copy; Copyright 2014 Keep It Simple. &nbsp; Design by <a title="Styleshout" href="http://www.styleshout.com/">Styleshout</a>.</p>
        
      </div> <!-- End row -->

      <div id="go-top"><a class="smoothscroll" title="Back to Top" href="#top"><i class="fa fa-chevron-up"></i></a></div>
<?php wp_footer(); ?>
   </footer> <!-- End Footer-->
</body>