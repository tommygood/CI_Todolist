<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $config['cache_lifetime'] = 60;
    $config['caching'] = false;
    $config['template_dir'] = APPPATH .'views';
    $config['compile_dir'] = APPPATH .'views/template_c';
    $config['cache_dir'] = APPPATH . 'views/cache';
    $config['config_dir'] = APPPATH . 'views/config';
    $config['use_sub_dirs'] = false; //子目錄變數(是否在快取資料夾中生成子目錄)
    $config['left_delimiter'] = '{';
    $config['right_delimiter'] = '}';
?>
