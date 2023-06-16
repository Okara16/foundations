<?php
/**
 * Template Name: Contact Page
 */

get_header(); ?>

<?php
$post_id = '';
if (isset($_GET['post_id']) && !empty($_GET['post_id'])):
    $post_id = $_GET['post_id'];
endif;
$test = '';


?>
    <main class="main-content">
        <section class="contact">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <article id="<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="grid-container">
                            <div class="grid-x grid-margin-x">
                                <div class="cell medium-6">
                                    <h1 class="page-title"><?php the_title(); ?></h1>
                                    <?php if (get_the_content()): ?>
                                        <div class="contact__content gb-content">
                                            <?php the_content(); ?>
                                        </div>
                                    <?php endif; ?>


                                    <form id="contact_form" name="contact_form" action="" method="POST">

                                        <label for="firstName">First name:</label><br>
                                        <input type="text" id="firstName" name="firstName" placeholder="First Name" required><br>
                                        <label for="lastName">Last name:</label><br>
                                        <input type="text" id="lastName" name="lastName" placeholder="First Name"><br>
                                        <label for="email">Email:</label><br>
                                        <input type="email" id="email" name="email" placeholder="Email" required><br>
                                        <label for="hidden"></label>
                                        <input type="hidden" id="post_id" value="<?php echo $post_id; ?>">
                                        <label for="subject">Subject</label><br>
                                        <select name="subject" id="subject">
                                            <option value="">Send only for me</option>
                                            <option value="">Send to admin</option>
                                        </select>
                                        <label for="message">Message:</label><br>
                                        <textarea name="message" id="message" cols="30" rows="10" required></textarea><br>
                                        <input type="hidden" name="new_post" value="1" />
                                        <input type="submit" name="submit" id="submit" value="Submit">
<!--                                        --><?php //wp_nonce_field( 'new-post' ); ?>
                                    </form>
<!--                                    --><?php
//
//                                    $name = $_POST['firstName'];
//                                    $email = $_POST['email'];
//                                    $message = $_POST['message'];
//
//                                    //php mailer variables
//                                    $to = get_option('sergey.o@thewhitelabelagency.com');
//                                    $subject = "Some text in subject...";
//                                    $headers = 'From: '. $email . "\r\n" .
//                                        'Reply-To: ' . $email . "\r\n";
//
//                                    //Here put your Validation and send mail
//                                    $sent = wp_mail($to, $subject, strip_tags($message), $headers);
//                                    var_dump($sent);
//
//                                    if($sent) {
//                                        echo 'message sent!';
//                                    }
//                                    else  {
//                                        echo 'message wasnt sent';
//                                    }
//                                    ?>


                                    <div class="contact__links">
                                        <?php if ($address = get_field('address', 'option')): ?>
                                            <address class="contact-link contact-link--address">
                                                <a href="<?php echo get_address_url($address); ?>"><?php echo $address; ?></a>
                                            </address>
                                        <?php endif; ?>
                                        <?php if ($email = get_field('email', 'options')): ?>
                                            <p class="contact-link contact-link--email"><a
                                                        href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ($phone = get_field('phone', 'options')): ?>
                                            <p class="contact-link contact-link--phone"><a
                                                        href="tel:<?php echo sanitize_number($phone); ?>"><?php echo $phone; ?></a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if (class_exists('GFAPI') && ($contact_form = get_field('contact_form')) && is_array($contact_form)): ?>
                                    <div class="cell medium-6">
                                        <div class="contact__form">
                                            <?php echo do_shortcode("[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']"); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php
                                $map_type = get_field('map_type', 'options');
                                $map_field_key = $map_type == 'google' ? 'location' : ($map_type == 'iframe' ? 'map_iframe' : 'map_image');
                                $location = get_field($map_field_key, 'options');

                                if ($location): ?>
                                    <div class="cell contact__map-wrap">
                                        <?php if ($map_type == 'google'): ?>
                                            <div class="acf-map contact__map">
                                                <div class="marker" data-lat="<?php echo $location['lat']; ?>"
                                                     data-lng="<?php echo $location['lng']; ?>"
                                                     data-marker-icon="<?php echo IMAGE_ASSETS . 'map-marker.png'; ?>"><?php echo '<p>' . $location['address'] . '</p>'; ?></div>
                                            </div>
                                        <?php elseif ($map_type == 'iframe'): ?>
                                            <div class="contact__map">
                                                <?php echo $location; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="contact__map">
                                                <?php echo wp_get_attachment_image($location, '1536x1536', false, array(
                                                    'class' => 'contact__map-img',
                                                    'alt' => get_field('address', 'options') ?: '',
                                                )); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

<?php get_footer(); ?>