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

// Get the taxonomy term "food"
$context['place_term'] = Timber::get_term_by('name', 'food');

// Get all people posts
$people = Timber::get_posts([
  'post_type'      => 'person',
  'posts_per_page' => -1,
]);

// Build a map: place_id => array of people
$place_people_map = [];

foreach ($people as $person) {
  $fav_places = get_field('favourite_places', $person->ID);
  if ($fav_places) {
    foreach ($fav_places as $fav_place) {
      $place_people_map[$fav_place->ID][] = $person;
    }
  }
}

// Add people and the mapping to Twig context
$context['people'] = $people;
$context['place_people_map'] = $place_people_map;

// Get current page
$context['post'] = Timber::get_post();

Timber::render('pages/places.twig', $context);