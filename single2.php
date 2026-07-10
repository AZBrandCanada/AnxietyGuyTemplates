<?php
/**
 * Alternative Template: "Midnight Ocean & Sand"
 * A high-end editorial and split-layout theme designed to establish deep authority, 
 * calmness, and visual sophistication.
 *
 * @package Podcaster
 * @since 1.0
 */

/* Loads the header.php template */
get_header();

$thst_wp_version   = get_bloginfo( 'version' );
$pod_plugin_active = pod_get_plugin_active();
$format            = get_post_format();

if ( 'ssp' === $pod_plugin_active ) {
	$format = pod_ssp_get_format( $post->ID );
}

$thump_cap            = pod_the_post_thumbnail_caption();
$featured_post_header = get_post_meta( $post->ID, 'cmb_thst_feature_post_img', true );
$image                = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
$header_img           = ! empty( $image[0] ) ? $image[0] : '';
$posttype             = get_post_type();

$pod_blog_layout                  = pod_theme_option( 'pod-blog-layout', 'sidebar-right' );
$gallerystyle_global              = pod_theme_option( 'pod-pofo-gallery', 'slideshow_on' );
$pod_sticky_header                = pod_theme_option( 'pod-sticky-header', false );
$pod_single_header_display        = pod_theme_option( 'pod-single-header-display', 'has-thumbnail' );
$pod_single_header_thumb_embed    = pod_theme_option( 'pod-single-header-thumbnail-audio-embed', true );
$pod_single_header_thumb_playlist = pod_theme_option( 'pod-single-header-thumbnail-audio-playlist', true );
$pod_header_thumb_size            = pod_theme_option( 'pod-single-header-thumbnail-size', 'thumb-size-small' );
$pod_header_thumb_radius          = pod_theme_option( 'pod-single-header-thumbnail-radius', 'straight-corners' );
$pod_single_header_par            = pod_theme_option( 'pod-single-header-par', false );
$pod_single_header_bgstyle        = pod_theme_option( 'pod-single-bg-style', 'background-repeat:repeat;' );
$pod_header_par                   = pod_theme_option( 'pod-single-header-par', false );
$pod_single_video_bg              = pod_theme_option( 'pod-single-video-bg', false );
$pod_players_preload              = pod_theme_option( 'pod-players-preload', 'none' );

/* Player position */
$pod_single_audio_player_position = pod_theme_option( 'pod-single-header-player-display', 'player-in-header' );
$pod_ssp_meta                     = pod_theme_option( 'pod-ssp-meta-data', false );
$has_thumb                        = ( has_post_thumbnail() && 'has-thumbnail' === $pod_single_header_display ) ? ' with_thumbnail' : '';

$ssp_single_sticky    = ( true === $pod_sticky_header ) ? 'sticky' : '';
$pod_single_header_bg = ( has_post_thumbnail() && 'has-background' === $pod_single_header_display && 'audio' === $format ) ? 'thumb_bg' : '';
$ssp_single_header_bg = ( has_post_thumbnail() && 'has-background' === $pod_single_header_display && 'podcast' === $posttype ) ? 'thumb_bg' : '';
$pod_single_bg_img    = ( has_post_thumbnail() && 'has-background' === $pod_single_header_display ) ? 'background-image: url(' . esc_url( $header_img ) . ');' : '';
$ssp_single_thumb_style = ( has_post_thumbnail() && 'has-thumbnail' === $pod_single_header_display ) ? ' with_thumbnail' : '';

$bpp_single_sticky      = ( true === $pod_sticky_header ) ? 'sticky' : ''; 
$bpp_single_header_bg   = ( has_post_thumbnail() && 'has-background' === $pod_single_header_display && 'audio' === $format ) ? 'thumb_bg' : '';
$bpp_single_bg_img      = ( has_post_thumbnail() && 'has-background' === $pod_single_header_display ) ? 'background-image: url(' . esc_url( $header_img ) . ');' : '';
$bpp_single_thumb_style = ( has_post_thumbnail() && 'has-thumbnail' === $pod_single_header_display ) ? ' with_thumbnail' : '';

$audiotype      = get_post_meta( $post->ID, 'cmb_thst_audio_type', true );
$audiourl       = get_post_meta( $post->ID, 'cmb_thst_audio_url', true );
$audioembed     = get_post_meta( $post->ID, 'cmb_thst_audio_embed', true );
$audioembedcode = get_post_meta( $post->ID, 'cmb_thst_audio_embed_code', true );
$audiocapt      = get_post_meta( $post->ID, 'cmb_thst_audio_capt', true );
$audioplists    = get_post_meta( $post->ID, 'cmb_thst_audio_playlist', true );
$audioex        = get_post_meta( $post->ID, 'cmb_thst_audio_explicit', true );

