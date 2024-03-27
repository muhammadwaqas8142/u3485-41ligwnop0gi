<?php
defined('ABSPATH') || exit;
/**
 * THAI_VERSION is defined for current Thai version
 */
if (!defined('THAI_VERSION')) {
	define('THAI_VERSION', '1.0.11');
}
/**
 * THAI_PATH Defines for load PHP files
 */
if (!defined('THAI_PATH')) {
	define('THAI_PATH', get_template_directory() . '/');
}
/**
 * THAI_URL Defines for load JS and CSS files
 */
if (!defined('THAI_URL')) {
	define('THAI_URL', get_template_directory_uri() . '/');
}
/**
 * @function cwp_theme_required_plugins
 *
 * Thai Theme required plugins.
 *
 * @returns bool
 */
/**
 * All Thai classes files to be loaded automatically.
 *
 * @param string $className Class name.
 */
if (!function_exists('thai_autoload_classes')) {
	function thai_autoload_classes($className)
	{
		// If class does not start with our prefix (Thai), nothing will return.
		if (!str_contains($className, 'Thai')) {
			return null;
		}
		// Replace _ with - to match the file name.
		$file_name = str_replace('_', '-', strtolower($className));
		// Calling class file.
		$files = array(
			THAI_PATH . 'classes/class-' . $file_name . '.php',
			THAI_PATH . 'classes/fields/class-' . $file_name . '.php',
			THAI_PATH . 'classes/shortcodes/class-' . $file_name . '.php'
		);
		foreach ($files as $file) {
			if (file_exists($file)) {
				require $file;
			}
		}
		return $className;
	}
	spl_autoload_register('thai_autoload_classes');
}
if (!function_exists('cwp_theme_required_plugins')) {
	function cwp_theme_required_plugins()
	{
		return array(
			array(
				'name'         => esc_html__('Elementor', 'thai'),
				'slug'         => 'elementor',
				'base'         => 'elementor',
				'required'     => 'yes',
				'class_exists' => 'Elementor\Plugin',
				'min_version'  => false
			),
			array(
				'name'         => esc_html__('CubeWP Framework', 'thai'),
				'slug'         => 'cubewp-framework',
				'base'         => 'cube',
				'source'       => THAI_URL . 'include/sdk/plugins/cubewp-framework.zip',
				'required'     => 'yes',
				'class_exists' => 'CubeWp_Load',
				'min_version'  => '1.1.5'
			),
			array(
				'name'         => esc_html__('CubeWP Frontend Pro', 'thai'),
				'slug'         => 'cubewp-addon-frontend-pro',
				'base'         => 'cubewp-frontend',
				'required'     => 'yes',
				'source'       => THAI_URL . 'include/sdk/plugins/cubewp-addon-frontend-pro.zip',
				'class_exists' => 'CubeWp_Frontend_Load',
				'min_version'  => false
			),
			array(
				'name'         => esc_html__('CubeWP Forms', 'thai'),
				'slug'         => 'cubewp-forms',
				'base'         => 'cubewp-forms',
				'required'     => 'no',
				'class_exists' => 'CubeWp_Forms_Custom',
				'min_version'  => false
			),
		);
	}
}
/**
 * Including theme setup file.
 *
 * @since  1.0.0
 */
require_once THAI_PATH . 'include/sdk/controller.php';
require_once THAI_PATH . 'include/register-elementor-widget.php';
/**
 * @function if_theme_can_load
 *
 * Check all required plugins for Thai Theme.
 *
 * @param bool $check_frontend Also Check CubeWP Frontend Pro.
 *
 * @returns bool
 */
if (!function_exists('if_theme_can_load')) {
	function if_theme_can_load($check_frontend = false)
	{
		if (!$check_frontend) {
			if (function_exists('CWP')) {
				return true;
			}
		} else {
			if (function_exists('CWP') && class_exists('CubeWp_Frontend_Load')) {
				return true;
			}
		}
		return false;
	}
}
/**
 * @function thai_frontend_styles
 *
 * General Thai Theme Styles And Scripts.
 */
