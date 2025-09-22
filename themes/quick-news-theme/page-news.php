<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

// Create a custom WP_Query array that fetches 12 blog posts 
// ordered by their ID in descending order (newest first).
$query = array(
  'post_type' => 'post',
  'orderby' => 'ID',
  'order' => 'DESC',
  'posts_per_page' => '12'
);

// Add the custom query results to the Timber context as 'posts',
// making them available inside the Twig template (looping through posts).
$context['posts'] = Timber::get_posts($query);

$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

// Render the appropriate Twig template for the current page,
// passing along the $context which now includes 'posts' and 'post'.
Timber::render(array('pages/' . $timber_post->post_name . '.twig', 'page.twig'), $context);