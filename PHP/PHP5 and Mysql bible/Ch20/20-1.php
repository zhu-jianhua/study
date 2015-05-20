class TextBoxSimple {
  var $body_text = "my text";
  function display() {
    print("<TABLE BORDER=1><TR><TD>$this->body_text");
    print("</TD></TR></TABLE>");
  }
}
