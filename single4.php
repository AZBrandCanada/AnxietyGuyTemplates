<?php
/**
 * Template Name: Modern Editorial Post
 * Description: A premium, print-inspired editorial single post template.
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

$who_is_dennis_img = 'https://theanxietyguy.com/wp-content/uploads/2020/11/the_anxiety_Guy_masterclass_1.jpg';
?>

<!-- STEP 1: LOAD MODERN STYLES & PRELOADER (MATCHES HOMEPAGE REFRESH SYSTEM) -->
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
    border-top: 3.5px solid #296bb1;
    border-radius: 50%;
    animation: refresh-spin 0.8s linear infinite;
  }

  @keyframes refresh-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

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

<!-- STEP 2: LOAD ENHANCED TYPOGRAPHY SPECIFICALLY FOR THE EDITORIAL DESIGN -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,400&family=Satisfy&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com?plugins=typography"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brandNavy: '#1e293b',
          brandBlue: '#296bb1',       
          brandCardBlue: '#3774b6',   
          brandGreen: '#6b9351',      
          brandPurple: '#7968ad',     
          brandOrange: '#dd8837',     
          brandHeadingBlue: '#3c569c', 
        },
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          serif: ['"Playfair Display"', 'Georgia', 'serif'],
          cursive: ['"Satisfy"', 'cursive'],
        }
      }
    }
  }
</script>

<!-- CSS Inject for Custom Editorial Stylings -->
<style>
  /* First letter drop-cap style */
  .editorial-prose > p:first-of-type::first-letter {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 3.85rem;
    font-weight: 800;
    float: left;
    line-height: 0.8;
    margin-top: 0.25rem;
    margin-right: 0.65rem;
    color: #1e293b;
  }
</style>

