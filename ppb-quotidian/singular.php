<?php get_header(); ?>
<section class="content single">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?= the_title(); ?></h1>
        </header>

        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <div class="entry-content">
                <?php echo the_content(); ?>
            </div>
        <?php endwhile; endif; ?>
    </article>
</section>
<?php get_footer(); ?>
