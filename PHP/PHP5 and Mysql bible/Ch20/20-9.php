<?php

// ---- The form class itself ---

class HtmlForm {

  // suitable for generating quick&dirty forms
  
  var $actionTarget; // path to receiving page
  private var $inputForms;  // array of HtmlFormInput
  var $hiddenVariables; // associative name/val

  // CONSTRUCTOR
  function __construct($action_target) {
    $this->actionTarget = $action_target;
    $this->inputForms = array();
    $this->hiddenVariables = array();
  }

  // PUBLIC METHODS
  function toString () {
    $return_string = "";
    $return_string .= 
       "<FORM METHOD=\"POST\" ".
       "ACTION=\"$this->actionTarget\">\n";
    $return_string .= $this->inputFormsString();
    $return_string .= $this->hiddenVariablesString();
    $return_string .= "<BR>\n";
    $return_string .= $this->submitButtonString();
    $return_string .= "</FORM>";
    return($return_string);
  }

  // adding elements to form

  function addInputForm ($input_form) {
    if (!isSet($input_form) ||
        !is_object($input_form) ||
        !is_subclass_of($input_form, 
                  'htmlforminput')){
      die("Argument to HtmlForm::addInputForm ".
          "must be instance of HtmlFormInput.".
          "  Given argument is of class " .
          get_class($input_form));
    }
    else {
      array_push($this->inputForms, $input_form);
    }
  }

  function addInputButton ($input_button) {
    if (!isSet($input_button) ||
        !isObject($input_button) ||
        !is_a($input_button, 'HtmlInputButton')){
      die("Argument to HtmlForm::addInputButton ".
          "must be instance of HtmlInputButton");
    }
    else {
      array_push($this->inputButtons, $input_button);
    }
  }

  function addHiddenVariable ($name, $value) {
    if (!isSet($value)) {
      die("HtmlForm::addHiddenVariable requires ".
          "two arguments (name and value)");
    }
    else {
      $this->hiddenVariables[$name] = $value;
    }
  }

  function inputFormsString () {
    $return_string = "";
    $form_array = $this->inputForms;
    foreach ($form_array as $input_form) {
      $return_string .= 
         "<B>$input_form->heading</B>";
      if ($this->headingElementBreak()) {
         $return_string .= "<BR>";
      }
      $return_string .= $input_form->toString();
      $return_string .= "<BR>\n";
    }
    return($return_string);
  }

  function hiddenVariablesString () {
    $return_string = "";
    while ($hidden_var = 
             each($this->hiddenVariables)) {
      $var_name = $hidden_var['key'];
      $var_value = $hidden_var['value'];
      $return_string .= 
         "<INPUT TYPE=HIDDEN " .
         "NAME=$var_name ".
         "VALUE=$var_value >";
         $return_string .= "\n";
    }
    return($return_string);
  }

  function headingElementBreak () {
    // override to disable breaks after headings,
    // or to do more complicate layout
    return(TRUE);
  }

  function submitButtonString () {
    $return_string = "<INPUT TYPE=Submit " .
                     " VALUE=Submit >\n";
    return($return_string);
  }
}

// ---- Classes for parts of a form ----

abstract class HtmlFormInput {
  var $name; // The variable name for form submission
  var $heading; // The visible label on form
  function __construct() {
    die("Class HtmlFormInput intended only " .
        "to be subclassed");
  }
  function toString () {
    die("Subclass of HtmlFormInput missing " .
        "definition of toString()");
  }
}

class HtmlFormSelect extends HtmlFormInput
{
  var $_valueArray = array();
  var $_selectedValue;

  function __construct ($name, $heading,
                           $value_array,
                           $selected_value=NULL) {
    if (!isSet($value_array)) {
      die("HtmlFormSelect needs a minimum of two " .
           "arguments: a name, and value array");
    }    
    elseif (!is_array($value_array)) {
      die("Third argument to HtmlFormSelect()" .
          "should be array where keys are values ".
          "submitted, and values are display values");
    }
    else {
      // actual initialization
      $this->name = $name;
      $this->heading = $heading;
      $this->_valueArray = $value_array;
      $this->_selected_value = $selected_value;
    }
  }

  function toString () {
    $return_string = "";
    $return_string .=
      "<SELECT NAME=\"$this->name\">";
    while ($var_entry = 
             each($this->_valueArray)) {
      $submit_value = $var_entry['key'];
      $display_value = $var_entry['value'];
      if ($submit_value == $this->_selected_value) {
        $return_string .= 
          "<OPTION VALUE=${submit_value} SELECTED >"; 
      }
      else {
        $return_string .= "<OPTION VALUE=${submit_value}>"; 
      }
      $return_string .= $display_value;
    }
    $return_string .=
      "</SELECT>";
    return($return_string);
  }
}

class HtmlFormText extends HtmlFormInput
{
  var $initial_value;

  function __construct ($name, 
                         $heading,
                         $initial_value="")
  {
    // Initialization of member vars
    if (!isSet($name) || 
        !isSet($heading)) {
      die("HtmlFormText constructor needs " .
          "at least two arguments (name, heading)");
    }
    $this->name = $name; // name defined in parent
    $this->heading = $heading; // defined in parent
    $this->initial_value = $initial_value; 
  }

  function toString () {
    $return_string = "";
    $return_string .= "<INPUT TYPE=TEXT ";
    $return_string .= "NAME=\"$this->name\" "; 
    $return_string .= 
       "VALUE=\"$this->initial_value\" "; 
    $return_string .= " >";
    return($return_string);
  }
}

class HtmlFormTextArea extends HtmlFormInput {
  var $initial_value;
  var $rows;
  var $cols;
  var $wrapType;
  
  function __construct ($name, 
                             $heading,
                             // optional args:
                             $initial_value="",
                             $rows=1, $cols=60,
                             $wrapType="VIRTUAL")
  {
    // Initialization of member vars
    if (!isSet($name)) {
      die("HtmlFormTextArea constructor needs " .
          "at least two arguments (name, heading)");
    }
    $this->name = $name; // name defined in parent
    $this->heading = $heading; // name defined in parent
    $this->initial_value = $initial_value;
    $this->rows = $rows; 
    $this->cols = $cols;
    $this->wrapType = $wrapType;
  }

  function toString () 
  {
    $return_string = "";
    $return_string .= "<TEXTAREA ";
    $return_string .= "NAME=\"$this->name\" "; 
    $return_string .= "ROWS=$this->rows ";
    $return_string .= "COLS=$this->cols ";
    $return_string .= "WRAP=$this->wrapType ";
    $return_string .= $this->additionalAttributes();
    $return_string .= ">";
    $return_string .= $this->initial_value;
    $return_string .= "</TEXTAREA>";
    return($return_string);
  }

  function additionalAttributes () {
    // OVERRIDE THIS to return a string with 
    // TextArea attributes other than
    // NAME, ROWS, COLS, and WRAP
    return("");
  }
}
?>
