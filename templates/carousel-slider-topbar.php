<?php $options = iba_get_shortcodes_atts('product_carousel'); ?>

<div class="heading-with-bg <?php echo $options['atts']['skin']; ?>">
    <?php echo '<h2>' . $options['atts']['header'] . '</h2>'; ?>
    <a class="view-all" href="<?php echo $options['atts']['link_to_caption']; ?>">
        <?php echo __($options['atts']['see_more_caption'], 'iba'); ?>
    </a>
</div>

<div class="bottom-slider">
    <div class="container">
        <div class="product-book-slider landing-page-slider">
            <?php
            $unique_prev = iba_random_unique_id();
            $unique_next = iba_random_unique_id();
            ?>
            <div class="cycle-slideshow" data-cycle-fx="carousel" data-cycle-timeout="0"
                 data-cycle-carousel-visible="5" data-cycle-carousel-fluid="true" data-cycle-slides="> div"
                 data-cycle-next="#next<?php echo $unique_next; ?>"
                 data-cycle-prev="#prev<?php echo $unique_prev; ?>">
                <?php
                while ($options['query']->have_posts()) {
                    $options['query']->the_post();
                    $product_ = wc_get_product(get_the_ID());
                    $paperback_price = null;
                    $paper_type = 'Price';

                    if ($product_->is_type('variable')) {
                        $variation_ids = $product_->get_children();
                        foreach($variation_ids as $var_id) {
                            $va = wc_get_product_variation_attributes($var_id);
                            if($va['attribute_pa_cover-type'] == 'paperback') {
                                $paper_type = $va['attribute_pa_cover-type'];
                                $current_product = new WC_Product_Variation($var_id);
                                $paperback_price = $current_product->get_price_html();
                            }
                        }
                    }
                    ?>
                    <div class="product-book-slide">
                        <div class="book-detail">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                            <div class="slide-detail">
                                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <span class="writer-name">Ryuichi Abe, Peter Hasket</span>
                                <span class="book-price"><?php echo ucwords($paper_type); ?>: <?php echo (is_null($paperback_price) ? $product_->get_price_html() : $paperback_price); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class=cycle-slideshow-pager>
                <a href="#" id="prev<?php echo $unique_prev; ?>" class="fa fa-angle-left"></a>
                <a href="#" id="next<?php echo $unique_next; ?>" class="fa fa-angle-right"></a>
            </div>
        </div>
    </div>
</div>