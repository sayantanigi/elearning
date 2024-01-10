<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class ScheduleModel extends CI_Model {
			
			public function checkSAvailableAndNoteAvailable($instructorId,$date,$time){
				$data =  $this->db->get_where('schedule_calendar',array('instructorId'=>$instructorId,'date'=>$date,'time'=>$time,'status'=>1))->num_rows();
				return $data;
			}

			public function checkBookedSloat($instructorId,$date,$time){
				
				$data =  $this->db->get_where('schedule_calendar',array('instructorId'=>$instructorId,'date'=>$date,'time'=>$time,'status'=>2))->num_rows();
			
				return $data;
			}

			public function checkBookedcomplete($instructorId,$date,$time){
				$data =  $this->db->get_where('schedule_calendar',array('instructorId'=>$instructorId,'date'=>$date,'time'=>$time,'status'=>3))->num_rows();
				return $data;
			}
			
			public function checkSlotdateAvailable($date){
		     	$data =  $this->db->select('sid')->get_where('schedule_calendar',array('date'=>$date))->result();
			 	return count($data);
			}

			public function bookedSlotCheck($instructorId,$date,$time){
		        $data =  $this->db->select('menteeId')->get_where('booking',array('instructorId'=>$instructorId,'b_date'=>$date,'b_time'=>$time,'staus'=>1))->row('menteeId');
				return $data;
			}
	}
	