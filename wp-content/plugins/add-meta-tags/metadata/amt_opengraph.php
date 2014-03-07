<?php
/**
 *  This file is part of the Add-Meta-Tags distribution package.
 *
 *  Add-Meta-Tags is an extension for the WordPress publishing platform.
 *
 *  Homepage:
 *  - http://wordpress.org/plugins/add-meta-tags/
 *  Documentation:
 *  - http://www.codetrax.org/projects/wp-add-meta-tags/wiki
 *  Development Web Site and Bug Tracker:
 *  - http://www.codetrax.org/projects/wp-add-meta-tags
 *  Main Source Code Repository (Mercurial):
 *  - https://bitbucket.org/gnotaras/wordpress-add-meta-tags
 *  Mirror repository (Git):
 *  - https://github.com/gnotaras/wordpress-add-meta-tags
 *  Historical plugin home:
 *  - http://www.g-loaded.eu/2006/01/05/add-meta-tags-wordpress-plugin/
 *
 *  Licensing Information
 *
 *  Copyright 2006-2013 George Notaras <gnot@g-loaded.eu>, CodeTRAX.org
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 *  The NOTICE file contains additional licensing and copyright information.
 */


/**
 * Opengraph Protocol Metadata
 * Opengraph Specification: http://ogp.me
 *
 * Module containing functions related to Opengraph Protocol Metadata
 */


/**
 * Add contact method for Facebook author and publisher.
 */
function amt_add_facebook_contactmethod( $contactmethods ) {
    // Add Facebook Author Profile URL
    if ( !isset( $contactmethods['amt_facebook_author_profile_url'] ) ) {
        $contactmethods['amt_facebook_author_profile_url'] = __('Facebook author profile URL', 'add-meta-tags') . ' (AMT)';
    }
    // Add Facebook Publisher Profile URL
    if ( !isset( $contactmethods['amt_facebook_publisher_profile_url'] ) ) {
        $contactmethods['amt_facebook_publisher_profile_url'] = __('Facebook publisher profile URL', 'add-meta-tags') . ' (AMT)';
    }

    // Remove test
    // if ( isset( $contactmethods['test'] ) {
    //     unset( $contactmethods['test'] );
    // }

    return $contactmethods;
}
add_filter( 'user_contactmethods', 'amt_add_facebook_contactmethod', 10, 1 );


/**
 * Generates Opengraph metadata.
 *
 * Currently for:
 * - home page
 * - author archive
 * - content
 */
