<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package s1mple
 */
?>
<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<html <?php language_attributes(); ?>>
<head>
   <!--- Basic Page Needs
   ================================================== -->
   <meta charset="utf-8">
	<title><?php bloginfo('description');?></title>
	<meta name="description" content="<?php bloginfo('description');?>">  
	<meta name="author" content="<?php bloginfo('name');?>">

	<!-- mobile specific metas
   ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

   <!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="favicon.png" >
<?php wp_head(); ?> 
</head>
<body>
 <!-- Header
   ================================================== -->
   <header id="top">

   	<div class="row">

   		<div class="header-content twelve columns">

		      <h1 id="logo-text"><a href="<?php bloginfo() ?>" title=""><?php bloginfo('name');?></a></h1>
				<p id="intro"><?php bloginfo('description');?></p>
			</div>			
	   </div>
	   <nav id="nav-wrap"> 
	   	<a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show Menu</a>
		   <a class="mobile-btn" href="#" title="Hide navigation">Hide Menu</a>
	   	<div class="row">    		            
	   			<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'nav',
						'menu_id'		 => 'nav',
					));
				?>
	   	</div> 
	   </nav> <!-- end #nav-wrap --> 	     

   </header> <!-- Header End -->