$videotype      = get_post_meta( $post->ID, 'cmb_thst_video_type', true );		
$videoembed     = get_post_meta( $post->ID, 'cmb_thst_video_embed', true );
$videourl       = get_post_meta( $post->ID, 'cmb_thst_video_url', true );
$videocapt      = get_post_meta( $post->ID, 'cmb_thst_video_capt', true );
$videothumb     = get_post_meta( $post->ID, 'cmb_thst_video_thumb', true );
$videoplists    = get_post_meta( $post->ID, 'cmb_thst_video_playlist', true );
$videoembedcode = get_post_meta( $post->ID, 'cmb_thst_video_embed_code', true );
$videoex        = get_post_meta( $post->ID, 'cmb_thst_video_explicit', true );

$gallerystyle = get_post_meta( $post->ID, 'cmb_thst_post_gallery_style', true );
$galleryimgs  = get_post_meta( $post->ID, 'cmb_thst_gallery_list', true );
$gallerycapt  = get_post_meta( $post->ID, 'cmb_thst_gallery_capt', true );
$gallerycol   = get_post_meta( $post->ID, 'cmb_thst_gallery_col', true );

$pod_sc_player = pod_theme_option( 'pod-audio-soundcloud-player-style', 'sc-classic-player' );

$mediatype = '';
if ( 'audio' === $format ) {
	$mediatype = $audiotype;
} elseif ( 'video' === $format ) {
	$mediatype = $videotype;
}

if ( 'audio-embed-url' === $audiotype || 'audio-embed-code' === $audiotype ) {
	$has_thumb_embed = ( $pod_single_header_thumb_embed ) ? 'audio-embed-thumbnail-active' : 'audio-embed-thumbnail-inactive';
} else {
	$has_thumb_embed = '';
}

if ( 'audio-playlist' === $audiotype ) {
	$has_thumb_playlist = ( $pod_single_header_thumb_playlist ) ? 'audio-playlist-thumbnail-active' : 'audio-playlist-thumbnail-inactive';
} else {
	$has_thumb_playlist = '';
}

/* Check for sidebars */
$pod_is_sidebar_active = is_active_sidebar( 'sidebar_single' ) ? 'pod-is-sidebar-active' : 'pod-is-sidebar-inactive';

/* Calming Reader Helper: Reading Time Calculation */
$post_content     = get_post_field( 'post_content', $post->ID );
$word_count       = str_word_count( strip_tags( $post_content ) );
$reading_time     = ceil( $word_count / 200 ); // Assumes average 200 words per minute
$reading_time_str = sprintf( _n( '%d min read', '%d mins read', $reading_time, 'podcaster' ), $reading_time );
?>

<!-- STEP 1: LOAD REFINED ASSETS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=typography"></script>

<!-- STEP 2: TAILWIND CUSTOM CONFIG (MIDNIGHT OCEAN & SAND) -->
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ocean: {
            50: '#F0F5F9',
            100: '#D9E6F1',
            200: '#B0CCE2',
            600: '#3D6C8F',
            800: '#1B2E3C', /* Deep anchoring navy */
            950: '#0F1A22',
          },
          clay: {
            50: '#FDF7F4',
            400: '#E0A389',
            500: '#D98A6C', /* Warm Dawn / Terracotta accent */
            600: '#C27558',
          },
          sand: {
            50: '#FAF6F0', /* Calming sand/linen background */
            100: '#F4EFE6',
            200: '#E9DEC9',
            900: '#2A261F',
          }
        },
        fontFamily: {
          sans: ['"Inter"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          serif: ['"Fraunces"', 'ui-serif', 'Georgia', 'serif'],
          editorial: ['"Cinzel"', 'serif'],
        }
      }
    }
  }
</script>

<!-- STEP 3: PRELOADER FOR THE ANCHORING WAVE DESIGN -->
<div id="calm-loader" style="position:fixed; top:0; left:0; width:100%; height:100%; background:#FAF6F0; z-index:99999; display:flex; flex-direction:column; justify-content:center; align-items:center; transition: opacity 0.4s cubic-bezier(0.25, 1, 0.5, 1); opacity:1;">
    <div style="width: 40px; height: 40px; border: 2px solid #E9DEC9; border-top-color: #1B2E3C; border-radius: 50%; animation: calm-spin 1.2s infinite cubic-bezier(0.53, 0.21, 0.29, 0.67);"></div>
    <p style="margin-top: 24px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; letter-spacing: 0.1em; color: #1B2E3C; text-transform: uppercase;">Calming the waves... preparing your space</p>
</div>

<style>
    @keyframes calm-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .asymmetric-border {
        border-bottom: 1px solid rgba(27, 46, 60, 0.08);
    }
</style>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const loader = document.getElementById('calm-loader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 400);
            }
        }, 150);
    });