function amt_add_opengraph_metadata_head( $post, $attachments, $embedded_media, $options ) {

    $do_auto_opengraph = (($options["auto_opengraph"] == "1") ? true : false );
    if (!$do_auto_opengraph) {
        return array();
    }

    $metadata_arr = array();


    // Default front page displaying the latest posts
    if ( amt_is_default_front_page() ) {

        // Type
        $metadata_arr[] = '<meta property="og:type" content="website" />';
        // Site Name
        $metadata_arr[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo('name') ) . '" />';
        // Title - Note: Contains multipage information through amt_process_paged()
        $metadata_arr[] = '<meta property="og:title" content="' . esc_attr( amt_process_paged( get_bloginfo('name') ) ) . '" />';
        // URL - Note: different method to get the permalink on paged archives
        if ( is_paged() ) {
            $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_pagenum_link( get_query_var('paged') ) ) . '" />';
        } else {
            $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_bloginfo('url') ) . '" />';
        }
        // Site description - Note: Contains multipage information through amt_process_paged()
        if (!empty($options["site_description"])) {
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( amt_process_paged( $options["site_description"] ) ) . '" />';
        } elseif (get_bloginfo('description')) {
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( amt_process_paged( get_bloginfo('description') ) ) . '" />';
        }
        // Locale
        $metadata_arr[] = '<meta property="og:locale" content="' . esc_attr( str_replace('-', '_', get_bloginfo('language')) ) . '" />';
        // Site Image
        // Use the default image, if one has been set.
        if (!empty($options["default_image_url"])) {
            $metadata_arr[] = '<meta property="og:image" content="' . esc_url_raw( $options["default_image_url"] ) . '" />';
        }


    // Front page using a static page
    // Note: might also contain a listing of posts which may be paged, so use amt_process_paged()
    } elseif ( amt_is_static_front_page() ) {

        // Type
        $metadata_arr[] = '<meta property="og:type" content="website" />';
        // Site Name
        $metadata_arr[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo('name') ) . '" />';
        // Title - Note: Contains multipage information through amt_process_paged()
        $metadata_arr[] = '<meta property="og:title" content="' . esc_attr( amt_process_paged( get_the_title($post->ID) ) ) . '" />';
        // URL - Note: different method to get the permalink on paged archives
        if ( is_paged() ) {
            $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_pagenum_link( get_query_var('paged') ) ) . '" />';
        } else {
            $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_bloginfo('url') ) . '" />';
        }
        // Site Description - Note: Contains multipage information through amt_process_paged()
        $content_desc = amt_get_content_description($post);
        if ( !empty($content_desc) ) {
            // Use the pages custom description
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( amt_process_paged( $content_desc ) ) . '" />';
        } elseif (get_bloginfo('description')) {
            // Alternatively use the blog's description
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( amt_process_paged( get_bloginfo('description') ) ) . '" />';
        }
        // Locale
        $metadata_arr[] = '<meta property="og:locale" content="' . esc_attr( str_replace('-', '_', get_bloginfo('language')) ) . '" />';
        // Site Image
        if ( function_exists('has_post_thumbnail') && has_post_thumbnail( $post->ID ) ) {
            $metadata_arr = array_merge( $metadata_arr, amt_get_opengraph_image_metatags( get_post_thumbnail_id( $post->ID ) ) );
        } elseif (!empty($options["default_image_url"])) {
            // Alternatively, use default image
            $metadata_arr[] = '<meta property="og:image" content="' . esc_url_raw( $options["default_image_url"] ) . '" />';
        }


    // The posts index page - a static page displaying the latest posts
    } elseif ( amt_is_static_home() ) {

        // Type
        $metadata_arr[] = '<meta property="og:type" content="website" />';
        // Site Name
        $metadata_arr[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo('name') ) . '" />';
        // Title - Note: Contains multipage information through amt_process_paged()
        $metadata_arr[] = '<meta property="og:title" content="' . esc_attr( amt_process_paged( get_the_title($post->ID) ) ) . '" />';
        // URL - Note: different method to get the permalink on paged archives
        if ( is_paged() ) {
            $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_pagenum_link( get_query_var('paged') ) ) . '" />';
        } else {
            $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_permalink($post->ID) ) . '" />';
        }
        // Site Description - Note: Contains multipage information through amt_process_paged()
        $content_desc = amt_get_content_description($post);
        if ( !empty($content_desc) ) {
            // Use the pages custom description
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( amt_process_paged( $content_desc ) ) . '" />';
        } elseif (get_bloginfo('description')) {
            // Alternatively use a generic description
            $metadata_arr[] = '<meta property="og:description" content="' . amt_process_paged( "An index of the lastest content." ) . '" />';
        }
        // Locale
        $metadata_arr[] = '<meta property="og:locale" content="' . esc_attr( str_replace('-', '_', get_bloginfo('language')) ) . '" />';
        // Site Image
        if ( function_exists('has_post_thumbnail') && has_post_thumbnail( $post->ID ) ) {
            $metadata_arr = array_merge( $metadata_arr, amt_get_opengraph_image_metatags( get_post_thumbnail_id( $post->ID ) ) );
        } elseif (!empty($options["default_image_url"])) {
            // Alternatively, use default image
            $metadata_arr[] = '<meta property="og:image" content="' . esc_url_raw( $options["default_image_url"] ) . '" />';
        }


    // Author archive. First page is considered a profile page.
    } elseif ( is_author() ) {

        // Author object
        // NOTE: Inside the author archives `$post->post_author` does not contain the author object.
        // In this case the $post (get_queried_object()) contains the author object itself.
        // We also can get the author object with the following code. Slug is what WP uses to construct urls.
        // $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
        // Also, ``get_the_author_meta('....', $author)`` returns nothing under author archives.
        // Access user meta with:  $author->description, $author->user_email, etc
        // $author = get_queried_object();
        $author = $post;

        // Type
        if ( ! is_paged() ) {
            // We treat the first page of the archive as a profile
            $metadata_arr[] = '<meta property="og:type" content="profile" />';
        } else {
            $metadata_arr[] = '<meta property="og:type" content="website" />';
        }
        // Site Name
        $metadata_arr[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo('name') ) . '" />';
        // Title - Note: Contains multipage information through amt_process_paged()
        if ( ! is_paged() ) {
            // We treat the first page of the archive as a profile
            $metadata_arr[] = '<meta property="og:title" content="' . esc_attr( $author->display_name ) . ' profile page" />';
        } else {
            $metadata_arr[] = '<meta property="og:title" content="' . esc_attr( amt_process_paged( "Content published by " . $author->display_name ) ) . '" />';
        }
        // URL - Note: different method to get the permalink on paged archives
        // If a Facebook author profile URL has been provided, it has priority,
        // Otherwise fall back to the WordPress author archive.
        $fb_author_url = $author->amt_facebook_author_profile_url;
        if ( !empty($fb_author_url) ) {
            $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( $fb_author_url, array('http', 'https') ) . '" />';
        } else {
            if ( is_paged() ) {
                $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_pagenum_link( get_query_var('paged') ) ) . '" />';
            } else {
                $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_author_posts_url( $author->ID ) ) . '" />';
            }
        }
        // description - Note: Contains multipage information through amt_process_paged()
        if ( is_paged() ) {
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( amt_process_paged( "Content published by " . $author->display_name ) ) . '" />';
        } else {
            // Here we sanitize the provided description for safety
            // We treat the first page of the archive as a profile
            $author_description = sanitize_text_field( amt_sanitize_description( $author->description ) );
            if ( empty($author_description) ) {
                $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( "Content published by " . $author->display_name ) . '" />';
            } else {
                $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( $author_description ) . '" />';
            }
        }
        // Locale
        $metadata_arr[] = '<meta property="og:locale" content="' . esc_attr( str_replace('-', '_', get_bloginfo('language')) ) . '" />';
        // Profile Image
        // Try to get the gravatar
        // Note: We do not use the get_avatar() function since it returns an img element.
        // Here we do not check if "Show Avatars" is unchecked in Settings > Discussion
        $author_email = sanitize_email( $author->user_email );
        if ( !empty( $author_email ) ) {
            // Contruct gravatar link
            $gravatar_size = 128;
            $gravatar_url = "http://www.gravatar.com/avatar/" . md5( $author_email ) . "?s=" . $gravatar_size;
            $metadata_arr[] = '<meta property="og:image" content="' . esc_url_raw( $gravatar_url ) . '" />';
            $metadata_arr[] = '<meta property="og:imagesecure_url" content="' . esc_url_raw( str_replace('http:', 'https:', $gravatar_url ) ) . '" />';
            $metadata_arr[] = '<meta property="og:image:width" content="' . esc_attr( $gravatar_size ) . '" />';
            $metadata_arr[] = '<meta property="og:image:height" content="' . esc_attr( $gravatar_size ) . '" />';
            $metadata_arr[] = '<meta property="og:image:type" content="image/jpeg" />';
        }
        // Profile data (only on the 1st page of the archive)
        if ( ! is_paged() ) {
            // Profile first and last name
            $last_name = $author->last_name;
            if ( !empty($last_name) ) {
                $metadata_arr[] = '<meta property="profile:last_name" content="' . esc_attr( $last_name ) . '" />';
            }
            $first_name = $author->first_name;
            if ( !empty($first_name) ) {
                $metadata_arr[] = '<meta property="profile:first_name" content="' . esc_attr( $first_name ) . '" />';
            }
        }


    // Attachments
    } elseif ( is_attachment() ) {

        $mime_type = get_post_mime_type( $post->ID );
        //$attachment_type = strstr( $mime_type, '/', true );
        // See why we do not use strstr(): http://www.codetrax.org/issues/1091
        $attachment_type = preg_replace( '#\/[^\/]*$#', '', $mime_type );

        // First add metadata common to all attachment types.

        // Type
        // Note: there is no specific type for images/videos/audio. We use article.
        // TODO: Check whether we could use another type specific to each attachment type.
        $metadata_arr[] = '<meta property="og:type" content="article" />';
        // Site Name
        $metadata_arr[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo('name') ) . '" />';
        // Title
        $metadata_arr[] = '<meta property="og:title" content="' . esc_attr( get_the_title($post->ID) ) . '" />';
        // URL
        $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( get_permalink($post->ID) ) . '" />';
        // Description - We use the description defined by Add-Meta-Tags
        $content_desc = amt_get_content_description($post);
        if ( !empty($content_desc) ) {
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( $content_desc ) . '" />';
        }
        // Locale
        $metadata_arr[] = '<meta property="og:locale" content="' . esc_attr( str_replace('-', '_', get_bloginfo('language')) ) . '" />';
        // Dates
        $metadata_arr[] = '<meta property="article:published_time" content="' . esc_attr( amt_iso8601_date($post->post_date) ) . '" />';
        $metadata_arr[] = '<meta property="article:modified_time" content="' . esc_attr( amt_iso8601_date($post->post_modified) ) . '" />';
        // Author
        // If a Facebook author profile URL has been provided, it has priority,
        // Otherwise fall back to the WordPress author archive.
        $fb_author_url = get_the_author_meta('amt_facebook_author_profile_url', $post->post_author);
        if ( !empty($fb_author_url) ) {
            $metadata_arr[] = '<meta property="article:author" content="' . esc_url_raw( $fb_author_url, array('http', 'https', 'mailto') ) . '" />';
        } else {
            $metadata_arr[] = '<meta property="article:author" content="' . esc_url_raw( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ) . '" />';
        }
        // Publisher
        // If a Facebook publisher profile URL has been provided, it has priority,
        // Otherwise fall back to the WordPress blog home url.
        $fb_publisher_url = get_the_author_meta('amt_facebook_publisher_profile_url', $post->post_author);
        if ( !empty($fb_publisher_url) ) {
            $metadata_arr[] = '<meta property="article:publisher" content="' . esc_url_raw( $fb_publisher_url, array('http', 'https', 'mailto') ) . '" />';
        } else {
            $metadata_arr[] = '<meta property="article:publisher" content="' . esc_url_raw( get_bloginfo('url') ) . '" />';
        }

        // Metadata specific to each attachment type

        if ( 'image' == $attachment_type ) {

            $metadata_arr = array_merge( $metadata_arr, amt_get_opengraph_image_metatags( $post->ID, $size='large' ) );

        } elseif ( 'video' == $attachment_type ) {
            
            // Video tags
            $metadata_arr[] = '<meta property="og:video" content="' . esc_url_raw( $post->guid ) . '" />';
            //$metadata_arr[] = '<meta property="og:video:secure_url" content="' . esc_url_raw( str_replace('http:', 'https:', $main_size_meta[0]) ) . '" />';
            //$metadata_arr[] = '<meta property="og:video:width" content="' . esc_attr( $main_size_meta[1] ) . '" />';
            //$metadata_arr[] = '<meta property="og:video:height" content="' . esc_attr( $main_size_meta[2] ) . '" />';
            $metadata_arr[] = '<meta property="og:video:type" content="' . esc_attr( $mime_type ) . '" />';

        } elseif ( 'audio' == $attachment_type ) {
            
            // Audio tags
            $metadata_arr[] = '<meta property="og:audio" content="' . esc_url_raw( $post->guid ) . '" />';
            //$metadata_arr[] = '<meta property="og:audio:secure_url" content="' . esc_url_raw( str_replace('http:', 'https:', $main_size_meta[0]) ) . '" />';
            $metadata_arr[] = '<meta property="og:audio:type" content="' . esc_attr( $mime_type ) . '" />';
        }


    // Posts, pages, custom content types (attachments excluded, caught in previous clause)
    // Note: content might be multipage. Process with amt_process_paged() wherever needed.
    } elseif ( is_singular() ) {

        // Type
        $metadata_arr[] = '<meta property="og:type" content="article" />';
        // Site Name
        $metadata_arr[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo('name') ) . '" />';
        // Title
        // Note: Contains multipage information through amt_process_paged()
        $metadata_arr[] = '<meta property="og:title" content="' . esc_attr( amt_process_paged( get_the_title($post->ID) ) ) . '" />';
        // URL - Uses amt_get_permalink_for_multipage()
        $metadata_arr[] = '<meta property="og:url" content="' . esc_url_raw( amt_get_permalink_for_multipage($post) ) . '" />';
        // Description - We use the description defined by Add-Meta-Tags
        // Note: Contains multipage information through amt_process_paged()
        $content_desc = amt_get_content_description($post);
        if ( !empty($content_desc) ) {
            $metadata_arr[] = '<meta property="og:description" content="' . esc_attr( amt_process_paged( $content_desc ) ) . '" />';
        }
        // Locale
        $metadata_arr[] = '<meta property="og:locale" content="' . esc_attr( str_replace('-', '_', get_bloginfo('language')) ) . '" />';
        // Dates
        $metadata_arr[] = '<meta property="article:published_time" content="' . esc_attr( amt_iso8601_date($post->post_date) ) . '" />';
        $metadata_arr[] = '<meta property="article:modified_time" content="' . esc_attr( amt_iso8601_date($post->post_modified) ) . '" />';


        // We store the featured image ID in this variable so that it can easily be excluded
        // when all images are parsed from the $attachments array.
        $featured_image_id = 0;
        // Set to true if any image attachments are found. Use to finally add the default image
        // if no image attachments have been found.
        $has_images = false;

        // Image
        if ( function_exists('has_post_thumbnail') && has_post_thumbnail( $post->ID ) ) {
            $metadata_arr = array_merge( $metadata_arr, amt_get_opengraph_image_metatags( get_post_thumbnail_id( $post->ID ) ) );
            // Finally, set the $featured_image_id
            $featured_image_id = get_post_thumbnail_id( $post->ID );
            // Images have been found.
            $has_images = true;
        }

        // Process all attachments and add metatags (featured image will be excluded)
        foreach( $attachments as $attachment ) {

            // Excluded the featured image since 
            if ( $attachment->ID != $featured_image_id ) {
                
                $mime_type = get_post_mime_type( $attachment->ID );
                //$attachment_type = strstr( $mime_type, '/', true );
                // See why we do not use strstr(): http://www.codetrax.org/issues/1091
                $attachment_type = preg_replace( '#\/[^\/]*$#', '', $mime_type );

                if ( 'image' == $attachment_type ) {

                    // Image tags
                    $metadata_arr = array_merge( $metadata_arr, amt_get_opengraph_image_metatags( $attachment->ID ) );

                    // Images have been found.
                    $has_images = true;
                    
                } elseif ( 'video' == $attachment_type ) {
                    
                    // Video tags
                    $metadata_arr[] = '<meta property="og:video" content="' . esc_url_raw( $attachment->guid ) . '" />';
                    //$metadata_arr[] = '<meta property="og:video:secure_url" content="' . esc_url_raw( str_replace('http:', 'https:', $main_size_meta[0]) ) . '" />';
                    //$metadata_arr[] = '<meta property="og:video:width" content="' . esc_attr( $main_size_meta[1] ) . '" />';
                    //$metadata_arr[] = '<meta property="og:video:height" content="' . esc_attr( $main_size_meta[2] ) . '" />';
                    $metadata_arr[] = '<meta property="og:video:type" content="' . esc_attr( $mime_type ) . '" />';

                } elseif ( 'audio' == $attachment_type ) {
                    
                    // Audio tags
                    $metadata_arr[] = '<meta property="og:audio" content="' . esc_url_raw( $attachment->guid ) . '" />';
                    //$metadata_arr[] = '<meta property="og:audio:secure_url" content="' . esc_url_raw( str_replace('http:', 'https:', $main_size_meta[0]) ) . '" />';
                    $metadata_arr[] = '<meta property="og:audio:type" content="' . esc_attr( $mime_type ) . '" />';
                }

            }
        }

        // Embedded Media
        foreach( $embedded_media['images'] as $embedded_item ) {

            $metadata_arr[] = '<meta property="og:image" content="' . esc_url_raw( $embedded_item['image'] ) . '" />';
            $metadata_arr[] = '<meta property="og:image:secure_url" content="' . esc_url_raw( str_replace('http:', 'https:', $embedded_item['image']) ) . '" />';
            $metadata_arr[] = '<meta property="og:image:width" content="' . esc_attr( $embedded_item['width'] ) . '" />';
            $metadata_arr[] = '<meta property="og:image:height" content="' . esc_attr( $embedded_item['height'] ) . '" />';
            $metadata_arr[] = '<meta property="og:image:type" content="image/jpeg" />';

            // Images have been found.
            $has_images = true;
        }
        foreach( $embedded_media['videos'] as $embedded_item ) {

            $metadata_arr[] = '<meta property="og:video" content="' . esc_url_raw( $embedded_item['player'] ) . '" />';
            $metadata_arr[] = '<meta property="og:video:type" content="application/x-shockwave-flash" />';

        }
        foreach( $embedded_media['sounds'] as $embedded_item ) {

            $metadata_arr[] = '<meta property="og:audio" content="' . esc_url_raw( $embedded_item['player'] ) . '" />';
            $metadata_arr[] = '<meta property="og:audio:type" content="application/x-shockwave-flash" />';

        }

        // If no images have been found so far use the default image, if set.
        // Scope BEGIN: ImageObject: http://schema.org/ImageObject
        if ( $has_images === false && ! empty( $options["default_image_url"] ) ) {
            $metadata_arr[] = '<meta property="og:image" content="' . esc_url_raw( $options["default_image_url"] ) . '" />';
        }

        // Author
        // If a Facebook author profile URL has been provided, it has priority,
        // Otherwise fall back to the WordPress author archive.
        $fb_author_url = get_the_author_meta('amt_facebook_author_profile_url', $post->post_author);
        if ( !empty($fb_author_url) ) {
            $metadata_arr[] = '<meta property="article:author" content="' . esc_url_raw( $fb_author_url, array('http', 'https', 'mailto') ) . '" />';
        } else {
            $metadata_arr[] = '<meta property="article:author" content="' . esc_url_raw( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ) . '" />';
        }

        // Publisher
        // If a Facebook publisher profile URL has been provided, it has priority,
        // Otherwise fall back to the WordPress blog home url.
        $fb_publisher_url = get_the_author_meta('amt_facebook_publisher_profile_url', $post->post_author);
        if ( !empty($fb_publisher_url) ) {
            $metadata_arr[] = '<meta property="article:publisher" content="' . esc_url_raw( $fb_publisher_url, array('http', 'https', 'mailto') ) . '" />';
        } else {
            $metadata_arr[] = '<meta property="article:publisher" content="' . esc_url_raw( get_bloginfo('url') ) . '" />';
        }

        // article:section: We use the first category as the section.
        $first_cat = amt_get_first_category($post);
        if ( ! empty( $first_cat ) ) {
            $metadata_arr[] = '<meta property="article:section" content="' . esc_attr( $first_cat ) . '" />';
        }
        
        // article:tag: Keywords are listed as post tags
        $keywords = explode(',', amt_get_content_keywords($post));
        foreach ($keywords as $tag) {
            $tag = trim( $tag );
            if (!empty($tag)) {
                $metadata_arr[] = '<meta property="article:tag" content="' . esc_attr( $tag ) . '" />';
            }
        }

    }

    // Filtering of the generated Opengraph metadata
    $metadata_arr = apply_filters( 'amt_opengraph_metadata_head', $metadata_arr );

    return $metadata_arr;
}


