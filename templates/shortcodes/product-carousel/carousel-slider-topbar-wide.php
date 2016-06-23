<?php $options = iba_get_shortcodes_atts('product_carousel'); ?>

<div class="gray-bar">
    <div class="container">
        <span class="title"><?php echo $options['atts']['header']; ?></span>
        <a class="show-all" href="<?php echo $options['atts']['link_to_caption']; ?>">
            <?php echo $options['atts']['see_more_caption']; ?>
        </a>
    </div>
</div>

<div class="gray-bar mobile-bar">
    <div class="container">
        <span>
            <a class="show-all" href="<?php echo $options['atts']['link_to_caption']; ?>">
                <?php echo $options['atts']['see_more_caption']; ?>
            </a>
        </span>
        <span class="title"><?php echo __('From the DHARMA SPRING BOOKSTORE', 'ds1'); ?></span>
    </div>
</div>

<div class="bottom-slider b-slider">
    <div class="container">
        <div id="<?php echo $options['atts']['slider_ID']; ?>">
            <?php
            while ($options['query']->have_posts()) {
                $options['query']->the_post();
                $product_ = wc_get_product(get_the_ID());
                $paperback_price = null;
                $paper_type = 'Price';

                if ($product_->is_type('variable')) {
                    $variation_ids = $product_->get_children();
                    foreach($variation_ids as $var_id) {
                        $var_data = new WC_Product_Variation($var_id);
                        $default_variation_slug = $var_data->default_attributes;
                        $va = wc_get_product_variation_attributes($var_id);
                        foreach($va as $key=>$val) {
                            if(($default_variation_slug[str_replace('attribute_', '' , $key)] == $val)) {
                                $paper_type = ucfirst(str_replace('-', '', $val));
                                $current_product = new WC_Product_Variation($var_id);
                                $paperback_price = $current_product->get_price_html();
                            }
                        }
                    }
                }
                $contributors = iba_get_product_contributors(get_the_ID());
                $con = '';
                foreach($contributors as $contributor){
                    if(empty($contributor['name'])) {
                        continue;
                    }
                    $con .= $contributor['name']. ', ';
                }
                $authors = rtrim($con, ', ');
                if (!has_post_thumbnail()) continue;
                ?>
                <div class="book-slide">
                    <div class="inner-box">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail(); ?>
                        </a>
                        <div class="slide-detail">
                            <h5>
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    if(get_field('iba_title')) {
                                        the_field('iba_title'); ?>: <?php
                                    }
                                    the_field('iba_subtitle', get_the_ID()); ?>
                                </a>
                            </h5>
                            <span><?php echo $authors; ?></span>
                            <span class="book-price">
                                <?php echo $paper_type; ?>:
                                <?php echo (is_null($paperback_price) ? $product_->get_price_html() : $paperback_price); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="slideshow-pager">
            <span id="<?php echo $options['atts']['slider_prev_ID']; ?>" class="prev"></span>
            <span id="<?php echo $options['atts']['slider_next_ID']; ?>" class="next"></span>
        </div>
    </div>
</div>

<script>
    if (!window.jQuery) {
        throw new Error('jQuery required for product carousel slider');
    }

    (function($) {
        var slider_ID = "#<?php echo $options['atts']['slider_ID']; ?>";
        var slider_next_ID = "#<?php echo $options['atts']['slider_next_ID']; ?>";
        var slider_prev_ID = "#<?php echo $options['atts']['slider_prev_ID']; ?>";

        var shopSliderOptions = {
            infiniteLoop: false,
            touchEnabled: true,
            nextSelector: slider_next_ID,
            prevSelector: slider_prev_ID,
            pager: false,
            nextText: ' ',
            prevText: ' ',
            autoReload: true,
            breaks: [{
                screen: 0,
                slides: 3,
                pager: false
            }, {
                screen: 480,
                slides: 5
            }, {
                screen: 768,
                slides: 4,
                slideMargin: 40
            }, {
                screen: 980,
                slides: 5,
                slideWidth: 120,
                slideMargin: 40
            }, {
                screen: 1536,
                slideWidth: 120,
                slides: 5,
                slideMargin: 106
            }]
        };

        // Book carousel slider on Shop Landing Page
        $(slider_ID).bxSlider(shopSliderOptions);
    })(jQuery);
</script>