<!-- STEP 3: WRAPPER AND STRUCTURE OVERRIDES -->
<div class="homepage-match-wrapper bg-white font-sans text-gray-800 antialiased overflow-x-hidden min-h-screen">
	
	<!-- EDITORIAL TOP HEADER BOUNDARY -->
	<header class="border-b border-slate-200 py-10 lg:py-16 bg-slate-50">
		<div class="max-w-[1440px] mx-auto px-6">
			<div class="max-w-4xl space-y-4">
				<div class="flex items-center gap-2 text-xs uppercase tracking-widest font-extrabold text-brandBlue">
					<span><?php echo esc_html( get_the_date() ); ?></span>
					<span>&bull;</span>
					<span class="text-brandGreen"><?php echo esc_html( $reading_time_str ); ?></span>
				</div>
				<h1 class="font-serif text-3xl md:text-5xl lg:text-6xl font-extrabold text-brandNavy tracking-tight leading-[1.1]">
					<?php echo esc_html( get_the_title() ); ?>
				</h1>
			</div>
		</div>
	</header>

	<!-- STEP 4: EDITORIAL GRID LAYOUT -->
	<div class="max-w-[1440px] mx-auto px-6">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-0 border-b border-slate-200">
			
			<!-- Left Column: Sticky Editorial Meta & Progress Ring (Visible on Desktop) -->
			<aside class="hidden lg:block lg:col-span-2 py-12 pr-8 border-r border-slate-200 relative">
				<div class="sticky top-10 space-y-8">
					
					<!-- Circular Interactive Progress Scroll Indicator -->
					<div class="flex flex-col items-center space-y-3">
						<div class="relative w-16 h-16">
							<svg class="w-full h-full transform -rotate-90">
								<circle cx="32" cy="32" r="28" stroke="#e2e8f0" stroke-width="3" fill="transparent" />
								<circle id="scroll-progress-ring" cx="32" cy="32" r="28" stroke="#296bb1" stroke-width="3.5" fill="transparent"
									stroke-dasharray="175.92" stroke-dashoffset="175.92" class="transition-all duration-75" />
							</svg>
							<div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-brandNavy" id="progress-percent">
								0%
							</div>
						</div>
						<p class="text-[10px] uppercase tracking-wider font-extrabold text-gray-400 text-center">Reading Progress</p>
					</div>

					<div class="h-px bg-slate-100 w-full"></div>

					<!-- Secondary Quick Info -->
					<div class="space-y-4">
						<div>
							<p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-1">Written By</p>
							<p class="text-xs font-bold text-brandNavy"><?php the_author(); ?></p>
						</div>
						<div>
							<p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-1">Share / Connect</p>
							<div class="flex gap-2">
								<a href="https://www.youtube.com/@TheAnxietyGuy" target="_blank" class="w-6 h-6 rounded bg-slate-100 flex items-center justify-center text-brandBlue hover:bg-brandBlue hover:text-white transition">
									<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.508a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.871.508 9.388.508 9.388.508s7.517 0 9.388-.508a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837z"/></svg>
								</a>
							</div>
						</div>
					</div>

				</div>
			</aside>

			<?php 
			/* Resolve remaining Columns based on sidebar settings */
			$main_col_span = 'lg:col-span-10 py-12 lg:pl-10 max-w-4xl mx-auto w-full';
			if ( 'sidebar-right' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-7 py-12 lg:px-10';
			} elseif ( 'sidebar-left' === $pod_blog_layout && is_active_sidebar( 'sidebar_single' ) ) {
				$main_col_span = 'lg:col-span-7 py-12 lg:px-10 order-last border-r border-slate-200';
			}
			?>

			<!-- CENTRAL CONTENT AREA -->
			<main class="<?php echo esc_attr( $main_col_span ); ?>" id="editorial-scroll-anchor">
				
				<!-- COMPREHENSIVE TYPOGRAPHY CONTROL WITH EDITORIAL DROP-CAP -->
				<div class="editorial-prose prose prose-slate max-w-none text-gray-700 font-sans leading-relaxed
					prose-headings:text-brandNavy prose-headings:font-serif prose-headings:font-bold prose-headings:tracking-tight
					prose-p:text-gray-600 prose-p:leading-8 prose-p:mb-8
					prose-a:text-brandBlue prose-a:font-semibold prose-a:underline hover:prose-a:text-brandHeadingBlue prose-a:transition-all
					prose-blockquote:border-l-0 prose-blockquote:bg-slate-50 prose-blockquote:p-8 prose-blockquote:rounded-xl prose-blockquote:text-center prose-blockquote:font-serif prose-blockquote:italic prose-blockquote:text-brandNavy prose-blockquote:text-xl">
					
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							/* Fetch structural formatting components */
							get_template_part( 'post/format', $format );
							pod_set_post_views( get_the_ID() );
						endwhile;	
					endif;
					?>

				</div>

				<!-- SPOTLIGHT BIO DESIGN: COLUMNIST COLUMN STYLE -->
				<section class="mt-16 pt-12 border-t border-slate-200">
					<div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
						
						<!-- Grayscale Inset Portrait with Smooth Color Shift -->
						<div class="md:col-span-4">
							<div class="relative bg-slate-100 p-2 rounded-xl shadow-md border border-slate-200 group overflow-hidden">
								<img src="<?php echo esc_url( $who_is_dennis_img ); ?>" alt="Dennis profile" class="w-full h-auto rounded-lg object-cover transition duration-500 filter grayscale hover:grayscale-0">
							</div>
						</div>

						<div class="md:col-span-8 space-y-4">
							<span class="text-[10px] font-bold uppercase tracking-widest text-brandGreen bg-emerald-50 px-3 py-1 rounded inline-block">Columnist & Specialist</span>
							<h4 class="font-serif text-2xl font-bold text-brandNavy"><?php the_author(); ?></h4>
							
							<div class="space-y-3 text-gray-600 text-sm leading-relaxed">
								<p>
									I understand how you feel; <a href="https://www.amazon.com/Fuck-Coping-Start-Healing-Anxiety-ebook/dp/B086JBWCXX" class="text-brandBlue font-semibold underline hover:text-[#1c4b7d]" target="_blank" rel="noopener noreferrer">I have been there</a>. Generalized anxiety turned to panic disorder, and panic disorder turned to health anxiety.
								</p>
								<p>
									It was a painful and sometimes hopeless time, until I built a structured approach to reverse my negative thinking patterns and build long-term, inner calm.
								</p>
							</div>

							<!-- Handwritten signature accent alignment -->
							<div class="pt-2">
								<p class="font-cursive text-3xl text-brandBlue leading-tight">You can recover. And I can help.</p>
								<p class="text-xs uppercase tracking-wider mt-1 opacity-80 font-bold text-brandNavy">— Dennis Simsek</p>
							</div>
						</div>

					</div>
				</section>

				<!-- RECOVERY CONSOLE CTA CARD (MATCHES HOMEPAGE ACCENTS) -->
				<section class="mt-12 bg-[#f4f7f0] rounded-2xl p-8 shadow-sm border border-emerald-100/50 flex flex-col md:flex-row justify-between items-center gap-6">
					<div class="space-y-2 text-center md:text-left max-w-xl">
						<h3 class="text-xl font-bold text-brandNavy">Ready to start your recovery path?</h3>
						<p class="text-gray-600 text-sm leading-relaxed">Explore Dennis' programs that have helped thousands globally overcome the continuous loops of health anxiety and intrusive thought patterns.</p>
					</div>
					<a href="https://theanxietyguy.com/all-programs/" class="inline-flex items-center justify-center gap-2 bg-brandGreen text-white text-sm font-bold py-3.5 px-6 rounded-md hover:opacity-95 transition duration-200 shadow-sm flex-shrink-0">
						Explore Programs
						<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
					</a>
				</section>

			</main>

			<!-- RIGHT SIDEBAR (LG:COL-SPAN-3 WITH EDITORIAL GRIDS) -->
			<?php if ( ( 'sidebar-right' === $pod_blog_layout || 'sidebar-left' === $pod_blog_layout ) && is_active_sidebar( 'sidebar_single' ) ) : ?>
				<aside class="lg:col-span-3 py-12 lg:pl-8 border-l border-slate-200" role="complementary">
					<div class="sticky top-10 space-y-6">
						<h4 class="text-xs uppercase tracking-widest font-extrabold text-brandNavy pb-3 border-b border-slate-200 mb-4">Supportive Materials</h4>
						<?php get_template_part( 'sidebar' ); ?>
					</div>
				</aside>
			<?php endif; ?>

		</div>
	</div>