if (!function_exists('thai_frontend_styles')) {
	function thai_frontend_styles()
	{
		$styles = array(
			'thai-fa'               => array(
				'src'   => THAI_URL . 'assets/lib/fontawesome/css/fontawesome.min.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-pie-css'               => array(
				'src'   => THAI_URL . 'assets/lib/pie/PieChart.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-fa-solid'         => array(
				'src'   => THAI_URL . 'assets/lib/fontawesome/css/solid.min.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-fa-regular'       => array(
				'src'   => THAI_URL . 'assets/lib/fontawesome/css/regular.min.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-fa-brands'        => array(
				'src'   => THAI_URL . 'assets/lib/fontawesome/css/brands.min.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-bootstrap-styles' => array(
				'src'   => THAI_URL . 'assets/lib/bootstrap/css/bootstrap.min.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-core-styles'      => array(
				'src'   => get_stylesheet_uri(),
				'deps'  => array('thai-bootstrap-styles'),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-styles'           => array(
				'src'   => THAI_URL . 'assets/css/thai-styles.css',
				'deps'  => array('thai-core-styles'),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-dynamic-styles'   => array(
				'src'   => THAI_URL . 'assets/css/dynamic-css.css',
				'deps'  => array('thai-fields-styles', 'thai-styles'),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-fields-styles'    => array(
				'src'   => THAI_URL . 'assets/css/thai-frontend-fields.css',
				'deps'  => array('thai-styles'),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-blog-styles'      => array(
				'src'   => THAI_URL . 'assets/css/thai-blog-styles.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-blogs-styles'     => array(
				'src'   => THAI_URL . 'assets/css/thai-blogs-styles.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-author-1-styles'  => array(
				'src'   => THAI_URL . 'assets/css/thai-author-style-1.css',
				'deps'  => array(),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-header-styles'    => array(
				'src'   => THAI_URL . 'assets/css/thai-header-styles.css',
				'deps'  => array('thai-styles'),
				'ver'   => THAI_VERSION,
				'media' => '',
			),
			'thai-slick-styles'            => array(
				'src'     => THAI_URL . 'assets/lib/slick/slick.css',
				'deps'    => array(),
				'ver' => THAI_VERSION,
				'has_rtl' => false,
				'media' => '',
				'in_footer' => true
			),
		);
		foreach ($styles as $handle => $data) {
			wp_register_style($handle, $data['src'], $data['deps'], $data['ver'], $data['media']);
		}
		$scripts = array(
			'thai-PieChart-scripts' => array(
				'src'       => THAI_URL . 'assets/lib/pie/PieChart.js',
				'deps'      => array(),
				'ver'       => THAI_VERSION,
				'in_footer' => true
			),
			'thai-bootstrap-scripts' => array(
				'src'       => THAI_URL . 'assets/lib/bootstrap/js/bootstrap.bundle.min.js',
				'deps'      => array(),
				'ver'       => THAI_VERSION,
				'in_footer' => true
			),
			'thai-author-1-scripts'  => array(
				'src'       => THAI_URL . 'assets/js/thai-author-scripts-1.js',
				'deps'      => array('jquery'),
				'ver'       => THAI_VERSION,
				'in_footer' => true
			),
			'thai-author-2-scripts'  => array(
				'src'       => THAI_URL . 'assets/js/thai-author-scripts-2.js',
				'deps'      => array('jquery'),
				'ver'       => THAI_VERSION,
				'in_footer' => true
			),
			'thai-scripts'           => array(
				'src'       => THAI_URL . 'assets/js/thai-scripts.js',
				'deps'      => array('jquery'),
				'ver'       => THAI_VERSION,
				'in_footer' => true,
			),
			'thai-headers-scripts'   => array(
				'src'       => THAI_URL . 'assets/js/thai-header-scripts.js',
				'deps'      => array('jquery'),
				'ver'       => THAI_VERSION,
				'in_footer' => true,
			),
			'thai-slick-scripts'          => array(
				'src'     => THAI_URL . 'assets/lib/slick/slick.min.js',
				'deps'    => array('jquery'),
				'ver' => THAI_VERSION,
				'has_rtl' => false,
				'in_footer' => true
			),
			// override plugin form validation script
			'thai-form-validation'          => array(
				'src'     => THAI_URL . 'assets/js/thai-frontend-form-validation.js',
				'deps'    => array('jquery'),
				'ver' => THAI_VERSION,
				'has_rtl' => false,
				'in_footer' => true
			),
		);

	
		foreach ($scripts as $handle => $data) {
			wp_register_script($handle, $data['src'], $data['deps'], $data['ver'], $data['in_footer']);
		}

		

		wp_enqueue_script('thai-slick-scripts');
		wp_enqueue_script('thai-bootstrap-scripts');
		wp_enqueue_script('thai-scripts');
		wp_enqueue_script('thai-headers-scripts');
		wp_localize_script('thai-scripts', 'thai_script_obj', array(
			'thai_ajax_url' => admin_url('admin-ajax.php'),
		));
		wp_enqueue_style('thai-fa');
		wp_enqueue_style('thai-slick-styles');
		wp_enqueue_style('thai-fa-solid');
		wp_enqueue_style('thai-fa-regular');
		wp_enqueue_style('thai-fa-brands');
		wp_enqueue_style('thai-fields-styles');
		wp_enqueue_style('thai-dynamic-styles');


		wp_enqueue_style('thai-header-styles');



		wp_enqueue_style('thai-pie-css');
		wp_enqueue_script('thai-PieChart-scripts');
		
		if ((is_search() || is_tag() || is_category()) && !thai_is_archive()) {
			wp_enqueue_style('thai-blogs-styles');
		}
		$post = get_post();
		if (is_page() && strpos($post->post_content, 'cwpForm') !== false) {
			global $thai_post_types;
			preg_match('/\[cwpForm\s+type="([^"]+)"\s*\]/', $post->post_content, $matches);
			$type = isset($matches[1]) ? $matches[1] : 'post';
			if (isset($thai_post_types) && is_array($thai_post_types) && in_array($type, $thai_post_types)) {
				wp_enqueue_style('thai-submission-styles');
				wp_enqueue_script('thai-submission-scripts');
			}
		}
		if (!if_theme_can_load()) {
			$font_family     = 'Manrope';
			$url_font_family = "family=" . str_replace(" ", "+", $font_family) . ":ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&";
			$google_font_api = 'https://fonts.googleapis.com/css2?' . $url_font_family . 'display=swap';
			wp_enqueue_style('google_fonts', $google_font_api);
		}
	}
	add_action('wp_enqueue_scripts', 'thai_frontend_styles');
}
if (!function_exists("thai_is_singular")) {
	function thai_is_singular()
	{
		global $thai_post_types;
		$return = false;
		if (is_singular($thai_post_types)) {
			$return = true;
		}
		return apply_filters('thai_is_singular', $return);
	}
}
if (!function_exists("thai_is_archive")) {
	function thai_is_archive()
	{
		global $thai_taxonomies, $thai_post_types;
		$return = false;
		if (is_post_type_archive($thai_post_types) || is_tax($thai_taxonomies)) {
			$return = true;
		}
		return apply_filters('thai_is_archive', $return);
	}
}
/**
 * @function thai_get_setting
 *
 * Return settings from CubeWP Settings.
 */
if (!function_exists('thai_get_setting')) {
	function thai_get_setting($setting, $handle_as = 'default', $find_array = '')
	{
		global $cwpOptions;
		if (empty($cwpOptions) || !is_array($cwpOptions)) {
			$cwpOptions = get_option('cwpOptions');
		}
		$return = '';
		if ($handle_as == 'default') {
			$return = $cwpOptions[$setting] ?? '';
		} else {
			if ($handle_as == 'page_url') {
				$return = $cwpOptions[$setting] ?? false;
				if (is_array($return)) {
					$return = $return[$find_array] ?? false;
				}
				if (is_numeric($return)) {
					$return = get_permalink($return);
				}
			} else if ($handle_as == 'media_url') {
				$return = $cwpOptions[$setting] ?? '';
				$return = wp_get_attachment_url($return);
			}
		}
		return apply_filters('thai_get_setting', $return, $setting, $handle_as, $find_array);
	}
}
/**
 * @function thai_theme_support
 *
 * Add Thai Theme features support.
 */
if (!function_exists('thai_theme_support')) {
	function thai_theme_support()
	{
		global $content_width;
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('widgets');
		add_theme_support('html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'navigation-widgets'
		));
		add_theme_support('post-thumbnails', array('Cridio-ad', 'real-estate', 'automotive'));
		add_image_size('thai-grid', 340, 195, true);
		if (!isset($content_width)) {
			$content_width = 900;
		}
	}
	add_filter("after_setup_theme", "thai_theme_support", 11);
}
/**
 * @function thai_register_sidebar_widget_area
 *
 * Register Default Sidebar.
 */
if (!function_exists('thai_register_sidebar_widshow_admin_barget_area')) {
	function thai_register_sidebar_widget_area()
	{
		register_sidebar(array(
			'name'          => esc_html__("Default Sidebar", "thai"),
			'id'            => 'thai_default_sidebar',
			'before_widget' => '<div class="thai-widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5>',
			'after_title'   => '</h5>'
		));
	}
	add_action('widgets_init', 'thai_register_sidebar_widget_area');
}
/**
 * @function thai_register_menu_locations
 *
 * Register WordPress menu locations.
 */
if (!function_exists('thai_register_menu_locations')) {
	function thai_register_menu_locations()
	{
		$menu_locations = array(
			'thai_home_header'     => esc_html__("Home Page Header", "thai"),
			'thai_inner_header'    => esc_html__("Inner Pages Header", "thai"),
		);
		if (function_exists('thai_get_setting')) {
			$sub_footer = thai_get_setting('sub_footer');
			if ($sub_footer) {
				$menu_locations['thai_sub_footer'] = esc_html__("Sub Footer", "thai");
			}
		}
		register_nav_menus($menu_locations);
	}
	add_filter("init", "thai_register_menu_locations", 11);
}
if (!function_exists('thai_register_menu_locations')) {
	function thai_register_menu_locations()
	{
		$menu_locations = array(
			'thai_home_header'     => esc_html__("Home Page Header", "thai"),
			'thai_inner_header'    => esc_html__("Inner Pages Header", "thai"),
		);
		if (function_exists('thai_get_setting')) {
			$sub_footer = thai_get_setting('sub_footer');
			if ($sub_footer) {
				$menu_locations['thai_sub_footer'] = esc_html__("Sub Footer", "thai");
			}
		}
		register_nav_menus($menu_locations);
	}
	add_filter("init", "thai_register_menu_locations", 11);
}
if (!function_exists('get_thai_menus')) {
	function get_thai_menus($menu_location, $class = '')
	{
		$thai_menus = 	wp_nav_menu(
			array(
				'theme_location' => $menu_location,
				'menu_class' => $class
			)
		);
		return $thai_menus;
	}
}
/**
 * @function thai_get_site_logo_url
 *
 * Return site logo image url.
 */
if (!function_exists('thai_get_site_logo_url')) {
	function thai_get_site_logo_url()
	{
		$logo_url = '';
		if (if_theme_can_load()) {
			if (is_front_page() || is_home()) {
				$logo_url = thai_get_setting('home_page_logo', 'media_url');
			} else {
				$logo_url = thai_get_setting('inner_pages_logo', 'media_url');
			}
		}
		if (empty($logo_url)) {
			$logo_url = THAI_URL . 'assets/images/logo.png';
		}
		return $logo_url;
	}
}
/**
 * @function thai_get_page_banner_bg_url
 *
 * Return banner image url for pages.
 */
if (!function_exists('thai_get_page_banner_bg_url')) {
	function thai_get_page_banner_bg_url($page_id)
	{
		$bg_url = get_the_post_thumbnail_url($page_id);
		if (empty($bg_url)) {
			$bg_url = THAI_URL . 'assets/images/banner-bg.jpg';
		}
		return $bg_url;
	}
}
/**
 * @function thai_get_page_banner_bg_url
 *
 * Return banner image url for pages.
 */
if (!function_exists('thai_get_page_banner_bg_url')) {
	function thai_get_page_banner_bg_url($page_id)
	{
		$bg_url = get_the_post_thumbnail_url($page_id);
		if (empty($bg_url)) {
			$bg_url = THAI_URL . 'assets/images/banner-bg.jpg';
		}
		return $bg_url;
	}
}
/**
 * @function thai_breadcrumb
 *
 * Thai Breadcrumb
 */
if (!function_exists('thai_breadcrumb')) {
	function thai_breadcrumb()
	{
		ob_start();
		$sep = '&nbsp;/&nbsp;';
		if (!is_front_page()) {
?>
			<div class="thai-breadcrumbs">
				<a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('Home', 'thai'); ?></a>
				<?php
				echo esc_html($sep);
				if (is_category()) {
					the_category('/');
				} else if (is_page()) {
					the_title();
				} else if (is_single() || is_archive() || is_search() || is_tax() || is_author()) {
					if (is_day()) {
						printf(__('%s', 'thai'), get_the_date());
					} else if (is_month()) {
						printf(__('%s', 'thai'), get_the_date(_x('F Y', 'monthly archives date format', 'thai')));
					} else if (is_year()) {
						printf(__('%s', 'thai'), get_the_date(_x('Y', 'yearly archives date format', 'thai')));
					} else if (is_author()) {
						$queried_object = get_queried_object();
						if (isset($queried_object->display_name)) {
							echo esc_html($queried_object->display_name);
						}
					} else {
						if (is_single()) {
							global $thai_category_taxonomies;
							$post_id       = get_the_ID();
							$post_category = thai_get_post_terms($post_id, $thai_category_taxonomies);
							$post_location = thai_get_post_terms($post_id, array('locations'));
							if (!empty($post_category) && is_array($post_category)) {
								foreach ($post_category as $counter => $term) {
									if ($counter != 0) {
										echo ',&nbsp;';
									}
									echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
								}
								echo esc_html($sep);
							}
							if (!empty($post_location) && is_array($post_location)) {
								foreach ($post_location as $counter => $location) {
									if ($counter != 0) {
										echo ',&nbsp;';
									}
									echo '<a href="' . esc_url(get_term_link($location)) . '">' . esc_html($location->name) . '</a>';
								}
								echo esc_html($sep);
							}
							the_title();
						} else {
							$queried_object = get_queried_object();
							if (!empty($queried_object) && isset($queried_object->name)) {
								if (isset($queried_object->term_id)) {
									echo '<a href="' . esc_url(get_term_link($queried_object->term_id)) . '">';
								}
								if (isset($queried_object->label)) {
									echo esc_html($queried_object->label);
								} else {
									echo esc_html($queried_object->name);
								}
								if (isset($queried_object->term_id)) {
									echo '</a>';
								}
							}
							if (isset($_GET['s']) && !empty($_GET['s'])) {
								echo esc_html($sep);
								printf(__('Search: %s', 'thai'), sanitize_text_field($_GET['s']));
							}
						}
					}
				} else if (is_home()) {
					global $post;
					$page_for_posts_id = get_option('page_for_posts');
					if ($page_for_posts_id) {
						$post = get_post($page_for_posts_id);
						setup_postdata($post);
						the_title();
						rewind_posts();
					}
				}
				?>
			</div>
<?php
		}
		$output = ob_get_clean();
		return apply_filters('thai_breadcrumb', $output);
	}
}
if (!function_exists('thai_get_post_featured_image')) {
	function thai_get_post_featured_image($post_id = 0, $id_only = false, $size = 'medium')
	{
		$return = '';
		if (!$post_id) {
			$post_id = get_the_ID();
		}
		if (has_post_thumbnail($post_id)) {
			if ($id_only) {
				$return = get_post_thumbnail_id($post_id);
			} else {
				$return = get_the_post_thumbnail_url($post_id, $size);
			}
		} else {
			$gallery = get_post_meta($post_id, 'Cridio_gallery', true);
			$gallery = $gallery['meta_value'] ?? '';
			if (!empty($gallery) && is_array($gallery)) {
				foreach ($gallery as $galleryItemID) {
					if ($id_only) {
						$return = $galleryItemID;
					} else {
						$return = wp_get_attachment_url($galleryItemID);
					}
					break;
				}
			}
		}
		if (empty($return)) {
			$return = thai_get_setting('default_featured_image', 'media_url');
		}
		if (empty($return)) {
			$return = THAI_URL . 'assets/images/placeholder.png';
		}
		return $return;
	}
}
/**
 * @function thai_estimate_reading_time
 *
 * Thai Estimate Post Read Time
 */
if (!function_exists('thai_estimate_reading_time')) {
	function thai_estimate_reading_time($content, $words_per_minute = 200)
	{
		if (has_blocks($content)) {
			$blocks      = parse_blocks($content);
			$contentHtml = '';
			if (!empty($blocks)) {
				foreach ($blocks as $block) {
					$contentHtml .= render_block($block);
				}
			}
			$content = $contentHtml;
		}
		$content = wp_strip_all_tags($content);
		if (!$content) {
			return 0;
		}
		$words_count = str_word_count($content);
		return ceil($words_count / $words_per_minute);
	}
}
/**
 * Return google font api url for given google font families.
 *
 * @param Array $families.
 *
 * @since  1.0.11
 */
if (!function_exists('thai_build_google_font_api_url')) {
	function thai_build_google_font_api_url($families)
	{
		foreach ($families as &$family) {
			$family = str_replace(' ', '+', $family) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
		}
		$fonts_url = sprintf('https://fonts.googleapis.com/css?family=%1$s%2$s', implode(rawurlencode('|'), $families), '&display=swap');
		$subsets = array(
			'cs_CZ' => 'latin-ext',
			'ro_RO' => 'latin-ext',
			'pl_PL' => 'latin-ext',
			'sk_SK' => 'latin-ext',
			'hr_HR' => 'latin-ext',
			'hu_HU' => 'latin-ext',
			'tr_TR' => 'latin-ext',
			'lt_LT' => 'latin-ext',
			'el'    => 'greek',
			'uk'    => 'cyrillic',
			'vi'    => 'vietnamese',
			'ru_RU' => 'cyrillic',
			'bg_BG' => 'cyrillic',
			'he_IL' => 'hebrew',
		);
		$subsets = apply_filters('thai/google_font/subsets', $subsets);
		$locale = get_locale();
		if (isset($subsets[$locale])) {
			$fonts_url .= '&subset=' . $subsets[$locale];
		}
		return $fonts_url;
	}
}
/**
 * Class Thai: Loads Thai theme configurations.
 *
 * @since  1.0.0
 */
if (!function_exists('thai')) {
	function thai()
	{
		if (if_theme_can_load()) {
			return Thai::instance();
		}
		return array();
	}
	thai();
}
/**
 * Get post type and taxonomy groups
 *
 * @param string $type Post Type Slug.
 * @param int $term term id.
 *
 * @return array  array of custom field names.
 */
if (!function_exists("cwp_get_groups_by_term")) {
	function cwp_get_groups_by_term($type = '', $term = 0)
	{
		if ($type == '' || $term == 0) {
			return;
		}
		$groups = cwp_get_groups_by_post_type($type);
		if (isset($groups) && !empty($groups)) {
			$output = array();
			foreach ($groups as $group) {
				$terms  = get_post_meta($group, '_cwp_group_terms', true);
				$terms  = isset($terms) && !empty($terms) ? explode(',', $terms) : array();
				if (count($terms) > 0 && in_array($term, $terms)) {
					$fields = get_post_meta($group, '_cwp_group_fields', true);
					$output[$group] = isset($fields) && !empty($fields) ? explode(',', $fields) : array();
				}
			}
		}
		return $output;
	}
}
function theme_name_widgets_init()
{
	$footer_column = thai_get_setting('footer_column');
	for ($i = 1; $i <= $footer_column; $i++) {
		register_sidebar(array(
			'name'          => esc_html__('Footer Widget ' . $i, 'theme-name'),
			'id'            => 'thai_footer_column-' . $i,
			'description'   => esc_html__('Add widgets here for the footer column ' . $i, 'theme-name'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		));
	}
}
add_action('widgets_init', 'theme_name_widgets_init');
if (!function_exists("format_number")) {
	function format_number($value)
	{
		$suffix = '';
		if ($value == 0 || empty($value)) {
			return '0';
		} elseif ($value >= 1000000000) {
			$value /= 1000000000;
			$suffix = ' B';
		} elseif ($value >= 1000000) {
			$value /= 1000000;
			$suffix = ' M';
		} elseif ($value >= 0) { // Change this condition to include values greater than 0 and less than 1000
			$value /= 1000;
			$suffix = ' K';
		}
		return number_format($value, 2) . $suffix;
	}
}
function search_startups_callback()
{
	$keyword = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
	if (!empty($keyword)) {
		$per_page = -1;
	} else {
		$per_page = 3;
	}
	$args = array(
		'post_type'      => 'startup',
		'posts_per_page' => $per_page,
		's'              => $keyword,
		'post_status'    => 'publish',
	);
	$response = array(
		'success' => true,
		'message' => 'Data loaded successfully!',
		'html' => ''
	);
	ob_start();
	$query = new WP_Query($args);
	$count = 0;
	if ($query->have_posts()) {
		while ($query->have_posts() && $count < 3) {
			$query->the_post();
			$thumbnail_uri = thai_get_post_featured_image(get_the_ID());
			$title = get_the_title();
			$url = get_permalink(get_the_ID());
			echo "<li><a href='$url'><img src='$thumbnail_uri' alt='$title'>$title</a></li>";
			$count++;
		}
		if ($query->found_posts > 3) {
			$search_url = home_url().'/?post_type=startup&s='.$keyword.'';
			echo "<li class='view-more-buttons'><a href='$search_url'>".esc_html__('View more' , 'wedding')." <i class='fa-solid fa-chevron-down'></i></a></li>";
		}
	} else {
		echo "<li>No results found.</li>";
	}
	$response['html'] = ob_get_clean();
	// Return the response as JSON
	wp_send_json($response);
}
add_action('wp_ajax_search_startups', 'search_startups_callback');
add_action('wp_ajax_nopriv_search_startups', 'search_startups_callback');
