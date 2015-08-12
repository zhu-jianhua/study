class TextBoxHeader extends TextBox
{
  var $header_text;

  // CONSTRUCTOR
  function __construct($header_text_in, 
                   $body_text_in) {
    $this->header_text = $header_text_in;
    $this->body_text = $body_text_in;
  }

  // MAIN DISPLAY FUNCTION
  function display() {
    $header_html = 
      $this->make_header($this->header_text);
    $body_html = $this->make_body($this->body_text);
    print("<TABLE BORDER=1><TR><TD>\n");
    print("$header_html\n");
    print("</TD></TR><TR><TD>\n");
    print("$body_html\n");
    print("</TD></TR></TABLE>\n");
  } 

  // HELPER FUNCTIONS
  function make_header ($text) {
    return($text);
  }
  function make_body ($text) {
    return($text);
  }
}
