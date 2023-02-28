<?php defined('BASEPATH') OR exit('No direct script access allowed');


class HR_model extends CI_Model {
    function get_position_lists($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_position');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_position_category_lists(){
        $this->db->select('position_category');
        $this->db->from('pcc_position');
        $this->db->group_by('position_category');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_department_lists($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_departments');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_staff_leave_records($leave_id){
        $this->db->select('la.*, lt.type');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left');           
        if($leave_id > 0){
            $this->db->where('la.id' , $leave_id);
        }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_emp_leave_records($leave_id){
        $this->db->select('la.*, lt.type');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left');          
        $this->db->where('dayswithpay', 0);     
        $this->db->where('dayswithoutpay', 0);     
        $this->db->order_by('date_requested', 'desc');     
        if($leave_id > 0){
            $this->db->where('la.id' , $leave_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

     function get_emp_leave_records_summary($leave_id){
        $this->db->select('la.*, lt.type');
        $this->db->from('pcc_hr_leave_application la');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=la.leave_type_id', 'left');                     
        $this->db->where('(dayswithpay != "0" OR dayswithoutpay != "0")');
        if($leave_id > 0){
            $this->db->where('la.id' , $leave_id);
        }
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_leave_credits($leave_id){
        $this->db->select('l.leave_credit, l.date_added, l.type_id, lt.type, l.empid, l.type_id, l.id');
        $this->db->from('pcc_hr_leave l');  
        $this->db->join('pcc_hr_leave_type lt', 'lt.id=l.type_id', 'inner');    
        if($leave_id > 0){
            $this->db->where('l.empid' , $leave_id);
        }    
        $this->db->group_by('l.empid, l.type_id');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_overtime_records($ot_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_overtime');  
        if($ot_id > 0){
            $this->db->where('pcc_hr_overtime.id' , $ot_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_pass_slip_records($passlip_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_passslip');  
        if($passlip_id > 0){
            $this->db->where('pcc_hr_passslip.id' , $passlip_id);
        }
         $this->db->where('pcc_hr_passslip.type' , 'personal');   
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp__official_pass_slip_records($passlip_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_passslip');  
        if($passlip_id > 0){
            $this->db->where('pcc_hr_passslip.id' , $passlip_id);
        }
         $this->db->where('pcc_hr_passslip.type' , 'official');   
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_pass_slip_records_summary($passlip_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_passslip');  
        // $this->db->where('exact_timeout !=', null);  
        if($passlip_id > 0){
            $this->db->where('pcc_hr_passslip.id' , $passlip_id);
        }
        $this->db->where('pcc_hr_passslip.type' , 'personal');   
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }
    function get_emp__official_pass_slip_records_summary($passlip_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_passslip');  
        // $this->db->where('exact_timeout !=', null);  
        if($passlip_id > 0){
            $this->db->where('pcc_hr_passslip.id' , $passlip_id);
        }
        $this->db->where('pcc_hr_passslip.type' , 'official');   
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_travel_order_records($travelo_id){
        $this->db->select('*');
        $this->db->from('pcc_hr_travel_form');  
        if($travelo_id > 0){
            $this->db->where('pcc_hr_travel_form.id' , $travelo_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_emp_position($select='*'){
        $this->db->select($select);
        $this->db->from('pcc_position');
        $query = $this->db->get();
        return $query->result();
    }
    function get_position_details($id){
        $this->db->select('*');
        $this->db->from('pcc_position');
        $this->db->where('id' , $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_holidays($holiday_id){
        $this->db->select('*');
        $this->db->from('holidays');  
        if($holiday_id > 0){
            $this->db->where('holidays.holiday_id' , $holiday_id);
        }    
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    } 

    function get_service_log(){
        $this->db->select("*");
        $this->db->from("pcc_hr_service_leave_credits");
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function insert_holiday_list($data){
        $this->db->insert('holidays', $data);
        return $this->db->insert_id();
    }
    
    function update_holiday_list($data, $holiday_id){
        $this->db->where('holiday_id', $holiday_id);
        $this->db->update('holidays', $data);
        return $this->db->affected_rows();
    }

    function del_holiday($holiday_id){
        $this->db->where('holidays.holiday_id', $holiday_id);
        return $this->db->delete('holidays');
    }


    function checkemp_for_request_approval($fileno){
        $this->db->select('p.position_category');
        $this->db->from('pcc_hr_leave_approval a');  
        $this->db->join('pcc_position p', 'lower(p.position_category)=lower(a.category_approval)', 'inner');      
        $this->db->join('pcc_staff s', 's.positionrank=p.id', 'inner');  
        $this->db->where('s.fileno', $fileno);   
        $query = $this->db->get();
        return $query->result()?$query->result():false;
        
    }

    function insert_employee_position($data){
        $this->db->insert('pcc_position', $data);
        return $this->db->insert_id();
    }

    function update_employee_position($data, $id){
        $this->db->where('id', $id);
        $this->db->update('pcc_position', $data);
        return $this->db->affected_rows();
    }

    function del_position_details($id){
        $this->db->where('pcc_position.id', $id);
        return $this->db->delete('pcc_position');
    }

    function get_all_leave_records_notif(){
        $this->db->select("la.*, st.LastName, st.FirstName, st.MiddleName");
        $this->db->from("pcc_hr_leave_application la");
        $this->db->join('pcc_staff st', 'la.empid = st.FileNo', 'left'); 
        $this->db->where('dayswithpay', 0); 
        $this->db->where('dayswithoutpay', 0); 
        $this->db->order_by("date_requested", 'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_all_unseen_notif_leave_(){
        $this->db->select("*");
        $this->db->from("pcc_hr_leave_application la");
        $this->db->join('pcc_hr_leave_seen_notification sn', 'la.id = sn.leave_app_id', 'left'); 
        // $this->db->where('dayswithpay', 0); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;    
    }



    // function update_all_leave_records_notif($data, $id){
    //     $this->db->where('id', $id);
    //     $this->db->update('pcc_hr_leave_application', $data);
    //     return $this->db->affected_rows();
    // }

    function update_seen_record($data, $id){
        $this->db->where('id', $id);
        $this->db->update('pcc_hr_leave_application', $data);
        return $this->db->affected_rows();
    }

    function insert_seen_record($data, $id){
        $this->db->where('id', $id);
        $this->db->update('pcc_hr_leave_application', $data);
        return $this->db->affected_rows();
    }
    function get_user_position($id){
        $this->db->select("s.PositionRank, p.position_category");
        $this->db->from("pcc_staff s");
        $this->db->join("pcc_position p", 's.PositionRank = p.id');
        $this->db->where("BiometricsID", $id);
        $query = $this->db->get();
        return $query->result()?$query->result():false;  
    }

    function checkemp_for_approval($rank, $category){
        $this->db->select('*');
        $this->db->from('pcc_hr_leave_approval');  
        $this->db->where('category', $rank);  
        $this->db->where('category_approval', $category);  
        $query = $this->db->get();
        return $query->result()?$query->result():false;
    }

    function get_all_leave_records_hr_notif(){
        $this->db->select("la.*, st.LastName, st.FirstName, st.MiddleName, ht.type");
        $this->db->from("pcc_hr_leave_application la");
        $this->db->join('pcc_staff st', 'la.empid = st.FileNo', 'left'); 
        $this->db->join('pcc_hr_leave_type ht', 'ht.id = la.leave_type_id'); 
        $this->db->where('dayswithpay', 0); 
        $this->db->where('dayswithoutpay', 0); 
        $this->db->order_by("date_requested", 'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;       
    }

    function insert_notification_status($data){
        $this->db->insert('pcc_hr_leave_seen_notification', $data);
        return $this->db->insert_id();
    }

    function get_notication_seen_lists($empid, $leave_id){
        $this->db->select("*");
        $this->db->from("pcc_hr_leave_seen_notification");
        $this->db->where('seen_empid', $empid); 
        $this->db->where('leave_app_id', $leave_id); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;         
    }

    function update_notification_status($data, $leave_id, $empid){
        $this->db->where('seen_empid', $empid);
        $this->db->where('leave_app_id', $leave_id);
        $this->db->update('pcc_hr_leave_seen_notification', $data);
        return $this->db->affected_rows();
    }

    function get_all_seen_notif_leave(){
        $this->db->select("*");
        $this->db->from("pcc_hr_leave_seen_notification sn");
        $this->db->join('pcc_hr_leave_application la', 'la.id = sn.leave_app_id', 'left'); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;       
    }

    function get_all_notification_seener($leave_id, $empid){
        $this->db->select("*");
        $this->db->from("pcc_hr_leave_seen_notification");
        $this->db->where('leave_app_id', $leave_id); 
        $this->db->where('seen_empid', $empid); 
        $query = $this->db->get();
        return $query->result()?$query->result():false; 
    }

   function get_user_leave_notification_list(){
        $this->db->select("la.*, st.LastName, st.FirstName, st.MiddleName, ht.type");
        $this->db->from("pcc_hr_leave_application la");
        $this->db->join('pcc_staff st', 'la.empid = st.FileNo', 'left'); 
        $this->db->join('pcc_hr_leave_type ht', 'ht.id = la.leave_type_id'); 
        $this->db->where("dept_head_approval", 0);
        $this->db->order_by("date_requested", 'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;          
    }
    function get_notication_overtime_lists($empid, $overtime_id){
        $this->db->select("*"); 
        $this->db->from("pcc_hr_overtime_seen_notification");
        $this->db->where('seen_empid', $empid); 
        $this->db->where('overtime_id', $overtime_id); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;         
    }

    function update_notification_overtime_status($data, $overtime_id, $empid){
        $this->db->where('seen_empid', $empid);
        $this->db->where('overtime_id', $overtime_id);
        $this->db->update('pcc_hr_overtime_seen_notification', $data);
        return $this->db->affected_rows();
    }

    function insert_notification_overtime_status($data){
        $this->db->insert('pcc_hr_overtime_seen_notification', $data);
        return $this->db->insert_id();
    }

    function get_notication_pass_lists($empid, $pass_slip_id){
        $this->db->select("*");
        $this->db->from("pcc_hr_pass_slip_seen_notification");
        $this->db->where('seen_empid', $empid); 
        $this->db->where('pass_slip_id', $pass_slip_id); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;         
    }

    function update_notification_pass_status($data, $pass_slip_id, $empid){
        $this->db->where('seen_empid', $empid);
        $this->db->where('pass_slip_id', $pass_slip_id);
        $this->db->update('pcc_hr_pass_slip_seen_notification', $data);
        return $this->db->affected_rows();
    }

    function insert_notification_pass_status($data){
        $this->db->insert('pcc_hr_pass_slip_seen_notification', $data);
        return $this->db->insert_id();
    }

    function get_notication_travel_lists($empid, $travel_id){
        $this->db->select("*");
        $this->db->from("pcc_hr_travel_seen_notification");
        $this->db->where('seen_empid', $empid); 
        $this->db->where('travel_id', $travel_id); 
        $query = $this->db->get();
        return $query->result()?$query->result():false;         
    }

    function update_notification_travel_status($data, $travel_id, $empid){
        $this->db->where('seen_empid', $empid);
        $this->db->where('travel_id', $travel_id);
        $this->db->update('pcc_hr_travel_seen_notification', $data);
        return $this->db->affected_rows();
    }
    function insert_notification_travel_status($data){
        $this->db->insert('pcc_hr_travel_seen_notification', $data);
        return $this->db->insert_id();
    }

    function get_all_overtime_seener($overtime_id, $empid){
        $this->db->select("*");
        $this->db->from("pcc_hr_overtime_seen_notification");
        $this->db->where('overtime_id', $overtime_id); 
        $this->db->where('seen_empid', $empid); 
        $query = $this->db->get();
        return $query->result()?$query->result():false; 
    }    

    function get_all_pass_seener($pass_slip_id, $empid){
        $this->db->select("*");
        $this->db->from("pcc_hr_pass_slip_seen_notification");
        $this->db->where('pass_slip_id', $pass_slip_id); 
        $this->db->where('seen_empid', $empid); 
        $query = $this->db->get();
        return $query->result()?$query->result():false; 
    }    

    function get_all_travel_seener($travel_id, $empid){
        $this->db->select("*");
        $this->db->from("pcc_hr_travel_seen_notification");
        $this->db->where('travel_id', $travel_id); 
        $this->db->where('seen_empid', $empid); 
        $query = $this->db->get();
        return $query->result()?$query->result():false; 
    }

    function get_all_overtime_records_hr_notif(){
        $this->db->select("la.*, st.LastName, st.FirstName, st.MiddleName");
        $this->db->from("pcc_hr_overtime la");
        $this->db->join('pcc_staff st', 'la.empid = st.FileNo', 'left'); 
        $this->db->where('dept_head_approval', 0); 
        $this->db->order_by("date_requested", 'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;       
    }
    
    function get_all_pass_records_hr_notif(){
        $this->db->select("la.*, st.LastName, st.FirstName, st.MiddleName");
        $this->db->from("pcc_hr_passslip la");
        $this->db->join('pcc_staff st', 'la.empid = st.FileNo', 'left'); 
        $this->db->where('dept_head_approval', 0); 
        $this->db->order_by("date_requested", 'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;       
    }
    function get_all_travel_records_hr_notif(){
        $this->db->select("la.*, st.LastName, st.FirstName, st.MiddleName");
        $this->db->from("pcc_hr_travel_form la");
        $this->db->join('pcc_staff st', 'la.empid = st.FileNo', 'left'); 
        $this->db->where('dept_head_approval', 0); 
        $this->db->order_by("date_requested", 'desc');
        $query = $this->db->get();
        return $query->result()?$query->result():false;       
    }

    function update_travel_highlights($travel_id, $empid){
        $this->db->set('highlight_status',1);        
        $this->db->where('travel_id', $travel_id);
        $this->db->where('seen_empid', $empid);
        $this->db->update('pcc_hr_travel_seen_notification');
        return $this->db->affected_rows();
    }

    function update_pass_seen_status($pass_id, $empid){
        $this->db->set('highlight_status',1);        
        $this->db->where('pass_slip_id', $pass_id);
        $this->db->where('seen_empid', $empid);
        $this->db->update('pcc_hr_pass_slip_seen_notification');
        return $this->db->affected_rows();
    }

    function update_overtime_seen_status($overt_id, $empid){
        $this->db->set('highlight_status',1);        
        $this->db->where('overtime_id', $overt_id);
        $this->db->where('seen_empid', $empid);
        $this->db->update('pcc_hr_overtime_seen_notification');
        return $this->db->affected_rows();

    }

    function update_leave_seen_status($leave_id, $empid){
        $this->db->set('highlight_status',1);        
        $this->db->where('leave_app_id', $leave_id);
        $this->db->where('seen_empid', $empid);
        $this->db->update('pcc_hr_leave_seen_notification');
        return $this->db->affected_rows();
    }

    function get_license_expired() {
        $this->db->select("e.eligname, e.expiry, s.LastName, s.FirstName, s.MiddleName, s.BiometricsID, e.id, ex.highlight_status");
        $this->db->from("pcc_staff_eligibility e");
        $this->db->join("pcc_staff s", "s.BiometricsID = e.staff_id", "left");
        $this->db->join("pcc_hr_expiry_seen_notification ex", "e.id = ex.eligibility_id", "left");
        $this->db->where("s.active", 1);
        $this->db->where("date(e.expiry) <= DATE_ADD(now(),INTERVAL 1 MONTH)");
        $this->db->where("date(e.expiry) >= now()");
        $this->db->where("date_format(e.expiry, '%Y') != '?';");
        // $this->db->order_by("expiry", "asc");
        return $this->db->get();
    }

    function insert_expiry_seen_notification($user_id, $elig_id) {
        $data = array(
            'seen_empid' => $user_id,
            'eligibility_id' => $elig_id,
            'notif_status' => 0, // not seen....
            'highlight_status' => 0 // highlighted
        );
        $this->db->insert('pcc_hr_expiry_seen_notification', $data);
    }

    function get_expiry_seen_notification($user_id, $elig_id) {
        $this->db->select("*");
        $this->db->from("pcc_hr_expiry_seen_notification");
        $this->db->where("seen_empid", $user_id);
        $this->db->where("eligibility_id", $elig_id);
        return $this->db->get();
    }

    function count_unseen_expiry_notification() {
        $this->db->select("*");
        $this->db->from("pcc_hr_expiry_seen_notification");
        $this->db->where("notif_status", 0);
        return $this->db->get();
    }

    function highlight_expiry_seen_notification($user_id, $elig_id) {
        $this->db->set("highlight_status", 1);
        $this->db->where("seen_empid", $user_id);
        $this->db->where("eligibility_id", $elig_id);
        $this->db->update("pcc_hr_expiry_seen_notification");
        return $this->db->affected_rows();
    }

    function update_seen_expiry_notification($user_id, $elig_id) {
        $this->db->set("notif_status", 1);
        $this->db->where("seen_empid", $user_id);
        $this->db->where("eligibility_id", $elig_id);
        $this->db->update("pcc_hr_expiry_seen_notification");
        return $this->db->affected_rows();
    }
}