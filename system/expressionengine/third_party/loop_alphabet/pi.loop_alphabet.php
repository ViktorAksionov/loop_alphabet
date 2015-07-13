<?php

/*
=====================================================
 This ExpressionEngine plugin was created by Viktor Aksionov
=====================================================
 Copyright (c) Viktor Aksionov
=====================================================
 Purpose: Provides alphabet loop functionality in templates
=====================================================
*/

$plugin_info = array(
            'pi_name'     => 'Loop Alphabet',
            'pi_version'    => '1.0',
            'pi_author'     => 'Viktor Aksionov',
            'pi_author_url'   => 'https://github.com/ViktorAksionov/loop_alphabet',
            'pi_description'  => 'Provides alphabet loop functionality in templates',
            'pi_usage'      => Loop_alphabet::usage()
          );

class Loop_alphabet {

    public $return_data;
 
    public function Loop_alphabet()
    {
        $this->EE =& get_instance();
      
        // get parameters and assign defaults if not set
        $tagdata = $this->EE->TMPL->tagdata;
        $range = ($this->EE->TMPL->fetch_param('range') !== false) ? $this->EE->TMPL->fetch_param('range') : 'a-z';
        $default_range = ($this->EE->TMPL->fetch_param('default_range') !== false) ? $this->EE->TMPL->fetch_param('default_range') : 'a-d';

        if ( !preg_match('/^[a-z]\-[a-z]$/', $range) ) {
            if ( preg_match('/^[a-z]\-[a-z]$/', $default_range) ) {
                $range = $default_range;
            } else {
                $range = 'a-z';
            }
            
        }
            
        $exp = explode('-', $range);
        $i = 1;
        $return_data = '';
        foreach (range($exp[0], $exp[1]) as $value) {
            $tagdatanew = $tagdata;
            $conds['alp_index'] = $i;
            $conds['alp_index_letter'] = $value;
            $tagdatanew = $this->EE->TMPL->swap_var_single('alp_index', $conds['alp_index'], $tagdatanew);
            $tagdatanew = $this->EE->TMPL->swap_var_single('alp_index_letter', $conds['alp_index_letter'], $tagdatanew);
            $tagdatanew = $this->EE->functions->prep_conditionals($tagdatanew, $conds);
            $i++;
            $return_data .= $tagdatanew;
        }
        $this->return_data = $return_data;
    }
  // END FUNCTION
  
  
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

    public function usage()
    {
        ob_start(); 
    ?>
    Use as follows:

    {exp:loop_alphabet range="b-g" default_range="a-d"}
     Iteration number {alp_index}, index letter is {alp_index_letter}
    {/exp:loop_alphabet}
    
    Use parse="inward" if you have other loop inside of {exp:loop_alphabet}
    
    Default value of parameters: 
        "range": "a-z"
        "default_range": "a-d"
        
    In case if parameter "range" is empty/not defined or invalid then value of parameter "default_range" will be used.
    In case if both parameters are not empty and incorrect then parameter "range" will have value 'a-z'

    <?php
        $buffer = ob_get_contents();

        ob_end_clean(); 

        return $buffer;
    }
// END USAGE
}