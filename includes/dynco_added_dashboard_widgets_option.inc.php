<?php

if(get_option('dynco_added_dashboard_widgets_option') == 1){

    // Add new dashboard widgets
    function dynco_toolbox_add_dashboard_widgets() {

        wp_add_dashboard_widget( 'dynco_toolbox_dashboard_welcome', 'Welcome', 'dynco_toolbox_add_welcome_widget' );

        wp_add_dashboard_widget( 'dynco_toolbox_dashboard_links', 'Useful Links - Dynamic Consultants', 'dynco_toolbox_add_links_widget' );

        wp_add_dashboard_widget( 'dynco_toolbox_dashboard_blog_feed', 'Latest Blogs - Dynamic Consultants', 'dynco_toolbox_add_blog_widget');

        wp_add_dashboard_widget( 'dynco_toolbox_dashboard_news_feed', 'Latest News - Dynamic Consultants', 'dynco_toolbox_add_news_widget');
    }

    function dynco_toolbox_add_welcome_widget(){ ?>

This content management system lets you edit the pages and posts on your website.

Your site consists of the following content, which you can access via the menu on the left:

<ul>
    <li><strong>Pages</strong> - static pages which you can edit.</li>
    <li><strong>Posts</strong> - news or blog articles - you can edit these and add more.</li>
    <li><strong>Media</strong> - images and documents which you can upload via the Media menu on the left or within each post or page.</li>
</ul>

On each editing screen there are instructions to help you add and edit content.

    <?php }

    function dynco_toolbox_add_links_widget() { ?>

Some links to resources which will help you manage your site:

<ul>
    <li><a target="_blank" href="http://www.dynco.co.uk">Our main website</a></li>
    <li><a target="_blank" href="http://support.dynco.co.uk">Support portal</a> - Search our knowledgebase or report a fault.</li>
    <li><a target="_blank" href="http://dynco.co.uk/system-status">System status</a> - Check for planned maintenance and current issues.</li>
    <li><a target="_blank" href="http://controlpanel.dynco.co.uk">Control panel</a> - Login to your hosting control panel.</li>
    <li><a target="_blank" href="http://webmail.dynco.co.uk">Webmail login</a> - Login to your email account.</li>
</ul>
    <?php }

    function dynco_toolbox_add_blog_widget() { dynco_toolbox_get_feed_widget('http://dynco.co.uk/feed', 3); }

    function dynco_toolbox_add_news_widget() { dynco_toolbox_get_feed_widget('http://www.dynco.co.uk/feed/?post_type=dynco_articles', 1); }

    function dynco_toolbox_get_feed_widget( $feed, $count ) {

        include_once(ABSPATH . WPINC . '/feed.php'); // Get RSS Feed

        $rss = fetch_feed( $feed ); // Get the feed object from our specified feed source.

        if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly

            $maxitems  = $rss->get_item_quantity( $count );

            $rss_items = $rss->get_items( 0, $maxitems );

        endif; ?>

        <div class="rss-widget">
            <ul>

                <?php
                if ( $maxitems == 0 ) { ?>
                    <li>There are currently no posts to show.</li>
                <?php } else {

                    // Loop through each feed item and display each item as a hyperlink.
                    foreach ( $rss_items as $item ) :
                        $item_date = human_time_diff( $item->get_date('U'), current_time('timestamp')).' '.__( 'ago', 'rc_mdm' );
                        $content = $item->get_content();

                        $article  = '<li>';
                        $article .= '<a href="'.esc_url( $item->get_permalink() ).'" title="'.$item_date.'">';
                        $article .= esc_html( $item->get_title() );
                        $article .= '</a>';
                        $article .= ' <span class="rss-date">'.$item_date.'</span><br />';
                        $article .= wp_html_excerpt($content, 120) . ' [...]';
                        $article .= '</li>';

                        echo $article;

                    endforeach;

                } ?>
            </ul>
        </div>
    <?php }

    add_action( 'wp_dashboard_setup', 'dynco_toolbox_add_dashboard_widgets' );
}
