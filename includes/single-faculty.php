<?php
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
