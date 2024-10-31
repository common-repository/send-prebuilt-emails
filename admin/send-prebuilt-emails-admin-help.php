<?php
	/**
	* Help Page
	*/	
	
	// get settings class
	$name = 'SEND_PREBUILT_EMAILS_VERSION';
	$version = '1.0.0';
	$spm_settings_class = new Send_Prebuilt_Emails_Settings($name,$version);
	
	
	
	?>
	<div class="wrap">
		<h2><?php
			echo esc_html__( 'Prebuilt E-Mails Help', 'send-prebuilt-emails' ) ?>
		</h2>
		
		<section tabindex="0" role="tabpanel" class="ml-nav-tabs-section wrap">
		<div class="wrap thinleek-setting-wrap" style="max-width:1000px">
		
		<table class="form-table thinleek-table" role="presentation" style="margin-bottom:0px!important"><?php
		
		
		
	/**
	 * Part: How to Use Prebuilt E-Mails
	 */
	$class = 'setup';
	$title = __( 'How to use Prebuilt E-Mails', 'send-prebuilt-emails' );
	$updown = 'up';
	$border = 'no';
	$spm_settings_class->spm_admin_settings_accordeon($class,$title,$updown,$border);
		
			?>
			<tr class="spm_tr_part_setup spm-lr-border">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-admin-tools"></span>
				</th>
				<td><?php
					echo esc_html__( 'Set Up Prebuilt E-Mail Templates', 'send-prebuilt-emails' ) ?>
				</td>
			</tr>
			
			<tr class="spm_tr_part_setup spm-lr-border">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-arrow-right"></span>
				</th>
				<td><?php
					echo esc_html__( 'Go to Order Edit Page and Send your E-Mail from the "Send Prebuilt E-Mail" Metabox', 'send-prebuilt-emails' ) ?>
				</td>
			</tr>
			
			<tr class="spm_tr_part_setup spm-lr-border">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-arrow-right"></span>
				</th>
				<td><?php
					echo esc_html__( 'Send Prebuilt E-Mails to multiple receipients via Order Bulk Actions', 'send-prebuilt-emails' ) ?>
				</td>
			</tr>
			
			<tr class="spm_tr_part_setup spm-lr-border">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-arrow-right"></span>
				</th>
				<td><?php
					echo esc_html__( 'if you activate "Prebuilt User E-Mails" you can set up user templates and send them from 
					user edit page and user bulk actions.', 'send-prebuilt-emails' ) ?>
				</td>
			</tr>
			
			<tr class="spm_tr_part_setup spm-lr-border">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-welcome-learn-more"></span>
				</th>
				<td><?php
					echo esc_html__( 'check out the full', 'send-prebuilt-emails' ) ?>
					<a href="https://thinleek-plugins.com/en/docs/send-pre-built-emails/introduction/" target="_blank">
						<?php echo esc_html__( 'introduction', 'send-prebuilt-emails' ) ?>
					</a>
				</td>
			</tr><?php
			
			
			
			
	/**
	 * Part: Use Cases
	 */
	$class = 'usecase';
	$title = __( 'Example use cases', 'send-prebuilt-emails' );
	$updown = 'down';
	$border = 'top';
	$spm_settings_class->spm_admin_settings_accordeon($class,$title,$updown,$border);
		
			?>
			<tr class="spm_tr_part_usecase spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-admin-post"></span>
				</th>
				<td>
					<b><?php echo esc_html__( 'Shipment anouncement', 'send-prebuilt-emails' ) ?></b>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'Example: It is friday and you want to inform all customers with pending orders that you will 
							ship the order on monday.', 'send-prebuilt-emails' ) ?>
						</span>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'No Problem: Filter pending Woocommerce orders and send your prebuilt e-mail template "shipping on monday" 
					via order bulk actions.', 'send-prebuilt-emails' ) ?>
						</span>
				</td>
			</tr>
			
			
			<tr class="spm_tr_part_usecase spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-admin-post"></span>
				</th>
				<td>
					<b><?php echo esc_html__( 'Leave a review', 'send-prebuilt-emails' ) ?></b>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'Example: you want to get reviews and you know you highperformer product is rated 
							great by clients who bought it.', 'send-prebuilt-emails' ) ?>
						</span>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'No Problem: Search Woocommerce Orders and get all where your highperformer product 
							is bought and send a leave a prebuilt leave a review e-mail via order bulk actions.', 'send-prebuilt-emails' ) ?>
						</span>
				</td>
			</tr>
			
			
			<tr class="spm_tr_part_usecase spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-admin-post"></span>
				</th>
				<td>
					<b><?php echo esc_html__( 'Payment reminder', 'send-prebuilt-emails' ) ?></b>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'Example: A customer forgot to pay.', 'send-prebuilt-emails' ) ?>
						</span>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'No Problem: open the order and use the "Send Prebuilt E-Mails" Metabox and select 
							your template "payment reminder" and click "send".', 'send-prebuilt-emails' ) ?>
						</span>
				</td>
			</tr>
			
			
			<tr class="spm_tr_part_usecase spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-admin-post"></span>
				</th>
				<td>
					<b><?php echo esc_html__( 'Product out of stock', 'send-prebuilt-emails' ) ?></b>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'Example: 20 customers are waiting for the product xyz they already ordered, but it 
							is out of stock and you have to wait till you got new ones.', 'send-prebuilt-emails' ) ?>
						</span>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'No Problem: Use "Plain E-Mails" Addon and go to Woocommerce orders. Serach pending 
							order with product xyz. Use Bulk Action "Write Plain E-Mail" and write an individal text to 
							the customers. Use placeholders, say sorry, and save time to get product xyz asap.', 'send-prebuilt-emails' ) ?>
						</span>
				</td>
			</tr>
			
			
			<tr class="spm_tr_part_usecase spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-admin-post"></span>
				</th>
				<td>
					<b><?php echo esc_html__( 'User Role updated', 'send-prebuilt-emails' ) ?></b>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'Example: You have different prices by user role. You want to inform user after user role 
							changed.', 'send-prebuilt-emails' ) ?>
						</span>
						<span class="spm-help-desc"><?php 
							echo esc_html__( 'No Problem: Change User role and send prebuilt e-mail directly form user edit page.', 'send-prebuilt-emails' ) ?>
						</span>
				</td>
			</tr>
			
			
			<tr class="spm_tr_part_usecase spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-welcome-learn-more"></span>
				</th>
				<td><?php
					echo esc_html__( 'check out more', 'send-prebuilt-emails' ) ?>
					<a href="https://thinleek-plugins.com/en/plugins/send-prebuilt-emails/#use-cases" target="_blank">
						<?php echo esc_html__( 'use cases', 'send-prebuilt-emails' ) ?>
					</a>
				</td>
			</tr><?php
			
			
			
	/**
	 * Part: What Send Prebuilt E-Mails does
	 */
	$class = 'links';
	$title = __( 'Support', 'send-prebuilt-emails' );
	$updown = 'down';
	$border = 'top';
	$spm_settings_class->spm_admin_settings_accordeon($class,$title,$updown,$border);
		
			?>
			<tr class="spm_tr_part_links spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-external"></span>
				</th>
				<td>
					<a href="https://thinleek-plugins.com/en/docs/send-pre-built-emails/faq/" target="_blank"><?php
						echo esc_html__( 'FAQ Page', 'send-prebuilt-emails' ) ?>
					</a>
				</td>
			</tr>
			
			
			
			
			<tr class="spm_tr_part_links spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-external"></span>
				</th>
				<td>
					<a href="https://thinleek-plugins.com/en/docs/category/send-pre-built-emails/" target="_blank"><?php
						echo esc_html__( 'Documentation', 'send-prebuilt-emails' ) ?>
					</a>
				</td>
			</tr>
			
			<?php
			if ( sendprebuiltemails_fs()->is_not_paying() ) {	
			
				?>
				<tr class="spm_tr_part_links spm-lr-border" style="display:none">
					<th class="thinleek-th-bright thinleek-help-th-short">
						<span class="dashicons dashicons-external"></span>
					</th>
					<td>
						<a href="<?php echo esc_url( sendprebuiltemails_fs()->get_upgrade_url() ) ?>" target="_blank"><?php
							echo esc_html__( 'Premium Version', 'send-prebuilt-emails' ) ?>
						</a>
					</td>
				</tr>
				<?php
		
			}
			?>
	
			
			
			
			
			<tr class="spm_tr_part_links spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-external"></span>
				</th>
				<td>
					<a href="https://thinleek-plugins.com/en/docs/send-pre-built-emails/hooks-and-filter/" target="_blank"><?php
						echo esc_html__( 'Hooks and Filters', 'send-prebuilt-emails' ) ?>
					</a>
				</td>
			</tr>
			
			
			<tr class="spm_tr_part_links spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-external"></span>
				</th>
				<td>
					<a href="https://thinleek-plugins.com/en/support/" target="_blank"><?php
						echo esc_html__( 'Support / Contact', 'send-prebuilt-emails' ) ?>
					</a>
				</td>
			</tr>
			<?php
			
			
			
			/**
			 * Part: What Send Prebuilt E-Mails does
			 */
			$class = 'like';
			$title = __( 'Do you like Send Prebuilt E-Mails?', 'send-prebuilt-emails' );
			$updown = 'down';
			$border = 'top';
			$spm_settings_class->spm_admin_settings_accordeon($class,$title,$updown,$border);
			
			
			?>
			<tr class="spm_tr_part_like spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-external"></span>
				</th>
				<td>
					<a href="https://de.wordpress.org/plugins/send-prebuilt-emails/" target="_blank"><?php
						echo esc_html__( 'Rate Send Prebuilt E-Mails', 'send-prebuilt-emails' ) ?>
					</a>
						<span class="thinleek-desc"><?php
							echo esc_html__( 'Thanks for helping thinleek plugins', 'send-prebuilt-emails' ) ?>
						</span>
				</td>
			</tr>
			
			<tr class="spm_tr_part_like spm-lr-border" style="display:none">
				<th class="thinleek-th-bright thinleek-help-th-short">
					<span class="dashicons dashicons-external"></span>
				</th>
				<td>
					<a href="https://www.paypal.com/donate?hosted_button_id=PRVNVCMWA3K3Y" target="_blank"><?php
						echo esc_html__( 'Donate via paypal', 'send-prebuilt-emails' ) ?>
					</a>
						<span class="thinleek-desc"><?php
							echo esc_html__( 'Thanks for helping thinleek plugins', 'send-prebuilt-emails' ) ?>
						</span>
				</td>
			</tr>
			
			<tr>
				<th colspan="2" style="border-top: 1px solid #cdcdcd;padding:10px!important;"></th>
			</tr>
			
	
			
		</table>
		</div>
		</section>
	</div> 