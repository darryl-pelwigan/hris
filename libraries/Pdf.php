<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf {

    function __construct()
    {
        $CI = & get_instance();
        // log_message('Debug', 'mPDF class is loaded.');
    }

    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/MPDF/mpdf.php';

        if ($params == NULL)
        {
            $param = "'utf-8','A4','','','15','15','28','18'";
        }

        return new mPDF($param);
    }
}