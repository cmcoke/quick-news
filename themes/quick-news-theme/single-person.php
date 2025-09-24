<?php

/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;


/**
 * Get the current logged-in user
 *
 * - We cannot use `new Timber\User()` directly because its constructor is protected.
 * - Instead, Timber provides the static method `Timber::get_user()`, which safely
 *   returns the current logged-in user as a `Timber\User` object.
 * - If no user is logged in, it will return `null`.
 */
$context['user'] = Timber::get_user();


// Get the "favourite_places" ACF field (this might return null, array of IDs, or array of WP_Post objects)
$fav_places = get_field('favourite_places');

// Only run Timber::get_posts() if the field actually has values
if ($fav_places) {
  // Convert the ACF field values (IDs/objects) into Timber\Post objects so they can be used in Twig
  $context['favourite_places'] = Timber::get_posts($fav_places);
} else {
  // If no favourite places are selected, pass an empty array to Twig
  // This prevents errors or notices when Twig tries to loop over the variable
  $context['favourite_places'] = [];
}

// get 5 random people
$query = array(
  'post_type' => 'person',
  'orderby' => 'rand',
  'posts_per_page' => '5'
);
$context['people'] =  Timber::get_posts($query);

if (post_password_required($timber_post->ID)) {
  Timber::render('single-password.twig', $context);
} else {
  Timber::render(array(
    'posts/' . $timber_post->ID . '.twig',
    'posts/' . $timber_post->post_type . '.twig',
    'posts/' . $timber_post->slug . '.twig',
    'single.twig'
  ), $context);
}