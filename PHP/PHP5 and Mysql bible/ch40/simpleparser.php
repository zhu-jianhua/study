<?php
$file = "recipe.xml";

// Call this at the beginning of every element
function startElement($parser, $name, $attrs) {
    print "<B>$name =></B>  ";
}

// Call this at the end of every element
function endElement($parser, $name) {
    print "\n";
}

// Call this whenever there is character data
function characterData($parser, $value) {
    print "$value<BR>";
}

// Define the parser
$simpleparser = xml_parser_create();
xml_set_element_handler($simpleparser, "startElement", "endElement");
xml_set_character_data_handler($simpleparser, "characterData");

// Open the XML file for reading
if (!($fp = fopen($file, "r"))) {
  die("could not open XML input");
}

// Parse it
while ($data = fread($fp, filesize($file))) {
if (!xml_parse($simpleparser, $data, feof($fp))) {
  die(xml_error_string(xml_get_error_code($simpleparser)));
  }
}

// Free memory
xml_parser_free($simpleparser);
?> 
