<?php

/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2014, Ajith Vp <ajith@kraftlabs.com>
 * @date 30-Jan-2015
 */
if (!function_exists('print_log')) {

    function print_log($text) {
        if (is_array($text)) {
            $text = http_build_query($text);
        }
        echo '<script type="text/javascript">log("' . $text . '");</script>';
    }

}

function generate_options($array = array(), $from = 1, $to = 12, $selected = 0) {
    $options = '';
    $group = '';
    $text = '';
    if (sizeof($array) == 0) {
        if ($from >= 0 && $to > 0) {
            for ($i = $from; $i <= $to; $i++) {
                $text = (isset($selected) && $selected == $i) ? 'selected="selected" ' : '';
                $options .= '<option ' . $text . ' value="' . $i . '" >' . $i . '</option>';
            }
        }
    } else {
        if (sizeof($array[0])) {
            foreach ($array as $key => $value) {
                if (isset($selected)) {
                    if (is_array($selected)) {
                        foreach ($selected as $k => $v) {
                            if ($v == $value['id']) {
                                $text = 'selected="selected" ';
                                break;
                            } else {
                                $text = '';
                            }
                        }
                    } else {
                        $text = ($selected == $value['id'] ) ? 'selected="selected" ' : '';
                    }
                }

                if (isset($value['group_name']) && $group != $value['group_name']) {
                    if ($group !== '') {
                        $options .= '</optgroup>';
                    }
                    $group = $value['group_name'];
                    $options .= '<optgroup label="' . $value['group_name'] . '">';
                }
                $options .= '<option value = "' . $value['id'] . '" ' . $text . ' >' . $value['name'] . '</option>';
            }
        }
    }
    if (isset($value['group_name'])) {
        $options .= '</optgroup>';
    }
    return $options;
}

function has_privilege($class,$method) {
    $CI = & get_instance();
    $CI->load->model('privilegemodel');
    return $CI->privilegemodel->user_has_privilege($class, $method);
}
