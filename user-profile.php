<?php

use QuanDigital\WpLib\Helpers;

$user = get_user_by( 'slug', get_query_var( 'author_name' ) );
$data = new \Quan\UserData\UserData($user);
$posts = get_posts([
    'author' => $user->ID,
    'posts_per_page' => -1,
    ]);
get_header();

?>
    <div class="user-profile">

        <div class="data-container">
            <div class="user-image-container">
                <div class="user-image" style="background-image: url(<?= $data->getUserProfileImage(); ?>)"></div>    
            </div>

            <div class="user-data">
                <h1><?= $user->display_name; ?></h1>
                <div class="user-job"><?= $data->job; ?></div> 
                <?php if (isset($data->bio)) : ?>
                    <div class="user-bio">
                        <?= $data->bio; ?>
                    </div>    
                <?php endif; ?>

                <div class="socials">
                    <?php if (Helpers::notEmpty($data->twitter)) : ?>
                        <div class="social user-twitter">
                            <a href="https://twitter.com/<?= $data->twitter; ?>" target="_blank"><span class="ion-social-twitter"></span></a>
                        </div>    
                    <?php endif; ?>
                    <?php if (Helpers::notEmpty($data->linkedin)) : ?>
                        <div class="social user-linkedin">
                            <a href="<?= $data->linkedin; ?>"  target="_blank"><span class="ion-social-linkedin-outline"></span></a>
                        </div>    
                    <?php endif; ?>
                    <?php if (Helpers::notEmpty($data->xing)) : ?>
                        <div class="social user-xing">
                            <a href="<?= $data->xing; ?>" target="_blank">X</a>
                        </div>    
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if($posts) : ?>
            <div class="user-posts">
                <h2><?= sprintf(__('Posts written by %s', 'quan'), $user->first_name); ?></h2>
                <div id="loop" class="preload user-loop">
                    <?php foreach ($posts as $post) : ?>
                        <article class="user-post">
                            <div class="post-image">
                                <?= quanPostThumbs($post); ?>
                            </div>

                            <div class="index-post-text">
                                <h2><a href="<?php the_permalink(); ?>" class="postlink"><?php the_title(); ?></a></h2>
                                <?= get_field( 'quan_excerpt' ) ? '<p>' . get_field( 'quan_excerpt' ) . '</p>' : ''; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php    
    get_footer();
