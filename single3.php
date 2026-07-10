<?php
/**
 * Template Name: Modern Single Post (Homepage Match)
 * Description: An editorial single post template matching the refreshed homepage with wider container structures for desktop.
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

// Swapped out with your exact live paths & custom variables from the homepage config:
$who_is_dennis_img = 'https://theanxietyguy.com/wp-content/uploads/2020/11/the_anxiety_Guy_masterclass_1.jpg';
?>

<!-- STEP 1: PRE-LOADER STYLING & ELEMENTS (MATCHES HOMEPAGE REFRESH) -->
<style>
  #refresh-loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #ffffff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 999999;
    opacity: 1;
    visibility: visible;
    transition: opacity 0.4s ease-out, visibility 0.4s ease-out;
  }
  
  .refresh-spinner {
    width: 44px;
    height: 44px;
    border: 3.5px solid #e2e8f0;
    border-top: 3.5px solid #296bb1; /* Matches brand blue */
    border-radius: 50%;
    animation: refresh-spin 0.8s linear infinite;
  }

  @keyframes refresh-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Keep main content hidden until Tailwind compiles the CSS */
  .homepage-match-wrapper {
    opacity: 0;
    transition: opacity 0.45s ease-in-out;
  }
  
  .homepage-match-wrapper.loaded {
    opacity: 1;
  }
</style>

<div id="refresh-loader-overlay">
  <div class="refresh-spinner"></div>
</div>

<!-- STEP 2: LOAD TAILWIND & GOOGLE FONTS (MATCHES HOMEPAGE SYSTEM) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Satisfy&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com?plugins=typography"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brandNavy: '#1e293b',
          brandBlue: '#296bb1',       // Hero button blue
          brandCardBlue: '#3774b6',   // Card blue accent
          brandGreen: '#6b9351',      // Theme green (Health Anxiety/My Story)
          brandPurple: '#7968ad',     // Card purple accent
          brandOrange: '#dd8837',     // Card orange accent
          brandHeadingBlue: '#3c569c', // Header blue highlight
        },
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          cursive: ['"Satisfy"', 'cursive'],
        }
      }
    }
  }
</script>

