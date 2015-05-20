<?php
$doc = new DomDocument("1.0");
$root = $doc->createElement("HTML");
$root = $doc->appendChild($root);
$body = $doc->createElement("BODY");
$body = $root->appendChild($body);
$body->setAttribute("bgcolor", "#87CEEB");
$graff = $doc->createElement("P");
$graff = $body->appendChild($graff);
$text = $doc->createTextNode("This is some text.");
$text = $graff->appendChild($text);
$doc->save("test_dom.xml");
?>
