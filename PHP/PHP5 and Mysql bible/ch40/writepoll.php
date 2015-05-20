<html>
<head>
<title>Write an XML file</title>
</head>

<body>
<?php

$pollfile = "poll.xml";

echo $_POST['Raw_Poll_Option'][1];


// Reading in the xml file as a string
$fd = fopen($pollfile, "r") or die("Can't open file.");
$fstr = fread($fd, filesize($pollfile)) or die("Can't read file, check permissions.");
fclose($fd); 

// Format response sets.
$PollName = str_replace("\'", "", $_POST["PollName"]);
$PollName = str_replace(" ", "_", $_POST["PollName"]);

$RespSet = "";

for ($r=0; $r<=5; $r++) {
    $currentRawPollOption = $_POST["Raw_Poll_Option"][$r];
  if (!empty($_POST["Raw_Poll_Option"][$r])) {
      $Poll_Option[$r] = "$_POST[PollName]-".str_replace("'", "", $currentRawPollOption);
    $Poll_Option[$r] = "$_POST[PollName]-".str_replace(" ", "_", $currentRawPollOption);
    $currentPollOption = $Poll_Option[$r];

    $RespSet .= "\t<response id=\"$currentPollOption\">$currentRawPollOption</response>\n";
  }
    

}

//Add new poll data
$separator = "</PollList>";
$divide = explode($separator, $fstr);
$glue = 
"\t<Poll name=\"$_POST[PollName]\"/>
</PollList>

<Poll id=\"$_POST[PollName]\">
\t<StartDate>$_POST[Poll_Startdate]</StartDate>
\t<EndDate>$_POST[Poll_Enddate]</EndDate>
\t<name>$_POST[PollName]</name>
\t<text>$_POST[Poll_Question]</text>
\t<display type=\"Bar-Graph\"/>
\t<responseSet resource=\"$PollName-responseSet\"/>
</Poll>

<responseSet id=\"$PollName-responseSet\">
$RespSet</responseSet>
";


$newxml = implode($glue, $divide);

//Write to file
$fd = fopen($pollfile, "w") or die("Can't open file for writing; check file permissions");
$writestr = fwrite($fd, $newxml);

//Message
echo "Wrote $writestr chars to $pollfile.";
?>

</body>
</html>
