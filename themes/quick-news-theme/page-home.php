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

$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

// Handle the top_story ACF field
$top_story = get_field('top_story', $timber_post->ID);
if ($top_story) {
  // Convert to Timber\Post object
  $context['top_story'] = Timber::get_post($top_story);
} else {
  $context['top_story'] = null; // Avoid errors in Twig
}

// Handle the featured_news ACF field (array of posts)
$featured_news = get_field('featured_news', $timber_post->ID);
if ($featured_news) {
  $context['featured_news'] = Timber::get_posts($featured_news);
} else {
  $context['featured_news'] = [];
}

// get the 'events' category by it's id which is 13
$context['events'] = Timber::get_term(13);

// get the 'sport' category by it's id which is 7
$context['sport'] = Timber::get_term(7);

// get the 'animals' category by it's id which is 2
$context['animals'] = Timber::get_term(2);

// get the 'architecture' category by it's id which is 11
$context['architecture'] = Timber::get_term(11);


// get the 'promotion' taxonomy  by the home id which is 18
$context['promoted_people'] =  Timber::get_term(18);



Timber::render(array('pages/' . $timber_post->post_name . '.twig', 'page.twig'), $context);