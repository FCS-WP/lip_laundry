<?php
add_shortcode('contact_form', 'contact_form_shortcode');

// Contact Form Shortcode
function contact_form_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'title' => 'Enquiry Form',
        'submit_text' => 'Send Enquiry',
    ), $atts);

    ob_start();
?>
    <div class="contact-form-wrapper">
        <?php if (!empty($atts['title'])) : ?>
            <h2 class="contact-form-title"><?php echo esc_html($atts['title']); ?></h2>
        <?php endif; ?>

        <form class="contact-form" id="contact-form" method="post" action="">
            <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="company_name">Company Name <span class="required">*</span></label>
                    <input type="text" id="company_name" name="company_name" required placeholder="Enter company name">
                </div>

                <div class="form-group">
                    <label for="industry">Industry <span class="required">*</span></label>
                    <input type="text" id="industry" name="industry" required placeholder="Enter industry">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="estimated_volume">Estimated Volume / Frequency <span class="required">*</span></label>
                    <input type="text" id="estimated_volume" name="estimated_volume" required placeholder="e.g. 50kg per week">
                </div>

                <div class="form-group">
                    <label for="garment_type">Type of Garments <span class="required">*</span></label>
                    <input type="text" id="garment_type" name="garment_type" required placeholder="e.g. Uniforms, Linens">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="contact_name_number">Contact Name & Number <span class="required">*</span></label>
                    <input type="text" id="contact_name_number" name="contact_name_number" required placeholder="Name & Phone number">
                </div>

                <div class="form-group">
                    <label for="contact_email">Email Address <span class="required">*</span></label>
                    <input type="email" id="contact_email" name="contact_email" required placeholder="your.email@example.com">
                </div>
            </div>

            <div class="form-group">
                <label for="additional_notes">Additional Notes</label>
                <textarea id="additional_notes" name="additional_notes" rows="4" placeholder="Any other details..."></textarea>
            </div>

            <div class="form-submit">
                <button type="submit" class="zippy-btn-submit">
                    <?php echo esc_html($atts['submit_text']); ?>
                </button>
            </div>

            <div class="form-response" style="display: none;"></div>
        </form>
    </div>
<?php
    return ob_get_clean();
}
