<?php

namespace App\View\Helper;

use Cake\View\Helper;

class GeneralHelper extends Helper
{
    public function mpr($d, $echo = TRUE)
    {
        if ($echo) {
            echo '<pre>' . print_r($d, true) . '</pre>';
        } else {
            return '<pre>' . print_r($d, true) . '</pre>';
        }
    }

    public function pr($d)
    {
        $last = debug_backtrace()[0];
        echo "<small><sub>" . $last['file'] . ":" . $last['line'] . "</sub></small>";
        echo "<br>";
        $this->mpr($d);
        die;
    }
}
