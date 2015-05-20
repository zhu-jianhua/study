<?php

// Get the xml
$writefile = 'phpbible.xml';
$file = "http://xml.amazon.com/onca/xml3?t=webservices-20&dev-t=D21CQ8KJ84BZLA&KeywordSearch=Park+Converse+PHP+Bible&mode=books&type=lite&page=1&f=xml";
// Replace X's with your Amazon Developer's Token
// If you don't have a valid token, comment out the block below and use the fake data file
// Write the xml to a file
$fp = fopen($file, "r");
$xml_array = file($file);
fclose($fp);
$xml_str = implode("", $xml_array);
$fp2 = fopen($writefile, "w");
$fw_return = fwrite($fp2, $xml_str);
fclose($fp2);


// Load up the xml file into memory
$dom = new DomDocument;
if (!$dom->load($writefile)) {
  echo "Cannot load XML file";
  exit;
}

// Get an immediately available edition
$editions = $dom->getElementsByTagname("Availability");
foreach ($editions as $edition_obj) {
  if ($edition_obj->nodeValue == 'Usually ships within 24 hours') {
    // Get the data for this book
    $book_array = array();
    $parent_node = $edition_obj->parentNode;
    $book_array['Details'] = $parent_node->getAttribute("url");
    $children = $parent_node->childNodes;
    foreach($children as $child_obj) {
      $node_name = $child_obj->nodeName;
      if ($node_name != "#text") {
        $content_str = $child_obj->nodeValue;
	$book_array["$node_name"] = $content_str;
      }
    }
    continue;
  } else {
    // Give a message if availability isn't good
  }
}

//print_r($book_array);
$title = $book_array['ProductName'];
$author = $book_array['Authors'];
$image = $book_array['ImageUrlSmall'];
$detail_page = $book_array['Details'];
$price = $book_array['OurPrice'];


// Format a nice box
$box_str = <<< EONICEBOX
<HTML>
<HEAD>
<STYLE>
#content {
	float: left;
	padding: 10px;
	margin: 10px;
	background: #FFFFFF;
	border: 4px solid #008000;
	width: 200px; /* ie5win fudge begins */
	voice-family: "\"}\"";
	voice-family:inherit;
	width: 200px;
	}
html>body #content {
	width: 170px; /* ie5win fudge ends */
	}
p {
        font-family: Verdana, Arial, sans-serif;
	font-size: 12px;
	line-height: 22px;
	margin-top: 3px;
	margin-bottom: 2px; 
	}

</STYLE>
</HEAD>
<BODY>
<div id="content">
<P><IMG SRC="$image">
<BR><A HREF="$detail_page">$title</A>
<BR>$author
<BR>$price</P>
</BODY>
</HTML>
EONICEBOX;
echo $box_str;
?>