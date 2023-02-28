<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transmutation
{
     protected $CI;

        // We'll use a constructor, as you can't directly call a function
        // from a property definition.
    public function __construct()
    {
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();
    }

    public function svnt5($total,$prcnt){
        $svnt5=floor($total*($this->convert_prcnt($prcnt)));
        return $svnt5;
    }

    public function convert_prcnt($prcnt){
        return $prcnt = ($prcnt/100);
    }

    public function get_diff($total,$svnt5){
       return $diff = $total-$svnt5;
    }

    public function create_json($total,$prcnt){
        $this->CI->load->helper('file');

        $svnt5 = $this->svnt5($total,$prcnt);
        $diff  =  $this->get_diff($total,$svnt5);

        //check file if exist if not create json
        $path = 'assets/transmutation/'.$prcnt.'/';
        $file = ($path.$total.'.json');

        if(file_exists($file)){
            $str = ((file_get_contents($file)));
            $json = json_decode($str, true);
            return $json;
        }else{

            if(!is_dir($path)){
                $old = umask(0);
                 mkdir($path,0777,TRUE) || chmod($path, 0744);
                umask($old);
            }

            if($diff>=24){
                $data = $this->set_higher_hps($total,$prcnt,$diff,$svnt5);
            }else{
                $data = $this->set_higher_hps_l($total,$prcnt,$diff,$svnt5);
            }

            if ( ! write_file($file, json_encode($data),'w+'))
            {

                    return false;
            }
            else
            {
                        chmod($file, 0774);
                        $str = ((file_get_contents($file)));
                        $json = json_decode($str, true);
                        return $json;
            }
        }




    }

    public function set_higher_hps($total,$prcnt,$diff,$svnt5){
            $data =[];
            $n_total = $total;
            $lps_total=$total;
            $int ='';
            $equiv=99;
            $data['hps'][$total]=$equiv;
            for($x=24;$x>0;$x--){
                $n_total = $total-$svnt5;
                $int =floor($n_total/$x);
                $equiv--;
                for($c=$int;$c>0;$c--){
                    if($total>$svnt5){
                        $total=$total-1;
                        $data['hps'][$total]=$equiv;
                    }
                }

                $n_total=$total;
            }

            $data['lps']=$this->set_lower_lps($total,$prcnt,$diff,$svnt5,$lps_total);
            krsort($data['lps']);
            krsort($data['hps']);
            $new = ($data['hps']+$data['lps']);
            return $new;
    }

    public function set_lower_lps($total,$prcnt,$diff,$svnt5,$lps_total){
        $equiv=65;
        $lps=0;
        $data=[];
        for($x=10;$x>0;$x--){
            $int=floor(($svnt5-$lps)/$x);
            for($c=0;$c<$int;$c++){
                        $data[$lps]=$equiv;
                        $lps=$lps+1;
            }

            $equiv++;
        }
        return ($data);
    }


    public function set_higher_hps_l($total,$prcnt,$diff,$svnt5){
            $data =[];
            $n_total = $total;
            $lps_total=$total;
            $int ='';
            $equiv=99;
            $xc=24;
            for($x=24;$x>=1;$x--){
                $n_total = $total-$svnt5;

                    if($n_total>0){
                        $int =floor($xc/$n_total);
                        $data['hps'][$total]=$equiv;
                        if($n_total==$xc){
                            $equiv=$equiv-1;
                        }else{
                            $equiv=$equiv-$int-1;
                        }
                             $total=$total-1;
                             $xc=$xc-$int-1;
                    }
                $n_total=$total;
            }
            if($svnt5<=10){
                 $data['lps']=$this->set_lower_lps_ll($total,$prcnt,$diff,$svnt5,$lps_total);
            }else{
                 $data['lps']=$this->set_lower_lps_l($total,$prcnt,$diff,$svnt5,$lps_total);
            }

            krsort($data['lps']);
            krsort($data['hps']);
            $new = ($data['hps']+$data['lps']);
            return $new;
    }

    public function set_lower_lps_ll($total,$prcnt,$diff,$svnt5,$lps_total){
        $equiv=65;
        $lps=0;
        $data=[];
        $cx=10-$svnt5;
        $c_0=1;
        $count=0;
        $data[$svnt5]=75;
        for($x=0;$x<10;$x++){
              if($c_0==0){
                    $c_0=1;
                    $count++;
                    $equiv=$equiv+1;
              }else{
                    $data[$lps]=$equiv;
                    $equiv=$equiv+1;
                    $lps++;
                  if($count==$cx){
                     $c_0=1;
                 }else{
                     $c_0=0;
                 }
              }
        }
        return ($data);
    }


    public function set_lower_lps_l($total,$prcnt,$diff,$svnt5,$lps_total){
        $equiv=65;
        $lps=0;
        $data=[];
        $xc=10;
        $data[$svnt5]=75;
        for($x=10;$x>=1;$x--){
            $int=floor(($svnt5-$lps)/$x);
               for($c=0;$c<$int;$c++){
                        $data[$lps]=$equiv;
                        $lps=$lps+1;
             }
               $equiv++;
        }
        return ($data);
    }






}