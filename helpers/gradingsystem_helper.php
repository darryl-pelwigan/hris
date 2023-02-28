<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Grading System  Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/form_helper.html
 */


// ------------------------------------------------------------------------
if ( ! function_exists('finalg'))
{
	function finalg($final , $remarks,$pdf = false){

		if($remarks == 'Passed'){
               	if($final > 75 ){
               		  $final=round( $final);
               	}else{
               		 $final=75;
               	}
		}else{
			if($remarks == 'Failed'){
				$finalx =round( $final);
				$finalz = explode('.', $final);
				if($finalx == 75){
					$final = $finalz[0];
				}else{
					$final = $finalx;
				}

			}elseif ( ucwords(strtolower($remarks))  == 'No Grade') {
				$final =  '';
			}else{
				$final=round( $final,2);
			}
		}

		return $final;

	}
}


// ------------------------------------------------------------------------
if ( ! function_exists('gremarks'))
{
	function gremarks($final , $remarks,$pdf = false){

		switch ($remarks) {

          case 'No Final Examination':
              $final = 'NFE';
            break;
          case 'No GRADE':
              $final ='NG';
            break;

          case 'Officially Dropped':
              $final ='ODRP';
            break;

          case 'Unofficially Dropped':
              $final ='UDRP';
            break;

          case 'Incomplete':
              $final ='INC';
            break;

          case 'No CREDIT':
              $final ='NC';
            break;

          case 'DROPPED':
              $final ='DRP';
            break;

          case 'Withdrawal with Permission':
              $final ='Withdrawal/P';
            break;

           case 'No Attendance':
              $final ='No Attendance';
            break;

          default:
            break;
        }

        return $final;

	}
}


if ( ! function_exists('xx'))
{
    function xx()
    {
        list($callee) = debug_backtrace();

        $args = func_get_args();

        $total_args = func_num_args();

        echo '<div><fieldset style="background: #fefefe !important; border:1px red solid; padding:15px">';
        echo '<legend style="background:blue; color:white; padding:5px;">'.$callee['file'].' @line: '.$callee['line'].'</legend><pre><code>';

        $i = 0;

        foreach ($args as $arg)
        {
            echo '<strong>Debug #' . ++$i . ' of ' . $total_args . '</strong>: ' . '<br>';

            var_dump($arg);
        }

        echo "</code></pre></fieldset><div><br>";

        die();
    }


}



if ( ! function_exists('summer_pmt'))
{
    function summer_pmt($data)
    {
    	if($data['courseno'] == 'COMPRE 2' && $data['course'] == '3' ){
    		return true;
    	}
       return false;
    }


}


// ------------------------------------------------------------------------
if ( ! function_exists('nice_dateX'))
{
	function nice_dateX($date , $format){

		$nice_dateX = nice_date($date , $format);

		if($nice_dateX == "Unknown"){
			$nice_dateX = "";
		}

		return $nice_dateX ;
	}
}



if ( ! function_exists('dd'))
{
	function dd($data){

		return '<pre>'.print_r($data).'</pre>';
	}
}




/** sort for specific field */
if ( ! function_exists('build_sorter'))
{
	function build_sorter($key) {
		return function ($a, $b) use ($key) {
			return strnatcmp($a[$key], $b[$key]);
		};
	}
}



if ( ! function_exists('subject_teacher'))
{
	/**
	 * Form Declaration - transmutation
	 *
	 * loads transmutation table
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string RLE
	 */
	function subject_teacher($subject)
	{
	$data = [];
	$data['count']=count($subject);

	$labunits=0;
	$lecunits=0;
	$skillslab=0;
	$clinical=0;
	$totalunits=0;
	for($x=0;$x<count($subject);$x++) {
		$data['teacherid'][$x]=$subject[$x]->teacherid;
		foreach ($subject[$x] as $key => $value) {
			$data[$subject[$x]->teacherid][$key] =$value;
			$data[$x][$key] =$value;
		}

		 	if($subject[$x]->labunits>0)
				{$labunits=($subject[$x]->labunits)+$labunits;}

			if($subject[$x]->lecunits>0)
			{$lecunits=($subject[$x]->lecunits)+$lecunits;}

			if($subject[$x]->skillslab>0)
			{$skillslab=($subject[$x]->skillslab)+$skillslab;}

			if($subject[$x]->clinical>0)
			{$clinical=($subject[$x]->clinical)+$clinical;}

			if($subject[$x]->totalunits>0)
			{$totalunits=($subject[$x]->totalunits)+$totalunits;}



	}
	$data['lecunits']=$lecunits;
	$data['labunits']=$labunits;
	$data['skillslab']=$skillslab;
	$data['clinical']=$clinical;
	$data['totalunits'] = $totalunits;
	return $data;
    }


}

if ( ! function_exists('subject_lab'))
{
	/**
	 * Form Declaration - transmutation
	 *
	 * loads transmutation table
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string RLE
	 */
	function subject_lab($subject_type)
	{
            if($subject_type=='Internship'){

            }elseif($subject_type=='Laboratory'){

            }elseif($subject_type=='Lecture'){

            }elseif($subject_type=='Lec&Lab'){

            }elseif($subject_type=='RLE'){

            }
    }


}

if ( ! function_exists('subject_type_lab'))
{
	/**
	 * Form Declaration - transmutation
	 *
	 * loads transmutation table
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string
	 */
	function subject_type_lab($subject_type)
	{

    }


}
if ( ! function_exists('curl'))
{
	/**
	 * Form Declaration - curl
	 *
	 * loads curl table
	 *
	 * @param	string	the URI segments of the form destination
	 * @param	array	a key/value pair of attributes
	 * @param	array	a key/value pair hidden data
	 * @return	string
	 */

	function curl($url,$params) {
		// Assigning cURL options to an array
		$options = Array(
			CURLOPT_RETURNTRANSFER => TRUE, // Setting cURL's option to return the webpage data
			CURLOPT_URL => $url, // Setting cURL's URL option with the $url variable passed into the function
			CURLOPT_POST => TRUE, // SET curl POST
			CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HEADER => 0
		);

		$ch = curl_init();  // Initialising cURL
		curl_setopt_array($ch, $options);   // Setting cURL's options using the previously assigned array data in $options
		$data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
		curl_close($ch);    // Closing cURL
		return $data;   // Returning the data from the function
	}
}




if ( ! function_exists('type_grade'))
{
        /**
         * Form Declaration - trans
         *
         * gets the alpbt letter
         *
         * @param       string  the URI segments of the form destination
         * @param       array   a key/value pair of attributes
         * @param       array   a key/value pair hidden data
         * @return      string
         */
        function type_grade( $type ){
                $checker = false;
                $type = strtolower($type);
           if($type == 'prelim'){
                 $checker = true;
           }else if($type == 'midterm'){
                 $checker = true;
           }else if($type == 'tentative'){
                 $checker = true;
           }else if($type == 'final'){
                 $checker = true;
           }

           return $checker;
   }

}


if ( ! function_exists('semester'))
{
        /**
         * Form Declaration - trans
         *
         * gets the alpbt letter
         *
         * @param       string  the URI segments of the form destination
         * @param       array   a key/value pair of attributes
         * @param       array   a key/value pair hidden data
         * @return      string
         */
        function semester( $sem ){
           if($sem == 1){
                 $checker = '1st Semester' ;
           }else if($sem == 2){
                 $checker = '2nd Semester' ;
           }else if($sem == 3){
                 $checker = 'Summer' ;
           }

           return $checker;
   }

}