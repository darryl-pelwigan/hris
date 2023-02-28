<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Exporttoexcel_leclab_nsub extends MY_Controller {

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
		$this->load->model('sched_record2/sched_record_model');
		$this->load->model('sched_record2/sched_cs_record_model_wc');
		$this->load->model('student/student_model');
		$this->load->model('admin/user_model');
		$this->load->model('teachersched/sched_model');
		$this->load->helper('transmutation');
		$this->load->helper('gradingsystem');
		$this->load->library('excel');
	#	$this->admin->_check_login();
	}

	public function xcl(){
		$teacher_id = $this->session->userdata('id');
		$type = $this->input->get('type', TRUE);
		$sched_id = $this->input->get('sched_id', TRUE);

		$teacher_info =$this->user_model->get_user_info($teacher_id);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$subject_course =$this->sched_record_model->get_sched_course($subject_info['sched_query'][0]->courseid);
		$subject_info2 =$this->sched_model->get_sched_info($teacher_id,$subject_info['sched_query'][0]->coursecode);
		$check_sched = subject_teacher($subject_info2['sched_query']);
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0){
			$arrayXcl =array("trans",'p','lp','total_pre','m','lm','total_mid','tf','ltf','total_tenta','final_grade');
			$template_xcl="assets/resources/trans-template-wc-leclab.xlsx";
		}else{
			$arrayXcl =array("trans",'p','m','tf','final_grade');
			$template_xcl="assets/resources/trans-template-wc-lec.xlsx";
		}
        $conf=$this->sched_record_model->get_conf( $check_sched[0]['coursecode'], $sched_id ,$teacher_id);

		$conf['configs']=json_decode($conf[0]->configs);
		$student_list=$this->sched_record_model->get_student_list($sched_id,'s.studentid');
		$dateY = date("Y");
		$filename=ucfirst($teacher_info[0]->LastName).ucfirst($teacher_info[0]->FirstName).ucfirst($teacher_info[0]->MiddleName).'_'.$dateY;


		// load template
		$objTpl = PHPExcel_IOFactory::load($template_xcl);
		// activate worksheet number 1
