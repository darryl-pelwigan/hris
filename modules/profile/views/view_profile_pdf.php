
<body>

	<div class="header">
		<img class="logo" src="<?php echo base_url(); ?>/assets/images/logo.png">
		<div class="header_text">
			<h3 class="zero_margin">Pines City Colleges</h3>
			<p class="zero_margin">Magsaysay Ave. Baguio City</p>
		</div>
		<img class="user_image" src="<?php echo base_url(); ?>/assets/images/user.png"/>
		<div class="break"></div>
		<h2 class="zero_margin">EMPLOYEE INFORMATION SHEET</h2>
	</div>

	<div class="table_Content">
		<table style="width: 100%;" class="information_table">
			<tr>
				<td class="small_width"><strong><span style="margin-right: 12px;">I.</span> File Number: </strong></td>
				<td>
					<table>
						<td class="with_border" style="padding: 2px 5px;"><?= $user[0]->FileNo; ?></td>
<!-- 						<td class="with_border" style="padding: 2px 5px;">I</td>
						<td class="with_border" style="padding: 2px 5px;">L</td>
						<td class="with_border" style="padding: 2px 5px;">E</td> -->
					</table>
				</td>
			</tr>
			<tr class="zero_margin center_align tr_border">
				<td class="small_width"></td>
				<td class="with_border"><?= $user[0]->LastName ?></td>
				<td class="with_border"><?= $user[0]->FirstName ?></td>
				<td class="with_border"><?= $user[0]->MiddleName ?></td>
			</tr>
			<tr>
				<td class="small_width"><strong><span style="margin-right: 10px;">II.</span> File Name:</strong></td>
				<td>LAST NAME:</td>
				<td>FIRSTNAME</td>
				<td>MIDDLE NAME</td>
			</tr>
			<tr>
				<td class="small_width"><strong><span style="margin-right: 8px;">III.</span> Position: </strong></td>
				<td class="center_align" style="width: 30%; border-bottom: 1px solid black;"></td>
			</tr>
		</table>
		<strong><span style="margin-right: 8px;">IV.</span> Personal Information: </strong>
		
		<div class="personal_information">

			<table style="width: 100%;">
				<tr style="text-align: left;">
					<td style=" width: 40%;"> 
						<p style="width: 30%; float: left;">Birth Date:</p>
						<table style="float: left; position: relative;">
							<tr>
								<td class="with_border center_align"><?= date('F', strtotime($user[0]->birth_date)) ?></td>
								<td class="with_border center_align"><?= date('j', strtotime($user[0]->birth_date)) ?></td>
								<td class="with_border center_align"><?= date('Y', strtotime($user[0]->birth_date)) ?></td>
							</tr>
							<tr>
								<td>Month</td>
								<td>Day</td>
								<td>Year</td>
							</tr>
						</table>
							<div class="break"></div> 
					</td>
					<td>
						<p style="width: 25%; float: left;">Age:</p>
						<p style="float: left; border-bottom: 1px solid black; width: 50%;"><?= $user[0]->age ?></p>
						<div class="break"></div> 
					</td>
					<td>
						<p style="width: 30%; float: left;">Gender:</p>
						<p style="width: 50%; float: left; border-bottom: 1px solid black;"><?= $user[0]->sex ?></p>
						<div class="break"></div> 
					</td>
				</tr>
			</table>

			<table width="100%" style="border-collapse: collapse;">
				<tr>
					<td width="60%">
						<p class="zero_margin" style="width: 25%; float: left;">Birth Place</p>
						<p class="zero_margin" style="width: 70%; float: left; border-bottom: 1px solid black; word-wrap: break-word;">&nbsp; <?= $user[0]->birth_place ?></p>
						<div class="break"></div>
					</td>
					<td>
						<p class="zero_margin" style="width: 25%; float: left;">Religion</p>
						<p class="zero_margin" style="width: 75%; float: left; border-bottom: 1px solid black; word-wrap: break-word;">&nbsp; <?= $user[0]->religion ?></p>
						<div class="break"></div>
					</td>
				</tr>
				<tr>
					<td>
						<p class="zero_margin" style="width: 25%; float: left;">City Address</p>
						<p class="zero_margin" style="width: 70%; float: left; border-bottom: 1px solid black; word-wrap: break-word;">&nbsp; <?= $user[0]->home_address ?></p>
						<div class="break"></div>
					</td>
					<td>
						<p class="zero_margin" style="width: 30%; float: left;">Mobile No.</p>
						<p class="zero_margin" style="width: 70%; float: left; border-bottom: 1px solid black; word-wrap: break-word;">&nbsp; <?= $user[0]->mobile_no ?></p>
						<div class="break"></div>
					</td>
				</tr>
				<tr>
					<td>
						<p class="zero_margin" style="width: 30%; float: left;">Provincial Address</p>
						<p class="zero_margin" style="width: 65%; float: left; border-bottom: 1px solid black; word-wrap: break-word;">&nbsp; <?= $user[0]->prov_address ?></p>
						<div class="break"></div>
					</td>
					<td>
						<p class="zero_margin" style="width: 35%; float: left;">Telephone No.</p>
						<p class="zero_margin" style="width: 65%; float: left; border-bottom: 1px solid black; word-wrap: break-word;">&nbsp; <?= $user[0]->landline_no ?></p>
						<div class="break"></div>
					</td>
				</tr>
				<tr>
					<td>
						<p class="zero_margin" style="width: 25%; float: left;">Email Address</p>
						<p class="zero_margin" style="width: 70%; float: left; border-bottom: 1px solid black; word-wrap: break-word;">&nbsp; <?= $user[0]->email ?></p>
						<div class="break"></div>
					</td>
					<td style="font-size: 14px;">
						<p class="zero_margin" style="width: 25%; float: left;">Civil Status</p>
						<input type="checkbox" <?=($user[0]->civil_status == 'single')? 'checked="checked"': ''; ?>>Single
						<input type="checkbox" <?=($user[0]->civil_status == 'married')? 'checked="checked"': ''; ?> >Married
						<input type="checkbox" <?=($user[0]->civil_status == 'windowed')? 'checked="checked"': ''; ?>>Widowed
						<div class="break"></div>
					</td>
				</tr>
			</table>

			<div class="if_married">
				<p style="font-weight: bold; float: left;">If married:</p>
				<div class="if_married_table" style=" margin-left: 15%; position: relative;">
					<table style="width: 100%;">
						<tr>
							<td style="width: 20%;">Name of spouse:</td>
							<td class="border_bottom">&nbsp; <?= $user[0]->spousename ?></td>
						</tr>
						<tr>
							<td>Occupation:</td>
							<td class="border_bottom">&nbsp; <?= $user[0]->spouseoccup ?></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td class="border_bottom">&nbsp; <?= $user[0]->spouseaddr ?></td>
						</tr>
						<tr>
							<td>Contact Number:</td>
							<td class="border_bottom">&nbsp; <?= $user[0]->spouseno ?></td>
						</tr>

					</table>
				</div>
				<div class="break"></div>

				<div class="if_dependents">
					<div class="check_checkbox" style="width: 50%; margin: 0 auto;">
						<input type="checkbox" <?= ($user[0]->wo_with_dependents == 'with dependents')? 'checked="checked"': '' ?> > With Dependents
						<input type="checkbox" <?= ($user[0]->wo_with_dependents == 'without dependents')? 'checked="checked"': '' ?> > Without Dependents
					</div>
					<div class="table_with_dependents">
						<table width="80%" style="margin: 0 auto;" class="dependents_table">
							<tr>
								<th class="center_align">Name of Dependent</th>
								<th class="center_align">Date of Birth</th>
								<th class="center_align">Relationship</th>
							</tr>
							<?php if($dependents): ?>
								<?php foreach ($dependents as $value): ?>
									<tr>
										<td><?=$value->depname ?></td>
										<td><?= date('j F Y', strtotime($value->datebirth)) ?></td>
										<td><?=$value->relation ?></td>
									</tr>
									
								<?php endforeach ?>

							<?php else : ?>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						<?php endif; ?>
						</table>
					</div>
				</div>
			</div>

			<div class="parent_Information">
				<table class="parent_table" style="width: 100%;">
					<tr>
						<td>
							<p class="zero_margin" style="width: 33%; float: left;">Name Of Father:</p>
							<p class="zero_margin border_bottom" style="width: 65%; float: left;">&nbsp; <?= $user[0]->fathername ?></p>
							<div class="break"></div>
						</td>
						<td>
							<p class="zero_margin" style="width: 33%; float: left;">Name Of Mother:</p>
							<p class="zero_margin border_bottom" style="width: 65%; float: left;">&nbsp; <?= $user[0]->mothername ?></p>
							<div class="break"></div>
						</td>
					</tr>
					<tr>
						<td>
							<p class="zero_margin" style="width: 30%; float: left;">Date of Birth:</p>
							<p class="zero_margin border_bottom" style="width: 65%; float: left;">&nbsp; <?= $user[0]->fatherbday ?></p>
							<div class="break"></div>
						</td>
						<td>
							<p class="zero_margin" style="width: 30%; float: left;">Date of Birth:</p>
							<p class="zero_margin border_bottom" style="width: 65%; float: left;">&nbsp; <?= $user[0]->motherbday ?></p>
							<div class="break"></div>
						</td>
					</tr>
					<tr>
						<td>
							<p class="zero_margin" style="width: 40%; float: left;">Father's Occupation:</p>
							<p class="zero_margin border_bottom" style="width: 55%; float: left;">&nbsp; <?= $user[0]->fatheroccup ?></p>
							<div class="break"></div>
						</td>
						<td>
							<p class="zero_margin" style="width: 40%; float: left;">Mother's Occupation:</p>
							<p class="zero_margin border_bottom" style="width: 55%; float: left;">&nbsp; <?= $user[0]->motheroccup ?></p>
							<div class="break"></div>
						</td>
					</tr>
				</table>
			</div>

			<div class="education_background">
				<strong><span style="margin-right: 8px;">V.</span> Education Background:</strong>

				<table style="width: 100%; border-collapse: collapse;">
					<?php if ($educ): ?>
						<?php foreach ($educ as $key): ?>
							<tr>
								<td style="width: 28%;"><?= $key->type ?> Degree</td>
								<td class="border_bottom">&nbsp; <?= $key->degree ?></td>
							</tr>
							<tr>
								<td style="width: 28%;">Status</td>
								<td class="border_bottom">&nbsp; <?= $key->status ?></td>
							</tr>
							<tr>
								<td style="width: 28%;">With Units</td>
								<td class="border_bottom">&nbsp; <?= $key->remarks ?></td>
							</tr>
							<tr>
								<td style="width: 28%;">Name of School and Address:</td>
								<td class="border_bottom">&nbsp; <?= $key->school_address ?></td>
							</tr>
							<tr>
								<td style="width: 28%;">&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</table>
			</div><br>

			<div class="eligibilities">
				<strong><span style="margin-right: 8px;">VI.</span> Eligibilities/Licensure Examination Taken:</strong>
				<table width="100%;" class="eligibilities_table" style="border-collapse: collapse;">
					<tr>
						<th>Type of Eligibility</th>
						<th>Date of Examination</th>
						<th>Liscensure No.</th>
						<th>Rate/Grade</th>
					</tr>
					<?php if ($elig): ?>
						<?php foreach ($elig as $key): ?>
						<tr>
							<td>&nbsp; <?= $key->eligname ?></td>
							<td>&nbsp; <?= date('F j, Y', strtotime($key->eligdate)) ?></td>
							<td>&nbsp; <?= $key->passingno ?> </td>
							<td>&nbsp; <?= $key->grade ?></td>
						</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					<?php endif; ?>
				</table>	
			</div>

			<div class="empoyment">
				<div class="employment_title">
					<p style="float: left; width: 55%; font-weight: bold;"><span style="margin-right: 8px;">VII.</span> Date of Employement At Pines City Colleges:</p>
				</div>

				<div class="employment_table">
					<table width="30%;" style="border-collapse: collapse; float: left; position: absolute; font-weight: bold;">
						<tr>
							<td><?= date('F', strtotime($user[0]->dateofemploy)) ?></td>
							<td><?= date('j', strtotime($user[0]->dateofemploy)) ?></td>
							<td><?= date('Y', strtotime($user[0]->dateofemploy )) ?></td>
						</tr>
						<tr>
							<td>Month</td>
							<td>Day</td>
							<td>Year</td>
						</tr>
					</table>
					<div class="break"></div>
				</div>
			</div>

			<div class="employee_status">
				<strong><span style="margin-right: 8px;">VIII.</span> Employee Status:</strong>

				<div class="check_checkbox" style="width: 70%; margin: 0 auto; font-size: 15px;">
					<input type="checkbox" <?= ($user[0]->emp_status == 'regular')? 'checked="checked"': ''; ?> > Regular
					<input type="checkbox" <?= ($user[0]->emp_status == 'contractual')? 'checked="checked"': ''; ?> > Contractual
					<input type="checkbox" <?= ($user[0]->emp_status == 'project-based')? 'checked="checked"': ''; ?> > Project-Based
					<input type="checkbox" <?= ($user[0]->emp_status == 'probationary')? 'checked="checked"': ''; ?> > Probationary
					<input type="checkbox" <?= ($user[0]->emp_status == 'fixed-term')? 'checked="checked"': ''; ?> > Fixed-Term
				</div>

			</div>

			<div class="nature_employement">
				<strong><span style="margin-right: 8px;">IX.</span> Nature of Employement:</strong>

				<div class="check_checkbox" style="width: 30%; margin: 0 auto; font-size: 15px;">
					<input type="checkbox" <?= ($user[0]->nature_emp == 'full-time')? 'checked="checked"': ''; ?>> Full-TIme
					<input type="checkbox" <?= ($user[0]->nature_emp == 'part-time')? 'checked="checked"': ''; ?> > Part-Time
				</div>

			</div>

			<div class="identification_number">
				<strong><span style="margin-right: 8px;">X.</span> Other Identification Numbers:</strong>

				<div class="id_content">
					<div class="id_left" style="width: 50%; float: left;">
						<p>SSS No. <span style="text-decoration: underline;"><?= $user[0]->sss ?></span></p>
						<p>PhilHealth No. <span style="text-decoration: underline;"><?= $user[0]->philhealth ?></span></p>
						<p>PAG-IBIG No. <span style="text-decoration: underline;"><?= $user[0]->pagibig ?></span></p>
					</div>

					<div class="id_right" style="width: 50%; float: left;">
						<p>PERAA No. <span style="text-decoration: underline;"><?= $user[0]->peraa ?></span> </p>
						<p>TIN No. <span style="text-decoration: underline;"><?= $user[0]->tin ?></span></p>
					</div>
					<div class="break"></div>

				</div>
			</div>

			<div class="other_information">
				<strong><span style="margin-right: 8px;">XI.</span> Other Information:</strong>
				<div class="other_content">
					<label style="display: inline-block;">Person to Contact in Case of Emergency:</label>
					<p class="zero_margin border_bottom" style="width: 50%; display: inline-block;">&nbsp; <?= $user[0]->person_contact_emergency ?></p><br>
					<label style="display: inline-block;">Address:</label>
					<p class="zero_margin border_bottom" style="width: 50%; display: inline-block;">&nbsp; <?= $user[0]->person_address ?></p>
					<label style="display: inline-block;">Contact No:</label>
					<p class="zero_margin border_bottom" style="width: 20%; display: inline-block;">&nbsp; <?= $user[0]->contact_number ?></p><br>
					<label style="display: inline-block;">Relationship:</label>
					<p class="zero_margin border_bottom" style="width: 20%; display: inline-block;">&nbsp; <?= $user[0]->relation_person ?></p><br>
				</div>
			</div>

			<div class="affiliations">
				<strong><span style="margin-right: 8px;">XII.</span> Affiliations:</strong>
				<p style="text-indent: 50px;">&nbsp;</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>

			</div>
			<div class="declaration">
				<strong><span style="margin-right: 8px;">XIII.</span> Declaration:</strong>

				<p class="zero_margin" style="margin-top: 5px; padding-top: 5px; text-indent: 50px;"> Have you ever been arrested or charged in a court or any other tribunal? ____ Yes ____ No
					If yes, please give the particulars of each case.</p>

				<p class="declaration_line zero_margin">&nbsp;</p>
				<p class="declaration_line zero_margin">&nbsp;</p>
				<p class="declaration_line zero_margin">&nbsp;</p>
				<p class="declaration_line zero_margin">&nbsp;</p>

				<p class="zero_margin" style="margin-top: 5px; padding-top: 5px; text-indent: 50px;">Are you related to any current or past officer or employee of PCC by affinity or consanguinity up to the
				fourth civil degree? ____ Yes ____ No </p>
				<p class="zero_margin">If yes, please indicate the name of the officer / employee and your relation:</p>

				<p class="declaration_2nd">&nbsp;</p>
				<p class="declaration_2nd">&nbsp;</p>

				<p style="margin-top: 5px; padding-top: 5px; text-indent: 50px;">
					 I hereby declare that the above information I have supplied in this form has been made in good faith,
					verified by me, and to the best of my knowledge and belief, is true and correct. If it turns out that: a.) any of
					the information I have supplied herein is false and incorrect; b.) I have supplied the information through
					misrepresentation, deceit, or fraud; or c.) the certificates, diplomas, transcript of records, birth certificates,
					credentials or other supporting documents I have submitted to gain employment or promotion are falsified or
					forged, the same shall be sufficient cause for my dismissal, without prejudice to the right of Pines City
					Colleges to institute the appropriate criminal or civil action against me.
				</p><br><br>
				
				<div class="declaration_footer">
					<p>SIGNATURE OVER PRINTED NAME</p><br><br>
					<p>DATE</p>
				</div>
			</div>

		</div><!-- end of personal Information -->

		<div style="page-break-after: always;"></div>

		<div class="hr_use" style="margin-top: 10px">
			<hr>
			<p class="zero_margin">*For HR Use Only</p>
			<h4 class="zero_margin" style="text-align: center;">Cause of Leaving the Institution</h4>

			<div class="leave_choices">
				<div class="choices_left" style="width: 45%; float: left;">
					<input type="checkbox"> Resigned <br>
					<input type="checkbox"> End of Contract <br>
					<input type="checkbox"> Terminated <br>
					<input type="checkbox"> Retrenched <br>
				</div>
				<div class="choices_right" style="width: 45%; float: left;">
					<input type="checkbox"> AWOL <br>
					<input type="checkbox"> Early Retirement <br>
					<input type="checkbox"> Mandatory Retirement <br>
				</div>
			</div>
			<div class="break"></div><br>

			<h4 style="width: 28%; float: left;">Last Day of the Company:</h4>
			<p class="zero_margin" style="width: 30%; float: left; border-bottom: 1px solid black;">&nbsp;</p>
			<div class="break"></div>

		</div>
	</div>


</body>
</html>