</div>

<!-- STEP 5: RUNTIME LOADING SCRIPTS AND INTERACTIVE PROGRESS TRACKER -->
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
        }, 400);
      }
    }

    // Scroll progress tracker logic
    function initScrollTracker() {
      var progressRing = document.getElementById('scroll-progress-ring');
      var progressPercent = document.getElementById('progress-percent');
      var contentAnchor = document.getElementById('editorial-scroll-anchor');

      if (!progressRing || !contentAnchor) return;

      var radius = parseFloat(progressRing.getAttribute('r'));
      var circumference = 2 * Math.PI * radius;

      window.addEventListener('scroll', function() {
        var rect = contentAnchor.getBoundingClientRect();
        var contentHeight = rect.height;
        var scrolledFromTop = -rect.top;
        var viewportHeight = window.innerHeight;

        // Calculate progress percentage inside the main article container
        var progress = Math.max(0, Math.min(100, (scrolledFromTop / (contentHeight - viewportHeight)) * 100));

        var offset = circumference - (progress / 100) * circumference;
        progressRing.style.strokeDashoffset = offset;
        if (progressPercent) {
          progressPercent.textContent = Math.round(progress) + '%';
        }
      });
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
      setTimeout(function() {
        revealPage();
        initScrollTracker();
      }, 150);
    } else {
      window.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
          revealPage();
          initScrollTracker();
        }, 150);
      });
      window.addEventListener('load', revealPage);
    }
  })();
</script>

<?php 
get_footer(); // Imports your existing theme footer.php
?>