$count = 1;
		foreach ($arrayXcl as $key => $value) {
			if($value!="trans"){
				if(!in_array($value, array('total_pre','total_mid','total_tenta','final_grade'))){
					$type_d=$this->sched_record_model->type($value,$check_sched[0]['acadyear']);
					$exam=$this->sched_record_model->get_subject_exam($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $sched_id ,$value);
					$cs=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,$value);
					$cs_sum=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,$value,'SUM(items) as items_sum')['cs_query'][0]->items_sum;
					if($check_sched['lecunits']>0 && $check_sched['labunits']>0){
					$type_d[8]=  $type_d[8];
					}else{
						$type_d[8]= $type_d[5];
					}

					$objTpl->createSheet();
					$objTpl->setActiveSheetIndex($count);
					$this->xcl_style_cotents($objTpl,$check_sched,$student_list,$count,$cs);
					$this->xcl_header($objTpl,$type_d,$teacher_info,$subject_info2,$subject_info,$subject_course,$conf,$count);
					$this->xcl_contents($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type );
					$count++;
				}elseif(in_array($value, array('total_pre','total_mid','total_tenta'))){

					$type_d['title']=$value;
					$objTpl->createSheet();
					$objTpl->setActiveSheetIndex($count);
					$this->xcl_style_cotents($objTpl,$check_sched,$student_list,$count,$cs);
					$this->xcl_header($objTpl,$type_d,$teacher_info,$subject_info2,$subject_info,$subject_course,$conf,$count);
					$this->xcl_sched($objTpl,$check_sched);
					$this->xcl_contents_leclab_total($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type );
					$count++;
				}else{
					$type_d['title']=$value;
					$objTpl->createSheet();
					$objTpl->setActiveSheetIndex($count);
					$this->xcl_style_cotents($objTpl,$check_sched,$student_list,$count,$cs);
					$this->xcl_header($objTpl,$type_d,$teacher_info,$subject_info2,$subject_info,$subject_course,$conf,$count);
					$this->xcl_sched($objTpl,$check_sched);
					if($check_sched['lecunits']>0 && $check_sched['labunits']>0){
						$this->xcl_contents_finalgrade_leclab($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type );
					}else{
						$this->xcl_contents_finalgrade_lec($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type );
					}
					$count++;
				}


			}
		}

		$filename=$filename.'.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

	}



	public function xcl_contents($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type )
	{
		$teacher_id = $this->session->userdata('id');
      	$aa=5+$check_sched['count'];
		$ccx=7+$check_sched['count'];
		$cc=7+$check_sched['count'];
		$cc_cs=7+$check_sched['count'];
		$xx=count($student_list);
		$this->xcl_sched($objTpl,$check_sched);
		$objTpl->getActiveSheet()->setCellValue('A'.($aa),'NO');
		$objTpl->getActiveSheet()->mergeCells('A'.($aa).':A'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('B'.($aa),'ID');
		$objTpl->getActiveSheet()->mergeCells('B'.($aa).':B'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('C'.($aa),'NAME');
		$objTpl->getActiveSheet()->mergeCells('C'.($aa).':C'.($aa+1));



		for($a=0;$a<$cs['cs_num'];$a++){
			$objTpl->getActiveSheet()->setCellValue(alpbt(4+$a).($aa+1),$cs['cs_query'][$a]->items);
		}
		$cs['cs_check']=1;
		if($cs['cs_num']==0  ){
			$cs['cs_check']=0;
			$cs['cs_num']=2;
		}
		$this->set_formula_sheet0($objTpl,$check_sched,$cs,$exam,$aa,$count,$type_d,$value);
		$this->set_content_th($objTpl,$check_sched,$cs,$exam,$aa,$count,$type_d,$value);
		$letter=$this->get_letter($check_sched,$value);

		for($x=0;$x<count($student_list);$x++){
			$studentid = $student_list[$x]->studentid;
			$student_lfm=($this->student_model->get_student_info($studentid,'lastname , firstname , middlename '));
			$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
			$objRichText = new PHPExcel_RichText();
			$objBold = $objRichText->createTextRun($student_lfm[0]->lastname);
			$objBold->getFont()->setBold(true);
			$objRichText->createText(", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme);
			$objTpl->getActiveSheet()->setCellValue('A'.($cc+$x), $x);
			$objTpl->getActiveSheet()->setCellValue('B'.($cc+$x), $studentid);
			$objTpl->getActiveSheet()->setCellValue('C'.($cc+$x), $objRichText);
			$objTpl->getActiveSheet()->setCellValue(alpbt(4+$cs['cs_num']).($cc+$x),'=SUMIFS('.alpbt(4).($aa+1).':'.alpbt(3+$cs['cs_num']).($aa+1).','.alpbt(4).($cc+$x).':'.alpbt(3+$cs['cs_num']).($cc+$x).',"<>E")');
			$objTpl->getActiveSheet()->setCellValue(alpbt(5+$cs['cs_num']).($cc+$x),'=SUM('.alpbt(4).($cc+$x).':'.alpbt(3+$cs['cs_num']).($cc+$x));
			$objTpl->getActiveSheet()->setCellValue(alpbt(6+$cs['cs_num']).($cc+$x),'=VLOOKUP('.(alpbt(5+$cs['cs_num']).($cc+$x)).','.$letter['cs_trans'].',3,1)');
			$objTpl->getActiveSheet()->setCellValue(alpbt(7+$cs['cs_num']).($cc+$x),'='.(alpbt(6+$cs['cs_num']).($cc+$x)).'*'.alpbt(7+$cs['cs_num']).($aa));
			$objTpl->getActiveSheet()->setCellValue(alpbt(9+$cs['cs_num']).($cc+$x),'=VLOOKUP('.(alpbt(8+$cs['cs_num']).($cc+$x)).','.$letter['e_trans'].',3,1)');
			$objTpl->getActiveSheet()->setCellValue(alpbt(10+$cs['cs_num']).($cc+$x),'='.(alpbt(9+$cs['cs_num']).($cc+$x)).'*'.alpbt(10+$cs['cs_num']).($aa));
			$objTpl->getActiveSheet()->setCellValue(alpbt(11+$cs['cs_num']).($cc+$x),'='.(alpbt(10+$cs['cs_num']).($cc+$x)).'+'.alpbt(7+$cs['cs_num']).($cc+$x));
			if($cs['cs_check']==1){
				for($a=0;$a<$cs['cs_num'];$a++){
					if($this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs['cs_query'][$a]->id,$sched_id,$type )){
						$score = $this->sched_cs_record_model_wc->get_student_cs( $studentid,$cs['cs_query'][$a]->id,$sched_id,$type )[0]->score;
						$objTpl->getActiveSheet()->setCellValue(alpbt(4+$a).($cc+$x),$score);
					}
				}
			}

			if($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0){
				if($this->sched_record_model->get_exam_score($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $studentid , $sched_id , $type ,  $type_d[8])){
					$score_e=$this->sched_record_model->get_exam_score($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $studentid , $sched_id , $type ,  $type_d[8])[0]->{$type_d[8]};
				}else{
					$score_e="";
				}
				$objTpl->getActiveSheet()->setCellValue(alpbt(8+$cs['cs_num']).($cc+$x),($score_e));
			}

		}
		$this->xcl_constyle($objTpl,$cs,$aa,$xx);
		return $objTpl;
	}

	public function xcl_contents_leclab_total($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type )
	{
		$teacher_id = $this->session->userdata('id');

		$p['lec']=0;
		$p['lab']=0;
		 if($exam['exam_query'] && $exam['exam_query'][0]->percentage){
				$percentage=json_decode($exam['exam_query'][0]->percentage);
				$p['lec']=$percentage->{'lec'};
				$p['lab']=$percentage->{'lab'};
		}
		$letter=array('total_pre'=>array('prelim','p'),'total_mid'=>array('midterm','m'),'total_tenta'=>array('tentativefinal','tf'));
		$cs_lec=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,$letter[$value][1]);
		$cs_lab=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,'l'.$letter[$value][1]);
      	if($cs_lec['cs_num']==0  ){
			$cs_lec['cs_num']=2;
		}
		if($cs_lab['cs_num']==0  ){
			$cs_lab['cs_num']=2;
		}

      	$aa=5+$check_sched['count'];
		$ccx=7+$check_sched['count'];
		$cc=7+$check_sched['count'];
		$cc_cs=7+$check_sched['count'];
		$xx=count($student_list);
		$this->xcl_sched($objTpl,$check_sched);
		$objTpl->getActiveSheet()->setCellValue('A'.($aa),'NO');
		$objTpl->getActiveSheet()->mergeCells('A'.($aa).':A'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('B'.($aa),'ID');
		$objTpl->getActiveSheet()->mergeCells('B'.($aa).':B'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('C'.($aa),'NAME');
		$objTpl->getActiveSheet()->mergeCells('C'.($aa).':C'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('D'.($aa),'LEC');
		$objTpl->getActiveSheet()->mergeCells('D'.($aa).':D'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('E'.($aa),$p['lec']);
		$objTpl->getActiveSheet()->mergeCells('E'.($aa).':E'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('F'.($aa),'LAB');
		$objTpl->getActiveSheet()->mergeCells('F'.($aa).':F'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('G'.($aa),$p['lab']);
		$objTpl->getActiveSheet()->mergeCells('G'.($aa).':G'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('H'.($aa),'TOTAL');
		$objTpl->getActiveSheet()->mergeCells('H'.($aa).':H'.($aa+1));
		for($x=0;$x<count($student_list);$x++){
			$studentid = $student_list[$x]->studentid;
			$student_lfm=($this->student_model->get_student_info($studentid,'lastname , firstname , middlename '));
			$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
			$objRichText = new PHPExcel_RichText();
			$objBold = $objRichText->createTextRun($student_lfm[0]->lastname);
			$objBold->getFont()->setBold(true);
			$objRichText->createText(", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme);
			$objTpl->getActiveSheet()->setCellValue('A'.($cc+$x), $x);
			$objTpl->getActiveSheet()->setCellValue('B'.($cc+$x), $studentid);
			$objTpl->getActiveSheet()->setCellValue('C'.($cc+$x), $objRichText);
			$objTpl->getActiveSheet()->setCellValue('D'.($cc+$x), '='.$letter[$value][0].'!'.alpbt(11+$cs_lec['cs_num']).($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('E'.($cc+$x), '=D'.($cc+$x).'*(E'.$aa.'/100)');
			$objTpl->getActiveSheet()->setCellValue('F'.($cc+$x), '=lab_'.$letter[$value][0].'!'.alpbt(11+$cs_lab['cs_num']).($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('G'.($cc+$x), '=F'.($cc+$x).'*(G'.$aa.'/100)');
			$objTpl->getActiveSheet()->setCellValue('H'.($cc+$x),'=E'.($cc+$x).'+'.'G'.($cc+$x));
		}
		return $objTpl;
	}

	public function xcl_contents_finalgrade_leclab($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type )
	{

		$teacher_id = $this->session->userdata('id');
      	$aa=5+$check_sched['count'];
		$ccx=7+$check_sched['count'];
		$cc=7+$check_sched['count'];
		$cc_cs=7+$check_sched['count'];
		$xx=count($student_list);
		$this->xcl_sched($objTpl,$check_sched);
		$objTpl->getActiveSheet()->setCellValue('A'.($aa),'NO');
		$objTpl->getActiveSheet()->mergeCells('A'.($aa).':A'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('B'.($aa),'ID');
		$objTpl->getActiveSheet()->mergeCells('B'.($aa).':B'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('C'.($aa),'NAME');
		$objTpl->getActiveSheet()->mergeCells('C'.($aa).':C'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('D'.($aa),'PRELIM');
		$objTpl->getActiveSheet()->mergeCells('D'.($aa).':D'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('E'.($aa),'MIDTERM');
		$objTpl->getActiveSheet()->mergeCells('E'.($aa).':E'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('F'.($aa),'TENTATIVE');
		$objTpl->getActiveSheet()->mergeCells('F'.($aa).':F'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('G'.($aa),'TOTAL');
		$objTpl->getActiveSheet()->mergeCells('G'.($aa).':G'.($aa+1));

		for($x=0;$x<count($student_list);$x++){
			$studentid = $student_list[$x]->studentid;
			$student_lfm=($this->student_model->get_student_info($studentid,'lastname , firstname , middlename '));
			$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
			$objRichText = new PHPExcel_RichText();
			$objBold = $objRichText->createTextRun($student_lfm[0]->lastname);
			$objBold->getFont()->setBold(true);
			$objRichText->createText(", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme);
			$objTpl->getActiveSheet()->setCellValue('A'.($cc+$x), $x);
			$objTpl->getActiveSheet()->setCellValue('B'.($cc+$x), $studentid);
			$objTpl->getActiveSheet()->setCellValue('C'.($cc+$x), $objRichText);
			$objTpl->getActiveSheet()->setCellValue('D'.($cc+$x), '=total_pre!H'.($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('E'.($cc+$x), '=total_mid!H'.($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('F'.($cc+$x), '=total_tenta!H'.($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('G'.($cc+$x), '=ROUND(SUM(D'.($cc+$x).':F'.($cc+$x).')/3, 2)');
		}
		$objTpl->setActiveSheetIndex(0);
		$cellValues = $objTpl->getActiveSheet()->rangeToArray('A1:W37',null,true,true,true);
		$objTpl->getActiveSheet()->fromArray($cellValues, null, 'A60');
		$objTpl->setActiveSheetIndex($count);
		return $objTpl;
	}

		public function xcl_contents_finalgrade_lec($objTpl,$check_sched,$student_list,$type_d,$exam,$cs,$cs_sum,$value,$count,$sched_id,$type )
	{

		$teacher_id = $this->session->userdata('id');
		$cs_p=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,'p');
		$cs_m=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,'m');
		$cs_tf=$this->sched_cs_record_model_wc->get_cs( $sched_id ,$teacher_id,'tf');
      	if($cs_p['cs_num']==0  ){
			$cs_p['cs_num']=2;
		}
		if($cs_m['cs_num']==0  ){
			$cs_m['cs_num']=2;
		}
		if($cs_tf['cs_num']==0  ){
			$cs_tf['cs_num']=2;
		}
      	$aa=5+$check_sched['count'];
		$ccx=7+$check_sched['count'];
		$cc=7+$check_sched['count'];
		$cc_cs=7+$check_sched['count'];
		$xx=count($student_list);
		$this->xcl_sched($objTpl,$check_sched);
		$objTpl->getActiveSheet()->setCellValue('A'.($aa),'NO');
		$objTpl->getActiveSheet()->mergeCells('A'.($aa).':A'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('B'.($aa),'ID');
		$objTpl->getActiveSheet()->mergeCells('B'.($aa).':B'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('C'.($aa),'NAME');
		$objTpl->getActiveSheet()->mergeCells('C'.($aa).':C'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('D'.($aa),'PRELIM');
		$objTpl->getActiveSheet()->mergeCells('D'.($aa).':D'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('E'.($aa),'MIDTERM');
		$objTpl->getActiveSheet()->mergeCells('E'.($aa).':E'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('F'.($aa),'TENTATIVE');
		$objTpl->getActiveSheet()->mergeCells('F'.($aa).':F'.($aa+1));
		$objTpl->getActiveSheet()->setCellValue('G'.($aa),'TOTAL');
		$objTpl->getActiveSheet()->mergeCells('G'.($aa).':G'.($aa+1));

		for($x=0;$x<count($student_list);$x++){
			$studentid = $student_list[$x]->studentid;
			$student_lfm=($this->student_model->get_student_info($studentid,'lastname , firstname , middlename '));
			$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
			$objRichText = new PHPExcel_RichText();
			$objBold = $objRichText->createTextRun($student_lfm[0]->lastname);
			$objBold->getFont()->setBold(true);
			$objRichText->createText(", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme);
			$objTpl->getActiveSheet()->setCellValue('A'.($cc+$x), $x);
			$objTpl->getActiveSheet()->setCellValue('B'.($cc+$x), $studentid);
			$objTpl->getActiveSheet()->setCellValue('C'.($cc+$x), $objRichText);
			$objTpl->getActiveSheet()->setCellValue('D'.($cc+$x), '=prelim!'.alpbt(11+$cs_p['cs_num']).($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('E'.($cc+$x), '=midterm!'.alpbt(11+$cs_m['cs_num']).($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('F'.($cc+$x), '=tentativefinal!'.alpbt(11+$cs_tf['cs_num']).($cc+$x));
			$objTpl->getActiveSheet()->setCellValue('G'.($cc+$x), '=ROUND(SUM(D'.($cc+$x).':F'.($cc+$x).')/3, 2)');
		}
		return $objTpl;
	}

	public function set_content_th($objTpl,$check_sched,$cs,$exam,$aa,$count,$type_d,$value){
		$objTpl->getActiveSheet()->setCellValue('D'.($aa),'C.S.');
			$objTpl->getActiveSheet()->mergeCells('D'.($aa).':'.alpbt(3+$cs['cs_num']).($aa));
			$objTpl->getActiveSheet()->setCellValue(alpbt(4+$cs['cs_num']).($aa),'TOTAL E');
			$objTpl->getActiveSheet()->setCellValue(alpbt(4+$cs['cs_num']).($aa+1),'=SUM(D'.($aa+1).':'.alpbt(3+$cs['cs_num']).($aa+1));
			$objTpl->getActiveSheet()->getColumnDimension(alpbt(4+$cs['cs_num']))->setVisible(false);
			$objTpl->getActiveSheet()->setCellValue(alpbt(5+$cs['cs_num']).($aa),'TOTAL');
			$objTpl->getActiveSheet()->setCellValue(alpbt(5+$cs['cs_num']).($aa+1),'=SUM(D'.($aa+1).':'.alpbt(3+$cs['cs_num']).($aa+1));
			$objTpl->getActiveSheet()->setCellValue(alpbt(6+$cs['cs_num']).($aa),"Trans ");
			$objTpl->getActiveSheet()->mergeCells(alpbt(6+$cs['cs_num']).($aa).':'.alpbt(6+$cs['cs_num']).($aa+1));
			$objTpl->getActiveSheet()->setCellValue(alpbt(7+$cs['cs_num']).($aa),$type_d[1]);
			$objTpl->getActiveSheet()->mergeCells(alpbt(7+$cs['cs_num']).($aa).':'.alpbt(7+$cs['cs_num']).($aa+1));
			$objTpl->getActiveSheet()->setCellValue(alpbt(8+$cs['cs_num']).($aa),"EXAM ");
			if($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0){
				$objTpl->getActiveSheet()->setCellValue(alpbt(8+$cs['cs_num']).($aa+1),$exam['exam_query'][0]->{$type_d[8]});
			}else{
				$objTpl->getActiveSheet()->setCellValue(alpbt(8+$cs['cs_num']).($aa+1),0);
			}
			$objTpl->getActiveSheet()->setCellValue(alpbt(9+$cs['cs_num']).($aa),"TRANS ");
			$objTpl->getActiveSheet()->mergeCells(alpbt(9+$cs['cs_num']).($aa).':'.alpbt(9+$cs['cs_num']).($aa+1));
			$objTpl->getActiveSheet()->setCellValue(alpbt(10+$cs['cs_num']).($aa),$type_d[2]);
			$objTpl->getActiveSheet()->mergeCells(alpbt(10+$cs['cs_num']).($aa).':'.alpbt(10+$cs['cs_num']).($aa+1));
			$objTpl->getActiveSheet()->setCellValue(alpbt(11+$cs['cs_num']).($aa),"PRELIM GRADE");
			$objTpl->getActiveSheet()->mergeCells(alpbt(11+$cs['cs_num']).($aa).':'.alpbt(11+$cs['cs_num']).($aa+1));

		return $objTpl;
	}

	public function get_letter($check_sched,$value){
		$letter=array(
					'p'=>array(
								'cs_alph'=>"B1",
								'e_alph'=>"AB1",
								'cs_trans'=>"TRANS!U2:W37",
								'e_trans'=>"TRANS!AU2:AW37",
							),
					'm'=>array(
								'cs_alph'=>"BA1",
								'e_alph'=>"BZ1",
								'cs_trans'=>"TRANS!BT2:BV37",
								'e_trans'=>"TRANS!CS2:CU37",
							),
					'tf'=>array(
								'cs_alph'=>"CY1",
								'e_alph'=>"DX1",
								'cs_trans'=>"TRANS!DR2:DT37",
								'e_trans'=>"TRANS!EQ2:ES37",
							),
					'lp'=>array(
								'cs_alph'=>"FV1",
								'e_alph'=>"GU1",
								'cs_trans'=>"TRANS!GO2:GQ37",
								'e_trans'=>"TRANS!HN2:HP37",
							),
					'lm'=>array(
								'cs_alph'=>"HT1",
								'e_alph'=>"IS1",
								'cs_trans'=>"TRANS!IM2:IO37",
								'e_trans'=>"TRANS!JL2:JN37",
							),
					'ltf'=>array(
								'cs_alph'=>"JR1",
								'e_alph'=>"KQ1",
								'cs_trans'=>"TRANS!KK2:KM37",
								'e_trans'=>"TRANS!LJ2:LL37",
							)

				);


		return $letter[$value];
	}


	public function set_formula_sheet0($objTpl,$check_sched,$cs,$exam,$aa,$count,$type_d,$value){
		$objTpl->setActiveSheetIndex(0);
		$letter=$this->get_letter($check_sched,$value);
		$objTpl->getActiveSheet()->setCellValue($letter['cs_alph'],'='.$type_d['title'].'!'.alpbt(5+$cs['cs_num']).($aa+1));
		$objTpl->getActiveSheet()->setCellValue($letter['e_alph'],'='.$type_d['title'].'!'.alpbt(8+$cs['cs_num']).($aa+1));
		$objTpl->setActiveSheetIndex($count);
		return $objTpl;
	}

	public function xcl_style(){
		$styleArray['Logo'] = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '006600'),
								        'size'  => 20,
								        'name'  => 'Trajan Pro'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							        	)
				    );
		$styleArray['Ins'] = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '000000'),
								        'size'  => 16,
								        'name'  => 'Century Gothic'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							        	)
				    );
		$styleArray['Sub'] = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '000000'),
								        'size'  => 12,
								        'name'  => 'Century Gothic'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							            'wrap' => 1,
							            'indent' => 1
							        	)
				    );
		$styleArray['Sub2'] = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '0C5770'),
								        'size'  => 11,
								        'name'  => 'Century Gothic'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
							            'wrap' => 1,
							            'indent' => 1
							        	)
				    );
		$styleArray['Th'] = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '063FF4'),
								        'size'  => 14,
								        'name'  => 'Baskerville Old Face'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							            'wrap' => 1,
							            'indent' => 1
							        	)
				    );
		// Style for header info CS  and Exam
		$styleArray['Th2'] = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '78060E'),
								        'size'  => 12,
								        'name'  => 'Arial'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							            'wrap' => 1
							        	)
				    );
		// Style for header total of cs and exam
		$styleArray['Th3'] = array(
				    	'font'  => array(
								        'bold'  => false,
								        'color' => array('rgb' => '046E04'),
								        'size'  => 12,
								        'name'  => 'Baskerville Old Face'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							        	)
				    );
		$styleArray['Th3b'] = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '046E04'),
								        'size'  => 12,
								        'name'  => 'Baskerville Old Face'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							        	)
				    );
		// $styleArray['Tb'] = array(
		// 		    	'font'  => array(
		// 						        'bold'  => false,
		// 						        'color' => array('rgb' => '000000'),
		// 						        'size'  => 11,
		// 						        'name'  => 'Arial Narrow'
		// 						        ),
		// 		        'alignment' => array(
		// 		        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		// 					            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		// 					            'wrap' => 1
		// 					        	),

		// 		    );
		// // style for scores set center
		$styleArray['TbB'] = array(
				    	'font'  => array(
								        'bold'  => false,
								        'color' => array('rgb' => '000000'),
								        'size'  => 11,
								        'name'  => 'Arial Narrow'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							            'wrap' => 1,
							            'indent' => 1
							        	),

				    );


		/*Conditional Styles for total grade passed=green failed=red*/
		$styleArray['2'] = array(
						    'font'  => array(
						        'bold'  => true,
						        'color' => array('rgb' => '099E1B'),
						        'size'  => 10,
						        'name'  => 'Tahoma'
						    ));

		$styleArray['3'] = array(
						    'font'  => array(
						        'bold'  => true,
						        'color' => array('rgb' => '9E0909'),
						        'size'  => 10,
						        'name'  => 'Tahoma'
						    ));
		return $styleArray;

	}

	public function xcl_style_cotents($objTpl,$check_sched,$student_list,$count,$cs=0){
		if($cs['cs_num']==0  ){
			$cs['cs_num']=2;
		}
		$aa=5+$check_sched['count'];
		$styleArray=$this->xcl_style();
		$objDrawing = new PHPExcel_Worksheet_Drawing();
	    $objDrawing->setName('Logo');
	    $objDrawing->setDescription('Logo');
	    $logo = ('./assets/images/logo220.png'); // Provide path to your logo file
	    $objDrawing->setPath($logo);
	    $objDrawing->setOffsetX(10);    // setOffsetX works properly
	    $objDrawing->setOffsetY(10);  //setOffsetY has no effect
	    $objDrawing->setCoordinates('A1');
	    $objDrawing->setHeight(50);
	    $objDrawing->setWidth(50);
	    $objDrawing->setWorksheet($objTpl->getActiveSheet());
	    $objTpl->getActiveSheet()->getRowDimension('1')->setRowHeight(50);
	    $objTpl->getActiveSheet()->getColumnDimension('C')->setWidth(35);

		$objTpl->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray['Logo']);
		$objTpl->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArray['Ins']);
		$objTpl->getActiveSheet()->getStyle('A3:R3')->applyFromArray($styleArray['Sub']);
		$objTpl->getActiveSheet()->getStyle('A4:R4')->applyFromArray($styleArray['Sub']);
		$objTpl->getActiveSheet()->getStyle('A5:R'.(4+$check_sched['count']))->applyFromArray($styleArray['Sub2']);
		$objTpl->getActiveSheet()->getStyle('A'.($aa).':'.alpbt(11+$cs['cs_num']).($aa))->applyFromArray($styleArray['Th']);
		$objTpl->getActiveSheet()->getStyle('A'.($aa+1).':B'.($aa+count($student_list)+1))->applyFromArray($styleArray['TbB']);
		$objTpl->getActiveSheet()->getStyle('D'.($aa+1).':'.alpbt(11+$cs['cs_num']).($aa+count($student_list)+1))->applyFromArray($styleArray['TbB']);
		// $objTpl->getActiveSheet()->getStyle('A'.($ccx).':A'.$cc)->applyFromArray($styleArray['Tb']);
		// $objTpl->getActiveSheet()->getStyle('B'.($ccx).':B'.$cc)->applyFromArray($styleArray['TbB']);
		// $objTpl->getActiveSheet()->getStyle('D'.($ccx).':AA'.$cc)->applyFromArray($styleArray['TbB']);
		return $objTpl;
	}

	public function xcl_constyle($objTpl,$cs,$aa,$xx){
		$styleArray=$this->xcl_style();
         /*Conditional Styles*/
      	$objConditional[1] = new PHPExcel_Style_Conditional();
      	$objConditional[1]->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                      	->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
                      	->addCondition('75');
      	$objConditional[1]->getStyle()->applyFromArray($styleArray['2']);
      	$objConditional[1]->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00  );


      	$objConditional[2] = new PHPExcel_Style_Conditional();
      	$objConditional[2]->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                      	->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN )
                      	->addCondition('75');
      	$objConditional[2]->getStyle()->applyFromArray($styleArray['3']);
      	$objConditional[2]->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00  );
      	$conditionalStyles = $objTpl->getActiveSheet()->getStyle(alpbt(11+$cs['cs_num']).($aa))->getConditionalStyles();
                              array_push($conditionalStyles, $objConditional[1]);
                              array_push($conditionalStyles, $objConditional[2]);
                    		$objTpl->getActiveSheet()->getStyle(alpbt(11+$cs['cs_num']).($aa).':'.alpbt(11+$cs['cs_num']).($aa+$xx+1))->setConditionalStyles($conditionalStyles);
                    		$objTpl->getActiveSheet()->getStyle('final_grade!G'.($aa).':G'.($aa+$xx+1))->setConditionalStyles($conditionalStyles);
      	return $objTpl;
	}

	public function xcl_header($objTpl,$type_d,$teacher_info,$subject_info2,$subject_info,$subject_course,$conf,$count){
		$objTpl->getActiveSheet()->setTitle($type_d['title']);
		$objTpl->getActiveSheet()->setCellValue('A1',('Pines City Colleges'));
		$objTpl->getActiveSheet()->mergeCells('A1:G1');
		$objTpl->getActiveSheet()->setCellValue('A2',(ucfirst($teacher_info[0]->LastName).', '.ucfirst($teacher_info[0]->FirstName).' '.ucfirst($teacher_info[0]->MiddleName)));
		$objTpl->getActiveSheet()->mergeCells('A2:C2');
		$objTpl->getActiveSheet()->setCellValue('A3',('Section : '.$subject_info2['sched_query'][0]->section.' SY : '.$subject_info2['sched_query'][0]->schoolyear) );
		$objTpl->getActiveSheet()->mergeCells('A3:C3');
		$objTpl->getActiveSheet()->setCellValue('A4',strtoupper($subject_info2['sched_query'][0]->description));
		$objTpl->getActiveSheet()->mergeCells('A4:C4');
		$objTpl->getActiveSheet()->setCellValue('D3',($subject_course[0]->course.'-'.$subject_info['sched_query'][0]->yearlvl));
		$objTpl->getActiveSheet()->mergeCells('D3:I3');
		$objTpl->getActiveSheet()->setCellValue('D4',strtoupper($subject_info2['sched_query'][0]->courseno));
		$objTpl->getActiveSheet()->mergeCells('D4:E4');
		$objTpl->getActiveSheet()->setCellValue('F4','PERCENTAGE');
		$objTpl->getActiveSheet()->setCellValue('G4',$conf['configs']->percent);
		$objTpl->setActiveSheetIndex(0);
		$objTpl->getActiveSheet()->setCellValue('A1',$conf['configs']->percent);
		$objTpl->setActiveSheetIndex($count);
		return $objTpl;
	}

	public function xcl_sched($objTpl,$check_sched,$th_c=5){
		for($th=0;$th<$check_sched['count'];$th++){
			$objTpl->getActiveSheet()->setCellValue('A'.($th_c+$th),$check_sched[0]['room']?$check_sched[0]['room']:"NO ROOM");
			$objTpl->getActiveSheet()->mergeCells('A'.($th_c+$th).':B'.($th_c+$th));
			$objTpl->getActiveSheet()->setCellValue('C'.($th_c+$th),$check_sched[0]['days']);
			$objTpl->getActiveSheet()->setCellValue('D'.($th_c+$th),($check_sched[0]['start'].'-'.$check_sched[0]['end']));
			$objTpl->getActiveSheet()->mergeCells('D'.($th_c+$th).':F'.($th_c+$th));
			$objTpl->getActiveSheet()->setCellValue('G'.($th_c+$th),($check_sched[0]['type']));
		}
		return $objTpl;
	}





}
