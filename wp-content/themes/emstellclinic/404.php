<?php
/**
 * The template for displaying 404 pages (not found).
 *
 */

get_header(); ?>

	<!-- Breadcrumbs -->
	<div class="modeltheme-breadcrumbs">
        <div id="overlay"></div>
	    <div class="container">
	        <div class="row">
	            <div class="col-md-12">
	                <h1 class="page-title"><?php esc_html_e('404','clinika'); ?></h1>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Page content -->
	<div id="primary" class="content-area">
	    <main id="main" class="container blog-posts site-main">
	        <div class="col-md-12 main-content">
				<section class="error-404 not-found">
					<header class="page-header-404">
						<div class="row">
							<div class="col-md-12">
								<div class="row">

									<div class="col-md-6">
										<h2 class="page-title"><img src="<?php echo esc_url(get_template_directory_uri().'/images/404.png'); ?>" alt="<?php esc_attr_e( '404 Not Found', 'clinika' ); ?>" /></h2>
										
										<p class="text-left"><?php esc_html_e( 'Sorry! The page you were looking for could not be found. Try searching for it or browse through our website.', 'clinika' ); ?></p>
										<a class="vc_button_404" href="<?php echo esc_url(get_site_url()); ?>"><?php esc_html_e( 'Back to Home', 'clinika' ); ?></a>
									</div>
									<div class="col-md-6 error-404-img">
										<img src="<?php echo esc_url(get_template_directory_uri().'/images/404-page.png'); ?>" alt="<?php esc_attr_e( '404 Not Found', 'clinika' ); ?>" />
									</div>
								</div>
							</div>
						</div>
					</header>
				</section>
			</div>
		</main>
	</div>

<?php get_footer(); ?>