</script>

<!-- STEP 4: HERO BREADCRUMB, HEADER, AND MEDIA BLOCK -->
<div class="bg-sand-50 text-sand-900 font-sans antialiased min-h-screen">
	
	<!-- EDITORIAL SPLIT HEADER SECTION -->
	<header class="bg-sand-100 py-16 md:py-24 border-b border-sand-200">
		<div class="max-w-6xl mx-auto px-6">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
				
				<!-- Left Column: Big Editorial Title -->
				<div class="lg:col-span-7 space-y-6">
					<div class="flex flex-wrap items-center gap-3 text-xs tracking-wider uppercase font-semibold text-ocean-600">
						<span><?php echo esc_html( get_the_date() ); ?></span>
						<span class="text-sand-200">&bull;</span>
						<span class="text-clay-500 font-bold"><?php echo esc_html( $reading_time_str ); ?></span>
					</div>

					<h1 class="font-serif text-4xl md:text-5xl lg:text-6xl text-ocean-800 font-bold tracking-tight leading-none mb-6">
						<?php echo esc_html( get_the_title() ); ?>
					</h1>

					<?php if ( 'on' === $audioex || 'on' === $videoex ) : ?>
						<span class="inline-block bg-clay-50 border border-clay-400 text-clay-600 text-[10px] uppercase tracking-widest font-extrabold px-3 py-1 rounded-sm">
							<?php echo esc_html__( 'Explicit content included', 'podcaster' ); ?>
						</span>
					<?php endif; ?>
				</div>

				<!-- Right Column: Premium Media Console overlapping layout -->
				<div class="lg:col-span-5">
					<?php if ( 'audio' === $format || 'video' === $format || 'image' === $format ) : ?>
						<div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-ocean-100 relative">
							<!-- Subtle decorative shadow backer -->
							<div class="absolute inset-0 bg-clay-500/5 rounded-2xl translate-x-2 translate-y-2 pointer-events-none -z-10"></div>
							
							<?php if ( 'ssp' === $pod_plugin_active ) : 
								global $ss_podcasting;
								$id = get_the_ID();
								$file = get_post_meta( $id, 'enclosure', true );
							?>
								<div class="space-y-6">
									<div class="flex items-center gap-4">
										<?php if ( has_post_thumbnail() && 'has-thumbnail' === $pod_single_header_display ) : ?>
											<div class="w-20 h-20 rounded-xl overflow-hidden shadow flex-shrink-0">
												<?php echo get_the_post_thumbnail( $id, 'square-large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
											</div>
										<?php endif; ?>
										<div>
											<p class="text-xs uppercase font-bold tracking-widest text-clay-500 mb-1">Interactive Episode</p>
											<p class="text-xs font-semibold text-ocean-800"><?php echo pod_get_ssp_series_cats( $post->ID, '', '', ',&nbsp;', true ); ?></p>
										</div>
									</div>

									<?php if ( '' !== $file ) : ?>
										<div class="audio-console bg-ocean-50 p-4 rounded-xl">
											<?php echo pod_get_featured_player( $post->ID ); ?>
										</div>
									<?php endif; ?>
								</div>

							<?php elseif ( 'bpp' === $pod_plugin_active ) : ?>
								<div class="audio-console bg-ocean-50 p-4 rounded-xl">
									<?php echo pod_get_featured_player( $post->ID ); ?>
								</div>

							<?php else : ?>
								<div class="space-y-6">
									<?php if ( has_post_thumbnail() && 'has-thumbnail' === $pod_single_header_display ) : ?>
										<div class="flex items-center gap-4">
											<div class="w-16 h-16 rounded-xl overflow-hidden shadow-inner flex-shrink-0">
												<?php echo get_the_post_thumbnail( $post->ID, 'square-large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
											</div>
											<div>
												<p class="text-[10px] uppercase font-bold tracking-widest text-ocean-600">Featured Podcast Format</p>
												<h4 class="font-serif text-sm font-semibold text-ocean-800 line-clamp-1"><?php echo esc_html( get_the_title() ); ?></h4>
											</div>
										</div>
									<?php endif; ?>

									<?php if ( '' !== $audiocapt ) : ?>
										<p class="text-xs font-medium text-ocean-600 bg-sand-50 p-3 rounded-lg border-l-2 border-clay-500"><?php echo esc_html( $audiocapt ); ?></p>
									<?php endif; ?>

									<div class="audio-console bg-ocean-50 p-4 rounded-xl">
										<?php echo pod_get_featured_player( $post->ID ); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</header>

	<!-- STEP 5: TWO COLUMN ASYMMETRIC GRID -->
	<div class="max-w-6xl mx-auto px-6 py-16 md:py-24">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
			
			<?php 
			/* Resolve Column layouts dynamically based on layout settings */
			$main_col_span = 'lg:col-span-12 max-w-3xl mx-auto w-full';
			if ( 'sidebar-right' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-8';
			} elseif ( 'sidebar-left' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-8 order-last';
			}
			?>

			<!-- MAIN CONTENT SECTION -->
			<main class="<?php echo esc_attr( $main_col_span ); ?> space-y-16">
				<article class="bg-white rounded-xl p-8 md:p-14 border border-sand-200 shadow-sm relative">
					
					<!-- COMPREHENSIVE TYPOGRAPHY CONTROL -->
					<div class="prose prose-ocean lg:prose-lg max-w-none text-sand-900 font-sans leading-relaxed
						prose-headings:font-serif prose-headings:font-semibold prose-headings:tracking-tight prose-headings:text-ocean-800
						prose-p:text-sand-900 prose-p:leading-8 prose-p:mb-8
						prose-a:text-clay-600 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline hover:prose-a:text-clay-500 prose-a:transition-all
						prose-blockquote:border-l-0 prose-blockquote:bg-sand-50 prose-blockquote:p-8 prose-blockquote:rounded-lg prose-blockquote:text-center prose-blockquote:font-serif prose-blockquote:italic prose-blockquote:text-ocean-850 prose-blockquote:text-lg">
						
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								/* Fetch individual layout format elements */
								get_template_part( 'post/format', $format );
								pod_set_post_views( get_the_ID() );
							endwhile;	
						endif;
						?>

					</div>

					<!-- SIGNATURE BIOGRAPHY CARD (ELEGANT ALIGNMENT) -->
					<section class="mt-20 pt-10 border-t border-sand-100 flex flex-col sm:flex-row items-center sm:items-start gap-8">
						<div class="w-24 h-24 rounded-full overflow-hidden bg-sand-200 flex-shrink-0 shadow-md">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 160, '', '', array( 'class' => 'w-full h-full object-cover grayscale' ) ); ?>
						</div>
						<div class="text-center sm:text-left space-y-3">
							<span class="text-[10px] font-bold uppercase tracking-widest text-clay-500 px-3 py-1 bg-clay-50 rounded-sm inline-block">Author & Mentor</span>
							<h4 class="font-serif text-xl font-semibold text-ocean-800"><?php the_author(); ?></h4>
							<p class="text-sm text-sand-900 leading-relaxed">
								As the guiding voice behind The Anxiety Guy, Dennis provides practical, direct tools and insights aimed at breaking free from loops of panic, health worry, and obsessive stress.
							</p>
						</div>
					</section>

				</article>

				<!-- SUNRISE RECOVERY CALL-TO-ACTION (TERRACOTTA THEME) -->
				<section class="bg-white rounded-xl border-l-4 border-clay-500 p-8 md:p-12 shadow-sm premium-card-border overflow-hidden relative">
					<div class="relative z-10 max-w-2xl space-y-6">
						<h4 class="font-serif text-xl md:text-3xl font-bold tracking-tight text-ocean-800">
							Are you ready to move past the limits of anxiety?
						</h4>
						<p class="text-sand-900 text-sm md:text-base leading-relaxed">
							Through custom programs and daily reflections, Dennis guides you toward self-awareness, letting go of coping mechanisms that no longer serve you, and building true confidence.
						</p>
						
						<div class="flex flex-wrap gap-4 pt-4">
							<a href="/programs/" class="bg-clay-500 text-white font-bold px-6 py-3.5 rounded-lg hover:bg-clay-600 active:scale-[0.99] transition-all text-sm shadow-md">
								Explore Dennis' Masterclasses & Courses
							</a>
							<a href="/newsletter/" class="bg-ocean-800 hover:bg-ocean-950 text-white font-semibold px-6 py-3.5 rounded-lg transition-all text-sm">
								Subscribe to the Reflection Newsletter
							</a>
						</div>
					</div>
				</section>
			</main>

			<!-- RIGHT SIDEBAR (DESIGNED TO INTEGRATE GRACEFULLY) -->
			<?php if ( ( 'sidebar-right' === $pod_blog_layout || 'sidebar-left' === $pod_blog_layout ) && is_active_sidebar( 'sidebar_single' ) ) : ?>
				<aside class="lg:col-span-4" role="complementary">
					<div class="sticky top-8 space-y-8 bg-white p-6 md:p-8 rounded-xl border border-sand-200 shadow-sm">
						<h4 class="font-serif text-lg font-bold text-ocean-800 pb-3 border-b border-sand-100 mb-6 uppercase tracking-wider text-[13px]">Explore Further</h4>
						<?php get_template_part( 'sidebar' ); ?>
					</div>
				</aside>
			<?php endif; ?>

		</div>
	</div>
</div>

<?php
/* Displays the footer template */
get_footer(); 
?>
