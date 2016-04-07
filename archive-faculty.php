<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h1 class="page-title">
                <?php
                    if ( is_taxonomy( 'type' ) ) {
                        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                        echo $term->name;
                    } elseif ( is_post_type_archive( 'faculty' ) ) {
                        echo 'Faculty and Staff';
                    }
                ?>
                </h1>
                <?php
                    if ( is_taxonomy( 'type' ) ) {
                        echo '<p><a href="' . home_url() . '/about-us/faculty-and-staff/">Back to all faculty and staff</a></p>';
                    }
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>
            </header><!-- .page-header -->

        <?php
            include( 'includes/faculty-staff.php' );
        endif;
        ?>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
