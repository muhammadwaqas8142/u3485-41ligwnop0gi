<?php

namespace Elementor_Announcements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
class Data_Stats extends Widget_Base
{
    public function get_name()
    {
        return 'Data_Stats';
    }
    public function get_title()
    {
        return __('Thai Data Stats', 'elementor-thai');
    }
    public function get_icon()
    {
        return 'eicon-posts-ticker';
    }
    public function get_categories()
    {
        return ['thai'];
    }
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'elementor-thai'),
            ]
        );
        $this->add_control('thai_states_type', array(
            'type' => Controls_Manager::SELECT,
            'label' => esc_html__('Select Stats type', 'thai'),
            'options' => array(
                '0' => esc_html__('Startups', 'thai'),
                '1' => esc_html__('Investors', 'thai'),
                '2' => esc_html__('Industries', 'thai'),
            ),
            'default' => '0',
        ));
        $this->add_control('thai_taxonomy', array(
            'type' => Controls_Manager::SELECT2,
            'label' => esc_html__('Select Taxonomy', 'thai'),
            'options' => cwp_taxonomies(),
            'default' => array(),
            'condition' => array(
                'thai_states_type' => '2',
            ),
        ));
        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        echo render_thai_stats($settings);
    }
}
function render_thai_stats($atts)
{
    // Extract shortcode attributes
    extract(shortcode_atts(array(
        'thai_states_type' => '',
        'thai_taxonomy' => '',
    ), $atts));
?>
    <?php
    if ($thai_states_type == "0") {
        $startup_post_count = wp_count_posts('startup')->publish;
    ?>
        <div class="thai-single-stat-data">
            <div class="single-stat-headings">
                <h3><?php echo esc_html__('Startups', 'Thai') ?></h3>
                <a href="<?php echo esc_url(home_url() . '/startup') ?>"><?php echo esc_html__('See All', 'Thai') ?></a>
            </div>
            <div class="single-stat">
                <h2 class="number"><?php echo  $startup_post_count; ?></h2>
                <img src="<?php echo esc_url(THAI_URL . 'assets/images/startups-Image.svg'); ?>" alt="image">
            </div>
        </div>
    <?php
    } else   if ($thai_states_type == "1") {
        $investment_post_count = wp_count_posts('investment')->publish;
    ?>
        <div class="thai-single-stat-data">
            <div class="single-stat-headings">
                <h3><?php echo esc_html__('Investors', 'Thai') ?></h3>
                <!-- TODO: uncomment when has more than 1 investors -->
            <a href="<?php echo esc_url(home_url() . '/investment') ?>"><?php echo esc_html__('See All', 'Thai') ?></a> 
            </div>
            <div class="single-stat">
                <h2 class="number"><?php echo  $investment_post_count; ?></h2>
                <img src="<?php echo esc_url(THAI_URL . 'assets/images/investment-Image.svg'); ?>" alt="image">
            </div>
        </div>
    <?php
    } else   if ($thai_states_type == "2") {

        $investment_post_count = wp_count_posts('investment')->publish;
        $terms_args = array(
            'taxonomy' => $thai_taxonomy,
            'hide_empty' => false,
        );
        $terms = get_terms($terms_args);
        $first_term = $terms[0];
        $archive_url = get_term_link($first_term);
        $first_three_terms = array_slice($terms, 0, 11); 
        $total_count = 0;
        foreach ($first_three_terms as $term) {
            $total_count += $term->count;
        }

        // Calculate percentage for each term
        $colors = [
            'rgba(249, 65, 68, 1)', 'rgba(109, 89, 122, 1)', 'rgba(55, 114, 255, 1)', 'rgba(249, 132, 74, 1)', 'rgba(249, 199, 79, 1)',
            'rgba(144, 190, 109, 1)', 'rgba(67, 170, 139, 1)', 'rgba(77, 144, 142, 1)', 'rgba(87, 117, 144, 1)', 'rgba(236, 217, 154, 1)', 'rgba(39, 125, 161, 1)'
        ];
        $color_percentages = [];
        $count_posts = wp_count_posts('startup');
        $published_count = $count_posts->publish;
        foreach ($first_three_terms as $index => $term) {
            $percentage = round(($term->count / $published_count) * 100);
            if ($percentage === 0) {
                $percentage = rand(1, 2);
            }
            $color_percentages[] = $percentage;
            if ($percentage > 100) {
                $term->color = $colors[count($colors) - $index - 1];
            } else {
                $term->color = $colors[$index];
            }
        }

    ?>


        <div class="thai-single-stat-data">

            <div class="single-stat-headings">
                <h3><?php echo esc_html__('Industries', 'Thai'); ?></h3>
            </div>

            <div class="single-stat graph">
                <div id="target">
                </div>
                <?php
                echo '<ul id="source">';
                foreach ($first_three_terms as $index => $term) {
                    echo "<li class='pieChart' data-colors='$term->color' value='$color_percentages[$index]'><span style='background-color: $term->color;'></span> $term->name <p>$term->count</p></li>";
                }
                echo '<li class="pieCharts"><a href="'.$archive_url.'">'.esc_html__('See All' , 'Thai').' <i class="fa-solid fa-chevron-down"></i></a></li>';
                echo '</ul>';
                ?>
            </div>
        </div>
<?php
    }
}