/**
 * Return an array of Opengraph metatags for an image attachment with the
 * provided post ID.
 * By default, returns metadata for the 'medium' sized version of the image.
 */
function amt_get_opengraph_image_metatags( $post_id, $size='medium' ) {
    $metadata_arr = array();
    $image = get_post( $post_id );
    //$image_meta = wp_get_attachment_metadata( $image->ID );   // contains info about all sizes
    // We use wp_get_attachment_image_src() since it constructs the URLs
    //$thumbnail_meta = wp_get_attachment_image_src( $image->ID, 'thumbnail' );
    $main_size_meta = wp_get_attachment_image_src( $image->ID, $size );
    // Image tags
    $metadata_arr[] = '<meta property="og:image" content="' . esc_url_raw( $main_size_meta[0] ) . '" />';
    //$metadata_arr[] = '<meta property="og:image:secure_url" content="' . esc_url_raw( str_replace('http:', 'https:', $main_size_meta[0]) ) . '" />';
    $metadata_arr[] = '<meta property="og:image:width" content="' . esc_attr( $main_size_meta[1] ) . '" />';
    $metadata_arr[] = '<meta property="og:image:height" content="' . esc_attr( $main_size_meta[2] ) . '" />';
    $metadata_arr[] = '<meta property="og:image:type" content="' . esc_attr( get_post_mime_type( $image->ID ) ) . '" />';
    return $metadata_arr;
}


