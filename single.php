<?php
/**
 * This file displays your single posts.
 * Fully redesigned with Tailwind CSS, typography enhancements,
 * and a calming preloader to prevent layout shifts.
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

<!-- STEP 1: LOAD MODERN STYLESHEETS & FONTS (TAILWIND PLAY CDN WITH TYPOGRAPHY PLUGIN) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=typography"></script>

<!-- STEP 2: CONFIGURE THE COHESIVE, CALMING COLOR PALETTE -->
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          sage: {
            50: '#F5F7F6',
            100: '#E6ECE8',
            200: '#D2E1D7',
            300: '#A9C2B2',
            600: '#4D755D',
            800: '#2D4E3A',
            900: '#1D3326',
          },
          warm: {
            50: '#FAF9F6', /* Gentle cream background */
            100: '#F3F1EC',
            800: '#2C2B29',
            900: '#1F1E1D',
          }
        },
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          serif: ['"Playfair Display"', 'ui-serif', 'Georgia', 'serif'],
        }
      }
    }
  }
</script>

<!-- STEP 3: PRELOADER TO PREVENT FLASH OF UNSTYLED CONTENT (FOUC) & LAYOUT SHIFT -->
<div id="calm-loader" style="position:fixed; top:0; left:0; width:100%; height:100%; background:#FAF9F6; z-index:99999; display:flex; flex-direction:column; justify-content:center; align-items:center; transition: opacity 0.5s ease; opacity:1;">
    <div style="width: 48px; height: 48px; border: 3px solid #E6ECE8; border-top-color: #2D4E3A; border-radius: 50%; animation: calm-spin 1s infinite linear;"></div>
    <p style="margin-top: 24px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 500; color: #2D4E3A; font-size: 15px; letter-spacing: 0.05em;">Breathing in, loading peace...</p>
</div>

<style>
    @keyframes calm-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    /* Simple utility classes nested cleanly */
    .premium-card-border {
        border: 1px solid rgba(45, 78, 58, 0.08);
    }
</style>

<script>
    // Reveal page only after structural rendering and style compilation is finished
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const loader = document.getElementById('calm-loader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 500);
            }
        }, 120); // Minor intentional delay to allow Tailwind compiler to build classes
    });
</script>

