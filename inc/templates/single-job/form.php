<?php
/**
 * For displaying job application form
 *
 * Override this by copying it to currenttheme/wp-job-openings/single-job/form.php
 *
 * @package wp-job-openings
 * @version 2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="awsm-job-form-inner">

	<?php
		/**
		 * before_awsm_application_form hook
		 *
		 * @since 1.0.0
		 * @since 2.2.0 The `$form_attrs` parameter was added.
		 *
		 * @param array $form_attrs Attributes array for the form.
		 */
		do_action( 'before_awsm_application_form', $form_attrs );
	?>

	<h2>
		<?php
			/**
			 * Filters the application form title.
			 *
			 * @since 1.0.0
			 * @since 2.2.0 The `$form_attrs` parameter was added.
			 *
			 * @param array $form_attrs Attributes array for the form.
			 */
			$form_title = apply_filters( 'awsm_application_form_title', __( 'Apply for this position', 'wp-job-openings' ), $form_attrs );
			echo esc_html( $form_title );
		?>
	</h2>

	<?php
		/**
		 * awsm_application_form_description hook
		 *
		 * @since 1.3.0
		 * @since 2.2.0 The `$form_attrs` parameter was added.
		 *
		 * @param array $form_attrs Attributes array for the form.
		 */
		do_action( 'awsm_application_form_description', $form_attrs );
	?>

	<form id="<?php echo $form_attrs['single_form'] ? 'awsm-application-form' : esc_attr( 'awsm-application-form-' . $form_attrs['job_id'] ); ?>" class="awsm-application-form" name="applicationform" method="post" enctype="multipart/form-data">

		<?php
			/**
			 * awsm_application_form_field_init hook
			 *
			 * Initialize job application form fields
			 *
			 * @hooked AWSM_Job_Openings_Form::form_field_init()
			 *
			 * @since 1.0.0
			 * @since 2.2.0 The `$form_attrs` parameter was added.
			 *
			 * @param array $form_attrs Attributes array for the form.
			 */
			//do_action( 'awsm_application_form_field_init', $form_attrs );
		?>

<div class='job-form-title'>
			1.Personal Details
		</div>

		<div class="awsm-job-form-group">
			<label for="awsm-applicant-name">Full Name <span class="awsm-job-form-error">*</span></label>
			<input type="text" placeholder="Full Name" name="awsm_applicant_name" class="awsm-job-form-field awsm-job-form-control" id="awsm-applicant-name" required="" data-msg-required="This field is required.">
		</div>

		<div class="awsm-job-form-group">
			<label for="awsm-applicant-email">Email Address <span class="awsm-job-form-error">*</span></label>
			<input type="text" placeholder="email@address.com" name="awsm_applicant_email" class="awsm-job-form-field awsm-job-form-control" id="awsm-applicant-email" required="" data-msg-required="This field is required.">
		</div>

		<div class="awsm-job-form-group">
			<label for="awsm_applicant_phone">Phone<span class="awsm-job-form-error">*</span></label>
			<input type="tel"  placeholder="Phone" name="awsm_applicant_phone" class="awsm-job-form-field awsm-job-form-control" id="awsm_applicant_phone" required="" data-msg-required="This field is required.">
		</div>

		<div class='job-form-title'>
			2. Profile
		</div>

		<div class="awsm-job-form-group">
			<label for="awsm_file">Resume / CV<span class="awsm-job-form-error">*</span></label>
			<input type="file"  placeholder="Resume" name="awsm_file" accept=".pdf, .doc, .docx" class="awsm-job-form-field awsm-job-form-control" id="awsm_file" required="" data-msg-required="This field is required.">
			<label style="margin-top:10px;font-size:12px">Allowed Type(s):  .pdf, .doc, .docx</lable>
		</div>

		<div class="awsm-job-form-group">
			<label for="awsm-applicant-summary">Personal Summary</label>
			<textarea rows="3" placeholder="This section is optional. Use it to tell us a little more about yourself." name="awsm_applicant_summary" class="awsm-job-form-field awsm-job-form-control" id="awsm-applicant-summary"  data-msg-required="This field is required." ></textarea>
		</div>

		<div class="job-form-title">
			3.Questions
		</div>

		<div class="awsm-job-form-group">
			<label for="awsm-applicant-office">Can you reliably and regularly travel to our offices in Salisbury?</label>
			<label class="radio-inline">
				<input type="radio" value="1"  name="awsm_applicant_office" class="awsm-job-form-fieldx awsm-job-form-controlx" id="awsm-applicant-office1" required="" data-msg-required="This field is required.">YES

				&nbsp;&nbsp;

				<input type="radio" value="0"  name="awsm_applicant_office" class="awsm-job-form-fieldx awsm-job-form-controlx" id="awsm-applicant-office2" required="" data-msg-required="This field is required.">NO
			</label>

	
		</div>


		<div class="awsm-job-form-group">
			<label for="awsm-applicant-salary">Please could you confirm your salary expectations<span class="awsm-job-form-error">*</span></label>
			<textarea rows="3" placeholder="" name="awsm_applicant_salary" class="awsm-job-form-field awsm-job-form-control" id="awsm-applicant-salary"  data-msg-required="This field is required." ></textarea>
		</div>

		<div class="awsm-job-form-group">
			<label for="awsm-applicant-work">Do you have the right to live and work in the UK?<span class="awsm-job-form-error">*</span></label>
			<textarea rows="3" placeholder="" name="awsm_applicant_work" class="awsm-job-form-field awsm-job-form-control" id="awsm-applicant-work"  data-msg-required="This field is required." ></textarea>
		</div>

		<div class="job-form-title">
			4. Submit Application
		</div>

		<div>
			In order to contact you with future jobs that you may be interested in, we need to store your personal data.

			If you are happy for us to do so please click the checkbox below.
			
			You can view our GDPR / <a href="/en/privacy-policy" class="external-panel__link" target="_blank">Privacy notice</a> notice for more information.

		</div>

		<div class="awsm-job-form-group awsm-job-inline-group">
		
		
				<input type="checkbox"  name="awsm_applicant_information" class="awsm-job-form-field" value="1"  id="awsm-applicant-information" required="" data-msg-required="This field is required.">
				<label for="awsm-applicant-information">Allow us to process your personal information.</label>
	
		
		</div>

		<input type="hidden" name="awsm_job_id" value="<?php echo esc_attr( $form_attrs['job_id'] ); ?>">
		<input type="hidden" name="action" value="awsm_applicant_form_submission">
		<div class="awsm-job-form-group">
			<?php awsm_job_form_submit_btn( $form_attrs ); ?>
		</div>

	</form>

	<div class="awsm-application-message" style="display: none;"></div>

	<?php
		/**
		 * after_awsm_application_form hook
		 *
		 * @since 1.0.0
		 * @since 2.2.0 The `$form_attrs` parameter was added.
		 *
		 * @param array $form_attrs Attributes array for the form.
		 */
		do_action( 'after_awsm_application_form', $form_attrs );
	?>

</div><!-- .awsm-job-form-inner -->
