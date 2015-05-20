class TextBoxBoldHeader extends TextBoxHeader {

  // CONSTRUCTOR
  function __construct($header_text_in, 
                   $body_text_in) {
    $this->header_text = $header_text_in;
    $this->body_text = $body_text_in;
  }

  // HELPER FUNCTIONS
  // make_header overrides parent
  function make_header ($text) {
    return("<B>$text</B>");
  }
}
