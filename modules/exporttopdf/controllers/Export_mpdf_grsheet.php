<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Export_mpdf_grsheet extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
		parent::__construct();
		$this->load->module('admin/admin');
		$this->load->model('sched_record2/sched_cs_record_model');
		$this->load->model('teacher_profile/user_model');
		$this->load->model('teachersched/sched_model');
		$this->load->module('sched_record2/sched_record_list');
		$this->load->module('sched_record2/sched_intern_record');
		$this->load->module('sched_record2/sched_finalgrade_record');
		$this->load->module('sched_record2/sched_total_leclab');
		$this->load->model('sched_record2/sched_record_model');

		$this->load->module('sched_record2/sched_record2');
		$this->load->module('sched_record2/sched_intern_record');
		$this->admin->_check_login();
	}
	public function types2(){
		 $data["subjec_data"]=' <img class="logo" src="assets/images/logo.png"  width="80px" />';
		 $data['grades']['table']='';
		 $data['grades2']['table']='';
		$data['grades3']['table']='';
		$html = $this->load->view('pdf_report', $data, true); // render the view into HTML
			$this->load->library("pdf");
			$pdf = $this->pdf->load();

			$pdf->WriteHTML($html); // write the HTML into the PDF
			$pdf->Output("test.pdf" , 'I'); // save to file because we can
	}
	public function types(){
		$data['teacher_id'] = $this->session->userdata('id');
		$filename=$data['teacher_id'].now();



		$data['labunits'] = $this->input->get('labunits', TRUE);
		$data['type'] = $this->input->get('type', TRUE);
		$data['sem'] = $this->input->get('sem', TRUE);
		$data['sched_id'] = $this->input->get('sched_id', TRUE);

		$data['teacher_info'] =$this->user_model->get_user_info($data['teacher_id']);
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$data['sched_id']);
		$data['subject_course'] =$this->sched_record_model->get_sched_course($data['subject_info']['sched_query'][0]->courseid);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$type_d=$this->sched_record_model->type($data['type'],$data['check_sched'][0]['acadyear']);


		$data['subjec_data'] = "
							<div class='row' id='subject_information'>
									<div class='col-lg-12'>
									<div class='panel panel-success'>
											<div class='panel-heading'>
												<strong>Subject</strong>
											</div>
											<div class='panel-body'>
											<div class='col-md-8'>INSTRUCTOR : <strong>".strtoupper($data['teacher_info'][0]->LastName).", ".strtoupper($data['teacher_info'][0]->FirstName)." ".strtoupper($data['teacher_info'][0]->MiddleName)[0].".</strong> DEPARTMENT : <strong>".strtoupper($data['subject_course'][0]->code)."</strong></div>
											<div class='col-md-8'>DESCRIPTION : <strong>".strtoupper($data['subject_info']['sched_query'][0]->description)."</strong>
											TYPE : <strong>".strtoupper($data['subject_info']['sched_query'][0]->type)."</strong>
											SUBJECT CODE : <strong>".strtoupper($data['subject_info']['sched_query'][0]->courseno)."</strong></div>
											<div class='col-md-6'>SCHEDULE :<br />";

											for($x=0;$x<$data['check_sched']['count'];$x++){
												$data['subjec_data'] .="<strong>".strtoupper($data['check_sched'][$x]['days'])." ".($data['check_sched'][$x]['start'])." - ".($data['check_sched'][$x]['end']);
												$data['subjec_data'] .=($data['check_sched'][$x]['lecunits']>0)?" LECTURE ":"";
												$data['subjec_data'] .=($data['check_sched'][$x]['labunits']>0)?" LABORATORY ":"";
												$data['subjec_data'] .= " ( ".strtoupper($data['check_sched'][$x]['room'])." )</strong><br />";
											 }
											$data['subjec_data'] .="</div> </div> </div> </div> </div>";

			$data["title"]="PDF GRADES REPORT FOR ".$type_d[0] . " BY : " .strtoupper($data['teacher_info'][0]->LastName).", ".strtoupper($data['teacher_info'][0]->FirstName)." ".strtoupper($data['teacher_info'][0]->MiddleName)[0].'.';
			$html = $this->load->view('pdf_report', $data, true); // render the view into HTML
			$this->load->library("pdf");
			$pdf = $this->pdf->load();  // L - landscape, P - portrait

			if($data['type']  == 'f'){
			 $pdf->mPDF('utf-8','Legal','','','10','10','37','15');
			}else{
				$pdf->mPDF('utf-8',
					'Legal-L',
					'',
					'0', // margin bottom
					'10',  // margin left
					'10', // margin right
					'37' // margin top
					);
			}

			$pdf->SetHTMLHeader('
									<div class="row header-wrapper">
										<div class="col-md-4 ">
												<div class="col-md-4 header" >
												 <img class="logo" src="assets/images/logo.png"  width="80px" />
														<p class="header_title" >Pines City Colleges</p><br/>
														<p class="header_title_l t_sm1">Magsaysay Avenue, Happy Homes, Baguio City, 2600 Benguet</p>
														<p class="header_title_l t_sm2">Tel. nos.:(074)445-2210, 445-2290 Fax:(074)445-2208</p>
														<p class="header_title_l t_sm3">www.pcc.edu.ph</p>
												</div>
												<div class="col-md-4 right" >
										</div>
									</div>
									',1,true);
			// $pdf->showImageErrors=true;
			$pdf->SetFooter(''."<strong>".strtoupper($data['teacher_info'][0]->LastName).", ".strtoupper($data['teacher_info'][0]->FirstName)." ".strtoupper($data['teacher_info'][0]->MiddleName)[0].".</strong>  <strong>(".strtoupper($data['subject_course'][0]->code)." <strong> ".strtoupper($data['subject_info']['sched_query'][0]->courseno)."</strong>)</strong> ".'|{PAGENO}|'.date("Y-m-d H:i:s")); // Add a footer for good measure
			$pdf->WriteHTML($html); // write the HTML into the PDF
			$pdfFilePath = strtoupper($data['teacher_info'][0]->LastName).", ".strtoupper($data['teacher_info'][0]->FirstName)." ".strtoupper($data['teacher_info'][0]->MiddleName)[0].'_'.$data['teacher_id'].'_'.strtoupper($data['subject_info']['sched_query'][0]->courseno).'_'.$data['sched_id'].'('.date("Y-m-d HisA").").pdf";

			$pdf->Output($pdfFilePath , 'I'); // save to file because we can

	}

}
