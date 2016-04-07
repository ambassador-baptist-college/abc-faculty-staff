<?php

// WP_Query arguments
$general_args = array (
	'post_type'              => array( 'faculty' ),
	'posts_per_page'         => '-1',
	'order'                  => 'ASC',
);

// administration
$administration_args = array (
    'orderby'                => 'menu_order',
    'tax_query'              => array(
        array(
            'taxonomy'  => 'faculty-category',
            'field'     => 'slug',
            'terms'     => 'administration',
        ),
    ),
);
display_faculty_staff( $general_args, $administration_args );

// faculty
$faculty_args = array (
    'orderby'                => 'meta_value',
    'meta_key'               => 'last_name',
    'tax_query'              => array(
        array(
            'taxonomy'  => 'faculty-category',
            'field'     => 'slug',
            'terms'     => 'faculty',
        ),
    ),
);
display_faculty_staff( $general_args, $faculty_args );

// administration
$staff_args = array (
    'orderby'                => 'meta_value',
    'meta_key'               => 'last_name',
    'tax_query'              => array(
        array(
            'taxonomy'  => 'faculty-category',
            'field'     => 'slug',
            'terms'     => 'staff',
        ),
    ),
);
display_faculty_staff( $general_args, $staff_args );

function display_faculty_staff( $general_args, $specific_args ) {
    global $post;
    $args = array_merge( $general_args, $specific_args );

    // The Query
    $faculty_query = new WP_Query( $args );

    // The Loop
    if ( $faculty_query->have_posts() ) {
        echo '<h2>' . ucwords( $faculty_query->query['tax_query'][0]['terms'] ) . '</h2>';
    	while ( $faculty_query->have_posts() ) {
    		$faculty_query->the_post();
            echo '<section id="' . $post->post_name . '" class="faculty-member">';
            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'faculty', array( 'class' => 'alignleft' ) );
            }
    		echo '<h3>' . get_the_title() . '</h3>';
            if ( get_field('position') ) {
                echo '<h4 class="position">' . get_field( 'position' ) . '</h4>';
            }
            if ( get_field( 'teacher_type' ) || get_field( 'department' ) ) {
                echo '<h4 class="subjects">';
                if ( get_field( 'teacher_type' ) ) {
                    the_field( 'teacher_type' );
                }
                if ( get_field( 'department' ) ) {
                    echo ': ' . get_field( 'department' );
                }
                echo '</h4>';
            }
            if ( get_field('qualifications') ) {
                the_field( 'qualifications' );
            }
            if ( get_field( 'email_address' ) ) {
                echo '<p>Email: <a href="mailto:' . antispambot( get_field( 'email_address' ) ) . '">' . antispambot( get_field( 'email_address' ) )  . '</a></p>';
            }
            echo '</section>';
    	}
    } else {
    	// no posts found
    }

    // Restore original Post Data
    wp_reset_postdata();
}
