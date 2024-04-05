<?php 
get_header();
?>

<div class="front">
    
    <h1 class="front__title">
        <?php the_title(); ?>
    </h1>

    <div class="front__content">
        <?php the_content(); ?>
    </div>

    <div class="front__testimonials">
        <div class="front__testimonials--top">
            <p><?php _e('Find a Testimonials', 'internal'); ?></p>
            <input type="text" id="testimonials-search" placeholder="<?php _e('Search Testimonials', 'internal'); ?>" autocomplete>
            <div class="front__testimonials--tip">
            </div>
        </div>
        <div class="front__testimonials--list">
            <a href="" class="front__item"></a>
        </div>

    </div>

</div>

<?php 
get_footer();