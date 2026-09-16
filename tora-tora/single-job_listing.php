<?php
/**
 * Single job listing (WP Job Manager apply flow).
 *
 * @package Tora_Tora
 */

get_header();
?>
<main class="standard-page job-listing-page" id="main-content" tabindex="-1">
    <div class="standard-page-inner job-listing-inner">
        <p class="job-listing-back">
            <a class="panel-back-link" href="<?php echo esc_url(home_url('/#careers')); ?>">
                <span class="panel-back-arrow" aria-hidden="true"></span>
                <span><?php esc_html_e('Back to careers', 'tora-tora'); ?></span>
            </a>
        </p>

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('job-listing-article'); ?>>
                    <header class="job-listing-header">
                        <span class="panel-eyebrow"><?php esc_html_e('Careers', 'tora-tora'); ?></span>
                        <h1><?php the_title(); ?></h1>
                        <?php
                        $location = tora_tora_job_location(get_the_ID());
                        $types = tora_tora_job_type_labels(get_the_ID());
                        ?>
                        <?php if ($location !== '' || $types) : ?>
                            <ul class="job-listing-meta">
                                <?php if ($location !== '') : ?>
                                    <li><?php echo esc_html($location); ?></li>
                                <?php endif; ?>
                                <?php foreach ($types as $type_label) : ?>
                                    <li><span class="job-type-badge"><?php echo esc_html($type_label); ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </header>

                    <div class="entry-content job-listing-body">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    $can_apply = function_exists('candidates_can_apply') && candidates_can_apply() && function_exists('get_job_manager_template');
                    $careers_mail = (string) get_theme_mod('tora_careers_email', 'hello@toratora.ae');
                    ?>
                    <?php if ($can_apply) : ?>
                        <section class="job-listing-apply" aria-labelledby="job-apply-title">
                            <h2 id="job-apply-title"><?php esc_html_e('Apply for this role', 'tora-tora'); ?></h2>
                            <?php get_job_manager_template('job-application.php'); ?>
                        </section>
                    <?php elseif ($careers_mail !== '') : ?>
                        <section class="job-listing-apply">
                            <a class="button" href="mailto:<?php echo esc_attr(antispambot($careers_mail)); ?>?subject=<?php echo rawurlencode('Job application: ' . get_the_title()); ?>"><?php esc_html_e('Email Your CV', 'tora-tora'); ?></a>
                        </section>
                    <?php endif; ?>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <h1><?php esc_html_e('Role not found', 'tora-tora'); ?></h1>
            <p><?php esc_html_e('This opening may have closed. Browse current careers or email your CV.', 'tora-tora'); ?></p>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url(home_url('/#careers')); ?>"><?php esc_html_e('View careers', 'tora-tora'); ?></a>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