<!-- STEP 4: HERO BREADCRUMB, HEADER, AND MEDIA BLOCK -->
<div class="bg-warm-50 text-warm-900 font-sans antialiased min-h-screen py-12 md:py-20">
	<header class="max-w-4xl mx-auto px-6 text-center mb-10 md:mb-16">
		<div class="flex items-center justify-center gap-3 mb-6">
			<span class="bg-sage-100 text-sage-800 text-xs uppercase tracking-widest px-4 py-1.5 rounded-full font-bold">
				<?php echo esc_html( get_the_date() ); ?>
			</span>
			<span class="text-sage-300">&bull;</span>
			<span class="text-sage-800 text-xs font-semibold tracking-wider">
				<?php echo esc_html( $reading_time_str ); ?>
			</span>
		</div>

		<h1 class="font-serif text-3xl md:text-5xl lg:text-6xl text-warm-900 font-semibold tracking-tight leading-tight max-w-3xl mx-auto mb-6">
			<?php echo esc_html( get_the_title() ); ?>
		</h1>

		<?php if ( 'on' === $audioex || 'on' === $videoex ) : ?>
			<span class="inline-block bg-red-50 text-red-600 text-[11px] uppercase tracking-wider font-extrabold px-3 py-1 rounded">
				<?php echo esc_html__( 'Explicit', 'podcaster' ); ?>
			</span>
		<?php endif; ?>
	</header>

	<!-- MEDIA CONTROLLER SECTION (IMMERSED IN SAGE SHADOWS) -->
	<?php if ( 'audio' === $format || 'video' === $format || 'image' === $format ) : ?>
		<section class="max-w-4xl mx-auto px-6 mb-16">
			<div class="bg-white rounded-3xl shadow-xl p-6 md:p-10 premium-card-border overflow-hidden">
				
				<?php if ( 'ssp' === $pod_plugin_active ) : 
					global $ss_podcasting;
					$id = get_the_ID();
					$file = get_post_meta( $id, 'enclosure', true );
				?>
					<div class="md:flex items-center gap-8">
						<?php if ( has_post_thumbnail() && 'has-thumbnail' === $pod_single_header_display ) : ?>
							<div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl overflow-hidden shadow-md flex-shrink-0 mb-6 md:mb-0">
								<?php echo get_the_post_thumbnail( $id, 'square-large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
							</div>
						<?php endif; ?>
						
						<div class="flex-grow">
							<p class="text-xs font-semibold text-sage-600 uppercase tracking-widest mb-2">Listen to Episode</p>
							<h3 class="font-serif text-xl md:text-2xl font-bold text-warm-900 mb-4"><?php echo esc_html( get_the_title() ); ?></h3>
							
							<?php if ( '' !== $file ) : ?>
								<div class="audio-wrapper bg-sage-50 p-4 rounded-xl">
									<?php echo pod_get_featured_player( $post->ID ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>

				<?php elseif ( 'bpp' === $pod_plugin_active ) : ?>
					<div class="audio-wrapper bg-sage-50 p-4 rounded-xl">
						<?php echo pod_get_featured_player( $post->ID ); ?>
					</div>

				<?php else : ?>
					<div class="md:flex items-center gap-8">
						<?php if ( has_post_thumbnail() && 'has-thumbnail' === $pod_single_header_display ) : ?>
							<div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl overflow-hidden shadow-md flex-shrink-0 mb-6 md:mb-0">
								<?php echo get_the_post_thumbnail( $post->ID, 'square-large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
							</div>
						<?php endif; ?>

						<div class="flex-grow">
							<?php if ( '' !== $audiocapt ) : ?>
								<p class="text-xs font-medium text-sage-600 italic mb-3"><?php echo esc_html( $audiocapt ); ?></p>
							<?php endif; ?>
							<div class="audio-wrapper bg-sage-50 p-4 rounded-xl">
								<?php echo pod_get_featured_player( $post->ID ); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</section>
	<?php endif; ?>

	<!-- STEP 5: TWO COLUMN RESPONSIVE GRID OR CALM CENTER LAYOUT -->
	<div class="max-w-6xl mx-auto px-6">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
			
			<?php 
			/* Resolve Columns based on user selections */
			$main_col_span = 'lg:col-span-12 max-w-3xl mx-auto w-full';
			if ( 'sidebar-right' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-8';
			} elseif ( 'sidebar-left' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-8 order-last';
			}
			?>

			<!-- MAIN POST WRAPPER -->
			<main class="<?php echo esc_attr( $main_col_span ); ?>">
				<div class="bg-white rounded-3xl p-6 md:p-12 shadow-sm premium-card-border">
					
					<!-- COMPREHENSIVE WP TYPOGRAPHY ENGINE -->
					<div class="prose prose-sage lg:prose-lg max-w-none text-warm-800 font-sans leading-relaxed
						prose-headings:font-serif prose-headings:font-semibold prose-headings:tracking-tight prose-headings:text-warm-900
						prose-p:text-warm-800 prose-p:leading-8 prose-p:mb-6
						prose-a:text-sage-800 prose-a:font-semibold prose-a:underline hover:prose-a:text-sage-600 prose-a:transition-all
						prose-blockquote:border-l-4 prose-blockquote:border-sage-300 prose-blockquote:bg-sage-50/50 prose-blockquote:px-6 prose-blockquote:py-2 prose-blockquote:rounded-r-xl prose-blockquote:italic prose-blockquote:text-sage-800">
						
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								/* Fetch layout format parts */
								get_template_part( 'post/format', $format );
								pod_set_post_views( get_the_ID() );
							endwhile;	
						endif;
						?>

					</div>

					<!-- INSPIRING AUTHOR & VALUE BIO (TAILORED FOR DENNIS/ANXIETY GUY) -->
					<section class="mt-16 pt-10 border-t border-sage-100 flex flex-col md:flex-row items-center gap-6 md:gap-8">
						<div class="w-20 h-20 rounded-full overflow-hidden bg-sage-100 flex-shrink-0 shadow-inner">
							<!-- Gravity or Custom Author Avatar -->
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 160, '', '', array( 'class' => 'w-full h-full object-cover' ) ); ?>
						</div>
						<div class="text-center md:text-left">
							<span class="text-xs font-semibold uppercase tracking-wider text-sage-600 block mb-1">Author & Guide</span>
							<h4 class="font-serif text-xl font-bold text-warm-900 mb-2"><?php the_author(); ?></h4>
							<p class="text-sm text-sage-800 leading-relaxed max-w-xl">
								Host of The Anxiety Guy Podcast. Through real, lived experiences, Dennis shares structured paths and calming strategies to help you navigate mental clarity and reclaim life.
							</p>
						</div>
					</section>

				</div>

				<!-- HIGHLY CONVERTING EMOTIONAL VALUE CALL-TO-ACTION (CTA) -->
				<section class="mt-12 bg-gradient-to-br from-sage-800 to-sage-900 text-white rounded-3xl p-8 md:p-12 shadow-xl relative overflow-hidden">
					<!-- Visual subtle background element -->
					<div class="absolute -right-16 -bottom-16 w-64 h-64 bg-sage-600/20 rounded-full blur-3xl"></div>
					
					<div class="relative z-10 max-w-2xl">
						<span class="inline-block bg-sage-600/30 text-sage-100 text-xs uppercase tracking-widest font-bold px-4 py-1.5 rounded-full mb-6">
							Your Recovery Journey Starts Here
						</span>
						<h3 class="font-serif text-2xl md:text-4xl font-bold tracking-tight mb-4 leading-tight">
							You don't have to carry this anxiety alone.
						</h3>
						<p class="text-sage-100 text-sm md:text-base leading-relaxed mb-8">
							Thousands of warriors have rewritten their panic, health anxiety, and intrusive thoughts using Dennis' structured programs. Get started with actionable guides or a personalized path today.
						</p>
						
						<div class="flex flex-wrap gap-4">
							<a href="/programs/" class="bg-white text-sage-900 font-bold px-6 py-3.5 rounded-xl hover:bg-sage-100 hover:scale-[1.01] active:scale-[0.99] transition-all text-sm shadow-md">
								Explore structured recovery programs
							</a>
							<a href="/newsletter/" class="bg-sage-800/80 hover:bg-sage-800 border border-sage-200/20 text-white font-semibold px-6 py-3.5 rounded-xl transition-all text-sm">
								Join the daily anxiety-free newsletter
							</a>
						</div>
					</div>
				</section>
			</main>

			<!-- OPTIONAL SIDEBAR (REFINED TO MATCH PREMIUM MINIMALIST THEME) -->
			<?php if ( ( 'sidebar-right' === $pod_blog_layout || 'sidebar-left' === $pod_blog_layout ) && is_active_sidebar( 'sidebar_single' ) ) : ?>
				<aside class="lg:col-span-4" role="complementary">
					<div class="sticky top-8 space-y-8 bg-white p-6 md:p-8 rounded-3xl premium-card-border shadow-sm">
						<h4 class="font-serif text-lg font-bold text-warm-900 pb-3 border-b border-sage-100 mb-6">Supportive Resources</h4>
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
