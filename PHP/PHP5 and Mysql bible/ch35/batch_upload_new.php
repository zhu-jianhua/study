<?php

/******************************************
 * New product batch upload script. The   *
 * purpose of this tool is to upload a    *
 * spreadsheet with new product data.     *
 * Editors will use this to add new items *
 * to a category.  Use script             *
 * header_download.php to get attributes. *
 ******************************************/

include("oci8_funcs.php"); //common functions for Oracle tools
$thisDB = "dev";
$thisDBuser = "oci_user";
$thisDBpassword = "sesame";


// HEADER
$header_str = <<< ENDOFHEADER
<HTML>
<HEAD>
<TITLE>Batch Editor New: Upload</TITLE>
<STYLE>
<!--
.header    {font-family: verdana, arial, sans-serif; font-size: 14pt; font-weight: bold; color: #000000; text-align: left}
.subheader    {font-family: verdana, arial, sans-serif; font-size: 12pt; font-weight: bold; color: #000000; background: #ebeef1; text-align: left}
-->
</STYLE>
</HEAD>

<BODY BGCOLOR="#FFFFFF">
<P class="header">Batch editor new: upload</P>

<P>The database is <B>$thisDB</B></P>
ENDOFHEADER;
echo $header_str;


// ADD NEW PRODUCTS
if($_POST['submit'] == "Upload") {
   set_time_limit(0);
   echo "<P>Check the error log (<A HREF\"upload_log.html\">upload_log.html</A>) for problems.</P>";

   // Copy uploaded file to a specific directory
   $tempfile = $HTTP_POST_FILES[file][tmp_name];
   $localfile = $HTTP_POST_FILES[file][name];
   if(!copy($tempfile, "/tmp/$localfile")) {
      echo "<P>Error writing file to upload directory.  Quitting.</P>\n";
      exit;
   }

   // Start an error log
   $error_log = 'upload_log.html';
   $fp = fopen($error_log, "w+") or die("Can't open error log.");
   fwrite($fp, "<HTML>\n");

   // Open the pipe
   $conn = OCILogon($thisDBuser, $thisDBpassword, $thisDB) or die("Can't get a database connection.  Whine at a webdev.");

   // Get a timestamp
   $begin_time = time();

   // Read in the data file as an array
   $uarray = file("/tmp/$localfile");

   // Parse the header for cat_id and attributes
   $header = array_shift($uarray);
   $harray = explode("\t", $header);
   $num_ha = count($harray);
   $cat_id = $harray[0];
   $attrib_array = array();
   for($i = 6; $i <= ($num_ha - 1); $i++) {
      $a_array = explode("|", $harray[$i]);
      $attrib_array[] = $a_array[1];
   }
   $num_attribs = count($attrib_array);

   $error_str = "";
   $res = array();
   // Get all the attrib values and stick them in a multidimensional array
   foreach($attrib_array as $attrib) {
      $query = "SELECT attrib_value_id, name
                FROM attrib_value
                WHERE attrib_id = $attrib";
      $stmt = parse_exec_fetch($conn, $query, &$error_str, &$res);
      if (!$stmt) {
         choke_and_die($conn, $fp, $error_str);
      } else {
	 foreach($res['NAME'] as $key => $val) {
	    $ava[$attrib][$val] = $res['ATTRIB_VALUE_ID'][$key];
	 }
         OCIFreeStatement($stmt);
      }
   }
   reset($attrib_array);

   // Shove the data down the pipe.
   foreach ($uarray as $valrow) {
      // Get a fresh product id from Oracle
      $query = "begin :new_id := newid('product'); end;";
      $sth = OCIParse($conn, $query);
      OCIBindByName($sth, ":new_id", &$new_id, 200);
      OCIExecute($sth);
      if (!$sth) {
         choke_and_die($conn, $fp, $error_str);
      } else {
	        $rowid = $new_id;
         OCIFreeStatement($sth);
      }

      // Format new product data.
      $val_array = explode("\t", $valrow);
      $prod_name = unquote($val_array[1]);
      $prod_name = strip_db($prod_name);
      $prod_name = escape_sq($prod_name);
echo "Working on $prod_name<BR>\n";
      $sku = unquote($val_array[2]);
      $itemurl = unquote($val_array[3]);
      $itemimage = unquote($val_array[4]);
      $desc = unquote($val_array[5]);
      $desc = escape_sq($desc);

      // PRODUCT
      $query = "INSERT INTO product (product_id, name, sku, itemurl, itemimage, desc, created, modified, category_id) VALUES ($rowid, '$prod_name', '$sku', '$itemurl', '$itemimage', '$desc', SYSDATE, SYSDATE, $cat_id)";
      $stmt = parse_exec_free($conn, $query, &$error_str);
      if (!$stmt) {
         choke_and_die($conn, $fp, $error_str);
      }

      // PRODUCT_ATTRIB_VALUE
      for ($i = 6; $i <= (6 + $num_attribs - 1); $i++) {
         $av = unquote($val_array[$i]);
         if($av != "") {
            $temp_q = explode("|", $av);
            foreach($temp_q as $av) {
               $av = unasterisk($av);
               $av = escape_sq($av);
	              $akey = $i - 6;
	              $attrib_id = $attrib_array[$akey];
	              if($ava[$attrib_id][$av]) {
		                $pav = $ava[$attrib_id][$av];
		                $query = "INSERT INTO product_attrib_value (attrib_value_id, product_id, created, modified) VALUES($pav, $rowid, SYSDATE, SYSDATE)";
		                $stmt = parse_exec_free($conn, $query, &$error_str);
		                if (!$stmt) {
                     choke_and_die($conn, $fp, $error_str);
		                }
	              }
            }
         } else {
            //echo "Null attrib value.<BR>\n";
         }
      }
   }

   // Get a second timestamp, and do the math
   $end_time = time();
   echo "DONE!  This operation took ".($end_time - $begin_time) ." seconds to complete.";

   OCICommit($conn);
   OCILogoff($conn);
   fwrite($fp, "</HTML>\n");
   fclose($fp);
}



// SHOW FILE UPLOAD FORM
elseif($_POST['submit'] != "Upload") {
   $upload_str = <<< ENDOFUPLOAD
<P>Upload new product data:</P>
<FORM ACTION="$PHP_SELF" METHOD="post" ENCTYPE="multipart/form-data">
<INPUT TYPE=HIDDEN NAME="max_file_size" VALUE="1000000">
<INPUT TYPE=FILE NAME="file" SIZE=50><BR><BR>
<INPUT TYPE=SUBMIT NAME="submit" VALUE="Upload">
</FORM>
ENDOFUPLOAD;
   echo $upload_str;
}

?>
</BODY>
</HTML>