<?php
if (isset($emailSent) && $emailSent == true) { ?>
	<p class="thanks">Thanks, your email was sent successfully.</p>
<?php } else { ?>
	<?php the_content(); ?>
	<?php if (isset($hasError) || isset($captchaError)) { ?>
		<p class="error">Sorry, an error occured.<p>
		<?php }
} ?>