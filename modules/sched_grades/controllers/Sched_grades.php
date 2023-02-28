<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sched_grades extends MY_Controller {

	 function __construct()
    {
        parent::__construct();
        $this->load->model('admin_registrar/fg_only_model');
		$this->load->model('sched_record2/sched_record_model');
		$this->load->model('teachersched/sched_model');
		$this->load->model('admin/user_model');
		$this->load->module('admin/admin');
        $this->load->module('sched_grades/sched_grades_checker');
		$this->load->module('template/template');
		$this->load->model('template/template_model');
		$this->load->model('subject/subject_enrollees_model');
		$this->load->model('sched_grades_model');
		$this->load->model('sched_record2/grade_submission_model');
		$this->load->model('student/student_model');
		$this->load->library('encryption');
        $this->load->model('admin_registrar/grades_submission_model');
        $this->load->model('grade_completion/grade_completion_model');
		$this->encryption->initialize(
									        array(
									                'cipher' => 'aes-256',
									                'mode' => 'OFB',
									                'key' => base64_encode('0-124356879-0'),
									        )
									);


    }



    public function enter_student_grades(){

        $this->admin->_check_login();

    	$sched_id = $this->encryption->decrypt($this->input->post('sched_id', TRUE)) ;
    	if($sched_id){
    		$this->gradesssss($sched_id);
    	}else{
    		redirect('TeacherScheduleList');
    	}

    }

    public function export_pdf(){
         $this->admin->_check_login_and_registrar();

        $sched_id = $this->input->post('sched_id', TRUE) ;

        if($sched_id){
            $this->gradesssss($sched_id,true,$this->input->post('print_this', TRUE));
        }else{
            redirect('TeacherScheduleList');
        }
    }

    public function enter_student_gradesx(){
         $this->admin->_check_login();
    	$sched_id = $this->encryption->decrypt($this->session->userdata('enc_sched_id')) ;
    	$this->gradesssss($sched_id);
	}



	public function gradesssss($sched_id,$pdf=null,$print_this = null){



		$data['ecn_sched_id'] = $sched_id;

		$data['sem_sy'] =$this->template->get_sem_sy();


		$data['sched_id'] = $sched_id ;
		$data['teacher_id'] = $this->session->userdata('id');

		$data['nav']=$this->admin->_nav();
		$data['user'] =$this->user_model->get_user_info($data['teacher_id'],'LastName , FirstName , MiddleName');
		$data['user_role'] =$this->user_model->get_user_role($data['teacher_id'],'pcc_roles.role');
		$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
		$data['subject_info2'] =$this->sched_model->get_schedteacher_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
		$data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
		$data['check_sched']['teacher_adviser']= $data['subject_info3'];

        $data['smpt'] = $this->sched_grades_checker->summer_pmtf($data['check_sched']);




        $data['checker'] = $this->sched_grades_checker->check_subject_type($data['check_sched']);

        // xx($data['checker']);
        $data['sub_sem_sy'] =$this->template->get_sem_w($data['check_sched'][0]['semester'],$data['check_sched'][0]['schoolyear']);

        $data['grade_submission']['p'] = $this->grades_submission_model->get_grade_submission($data['check_sched'][0]['schoolyear'],$data['check_sched'][0]['semester'],'p');
        $data['grade_submission']['m'] = $this->grades_submission_model->get_grade_submission($data['check_sched'][0]['schoolyear'],$data['check_sched'][0]['semester'],'m');
        $data['grade_submission']['tf'] = $this->grades_submission_model->get_grade_submission($data['check_sched'][0]['schoolyear'],$data['check_sched'][0]['semester'],'tf');

		$check_fused = $this->subject_enrollees_model->check_fused($sched_id);
			if($check_fused[0]->fuse==null){
				$student_list=$this->sched_record_model->get_student_list($sched_id,'s.studentid,r.lastname');
			}else{
				$get_fused = $this->subject_enrollees_model->get_fused($check_fused[0]->fuse);
				$schedids = explode(",",$get_fused[0]->sched);
				$test = array();
				for($x=0;$x<count($schedids);$x++){
					$aaData[$x]=$this->sched_record_model->get_student_list($schedids[$x],'s.studentid,r.lastname');
					$test = array_merge($test,$aaData[$x]);
				}
				$student_list=$test;
			}


			if( $data['check_sched']['lecunits'] != 0 && $data['check_sched']['labunits'] != 0 ){

                 $sched_id = $data['check_sched'][0]['schedid'];
                 $data['sched_id'] = $sched_id ;

					if( $data['check_sched']['teacherid'][0] ==  $this->session->userdata('id') ){
                        $data['ecn_sched_id'] = $sched_id;
					}else{
						$data['ecn_sched_id'] = $sched_id;
					}

			}
             $data['check_submitted'] = $this->sched_grades_model->get_grade_review( $sched_id );
            if(!isset($data['check_submitted'][0])){
                $data['check_submitted'] = $this->sched_grades_model->get_grade_review( $sched_id );
            }


			$student_list = json_decode(json_encode($student_list), true);
			usort($student_list , build_sorter('fullname') );
			$student_list = json_decode(json_encode($student_list));






			 $data['student_count']=count($student_list);
			 $checkssss = true;
             $data['print_this'] = $print_this;

            if(!$pdf){
                if( $data['check_sched']['lecunits'] != 0 && $data['check_sched']['labunits'] != 0 ){

                        if( $data['check_sched']['teacherid'][0] ==  $this->session->userdata('id')  ){
                            $data['table'] = $this->set_students($student_list,$sched_id,$data);
                            $data['tfoot'] = $this->set_tfoot($data);
                            $checkssss = true;
                        }else{
                            $data['table'] = $this->set_students_view($student_list,$sched_id,$data);
                            $data['tfoot'] = $this->set_tfoot_view($data);
                            $checkssss = false;
                        }
                }else{

                    $checkssss = true;
                    $data['table'] = $this->set_students($student_list,$sched_id,$data);
                    $data['tfoot'] = $this->set_tfoot($data);
                }
                if(isset($data['grade_submission']['tf'][0]) && isset($data['check_submitted'][0]->submit_final) ){
                    if(  human_to_unix($data['grade_submission']['tf'][0]->end_date) >=  now() && $data['check_submitted'][0]->submit_final == null ){
                        $data['table'] = $this->set_students($student_list,$sched_id,$data);
                        $data['tfoot'] = $this->set_tfoot($data);
                        $checkssss = true;
                    }else{
                        $data['table'] = $this->set_students_view($student_list,$sched_id,$data);
                        $data['tfoot'] = $this->set_tfoot_view($data);
                        $checkssss = true;
                    }
                }

                $data['excel_list'] = $this->sched_grades_model->get_sched_excel_list($sched_id);
                $data['checkssss']  = $checkssss;
                if($data['checker']['fg_only']){
                    $data['view_content']='sched_grades/sched_grades_record_fg';
                    $data['get_plugins_js']='sched_grades/plugins_fg_js';
                }else{
                    $data['view_content']='sched_grades/sched_grades_record';
                    $data['get_plugins_js']='sched_grades/plugins_js';
                }

                $data['get_plugins_css']='sched_grades/plugins_css';
                $this->load->view('template/init_view_windowed',$data);
            }else{
                $data['teacher_info'] =$this->user_model->get_user_info($data['teacher_id']);

                $data["title"]="PDF GRADES REPORT  BY : " .strtoupper($data['user'][0]->LastName).", ".strtoupper($data['user'][0]->FirstName)." ".strtoupper($data['user'][0]->MiddleName)[0].'.';
                            $data['student_count'] = count($student_list);
                            $data['table'] = $this->set_students_view_pdf($student_list,$sched_id,$data);
                            $data['tfoot'] = $this->set_tfoot_view($data,true);
                            $checkssss = false;
                                 // $this->load->view('sched_grades_record_pdf', $data, true);

                            $html = $this->load->view('sched_grades_record_pdf', $data, true); // render the view into HTML
                            $this->load->library("pdf");
                            $pdf = $this->pdf->load();  // L - landscape, P - portrait
                            $pdf->mPDF('utf-8','Legal','','','10','10','37','15');

                            $pdf->allow_charset_conversion=true;
                            $pdf->charset_in='UTF-8';
                            $pdf->simpleTables = true;
                            $pdf->packTableData = true;
                            $pdf->shrink_tables_to_fit=1;
                            $pdf->SetHTMLHeader('
                                      <div class=" header-wrapper">
                                                    <div class="col-md-5 header"  >
                                                     <img class="logo" src="assets/images/logo.png"  />
                                                            <p class="header_title " >Pines City Colleges</p><br/>
                                                            <p class="header_title_l t_sm1">(Owned and operated by THORNTONS INTERNATIONAL STUDIES, INC.)</p>
                                                            <p class="header_title_l t_sm1">Magsaysay Avenue, Baguio City, 2600 Philippines</p>
                                                            <p class="header_title_l t_sm2">Tel. nos.:(074)445-2210, 445-2209 Fax:(074)445-2208</p>
                                                            <p class="header_title_l t_sm3">http://www.pcc.edu.ph</p>

                                                    </div>
                                      </div>
                                    ',1,true);

                            $pdf->SetFooter("<strong>".($data['teacher_info'][0]->LastName).", ".strtoupper($data['teacher_info'][0]->FirstName)." ".strtoupper($data['teacher_info'][0]->MiddleName)[0].".</strong>  <strong>(".strtoupper($data['subject_course'][0]->code)." <strong> ".strtoupper($data['subject_info']['sched_query'][0]->courseno)."</strong>)</strong> ".'|{PAGENO}|'.unix_to_human(now()).'<br  /> <small>This is a Computer Generated Document.</small>'); // Add a footer for good measure

                            $pdf->WriteHTML($html); // write the HTML into the PDF

                            $pdfFilePath = ($data['user'][0]->LastName).", ".strtoupper($data['user'][0]->FirstName)." ".strtoupper($data['user'][0]->MiddleName)[0].'_'.$data['teacher_id'].'_'.strtoupper($data['subject_info']['sched_query'][0]->courseno).'_'.$data['sched_id'].'('.date("Y-m-d HisA").").pdf";
                            $pdf->Output($pdfFilePath , 'D'); // save to file because we can D
            }




    }

     public function check_ifsubmitted($data){
        $data_checker = [];
        $data_checker['prelim'] = false;
        $data_checker['midterm'] = false;
        $data_checker['tentative'] = false;
                    if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){
                         if($data['check_submitted'][0]->submit_prelim == null){
                             $data_checker['prelim'] = false;
                        }else{
                            $data_checker['prelim'] = true;
                        }
                    }

                    if($data['check_submitted'][0]->submit_midterm != null){
                         $data_checker['midterm'] = true;
                    }

                    if($data['check_submitted'][0]->submit_tentative != null){
                         $data_checker['tentative'] = true;
                    }


                return $data_checker;


    }

    public function set_tfoot($data){
    	$dean_tfoot = '<tr><td colspan="3">DATE APPROVED AND CHECKED BY DEAN</td>';
    	$registrar_tfoot = '<tr><td colspan="3">DATE APPROVED AND CHECKED BY REGISTRAR</td>';

    	$tfoot = '<tr><td colspan="3">DATE SUBMITTED</td>';

        $tfdata = [];

                if(!isset($data['check_submitted'][0])  ){
                    if($data['checker']['fg_only']){
                         $tfoot .=  '<td>
                                <button class="btn btn-primary" onclick="$(this).submitGRADES(\'tentative\',\''.$data["ecn_sched_id"].'\');" >SUBMIT TENTATIVE </button>
                            </td>
                            <td ></td>
                            <td ></td>';
                            $dean_tfoot .= '<td ></td><td ></td><td colspan="2">
                            </td>';
                            $registrar_tfoot .= '<td ></td><td ></td><td colspan="2">
                            </td>';
                    }else{
                        if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){
                             $tfoot .=  '<td>
                                <button class="btn btn-primary" onclick="$(this).submitGRADES(\'prelim\',\''.$data["ecn_sched_id"].'\');" >SUBMIT PRELIM </button>
                            </td>
                            <td ></td>
                            <td ></td>
                            <td ></td>

                            <td ></td>';
                            $dean_tfoot .= '<td ></td><td ></td><td ></td><td ></td><td colspan="2">
                            </td>';
                            $registrar_tfoot .= '<td ></td><td ></td><td ></td><td ></td><td colspan="2">
                            </td>';
                        }else{
                             $tfoot .=  '<td>
                                    <button class="btn btn-primary" onclick="$(this).submitGRADES(\'midterm\',\''.$data["ecn_sched_id"].'\');" >SUBMIT MIDTERM </button>
                                </td>
                                <td ></td>
                                <td ></td>
                                <td ></td>';
                                $dean_tfoot .= '<td></td><td ></td><td ></td><td ></td>';
                                $registrar_tfoot .= '<td></td><td ></td><td ></td><td></td>';
                        }
                    }
                }else{
                    if(!$data['checker']['fg_only']){
                    	if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){
                    		 if($data['check_submitted'][0]->submit_prelim == null){
                    			 $tfoot .= 	'<td>
    			                      			<button class="btn btn-primary" onclick="$(this).submitGRADES(\'prelim\',\''.$data["ecn_sched_id"].'\');" >SUBMIT PRELIM  </button>
    										</td>';
    										$dean_tfoot .= '<td></td>';
    										$registrar_tfoot .= '<td></td>';
                    		}else{
                    			 $tfoot .= 	'<td>
                    			 				<button class="btn btn-danger btn-xs" onclick="$(this).requestForUpdate(\'prelim\',\''.$data["ecn_sched_id"].'\');" >Request Update PRELIM</button>
    											<br />
    											<strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_prelim,'M d, Y H:i').'</strong>
                    			 			</td>';
                    			 			$dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_prelim,'M d, Y H:i')).'</strong></td>';
                    			 			$registrar_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkregistrar_prelim,'M d, Y H:i') ) .'</strong></td>';
                    		}
                    	}

                    	 if($data['check_submitted'][0]->submit_midterm == null){
                                if($data['check_sched'][0]['semester'] == 3){
                                    $tfoot .=   '<td ><button class="btn btn-primary" onclick="$(this).submitGRADES(\'midterm\',\''.$data["ecn_sched_id"].'\');" >SUBMIT MIDTERM </button></td>';
                                        $dean_tfoot .= '<td></td>';
                                        $registrar_tfoot .= '<td></td>';
                                }else{
                                    if($data['check_submitted'][0]->submit_prelim != null){
                                        $tfoot .=   '<td ><button class="btn btn-primary" onclick="$(this).submitGRADES(\'midterm\',\''.$data["ecn_sched_id"].'\');" >SUBMIT MIDTERM </button></td>';
                                        $dean_tfoot .= '<td></td>';
                                        $registrar_tfoot .= '<td></td>';
                                    }else{
                                        $tfoot .=   '<td></td>';
                                        $dean_tfoot .= '<td></td>';
                                        $registrar_tfoot .= '<td></td>';
                                    }
                                }

                    		}else{
                                if($data['check_sched'][0]['semester'] == 3){
                                    $tfoot .=  '<td>
                                                    <button class="btn btn-danger btn-xs" onclick="$(this).requestForUpdate(\'midterm\',\''.$data["ecn_sched_id"].'\');" >Request Update MIDTERM</button>
                                                    <br />
                                                    <strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_midterm,'M d, Y H:i').'</strong>

                                                </td>';
                                                $dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_midterm,'M d, Y H:i')  ) .'</strong></td>';
                                                $registrar_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkregistrar_midterm,'M d, Y H:i')  ) .'</strong></td>';
                                }else{
                                    if($data['check_submitted'][0]->submit_prelim != null){
                                     $tfoot .=  '<td>
                                                    <button class="btn btn-danger btn-xs" onclick="$(this).requestForUpdate(\'midterm\',\''.$data["ecn_sched_id"].'\');" >Request Update MIDTERM</button>
                                                    <br />
                                                    <strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_midterm,'M d, Y H:i').'</strong>

                                                </td>';
                                                $dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_midterm,'M d, Y H:i')  ) .'</strong></td>';
                                                $registrar_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkregistrar_midterm,'M d, Y H:i')  ) .'</strong></td>';
                                    }else{
                                        $tfoot .=   '<td></td>';
                                        $dean_tfoot .= '<td></td>';
                                        $registrar_tfoot .= '<td></td>';
                                    }
                                }

                    		}

                        }

                		if($data['check_submitted'][0]->submit_tentative == null){
							if($data['check_submitted'][0]->submit_midterm != null){
                			 	$tfoot .= 	'<td><button class="btn btn-primary" onclick="$(this).submitGRADES(\'tentative\',\''.$data["ecn_sched_id"].'\');" >SUBMIT TENTATIVE</button></td>';
                			}else{
                				$tfoot .= 	'<td></td>';
                			}
                			$dean_tfoot .= '<td></td>';
                			$registrar_tfoot .= '<td></td>';
                		}else{
                			if($data['check_submitted'][0]->submit_midterm != null){
                			 $tfoot .= 	'<td><button class="btn btn-danger btn-xs" onclick="$(this).requestForUpdate(\'tentative\',\''.$data["ecn_sched_id"].'\');" >Request Update TENTATIVE</button>
											<br />
											<strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_tentative,'M d, Y H:i').'</strong>
                			 			</td>';
                			 			$dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i')  ).'</strong></td>';
                			 			$registrar_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkregistrar_tentative,'M d, Y H:i')  ).'</strong></td>';
                			}else{
                				$tfoot .= 	'<td></td>';
                				$dean_tfoot .= '<td></td>';
                				$registrar_tfoot .= '<td></td>';
                			}
                		}

                		if($data['check_submitted'][0]->submit_final == null){

							if($data['check_submitted'][0]->submit_tentative != null){
                			 	$tfoot .= 	'<td colspan="2"><button class="btn btn-primary" onclick="$(this).submitGRADES(\'final\',\''.$data["ecn_sched_id"].'\');" >SUBMIT FINAL</button></td>';
                			}else{
                				$tfoot .= 	'<td></td>';
                			}
                			$dean_tfoot .= '<td></td>';
                			$registrar_tfoot .= '<td></td>';
                		}else{
                			if($data['check_submitted'][0]->submit_tentative != null){
                			 $tfoot .= 	'<td >
                			 				<button class="btn btn-danger btn-xs" onclick="$(this).requestForUpdate(\'final\',\''.$data["ecn_sched_id"].'\');" >Request Update FINAL</button>
											<br />
											<strong class="date-approve">'.nice_dateX($data['check_submitted'][0]->submit_final,'M d, Y H:i').'</strong>
                			 			</td>';
                			 			$dean_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkdean_final,'M d, Y H:i') ).'</strong></td>';
                			 			$registrar_tfoot .= '<td><strong class="date-approve">'.( nice_dateX($data['check_submitted'][0]->checkregistrar_final,'M d, Y H:i')  ).'</strong></td>';
                			}else{
                				$tfoot .= 	'<td></td>';
                				$dean_tfoot .= '<td></td>';
                				$registrar_tfoot .= '<td></td>';
                			}
                		}

                }
                $dean_tfoot .= ' </tr>';
                $registrar_tfoot .= ' </tr>';

                $tfoot .= ' </tr>';


                return $tfoot.$dean_tfoot.$registrar_tfoot;


    }

    public function set_tfoot_view($data,$pdf = false){
        if(!$pdf){
            $dean_tfoot = '<tr><td colspan="3">DATE APPROVED AND CHECKED BY DEAN</td>';
            $registrar_tfoot = '<tr><td colspan="3">DATE APPROVED AND CHECKED BY REGISTRAR</td>';
            $tfoot = '<tr><td colspan="3">DATE SUBMITTED</td>';
        }else{
            $dean_tfoot = '<tr><td colspan="4">DATE APPROVED AND CHECKED BY DEAN</td>';
            $registrar_tfoot = '<tr><td colspan="4">DATE APPROVED AND CHECKED BY REGISTRAR</td>';
            $tfoot = '<tr><td colspan="4">DATE SUBMITTED</td>';
        }



                if(!isset($data['check_submitted'][0])  ){
                    if($data['checker']['fg_only']){
                	    $tfoot .=  '<td></td>';
                             $dean_tfoot .=  '<td></td>';
                             $registrar_tfoot .=  '<td></td>';

                	}else{
                            if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){
                                 $tfoot .=  '<td></td>';
                                 $dean_tfoot .=  '<td></td>';
                                 $registrar_tfoot .=  '<td></td>';
                        }
                                $tfoot .=  '<td></td><td></td><td></td>';
                                $dean_tfoot .= '<td ></td><td ></td><td ></td>';
                                $registrar_tfoot .= '<td ></td><td ></td><td ></td>';
                    }



                }else{
                    if(!$data['checker']['fg_only']){
                    	if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){

                    		$nice_date_p = nice_date($data['check_submitted'][0]->checkdean_prelim,'M d, Y H:i') == 'Unknown' ? "" :  nice_date($data['check_submitted'][0]->checkdean_prelim,'M d, Y H:i');
                                 $tfoot .=  '<td class="text-center" ><strong class="date-approve">'.$nice_date_p .'</strong></td>';
                                			$dean_tfoot .= '<td class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkdean_prelim ? nice_date($data['check_submitted'][0]->checkdean_prelim,'M d, Y H:i') : '').'</strong></td>';
                    			 			$registrar_tfoot .= '<td><strong class="date-approve">'.( $data['check_submitted'][0]->checkregistrar_prelim ? nice_date($data['check_submitted'][0]->checkregistrar_prelim,'M d, Y H:i') : '') .'</strong></td>';
                    	}
						     $nice_date_m = nice_date($data['check_submitted'][0]->checkdean_midterm,'M d, Y H:i') == 'Unknown' ? "" : nice_date($data['check_submitted'][0]->checkdean_midterm,'M d, Y H:i');
                             $tfoot .=  '<td class="text-center" ><strong class="date-approve">'.$nice_date_m.'</strong></td>';



							$nice_date_t = nice_date($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i') == 'Unknown' ? "" : nice_date($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i');
                            $tfoot .=  '<td class="text-center" ><strong class="date-approve">'. $nice_date_t .'</strong></td>';


                			$nice_date_f = nice_date($data['check_submitted'][0]->submit_final,'M d, Y H:i') == 'Unknown' ? "" : nice_date($data['check_submitted'][0]->submit_final,'M d, Y H:i');
                            $tfoot .=  '<td colspan="2" class="text-center" ><strong class="date-approve">'.$nice_date_f.'</strong></td>';

                            $dean_tfoot .= '<td class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkdean_midterm ? nice_date($data['check_submitted'][0]->checkdean_midterm,'M d, Y H:i') : '' ) .'</strong></td>';
                			$registrar_tfoot .= '<td class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkregistrar_midterm ? nice_date($data['check_submitted'][0]->checkregistrar_midterm,'M d, Y H:i') : '' ) .'</strong></td>';

                			$dean_tfoot .= '<td class="text-center" ><strong class="date-approve">'.($data['check_submitted'][0]->checkdean_tentative ? nice_date($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i') : "" ).'</strong></td>';
                			$registrar_tfoot .= '<td class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkregistrar_tentative ? nice_date($data['check_submitted'][0]->checkregistrar_tentative,'M d, Y H:i') : "" ).'</strong></td>';

                			$dean_tfoot .= '<td class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkdean_final ? nice_date($data['check_submitted'][0]->checkdean_final,'M d, Y H:i') : "" ).'</strong></td>';
                			$registrar_tfoot .= '<td class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkregistrar_final ? nice_date($data['check_submitted'][0]->checkregistrar_final,'M d, Y H:i') : "" ).'</strong></td>';
                    }else{
                            $nice_date_t = nice_date($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i') == 'Unknown' ? "" : nice_date($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i');
                            $tfoot .=  '<td class="text-center" ><strong class="date-approve">'. $nice_date_t .'</strong></td>';


                            $nice_date_f = nice_date($data['check_submitted'][0]->submit_final,'M d, Y H:i') == 'Unknown' ? "" : nice_date($data['check_submitted'][0]->submit_final,'M d, Y H:i');
                            $tfoot .=  '<td colspan="2" class="text-center" ><strong class="date-approve">'.$nice_date_f.'</strong></td>';

                            $dean_tfoot .= '<td  colspan="2" class="text-center" ><strong class="date-approve">'.($data['check_submitted'][0]->checkdean_tentative ? nice_date($data['check_submitted'][0]->checkdean_tentative,'M d, Y H:i') : "" ).'</strong></td>';
                            $registrar_tfoot .= '<td  colspan="2" class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkregistrar_tentative ? nice_date($data['check_submitted'][0]->checkregistrar_tentative,'M d, Y H:i') : "" ).'</strong></td>';

                            $dean_tfoot .= '<td  colspan="2" class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkdean_final ? nice_date($data['check_submitted'][0]->checkdean_final,'M d, Y H:i') : "" ).'</strong></td>';
                            $registrar_tfoot .= '<td  colspan="2" class="text-center" ><strong class="date-approve">'.( $data['check_submitted'][0]->checkregistrar_final ? nice_date($data['check_submitted'][0]->checkregistrar_final,'M d, Y H:i') : "" ).'</strong></td>';
                    }
                }

                  $dean_tfoot .= ' </tr>';
                $registrar_tfoot .= ' </tr>';

                $tfoot .= ' </tr>';

                return $tfoot.$dean_tfoot.$registrar_tfoot;


    }



    public function set_students($student_list,$sched_id,$data){
    	$list = '';
    	$count = 1;

    	for($x=0;$x<count($student_list);$x++){
                        $student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
                        $midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';



                        $list .= '
				  			<tr>
							  <td>'.$count.'</td>
							  <td class="student_lfm" >'.$student_list[$x]->studentid.'</td>
							  <td class="student_lfm" >'.strtoupper( $student_lfm[0]->lastname).", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme.'</td>
							  '.$this->get_grades($sched_id,$student_list[$x]->studentid,$data ).'
							</tr>
							  '
							  ;
							  $count++;
        }

        return $list;
    }

     public function set_students_view($student_list,$sched_id,$data){
    	$list = '';
    	$count = 1;
    	for($x=0;$x<count($student_list);$x++){
                        $student_lfm=($this->student_model->get_student_info($student_list[$x]->studentid,'lastname , firstname , middlename '));
                        $midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';



                        $list .= '
				  			<tr>
							  <td>'.$count.'</td>
							  <td class="student_lfm" >'.$student_list[$x]->studentid.'</td>
							  <td class="student_lfm" >'.strtoupper( $student_lfm[0]->lastname).", ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme.'</td>
							  '.$this->get_grades_view($sched_id,$student_list[$x]->studentid,$data ).'
							</tr>
							  '
							  ;
							  $count++;
        }

        return $list;
    }

    public function set_students_view_pdf($student_list,$sched_id,$data){
        $list = '';
        $count = 1;
        for($x=0;$x<count($student_list);$x++){
                        $student_lfm=($this->student_model->get_student_infocie($student_list[$x]->studentid,'r.lastname , r.firstname , r.middlename, c.code, ei.yearlvl '));
                        $midl_nme = ($student_lfm[0]->middlename!='')?$student_lfm[0]->middlename[0].'.':'';



                        $list .= '
                            <tr>
                              <td class="text-center" >'.$count.'</td>
                              <td class="student_lfm text-center" >'.$student_list[$x]->studentid.'</td>
                              <td class="student_lfm" ><strong class="toupper">'.strtoupper( $student_lfm[0]->lastname)."</strong><strong>, ".ucwords(strtolower($student_lfm[0]->firstname))." ".$midl_nme.'</strong></td>
                              <td class="student_lfm" ><strong class="toupper">'.strtoupper( $student_lfm[0]->code).'-'.$student_lfm[0]->yearlvl.'</strong></td>
                              '.$this->get_grades_view($sched_id,$student_list[$x]->studentid, $data,true ).'

                            </tr>
                              '
                              ;
                              $count++;
        }

        return $list;
    }

    public function get_grades($sched_id,$studentid,$data){
    	$grades_list = '';
    	$table_e_f = 'pcc_student_final_grade';
    	$grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$studentid,'');
    	$student_remarks_r = '';
				$student_remarks='<option value="" data_index="0" ></option>';
				if($this->grade_submission_model->get_stud_fgrades( $sched_id,$studentid,'')){
					$r = $this->grade_submission_model->get_stud_fgrades( $sched_id,$studentid,'');
					$r = ($r[0]->remarks!=NULL)?$r[0]->remarks:'';
					$student_remarks = '<option value="'.$r.'" data_index="0">'.$r.'</option>';

					if(isset($data['check_submitted'][0]) && $data['check_submitted'][0]->submit_final != null){
                                                $student_remarks = $r;
                    }


					$student_remarks_r = $r;
				}
				// xx(summer_pmt($data['check_sched'][0]));
				if(!$data['checker']['fg_only']){

                    if($data['check_sched'][0]['semester'] != 3 || $data['smpt']  ){

                        $grades_list .= $this->prelim_g($sched_id,$studentid,$data['check_submitted'],$grades);
                    }
                    $grades_list .= $this->midterm_g($sched_id,$studentid,$data['check_submitted'],$grades);
                }

				$grades_list .= $this->tenta_g($sched_id,$studentid,$data['check_submitted'],$grades);
				$remarks = $this->remarks_g($sched_id,$studentid,$student_remarks_r,$student_remarks,$data,$grades);

    	$grades_list .='<td id="'.$studentid.'_'.$sched_id.'_final" class="'.$remarks['class'].'" >'.$remarks['final'].'</td>';
    	$grades_list .='<td class="'.$remarks['class'].'" >'.$remarks['remarks'].'</td>';
    	return $grades_list;

    }






    public function prelim_g($sched_id,$studentid,$check_submitted,$grades){
    				if(isset($check_submitted[0]->submit_prelim)  && $check_submitted[0]->submit_prelim != null ){
				    	$grades_list = '<td><div class="input-group col-md-10 col-md-offset-1" > <input type="hidden" readonly disabled min="0" max="99" step="0.01" value="'. (isset($grades[0]->prelim) ? $grades[0]->prelim : 0 ) .'" id="'.$studentid.'_'.$sched_id.'_pre" /> '.(isset($grades[0]->prelim) ? $grades[0]->prelim : 0 ) .' </div></td>';
					}else{
						$grades_list = '<td><div class="input-group col-md-10 col-md-offset-1" > <input  class="form-control inp-sm text-center empty-exam" onblur="$(this).UpdateGrade(\''.$studentid.'\',\''.$sched_id.'\',\'pre\');" type="number" min="0" max="99" step="0.01" value="'. (isset($grades[0]->prelim) ? $grades[0]->prelim : 0 ) .'" id="'.$studentid.'_'.$sched_id.'_pre" /> </div></td>';
					}

					return $grades_list;
    }

    public function midterm_g($sched_id,$studentid,$check_submitted,$grades){
    				if(isset($check_submitted[0]->submit_midterm) && $check_submitted[0]->submit_midterm != null){
				    	$grades_list = '<td><div class="input-group col-md-10 col-md-offset-1" > <input type="hidden" readonly disabled min="0" max="99" step="0.01" value="'. (isset($grades[0]->midterm) ? $grades[0]->midterm : 0 ) .'" id="'.$studentid.'_'.$sched_id.'_mid" /> '.(isset($grades[0]->midterm) ? $grades[0]->midterm : 0 ) .' </div></td>';
					}else{
						$grades_list = '<td><div class="input-group col-md-10 col-md-offset-1" > <input  class="form-control inp-sm text-center empty-exam" onblur="$(this).UpdateGrade(\''.$studentid.'\',\''.$sched_id.'\',\'mid\');" type="number" min="0" max="99" step="0.01" value="'. (isset($grades[0]->midterm) ? $grades[0]->midterm : 0 ) .'" id="'.$studentid.'_'.$sched_id.'_mid" /> </div></td>';
					}

					return $grades_list;
    }

    public function tenta_g($sched_id,$studentid,$check_submitted,$grades){
    				if(isset($check_submitted[0]->submit_tentative)  && $check_submitted[0]->submit_tentative != null ){
				    	$grades_list = '<td><div class="input-group col-md-10 col-md-offset-1" > <input type="hidden" readonly disabled min="0" max="99" step="0.01" value="'. (isset($grades[0]->tentativefinal) ? $grades[0]->tentativefinal : 0 ) .'" id="'.$studentid.'_'.$sched_id.'_tenta" />  '.(isset($grades[0]->tentativefinal) ? $grades[0]->tentativefinal : 0 ) .' </div></td>';
					}else{
						$grades_list = '<td><div class="input-group col-md-10 col-md-offset-1" > <input  class="form-control inp-sm text-center empty-exam" onblur="$(this).UpdateGrade(\''.$studentid.'\',\''.$sched_id.'\',\'tenta\');" type="number" min="0" max="99" step="0.01" value="'. (isset($grades[0]->tentativefinal) ? $grades[0]->tentativefinal : 0 ) .'" id="'.$studentid.'_'.$sched_id.'_tenta" /> </div></td>';
					}
					return $grades_list;
    }





    public function remarks_g($sched_id,$studentid,$student_remarks_r,$student_remarks,$data,$grades){
    	$final = 0;
    	$div =2;

		if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){ $div =3;	}
        if(!$data['checker']['fg_only']){
        	if(isset($grades[0]->prelim)){
        			$final = ($grades[0]->prelim + $grades[0]->midterm + $grades[0]->tentativefinal)/$div ;
        	}
        }else{
            if(isset($grades[0]->tentativefinal)){
                 $final = $grades[0]->tentativefinal;
            }
        }

			$final = finalg($final,$student_remarks_r);

        $this->sched_grades_model->update_grades_final($sched_id,$studentid,$final);
        $opt_failed = '';
		if( $student_remarks_r == 'Passed' ){	$d['class'] ='passed'; }
		else{ 	$d['class']='failed';  $opt_failed = '<option value="Failed" data_index="2" >Failed</option>';}

    	$d['final'] =	$final;
    	$d['remarks'] = '<select class="fnlg_remarks form-control" onchange="$(this).setRemarks(\''.$sched_id .'\',\''.$studentid .'\');" id="remarks_'.$studentid .'" name="remarks_'.$studentid .'"  >
								'.$student_remarks.'
								<option value="Passed" data_index="1" >Passed</option>
								'.$opt_failed.'
								<option value="No Final Examination" data_index="3" >No Final Examination</option>
								<option value="No GRADE" data_index="4" >No Grade</option>
								<option value="Incomplete" data_index="5" >Incomplete</option>
								<option value="No CREDIT" data_index="6" >No Credit</option>
								<option value="DROPPED" data_index="7" >Dropped</option>
								<option value="Withdrawal with Permission" data_index="8" >Withdrawal with Permission</option>
                                <option value="No Attendance" data_index="9" >No Attendance</option>
								<option value="" data_index="10"></option>
							</select>';

			if(isset($data['check_submitted'][0]) && $data['check_submitted'][0]->submit_final != null){


                                        if($student_remarks != null ){
                                            $d['remarks'] = $student_remarks;
                                        }else{
                                            $d['remarks'] = 'Please request to update and Set Remarks';
                                        }
            }
            if(isset($grades[0]->prelim)){
            	if($grades[0]->tentativefinal > 0){
            		$d['final'] =	$final;
            	}else{
            		$d['final'] =	0;
            	}
            }





					switch ($student_remarks_r) {

					case 'No Final Examination':
							$d['final'] =	'NFE';
						break;
					case 'No GRADE':
							$d['final'] ='NG';
						break;

					case 'Officially Dropped':
							$d['final'] ='ODRP';
						break;

					case 'Unofficially Dropped':
							$d['final'] ='UDRP';
						break;

					case 'Incomplete':
							$d['final'] ='INC';
						break;

					case 'No CREDIT':
							$d['final'] ='NC';
						break;

					case 'DROPPED':
							$d['final'] ='DRP';
						break;

					case 'Withdrawal with Permission':
							$d['final'] ='Withdrawal/P';
						break;
                    case 'No Attendance':
                            $d['final'] ='No Attendance';
                        break;

					default:
						break;
				}


				return $d;
    }

    public function get_grades_view($sched_id,$studentid,$data, $pdf = false){

    	$grades_list = '';
    	$table_e_f = 'pcc_student_final_grade';
    	$grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$studentid,'');
    	$student_remarks_r = '';
				$student_remarks='<option value="" data_index="0" ></option>';
				if($this->grade_submission_model->get_stud_fgrades( $sched_id,$studentid,'')){
					$r = $this->grade_submission_model->get_stud_fgrades( $sched_id,$studentid,'');
					$r = ($r[0]->remarks!=NULL)?$r[0]->remarks:'';
					$student_remarks = '<option value="'.$r.'" data_index="0" >'.$r.'</option>';

					if(isset($data['check_submitted'][0]) && $data['check_submitted'][0]->submit_final != null){
                                                $student_remarks = $r;
                    }


					$student_remarks_r = $r;
				}

				if(!$pdf){
                    if(!$data['checker']['fg_only']){

                        if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){
                        $grades_list .= $this->prelim_gv($sched_id,$studentid,$data['check_submitted'],$grades,$pdf);
                        }
                        $grades_list .= $this->midterm_gv($sched_id,$studentid,$data['check_submitted'],$grades,$pdf);
                    }

                    if( !$pdf ){
                            $grades_list .= $this->tenta_gv($sched_id,$studentid,$data['check_submitted'],$grades,$pdf);
                    }
                }else{

                    $array_final_only = ['INTERNSHIP'];
                    if(!in_array(strtoupper($data['subject_info']['sched_query'][0]->type ), $array_final_only) && $data['checker']['fg_only'] == false){
                         if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){
                            if($data['print_this'] == 'PRELIM' || $data['print_this'] == 'MIDTERM' || $data['print_this'] == 'TENTATIVE' || $data['print_this'] == 'FINAL' ){
                                 $grades_list .= $this->prelim_gv($sched_id,$studentid,$data['check_submitted'],$grades,$pdf);
                            }

                          }
                            if( $data['print_this'] == 'MIDTERM' || $data['print_this'] == 'TENTATIVE' || $data['print_this'] == 'FINAL' ){
                                 $grades_list .= $this->midterm_gv($sched_id,$studentid,$data['check_submitted'],$grades,$pdf);
                            }


                            if( !$pdf ){
                                    $grades_list .= $this->tenta_gv($sched_id,$studentid,$data['check_submitted'],$grades,$pdf);
                            }
                    }

                }


				$remarks = $this->remarks_gv($sched_id,$studentid,$student_remarks_r,$student_remarks,$data,$grades,$pdf);
                    if(is_numeric($remarks['final'])){
                            $finalx = $remarks['final'] == 0 ? '' : $remarks['final'];
                    }else{
                        $finalx = $remarks['final'];
                    }
    	// $grades_list .='<td id="'.$studentid.'_'.$sched_id.'_final" class="'.$remarks['class'].' text-center" >'.$remarks['final'].'</td>';
       if($pdf){
                if(   $data['print_this'] == 'FINAL' ){
                                  $grades_list .='<td id="'.$studentid.'_'.$sched_id.'_final" class="'.$remarks['class'].' text-center" >'.($finalx).'</td>';
                 }

                $remarks_s = (strlen($remarks['remarks']) > 40 ? 'span2' : '');

                 if( $data['print_this'] == 'FINAL' ){
                                         $grades_list .='<td class="'.$remarks['class'].' text-center" ><span class="'.$remarks_s.'">'.ucfirst( strtolower($remarks['remarks'])).'</span> </td>';
                 }

       }else{
            $grades_list .='<td id="'.$studentid.'_'.$sched_id.'_final" class="'.$remarks['class'].' text-center" >'.($finalx).'</td>';
             $remarks_s = (strlen($remarks['remarks']) > 40 ? 'span2' : '');
             $rm = ucfirst( strtolower($remarks['remarks']));
             $grades_list .='<td class="'.$remarks['class'].' text-center" ><span class="'.$remarks_s.'">'.$rm.'</span> </td>';

             if($this->session->userdata('role') == 1){
                // if($rm != 'Dropped' && $rm != 'No Grade'){
                    $grades_list .='<td class="'.$remarks['class'].' text-center" >
                            <form method="POST" action="'.base_url().'grade_ratification/ratify_student_grades" target="__blank">
                                                                                                <input type="hidden" name="sched_id" value="'.$sched_id.'" />
                                                                                                <input type="hidden" name="studentid" value="'.$studentid.'" />
                                                                                                 <button type="submit" class="btn " style="color: #fff;background-color: #8b5cb8;border-color: #7c5692;" title="CLICK TO RECTIFY" > rectification </button>
                                                                                            </form>
                </td>';
                // }else{
                //      $grades_list .='<td class="'.$remarks['class'].' text-center" >Not Applicable </td>';
                // }

             }

       }


    	return $grades_list;

    }

    public function prelim_gv($sched_id,$studentid,$check_submitted,$grades,$pdf){
            $prelim = (isset($grades[0]->prelim) ? $grades[0]->prelim : '' );
            // $prelim = (isset($grades[0]->prelim) ? $grades[0]->prelim : 0 );

            $prelim = $pdf ? explode('.', $prelim)[0]:$prelim;
            $class = "failed";
            if($prelim >=75 ){
                $class = "passed";
            }
            if(!$pdf){
                $grades_list = '<td><div class="input-group col-md-10 col-md-offset-1 text-center '.$class.'  " > '. $prelim .' </div></td>';
            }else{
                $grades_list = '<td class="text-center" > '. $prelim .' </td>';
            }

                    return $grades_list;
    }

    public function midterm_gv($sched_id,$studentid,$check_submitted,$grades,$pdf){
        $midterm = (isset($grades[0]->midterm) ? $grades[0]->midterm : '' );
        // $midterm = (isset($grades[0]->midterm) ? $grades[0]->midterm : 0 );

        $midterm = $pdf ? explode('.', $midterm)[0]:$midterm;
            $class = "failed";
            if($midterm >=75 ){
                $class = "passed";
            }
            if(!$pdf){
                $grades_list = '<td><div class="input-group col-md-10 col-md-offset-1 text-center '.$class.'  " > '. $midterm .' </div></td>';
            }else{
                $grades_list = '<td class="text-center" > '. $midterm .' </td>';
            }
                    return $grades_list;
    }

    public function tenta_gv($sched_id,$studentid,$check_submitted,$grades,$pdf){
         // $tentativefinal = (isset($grades[0]->tentativefinal) ? $grades[0]->tentativefinal : 0 );
         $tentativefinal = (isset($grades[0]->tentativefinal) ? $grades[0]->tentativefinal : '' );

         $tentativefinal = $pdf ? explode('.', $tentativefinal)[0]:$tentativefinal;
            $class = "failed";
            if($tentativefinal >=75 ){
                $class = "passed";
            }

            if(!$pdf){
                $grades_list = '<td><div class="input-group col-md-10 col-md-offset-1 text-center '.$class.'  " > '. $tentativefinal .' </div></td>';
            }else{
                $grades_list = '<td class="text-center" > '. $midterm .' </td>';
            }

                    return $grades_list;
    }

    public function remarks_gv($sched_id,$studentid,$student_remarks_r,$student_remarks,$data,$grades,$pdf){
        $final = 0;
        $div =2;

        if($data['check_sched'][0]['semester'] != 3 || $data['smpt'] ){ $div =3; }
        if(!$data['checker']['fg_only']){
            if(isset($grades[0]->prelim)){
                    $final = ($grades[0]->prelim + $grades[0]->midterm + $grades[0]->tentativefinal)/$div ;
            }
        }else{
            if(isset($grades[0])){
                $final =  $grades[0]->tentativefinal;
            }

        }

        $final = finalg($final,$student_remarks_r);

        $this->sched_grades_model->update_grades_final($sched_id,$studentid,$final);

        if( $student_remarks_r == 'Passed' ){   $d['class'] ='passed'; }
        else{   $d['class']='failed'; }

        $d['final'] =   $final;
        $d['remarks'] = ucfirst(strtolower($student_remarks));
            if(!isset($data['grade_submission'])){

            }
            elseif(isset($data['check_submitted'][0]) && $data['check_submitted'][0]->submit_final != null){
                $datex = new Carbon\Carbon($data['grade_submission']['tf'][0]->end_date);
                $now = Carbon\Carbon::now();
                $checker_remarks = false;
                if($student_remarks ==  'Incomplete'){
                     $checker_remarks = true;
                }elseif ($student_remarks ==  'No Final Examination') {
                     $checker_remarks = true;
                }
                                        if($student_remarks != null ){
                                            if(isset($data['grade_submission']['tf'][0])){


                                                   if( ( $datex->diffInDays( $now ) <= $data['checker']['completion_days'] ) && $checker_remarks && !$pdf ){
                                                    $grade_completion = $this->grade_completion_model->get_grade_completion_student($sched_id,$studentid);
                                                        if(isset($data['registrar'])){

                                                             if( $grade_completion && !$grade_completion[0]->approved_by_registrar && $grade_completion[0]->is_printed == 1   ){
                                                                $d['remarks'] = $student_remarks.'  <form method="POST" action="'.base_url().'Grade_completion/enter_student_grades_registrar" target="__blank">
                                                                                                <input type="hidden" name="sched_id" value="'.$sched_id.'" />
                                                                                                <input type="hidden" name="aprroval_only" value="true">
                                                                                                <input type="hidden" name="studentid" value="'.$studentid.'" />
                                                                                                 <input type="hidden" name="approving_registrar" value="true" />
                                                                                                 <button type="submit" class="btn btn-primary" title="CLICK TO GENERATE GRADES COMPLETION" > view completion </button>
                                                                                            </form> ';
                                                             }
                                                        }else{
                                                            if($grade_completion){
                                                                 $d['remarks'] = $student_remarks.'  <form method="POST" action="'.base_url().'grade_completion/enter_student_grades" target="__blank">
                                                                                                <input type="hidden" name="sched_id" value="'.$sched_id.'" />
                                                                                                <input type="hidden" name="studentid" value="'.$studentid.'" />
                                                                                                 <button type="submit" class="btn btn-primary" title="CLICK TO GENERATE GRADES COMPLETION" > print completion </button>
                                                                                            </form> ';
                                                            }else{
                                                                 $d['remarks'] = $student_remarks.'<form method="POST" action="'.base_url().'Grade_completion/enter_student_grades" target="__blank">
                                                                                                <input type="hidden" name="sched_id" value="'.$sched_id.'" />
                                                                                                <input type="hidden" name="studentid" value="'.$studentid.'" />
                                                                                                 <button type="submit" class="btn btn-warning" title="CLICK TO GENERATE GRADES COMPLETION" > completion </button>
                                                                                            </form> ';
                                                            }

                                                        }

                                                   }else{
                                                    $d['remarks'] = $student_remarks;
                                                   }

                                            }

                                        }else{
                                             $d['remarks'] = '';
                                            if( ( $datex->diffInDays( $now ) <= $data['checker']['completion_days'] )&& !$pdf ){
                                                $d['remarks'] = $student_remarks.'<form method="POST" action="'.base_url().'Grade_completion/enter_student_grades" target="__blank">
                                                                                                <input type="hidden" name="sched_id" value="'.$sched_id.'" />
                                                                                                <input type="hidden" name="studentid" value="'.$studentid.'" />
                                                                                                 <button type="submit" class="btn btn-warning" title="CLICK TO GENERATE GRADES COMPLETION" > completion </button>
                                                                                            </form> ';
                                            }

                                        }
            }
            if(isset($grades[0]->prelim)){
                if($grades[0]->tentativefinal > 0){
                    $d['final'] =   $final;
                }else{
                    $d['final'] =   0;
                }
            }
            $rems = ucwords( strtolower($student_remarks));
            if( $rems == 'No Final Examination' ){
                $d['final'] =   'NFE';
            }elseif($rems == 'No Grade' ){
                 $d['final'] ='NG';
            }elseif($rems == 'Officially Dropped' ){
                 $d['final'] ='ODRP';
            }elseif($rems == 'Unofficially Dropped' ){
                 $d['final'] ='UDRP';
            }elseif($rems == 'Incomplete' ){
                 $d['final'] ='INC';
            }elseif($rems == 'No Credit' ){
                $d['final'] ='NC';
            }elseif($rems == 'Dropped' ){
                 $d['final'] ='DRP';
            }elseif($rems == 'Withdrawal With Permission' ){
                $d['final'] ='Withdrawal/P';
            }elseif($rems == 'No Attendance' ) {
                 $d['final'] = 'No Attendance';
            }
                return $d;
    }



    public function update_grades(){
    	$sched_id = $this->input->post('sched_id', TRUE);
    	$studentid = $this->input->post('studentid', TRUE);
    	$grade = $this->input->post('grade', TRUE);
    	$studentinfo=$this->sched_grades_model->get_student_info($studentid,'studid,lastname,firstname,middlename');
    	if( $grade>=0 &&  $grade<100 ){
    		if($this->input->post('typed', TRUE) == 'pre'){
	    		$typed = 'prelim';
	    	}elseif ($this->input->post('typed', TRUE) == 'mid') {
	    		$typed = 'midterm';
	    	}else{
	    		$typed = 'tentativefinal';
	    	}
	    	$grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$studentid,'');
	    	$data = array(
	                                'student_id' => $studentid,
	                                'sched_id' => $sched_id,
	                                'submitted_by' => $this->session->userdata('id'),
	                                $typed => $grade,
                                    'date_created' => mdate('%Y-%m-%d %H:%i:%s')
	                            );

	    	if($grades){
				if(isset($grades[0]->prelim)){
					$this->grade_submission_model->update_grades($sched_id,$studentid,$typed,$grade);
				}
				else{
					$this->grade_submission_model->insert_grades($data);
				}
			}else{
				$this->grade_submission_model->insert_grades($data);
			}


			echo json_encode([1,$studentinfo]);
    	}else{
    		echo json_encode([0,$studentinfo]);
    	}

    }

    public function update_grades_fg(){
        $sched_id = $this->input->post('sched_id', TRUE);
        $studentid = $this->input->post('studentid', TRUE);
        $grade = $this->input->post('grade', TRUE);
        $subject_info = $this->subject_enrollees_model->get_subjectx($sched_id);
        $studentinfo=$this->sched_grades_model->get_student_info($studentid,'studid,lastname,firstname,middlename');
        if( $grade>=0 &&  $grade<100 ){

            $grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$studentid,'');
            $prelim = 0;
            if($subject_info[0]->semester == 3){
                $prelim = $grade;
            }

             $data = array(
                                    'student_id' => $studentid,
                                    'sched_id' => $sched_id,
                                    'submitted_by' => $this->session->userdata('id'),
                                    'prelim' => $prelim,
                                    'midterm' => $grade,
                                    'tentativefinal' => $grade,
                                    'final' => $grade,
                                );


            if($grades){
                if(isset($grades[0]->prelim)){

                    $this->grade_submission_model->update_grades_pmtf($sched_id,$studentid,$data);
                }
                else{
                    $this->grade_submission_model->insert_grades($data);
                }
            }else{
                $this->grade_submission_model->insert_grades($data);
            }

            echo json_encode([1,$studentinfo]);
        }else{
            echo json_encode([0,$studentinfo]);
        }

    }

    public function upload_excel(){
    	$grading = $this->input->post('grading',TRUE);
    	$sched_id = $this->input->post('sched_id',TRUE);

    	$data['teacher_id'] = $this->session->userdata('id');
    	$data['subject_info'] =$this->sched_record_model->get_sched_info($data['teacher_id'],$sched_id);
		$data['subject_info2'] =$this->sched_model->get_sched_info($data['teacher_id'],$data['subject_info']['sched_query'][0]->coursecode);
		$data['check_sched'] = subject_teacher($data['subject_info2']['sched_query']);
		$data['subject_info3'] =$this->sched_record_model->get_sched_adviser($sched_id,'teacher_id');
		$data['check_sched']['teacherid'][count($data['check_sched']['teacherid'])+1] = $data['subject_info3'];
		$data['check_sched']['teacher_adviser']= $data['subject_info3'];

	    	$fileDir = '/var/www/excel_files/'.$data['check_sched'][0]['schoolyear'].'/'.$data['check_sched'][0]['semester'].'/'.$sched_id;
	    	if(!is_dir($fileDir)){
	                $old = umask(0);
	                 mkdir($fileDir,0777,TRUE) || chmod($fileDir, 0744);
	                umask($old);
	        }


	        $file_name = $sched_id.'_'.$data['teacher_id'].'_'.$grading;

	    	 		$config['upload_path']          			= $fileDir;
	                $config['allowed_types']        			= 'xlsx|xls';
	                $config['file_name']             			= $file_name;
	                $config['overwrite']           				= TRUE;
	                $config['file_ext_tolower']             	= TRUE;
	                $config['max_size']             			= 500;


	    	$this->load->library('upload', $config);
	    	if ( ! $this->upload->do_upload('excel_file'))
	        {
	                $error = array('error' => $this->upload->display_errors());
	                $this->session->set_flashdata('error', $error);
	        }
	        else
	        {
	        	$this->load->helper('date');

	                $this->session->set_flashdata('success_upload_excel', $file_name);
	                $file_namex = $this->upload->data('raw_name');
	          		$file_ext = $this->upload->data('file_ext');
	          		$file_path = $this->upload->data('file_path');

	          		$idata = [
	          						'sched_id' => $sched_id,
	          						'submitted_by' => $data['teacher_id'],
	          						'excel_file' => $file_namex,
	          						'file_extension' => $file_ext,
	          						'file_path' => $file_path,
	          						'for_type' => $grading,
	          						'created_at' => mdate('%Y-%m-%d %h:%i:%s'),
	          				];
	          		if($this->sched_grades_model->get_sched_excel($sched_id,$data['teacher_id'],$file_namex,$grading)){
	          			$this->sched_grades_model->update_sched_excel($sched_id,$data['teacher_id'],$file_namex,$grading);
	          		}else{
	          			$this->sched_grades_model->insert_sched_excel($idata);
	          		}
	        }



		$enc_sched_id =		$this->encryption->encrypt($sched_id);
		$this->session->set_userdata('enc_sched_id', $enc_sched_id);
        redirect("Schedule/SCHED_GRADESX");

    }



    public function download_excel(){
    	$sched_id = $this->input->post('sched_id',TRUE);
    	$file_id = $this->encryption->decrypt($this->input->post('excel_file',TRUE)) ;

    		if($this->sched_grades_model->get_sched_excel1($file_id)){
    			$excel = $this->sched_grades_model->get_sched_excel1($file_id);
      			$fileDir = $excel[0]->file_path.$excel[0]->excel_file.$excel[0]->file_extension;
		        $contents = file_get_contents($fileDir);
		        if($excel[0]->file_extension == '.xlsx'){
		        	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		        }else{
		        	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		        }
		        header('Content-Disposition: attachment; filename="'.$excel[0]->excel_file.$excel[0]->file_extension.'"');

		        echo $contents;

		    	die();
      		}else{
      			$enc_sched_id =		$sched_id;
				$this->session->set_userdata('enc_sched_id', $enc_sched_id);
        		redirect("Schedule/SCHED_GRADESX");
      		}


    }




    public function update_grades_remarks(){
    	$sched_id = $this->input->post('sched_id', TRUE);
    	$studentid = $this->input->post('studentid', TRUE);
    	$remarks = $this->input->post('remarks', TRUE);

    	$grades = $this->grade_submission_model->get_stud_fgrades($sched_id,$studentid,'');
    	$data = array(
                                'student_id' => $studentid,
                                'sched_id' => $sched_id,
                                'submitted_by' => $this->session->userdata('id'),
                                'remarks' => $remarks,
                            );
        $studentinfo['teacherid'] = $this->session->userdata('id');
        $studentinfo['studentinfo']=$this->sched_grades_model->get_student_info($studentid,'studid,lastname,firstname,middlename');
    	if($grades){
			if(isset($grades[0]->prelim)){
                $studentinfo['error'] = 'er1'.$studentid.'--'.$remarks.'--'.$sched_id.'--'.$this->session->userdata('id');
				$studentinfo['succ'] = $this->sched_grades_model->update_grades_remarks($sched_id,$this->session->userdata('id'),$studentid,$remarks);
			}else{
                 $studentinfo['error'] = 'er2';
				$studentinfo['succ'] = $this->grade_submission_model->insert_grades($data);
			}
		}else{
            $studentinfo['error'] = 'er3';
			$studentinfo['succ'] = $this->grade_submission_model->insert_grades($data);
		}


		echo json_encode($studentinfo);
    }

       /* submit grades for review*/

    public function submit_grade_review(){
        	// $sched_id = $this->encryption->decrypt($this->input->post('sched_id', TRUE)) ;
            $sched_id = $this->input->post('sched_id', TRUE) ;
        	$type 		= $this->input->post('type', TRUE );
        	$teacher_id = $this->session->userdata('id');

        	// if( $this->check_excel_db2($sched_id,$teacher_id,$type) == 1 ){
        		if($this->sched_grades_model->get_grade_review( $sched_id )){

	        		$this->sched_grades_model->submit_grade_review( $sched_id,$this->session->userdata('id'), $type );
	        		echo json_encode([1,'Successfully submitted for review .',$type]);
	        	}else{
	        		$data =array(
	        						'sched_id' => $sched_id,
	        						'submitted_by' => $this->session->userdata('id'),
	        						'submit_'.$type => mdate('%Y-%m-%d %h:%i:%s'),
	        						'date_created' => mdate('%Y-%m-%d %h:%i:%s'),
	        				);
	        				$this->sched_grades_model->set_grade_review( $data );
	        				echo json_encode([1,'Successfully submitted for review.',$sched_id]);
	        	}
        	// }else{
        	// 	echo json_encode([0,'Please upload the excel file for '.$type.' Before Submitting, for supporting documents.']);
        	// }





    }

    public function submit_grade_review_fg(){
            // $sched_id = $this->encryption->decrypt($this->input->post('sched_id', TRUE)) ;
            $sched_id = $this->input->post('sched_id', TRUE) ;
            $type       = $this->input->post('type', TRUE );
            $teacher_id = $this->session->userdata('id');
                if($this->sched_grades_model->get_grade_review( $sched_id )){

                    $this->sched_grades_model->submit_grade_review( $sched_id,$this->session->userdata('id'), $type );
                    echo json_encode([1,'Successfully submitted for review .']);
                }else{
                    $data =array(
                                    'sched_id' => $sched_id,
                                    'submitted_by' => $this->session->userdata('id'),
                                    'submit_prelim' => mdate('%Y-%m-%d %h:%i:%s'),
                                    'submit_midterm' => mdate('%Y-%m-%d %h:%i:%s'),
                                    'submit_tentative' => mdate('%Y-%m-%d %h:%i:%s'),
                                    'submit_final' => mdate('%Y-%m-%d %h:%i:%s'),

                                    'date_created' => mdate('%Y-%m-%d %h:%i:%s'),
                            );

                            $this->sched_grades_model->set_grade_review( $data );
                            echo json_encode([1,'Successfully submitted for review.']);
                }






    }

     public function check_excel_db2($sched_id,$teacher_id,$type){
    	$proceed = 0;
    	if($this->sched_grades_model->get_sched_exce2($sched_id,$teacher_id,$type)){
			$proceed = 1;
	    }

	    return $proceed;
    }

    public function check_excel_db($sched_id,$teacher_id,$grading){
    	$proceed = 1;
    	if($this->sched_grades_model->get_sched_excel($sched_id,$teacher_id,$grading)){
    		$countx = count($this->sched_grades_model->get_sched_excel($sched_id,$teacher_id,$grading));
    		if($grading == 'ALL' && $countx >= 9){
	         		$proceed = 0;
    		}elseif($grading != 'ALL' && $countx >= 3){
    				$proceed = 0;
    		}
	    }
    }


    public function submit_grade_update(){
    		$sched_id = $this->input->post('sched_id', TRUE);
        	$type 		= $this->input->post('type', TRUE );
        	$teacher_id = $this->session->userdata('id');
        	$message = $this->input->post('message', TRUE );
        	if( $sched_id ){
        		if($message){
        			$get_grade_review = $this->sched_grades_model->get_grade_review( $sched_id );

        			$message_enc = json_decode($get_grade_review[0]->{'requ_'.$type.'_remarks'});
        			$key = count($message_enc);
        			$message_enc[$key] = array(
                            'user_id' => $teacher_id,
                            'type' => $type,
                            'who' => 'teacher',
                            'date' => date('Y-m-d H:i:s'),
                            'remarks' => $message
                        );
        			$message_enc = json_encode($message_enc);

        			$this->sched_grades_model->submit_grade_request_update( $sched_id,$this->session->userdata('id'), $type,$message_enc );
	        		echo json_encode([1,'Successfully submitted for Update Request .']);
        		}else{
        			echo json_encode([0,'PLEASE ADD A MESSAGE AND TRY AGAIN.']);
        		}

        	}else{
        		echo json_encode([0,'PLEASE RELOAD AND TRY AGAIN']);
        	}
    }


    public function get_request_remarks(){
        $sched_id = $this->input->post('sched_id',TRUE) ;
        $type = $this->input->post('type',TRUE) ;
          if($sched_id){
                $get_grade_review = $this->sched_grades_model->get_grade_review( $sched_id );
                $message_enc = json_decode($get_grade_review[0]->{'requ_'.$type.'_remarks'});
                 $remarks_c = '';
                 if($message_enc != NULL){
                 	 foreach ($message_enc as $key => $value) {
	                    $name = $this->user_model->get_user_info($value->user_id,"CONCAT(LastName,', ',FirstName,' ',MiddleName) as name");
	                    if( $value->user_id == $this->session->userdata('id')){
	                         $remarks_c .=  '
	                                      <div class="alert  messaging-left"  >
	                                              <small>'.$this->session->userdata('name').' '.nice_date($value->date,'M d, Y H:i').'</small><br />
	                                              <p>'. $value->remarks.'</p>
	                                      </div>
	                                  ';
	                    }else{
	                     $remarks_c  .= '
	                                          <div class="alert messaging-right" >
	                                                 <small>'.$name[0]->name.' '.nice_date($value->date,'M d, Y H:i').'</small><br />
	                                                  <p>'. $value->remarks.'</p>
	                                          </div>
	                                      ';
	                    }
	                }
                 }else{
                 	 $remarks_c  .= '';
                 }


            echo json_encode([1,  '<div class="message-container" >'.$remarks_c.'</div>'  ]);
          }else{
            echo json_encode([0,  'Please reload page and try again2'  ]);
         }
    }




}
