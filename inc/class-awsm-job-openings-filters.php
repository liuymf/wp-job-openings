<?php
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AWSM_Job_Openings_Filters {
    private static $_instance = null;

    public function __construct( ) {
        add_action( 'awsm_filter_form', array( $this, 'display_filter_form' ) );
        add_action( 'wp_ajax_jobfilter', array( $this,'awsm_posts_filters' ) );
        add_action( 'wp_ajax_nopriv_jobfilter',  array( $this,'awsm_posts_filters') );
        add_action( 'wp_ajax_loadmore', array( $this,'awsm_posts_filters' ) );
        add_action( 'wp_ajax_nopriv_loadmore', array( $this,'awsm_posts_filters') );
    }

    public static function init() {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function display_filter_form() {
        if( get_option( 'awsm_enable_job_filter_listing' ) !== 'enabled' ) {
            return;
        }
        if( is_archive() && ! is_post_type_archive( 'awsm_job_openings' ) ) {
            return;
        }
        $filter_content = '';
        $filter_suffix = '_filter';
        $taxonomies = get_object_taxonomies( 'awsm_job_openings', 'objects' );
        $available_filters = get_option( 'awsm_jobs_listing_available_filters' );
        $selected_filters = array();
        foreach( $available_filters as $available_filter ) {
            $current_filter_key = str_replace( '-', '__', $available_filter ) . $filter_suffix;
            if( isset( $_GET[$current_filter_key] ) ) {
                $selected_filters[$available_filter] = intval( $_GET[$current_filter_key] );
            }
        }
        $available_filters_arr = array();
        if( ! empty(  $taxonomies ) && ! empty( $available_filters ) ) {
            foreach( $taxonomies as $taxonomy => $tax_details ) {
                if( in_array( $taxonomy, $available_filters ) ) {
                    $terms = get_terms( $taxonomy, 'orderby=name&hide_empty=1' );
                    if( ! empty( $terms ) ) {
                            $available_filters_arr[$taxonomy] = $tax_details->label;
                            $options_content = '';
                            foreach ( $terms as $term ) {
                                $selected = '';
                                if( in_array( $taxonomy, array_keys( $selected_filters ) ) && $selected_filters[$taxonomy] === $term->term_id ) {
                                    $selected = ' selected';
                                }
                                $options_content .= sprintf( '<option value="%1$s"%3$s>%2$s</option>', esc_attr( $term->term_id ), esc_html( $term->name ), esc_attr( $selected ) );
                            }
                            $filter_key = str_replace( '-', '__', $taxonomy );
                            $filter_content .= sprintf( '<div class="awsm-filter-item" data-filter="%2$s"><select name="awsm_job_spec[%1$s]" class="awsm-filter-option" id="awsm-%1$s-filter-option"><option value="">%3$s</option>%4$s</select></div>', esc_attr( $taxonomy ), esc_attr( $filter_key . $filter_suffix ), esc_html__( 'All ', 'wp-job-openings' ) . esc_html( $tax_details->label ), $options_content );
                    }
                }
            }
            if( ! empty( $filter_content ) ) {
                $filter_content = sprintf( '<div class="awsm-filter-wrap"><form action="%2$s/wp-admin/admin-ajax.php" method="POST" id="awsm-job-filter">%1$s<input type="hidden" name="action" value="jobfilter"></form></div>', $filter_content, site_url() );
            }
        }
        echo apply_filters( 'awsm_filter_content', $filter_content, $available_filters_arr );
    }

    public function awsm_posts_filters() {
        $filters = array();
        if( isset( $_POST['awsm_job_spec'] ) && ! empty( $_POST['awsm_job_spec'] ) ) {
            $job_specs = $_POST['awsm_job_spec'];
            foreach( $job_specs as $taxonomy => $term_id ) {
                $taxonomy = sanitize_text_field( $taxonomy );
                $filters[$taxonomy] = intval( $term_id );
            }
        }

        $args = AWSM_Job_Openings::awsm_job_query_args( $filters );

        if( isset( $_POST['paged'] ) ) {
            $args['paged'] = intval( $_POST['paged'] ) + 1;
        }

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
            include AWSM_Job_Openings::get_template_path( 'main.php', 'job-openings' );
        else :
            if( $_POST['action'] !== 'loadmore' ) :
        ?>
                <div class="awsm-jobs-none-container">
                    <p><?php esc_html_e( 'Sorry! No jobs to show.', 'wp-job-openings' ); ?></p>
                </div>
        <?php
            else:
        ?>
                <div class="awsm-load-more-main awsm-no-more-jobs-container">
                    <p><?php esc_html_e( 'Sorry! No more jobs to show.', 'wp-job-openings' ); ?></p>
                </div>
        <?php
            endif;
        endif;
        wp_die();
    }
}