<!-- STEP 3: WRAPPER AND STRUCTURE OVERRIDES -->
<div class="homepage-match-wrapper bg-slate-50 font-sans text-gray-800 antialiased overflow-x-hidden min-h-screen py-10 lg:py-16">

	<!-- STEP 4: WIDE TWO-COLUMN CONTENT GRID (EXPANDED TO max-w-[1440px]) -->
	<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
			
			<?php 
			/* Resolve Column layouts dynamically. Width balances adjusted to lg:col-span-9 on wide desktops */
			$main_col_span = 'lg:col-span-12 max-w-5xl mx-auto w-full';
			if ( 'sidebar-right' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-9';
			} elseif ( 'sidebar-left' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-9 order-last';
			}
			?>

			<!-- MAIN POST CONTENT AREA -->
			<main class="<?php echo esc_attr( $main_col_span ); ?>">
				<div class="bg-white rounded-2xl p-6 md:p-12 shadow-sm border border-gray-100/80">
					
					<!-- STANDARD TYPOGRAPHY HANDLER -->
					<div class="prose max-w-none text-gray-700 font-sans leading-relaxed
						prose-headings:text-brandNavy prose-headings:font-extrabold prose-headings:tracking-tight
						prose-p:text-gray-600 prose-p:leading-8 prose-p:mb-6
						prose-a:text-brandBlue prose-a:font-semibold prose-a:underline hover:prose-a:text-brandHeadingBlue prose-a:transition-all
						prose-blockquote:border-l-4 prose-blockquote:border-brandBlue prose-blockquote:bg-slate-50 prose-blockquote:px-6 prose-blockquote:py-2 prose-blockquote:rounded-r-lg prose-blockquote:italic">
						
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								/* Fetch specific WordPress formatting templates */
								get_template_part( 'post/format', $format );
								pod_set_post_views( get_the_ID() );
							endwhile;	
						endif;
						?>

					</div>

					<!-- SIGNATURE BIOGRAPHY CARD (MATCHES HOMEPAGE "WHO IS DENNIS" DESIGN) -->
					<section class="mt-12 pt-10 border-t border-gray-100">
						<div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
							
							<!-- Left Text Info -->
							<div class="md:col-span-8 space-y-4 text-left">
								<h2 class="text-2xl font-extrabold text-brandNavy">
									Who is <span class="font-cursive text-3xl text-brandBlue ml-1">Dennis</span>
								</h2>
								
								<div class="space-y-3 text-gray-600 text-sm leading-relaxed">
									<p>
										I know how you feel; <a href="https://www.amazon.com/Fuck-Coping-Start-Healing-Anxiety-ebook/dp/B086JBWCXX" class="text-brandBlue font-semibold underline hover:text-[#1c4b7d]" target="_blank" rel="noopener noreferrer">I’ve been there</a>. For me, generalized anxiety disorder turned to panic disorder, and panic disorder turned to health anxiety.
									</p>
									<p>
										It was a painful and sometimes hopeless time in my life, until I put together a plan to reverse my thinking patterns and find true inner peace.
									</p>
								</div>
								
								<!-- Handwritten Signature Style from the Hero -->
								<div class="pt-2">
									<p class="font-cursive text-3xl text-brandBlue leading-tight">You can recover. And I can help.</p>
									<p class="text-xs uppercase tracking-wider mt-1 opacity-80 font-bold text-brandNavy">— Dennis Simsek</p>
								</div>
							</div>

							<!-- Right Profile Photo Frame -->
							<div class="md:col-span-4 flex justify-center">
								<div class="relative w-full max-w-[180px] bg-white p-2 rounded-xl shadow-md border border-gray-100">
									<img src="<?php echo esc_url( $who_is_dennis_img ); ?>" alt="Dennis portrait" class="w-full h-auto rounded-lg object-cover shadow-inner">
								</div>
							</div>

						</div>
					</section>

				</div>

				<!-- HIGH-CONVERTING BOTTOM CALL-TO-ACTION (MATCHES HOMEPAGE GREEN/BLUE VALUE ACTIONS) -->
				<section class="mt-10 bg-[#f4f7f0] rounded-2xl p-8 shadow-sm border border-emerald-100/50 flex flex-col md:flex-row justify-between items-center gap-6">
					<div class="space-y-2 text-center md:text-left max-w-2xl">
						<h3 class="text-xl font-bold text-brandNavy">Ready to start your anxiety recovery?</h3>
						<p class="text-gray-600 text-sm leading-relaxed">Dennis has spent over 15 years developing step-by-step masterclasses to reverse symptom checking, panic attacks, and intrusive loops.</p>
					</div>
					<a href="https://theanxietyguy.com/all-programs/" class="inline-flex items-center justify-center gap-2 bg-brandGreen text-white text-sm font-bold py-3 px-6 rounded-md hover:opacity-95 transition duration-200 shadow-sm flex-shrink-0">
						Get Started Today!
						<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
					</a>
				</section>
			</main>

			<!-- RIGHT SIDEBAR (LG:COL-SPAN-3 ADJUSTED TO ACCENTUATE THE WIDTH) -->
			<?php if ( ( 'sidebar-right' === $pod_blog_layout || 'sidebar-left' === $pod_blog_layout ) && is_active_sidebar( 'sidebar_single' ) ) : ?>
				<aside class="lg:col-span-3" role="complementary">
					<div class="sticky top-8 bg-white p-6 rounded-2xl border border-gray-100/80 shadow-sm space-y-6">
						<h4 class="text-xs uppercase tracking-wider font-extrabold text-brandNavy pb-3 border-b border-gray-100 mb-4">Supportive Materials</h4>
						<?php get_template_part( 'sidebar' ); ?>
					</div>
				</aside>
			<?php endif; ?>

		</div>
	</div>
</div>

<!-- Native lightweight JS script to smoothly fade in the page wrapper once HTML/Tailwind renders -->
<script>
  (function() {
    function revealPage() {
      var wrapper = document.querySelector('.homepage-match-wrapper');
      var loader = document.getElementById('refresh-loader-overlay');
      if (wrapper) {
        wrapper.classList.add('loaded');
      }
      if (loader) {
        loader.style.opacity = '0';
        loader.style.visibility = 'hidden';
        setTimeout(function() {
          if (loader.parentNode) {
            loader.parentNode.removeChild(loader);
          }
        }, 400); // Matches CSS transition duration
      }
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
      setTimeout(revealPage, 150);
    } else {
      window.addEventListener('DOMContentLoaded', function() {
        setTimeout(revealPage, 150);
      });
      window.addEventListener('load', revealPage);
    }
  })();
</script>

<?php 
get_footer(); // Imports your existing theme footer.php
?>
