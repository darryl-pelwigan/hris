<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Exporttoexcel_lec extends MY_Controller {

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
		$this->load->model('sched_record/sched_record_model');
		$this->load->model('sched_record/sched_cs_record_model');
		$this->load->model('student/student_model');
		$this->load->model('admin/user_model');
		$this->load->model('teachersched/sched_model');
		$this->load->helper('transmutation');
		$this->load->helper('gradingsystem');
		$this->admin->_check_login();
	}
	public function test()
	{
		$teacher_id = $this->session->userdata('id');
		$type = $this->input->get('type', TRUE);
		$sched_id = $this->input->get('sched_id', TRUE);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$subject_course =$this->sched_record_model->get_sched_course($subject_info['sched_query'][0]->courseid);
		$subject_info2 =$this->sched_model->get_sched_info($teacher_id,$subject_info['sched_query'][0]->coursecode);
		$check_sched = subject_teacher($subject_info2['sched_query']);
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$cs=$this->sched_record_model->get_subject_cs( $check_sched['labunits'] , $teacher_id , $sched_id ,$type);
		$cs_items_count=0;
		$xx=2;
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0){$type_d[8]=  $type_d[8];}
        else{$type_d[8]= $type_d[5];}
		$exam=$this->sched_record_model->get_subject_exam($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $sched_id ,$type);
		if($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0){
			echo 'if';
		}else{
			echo 'else';
		}


	}

	public function export_grades()
	{

		$teacher_id = $this->session->userdata('id');

		$type = $this->input->get('type', TRUE);
		$sched_id = $this->input->get('sched_id', TRUE);


		$teacher_info =$this->user_model->get_user_info($teacher_id);
		$subject_info =$this->sched_record_model->get_sched_info($teacher_id,$sched_id);
		$subject_course =$this->sched_record_model->get_sched_course($subject_info['sched_query'][0]->courseid);
		$subject_info2 =$this->sched_model->get_sched_info($teacher_id,$subject_info['sched_query'][0]->coursecode);
		$check_sched = subject_teacher($subject_info2['sched_query']);
		$type_d=$this->sched_record_model->type($type,$check_sched[0]['acadyear']);
		$exam=$this->sched_record_model->get_subject_exam($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $sched_id ,$type);
		if($check_sched['lecunits']>0 && $check_sched['labunits']>0){$type_d[8]=  $type_d[8];}
        else{$type_d[8]= $type_d[5];}

		// Class Standing


		$student_list=$this->sched_record_model->get_student_list($sched_id,'s.studentid');
		$dateY = date("Y");
		$filename=ucfirst($teacher_info[0]->LastName).ucfirst($teacher_info[0]->FirstName).ucfirst($teacher_info[0]->MiddleName).'_'.$dateY;

		// load our new PHPExcel library
		$this->load->library('excel');
		// activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		// name the worksheet
		$this->excel->getActiveSheet()->setTitle($type_d[0]);
		$this->excel->getActiveSheet()->setCellValue('A1',('Pines City Colleges'));
		$this->excel->getActiveSheet()->mergeCells('A1:G1');

		$this->excel->getActiveSheet()->setCellValue('A2',(ucfirst($teacher_info[0]->LastName).', '.ucfirst($teacher_info[0]->FirstName).' '.ucfirst($teacher_info[0]->MiddleName)));
		$this->excel->getActiveSheet()->mergeCells('A2:C2');
		$this->excel->getActiveSheet()->setCellValue('A3',('Section : '.$subject_info2['sched_query'][0]->section.' SY : '.$subject_info2['sched_query'][0]->schoolyear) );
		$this->excel->getActiveSheet()->mergeCells('A3:C3');
		$this->excel->getActiveSheet()->setCellValue('A4',strtoupper($subject_info2['sched_query'][0]->description));
		$this->excel->getActiveSheet()->mergeCells('A4:C4');
		$this->excel->getActiveSheet()->setCellValue('D3',($subject_course[0]->course.'-'.$subject_info['sched_query'][0]->yearlvl));
		$this->excel->getActiveSheet()->mergeCells('D3:I3');
		$this->excel->getActiveSheet()->setCellValue('D4',strtoupper($subject_info2['sched_query'][0]->courseno));
		$this->excel->getActiveSheet()->mergeCells('D4:E4');

		$styleArrayLogo = array(
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
		$styleArrayIns = array(
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
		$styleArraySub = array(
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
		$styleArraySub2 = array(
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
		$styleArrayTh = array(
				    	'font'  => array(
								        'bold'  => true,
								        'color' => array('rgb' => '063FF4'),
								        'size'  => 14,
								        'name'  => 'Baskerville Old Face'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
							        	)
				    );
		// Style for header info CS  and Exam
		$styleArrayTh2 = array(
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
		$styleArrayTh3 = array(
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
		$styleArrayTh3b = array(
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
		$styleArrayTb = array(
				    	'font'  => array(
								        'bold'  => false,
								        'color' => array('rgb' => '000000'),
								        'size'  => 11,
								        'name'  => 'Arial Narrow'
								        ),
				        'alignment' => array(
				        				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
							            'wrap' => 1
							        	),

				    );
		// style for scores set center
		$styleArrayTbB = array(
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
$styleArray2 = array(
				    'font'  => array(
				        'bold'  => true,
				        'color' => array('rgb' => '099E1B'),
				        'size'  => 10,
				        'name'  => 'Tahoma'
				    ));

$styleArray3 = array(
				    'font'  => array(
				        'bold'  => true,
				        'color' => array('rgb' => '9E0909'),
				        'size'  => 10,
				        'name'  => 'Tahoma'
				    ));

         /*Conditional Styles*/
                          $objConditional1 = new PHPExcel_Style_Conditional();
                          $objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                                          ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
                                          ->addCondition('75');
                          $objConditional1->getStyle()->applyFromArray($styleArray2);
                          $objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00  );


                          $objConditional2 = new PHPExcel_Style_Conditional();
                          $objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
                                          ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHANOREQUAL )
                                          ->addCondition('74');
                          $objConditional2->getStyle()->applyFromArray($styleArray3);
                          $objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00  );


		if($check_sched['count']==1){
			$this->excel->getActiveSheet()->setCellValue('A5',$check_sched[0]['room']);
			$this->excel->getActiveSheet()->mergeCells('A5:B5');
			$this->excel->getActiveSheet()->setCellValue('C5',$check_sched[0]['days']);
			$this->excel->getActiveSheet()->setCellValue('D5',($check_sched[0]['start'].'-'.$check_sched[0]['end']));
			$this->excel->getActiveSheet()->mergeCells('D5:F5');
			$this->excel->getActiveSheet()->setCellValue('G5',($check_sched[0]['type']));
			$d=6;
		}else{
			$this->excel->getActiveSheet()->setCellValue('A5',$check_sched[0]['room']);
			$this->excel->getActiveSheet()->mergeCells('A5:B5');
			$this->excel->getActiveSheet()->setCellValue('C5',$check_sched[0]['days']);
			$this->excel->getActiveSheet()->setCellValue('A6',$check_sched[1]['room']);
			$this->excel->getActiveSheet()->mergeCells('A6:B6');
			$this->excel->getActiveSheet()->setCellValue('C6',$check_sched[1]['days']);
			$this->excel->getActiveSheet()->setCellValue('D5',($check_sched[0]['start'].'-'.$check_sched[0]['end']));
			$this->excel->getActiveSheet()->mergeCells('D5:F5');
			$this->excel->getActiveSheet()->setCellValue('D6',($check_sched[1]['start'].'-'.$check_sched[1]['end']));
			$this->excel->getActiveSheet()->mergeCells('D6:F6');
			$this->excel->getActiveSheet()->setCellValue('G5',($check_sched[0]['type']));
			$this->excel->getActiveSheet()->setCellValue('G6',($check_sched[1]['type']));
			$d=7;
		}
		$aa=5+$check_sched['count'];
		$ccx=8+$check_sched['count'];
		$cc=8+$check_sched['count'];
		$cc_cs=8+$check_sched['count'];
		$xx=4;
		$this->excel->getActiveSheet()->setCellValue('A'.($aa),'NO');
		$this->excel->getActiveSheet()->mergeCells('A'.($aa).':A'.($aa+2));
		$this->excel->getActiveSheet()->setCellValue('B'.($aa),'ID');
		$this->excel->getActiveSheet()->mergeCells('B'.($aa).':B'.($aa+2));
		$this->excel->getActiveSheet()->setCellValue('C'.($aa),'NAME');
		$this->excel->getActiveSheet()->mergeCells('C'.($aa).':C'.($aa+2));

		  $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $logo = ('./assets/images/logo.png'); // Provide path to your logo file
            $objDrawing->setPath($logo);
            $objDrawing->setOffsetX(10);    // setOffsetX works properly
            $objDrawing->setOffsetY(10);  //setOffsetY has no effect
            $objDrawing->setCoordinates('A1');
	        $objDrawing->setHeight(50);
	        $objDrawing->setWidth(50);
            $objDrawing->setWorksheet($this->excel->getActiveSheet());
            $this->excel->getActiveSheet()->getRowDimension('1')->setRowHeight(50);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);

            $cs=$this->sched_record_model->get_subject_cs( $check_sched['labunits'] , $teacher_id , $sched_id ,$type);
			$cs_items_count=0;
			if($cs['cs_num']>0 || ($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0)  ){
				if($cs['cs_num']>0){
					for ($c=0;$c<count($cs["cs_query"]) ; $c++) {
						$cs_items=$this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs["cs_query"][$c]->id,$type);
						$cs_items_count=$cs_items_count+$cs_items['cs_i_num'];
						$cs_i_total=0;
						if($cs_items['cs_i_num']>0){
							for($cx=0;$cx<$cs_items['cs_i_num'];$cx++){
								$cs_i_total=$cs_i_total+$cs_items['cs_i_query'][$cx]->items;
								$this->excel->getActiveSheet()->setCellValue(alpbt($xx).($d+1),$cs_items['cs_i_query'][$cx]->title);
								$this->excel->getActiveSheet()->setCellValue(alpbt($xx).($d+2),$cs_items['cs_i_query'][$cx]->items);
								$this->excel->getActiveSheet()->getStyle(alpbt($xx).($d+2))->applyFromArray($styleArrayTh3);
								$xx=$xx+1;
							}
							$cs_sum_itemsx=0;
							if($cs_i_total<=200 ){
								$cs_sum_itemsx = $cs_i_total;
							}else{
								if((($cs_i_total)%20==0) && $cs_i_total>200 && $cs_i_total<=400){
									$cs_sum_itemsx='='.$cs_i_total.'/2';
								}else{

								}
							}

							$this->excel->getActiveSheet()->setCellValue(alpbt($xx).($d+1),"Total");
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx).($d+2),$cs_sum_itemsx);
							$this->excel->getActiveSheet()->getStyle(alpbt($xx).($d+2))->applyFromArray($styleArrayTh3b);
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx+1).($d+1),"Trans (99)");
							$this->excel->getActiveSheet()->mergeCells(alpbt($xx+1).($d+1).':'.alpbt($xx+1).($d+2));
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx+2).($d+1),$cs['cs_query'][$c]->percent."%");
							$this->excel->getActiveSheet()->mergeCells(alpbt($xx+2).($d+1).':'.alpbt($xx+2).($d+2));
						}
							$xx=$xx+3;
					}
				$e_total='';
				if($exam["exam_query"]){
					$e_total=$exam["exam_query"][0]->{$type_d[8]};
				}
					$this->excel->getActiveSheet()->setCellValue(alpbt($xx).($d+1),'total (100%)');
					$this->excel->getActiveSheet()->mergeCells(alpbt($xx).($d+1).':'.alpbt($xx).($d+2));
					$this->excel->getActiveSheet()->setCellValue(alpbt($xx+1).($d+1),$type_d[3]);
					$this->excel->getActiveSheet()->mergeCells(alpbt($xx+1).($d+1).':'.alpbt($xx+1).($d+2));
			}

			if(($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0)  ){
				$this->excel->getActiveSheet()->setCellValue(alpbt($xx+2).($d+1),'EXAM');
				$this->excel->getActiveSheet()->setCellValue(alpbt($xx+2).($d+2),$e_total);
				$this->excel->getActiveSheet()->setCellValue(alpbt($xx+3).($d+1),'TRANS (99)');
				$this->excel->getActiveSheet()->setCellValue(alpbt($xx+4).($d+1),$type_d[4]);
				$this->excel->getActiveSheet()->setCellValue(alpbt($xx+5).($d+1),$type_d[0]);
			}

			}



			for($x=0;$x<count($student_list);$x++){
				$bb=4;
				$bbx=4;
				$studentid = $student_list[$x]->studentid;
				$student_lfm=($this->student_model->get_student_info($studentid,'lastname , firstname , middlename '));
				$midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';
				$objRichText = new PHPExcel_RichText();
				$objBold = $objRichText->createTextRun($student_lfm[0]->lastname);
				$objBold->getFont()->setBold(true);
				$objRichText->createText(", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme);
				$this->excel->getActiveSheet()->setCellValue('A'.$cc, $x);
				$this->excel->getActiveSheet()->setCellValue('B'.$cc, $studentid);
				$this->excel->getActiveSheet()->setCellValue('C'.$cc, $objRichText);
				if($cs['cs_num']>0 || ($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0) ){
					// start CS SCORE
					if($cs['cs_num']>0){
							for($c=0;$c<$cs['cs_num'];$c++){
								$percent=($cs['cs_query'][$c]->percent)/100;
								$cs_id=$cs['cs_query'][$c]->id;
								$cs_items=$this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs_id,$type);
								$cs_i_total=$this->sched_cs_record_model->view_cs_items($teacher_id,$sched_id,$cs_id,$type,'SUM(items) as items');
								if($cs_items['cs_i_num']>0){
																	for($v=0;$v<$cs_items['cs_i_num'];$v++){
																		if($this->sched_record_model->get_cs_score( $check_sched['labunits'] ,$studentid , $cs_id ,$cs_items['cs_i_query'][$v]->id , $type , 'sc_score' )){
																			$score =	$this->sched_record_model->get_cs_score( $check_sched['labunits'] ,$studentid , $cs_id ,$cs_items['cs_i_query'][$v]->id , $type , 'sc_score' )[0]->sc_score;
																		}else{
																			$score = 0;
																		}
																		$this->excel->getActiveSheet()->setCellValue(alpbt($bb).$cc, $score);
																		$bb=$bb+1;
																	}
								$cs_sum_itemsx = 0;
								$cs_sum_itemsv = 0;
									if(($cs_i_total['cs_i_query'][0]->items)<=200 ){
										$cs_sum_itemsv = $cs_i_total['cs_i_query'][0]->items;
										$cs_sum_itemsx = '=SUM('.alpbt($bbx).$cc.':'.alpbt($bbx+$cs_items['cs_i_num']-1).$cc.')';
									}else{
										if((($cs_i_total['cs_i_query'][0]->items)%20==0) && ($cs_i_total['cs_i_query'][0]->items)>200 && ($cs_i_total['cs_i_query'][0]->items)<=400){
											$cs_sum_itemsx='=INT((SUM('.alpbt($bbx).$cc.':'.alpbt($bbx+$cs_items['cs_i_num']-1).$cc.'))/2)';
											$cs_sum_itemsv = ($cs_i_total['cs_i_query'][0]->items)/2;
										}else{

										}
								}
								// TOTAL CS
								$p_data[$studentid][$cc][$c]=alpbt($bb+2);

									$this->excel->getActiveSheet()->setCellValue(alpbt($bb).$cc,$cs_sum_itemsx );
									$this->excel->getActiveSheet()->setCellValue(alpbt($bb+1).$cc, '=VLOOKUP($'.alpbt($bb).'$8:$'.alpbt($bb).'$'.(count($student_list)+9).',Sheet1!$'.trans($cs_sum_itemsv)[0].'$2:$'.trans($cs_sum_itemsv)[1].'$'.trans($cs_sum_itemsv)[2].',2,FALSE)');
									$this->excel->getActiveSheet()->setCellValue(alpbt($bb+2).$cc,'='.(alpbt($bb+1).$cc).'*'.$percent);
									$bb=$bb+3;
									$bbx=$bb;
							$d_prcnt = 'SUM(';
							for($f=0;$f<count($p_data[$studentid][$cc]);$f++){
								$d_prcnt .= $p_data[$studentid][$cc][$f].$cc.',';
							}

							$this->excel->getActiveSheet()->setCellValue(alpbt($xx).$cc,'='.$d_prcnt.')');
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx+1).$cc,'=('.alpbt($xx).$cc.'*'.$type_d[1].')');
								$cs_col_num=(3*$cs['cs_num'])+$cs_items_count;
					            //cs start
								$this->excel->getActiveSheet()->setCellValue('D'.$d,'Class Standing');
								$this->excel->getActiveSheet()->mergeCells('D'.$d.':'.alpbt($cs_col_num+1).'6');
								// Class Standing Style header
								$this->excel->getActiveSheet()->getStyle('D'.$d.':'.alpbt($cs_col_num+1).'6')->applyFromArray($styleArrayTh);
								$this->excel->getActiveSheet()->getStyle('D'.($d+1).':'.alpbt($xx+5).($d+1))->applyFromArray($styleArrayTh2);
						}
					}
				}
				// end CS SCORE

				//start EXAM SCORE
					if($exam['exam_num']>0 && $exam['exam_query'][0]->{$type_d[8]}!=0){
							// start of exam score
							if($this->sched_record_model->get_exam_score($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )){
														$scoreE = $this->sched_record_model->get_exam_score($check_sched['lecunits'] , $check_sched['labunits'] , $teacher_id , $studentid , $sched_id , $type , $type_d[8] )[0]->{$type_d[8]};
							}else{
													$scoreE = 0;
							}
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx+2).$cc,$scoreE);
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx+3).$cc,'=VLOOKUP($'.alpbt($xx+2).'$8:$'.alpbt($xx+2).'$'.(count($student_list)+9).',Sheet1!$'.trans($exam["exam_query"][0]->{$type_d[8]})[0].'$2:$'.trans($exam["exam_query"][0]->{$type_d[8]})[1].'$'.trans($exam["exam_query"][0]->{$type_d[8]})[2].',2,FALSE)');
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx+4).$cc,'=('.alpbt($xx+3).$cc.'*'.$type_d[2].')');
							$this->excel->getActiveSheet()->setCellValue(alpbt($xx+5).$cc,'=SUM('.alpbt($xx+1).$cc.','.alpbt($xx+4).$cc.')');
							$conditionalStyles = $this->excel->getActiveSheet()->getStyle(alpbt($xx+5).$cc)->getConditionalStyles();
                              array_push($conditionalStyles, $objConditional1);
                              array_push($conditionalStyles, $objConditional2);
                    		$this->excel->getActiveSheet()->getStyle(alpbt($xx+5).$cc)->setConditionalStyles($conditionalStyles);
					}
				//end EXAM SCORE
				}
				$cc++;
			}





		$this->excel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArrayLogo);
		$this->excel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArrayIns);
		$this->excel->getActiveSheet()->getStyle('A3:R3')->applyFromArray($styleArraySub);
		$this->excel->getActiveSheet()->getStyle('A4:R4')->applyFromArray($styleArraySub);
		$this->excel->getActiveSheet()->getStyle('A5:R5')->applyFromArray($styleArraySub2);
		$this->excel->getActiveSheet()->getStyle('A'.($aa).':C'.($aa))->applyFromArray($styleArrayTh);
		$this->excel->getActiveSheet()->getStyle('A'.($ccx).':A'.$cc)->applyFromArray($styleArrayTb);
		$this->excel->getActiveSheet()->getStyle('B'.($ccx).':B'.$cc)->applyFromArray($styleArrayTbB);
		$this->excel->getActiveSheet()->getStyle('D'.($ccx).':AA'.$cc)->applyFromArray($styleArrayTbB);

		$filename=$filename.'.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

	}



}
