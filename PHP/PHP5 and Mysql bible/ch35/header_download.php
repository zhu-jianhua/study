<?php

/*******************************************
 * New product download attributes script. *
 * The purpose of this tool is to download *
 * a spreadsheet with the product data     *
 * header.  Editors will use this to add   *
 * new items to a category.  Use script    *
 * batch_upload_new.php to upload data.    *
 *******************************************/

include("oci8_funcs.php"); //common functions for Oracle tools
$thisDB = "dev";
$thisDBuser = "oci_user";
$thisDBpassword = "sesame";

// Open the pipe
$conn = OCILogon($thisDBuser, $thisDBpassword, $thisDB);

// -----------------------
// GET THE CATEGORY HEADER
// -----------------------
if ($_POST['submit'] == "Add") {
   // Call stored procedure for this category
   $cat_id_in = $_POST['cat_id'];
   $request = "begin DEV.get_cat_header($cat_id_in, :OUT1, :OUT2); end;";
   $cursor1 = OCINewCursor($conn);
   $cursor2 = OCINewCursor($conn);
   $stmt = OCIParse($conn, $request);
   OCIBindByName($stmt, ":OUT1", &$cursor1, -1, OCI_B_CURSOR);
   OCIBindByName($stmt, ":OUT2", &$cursor2, -1, OCI_B_CURSOR);
   OCIExecute($stmt);
   OCIExecute($cursor1);
   OCIExecute($cursor2);
   $err_array = OCIError($conn);
   if ($err_array) {
      $err_message = $err_array['message'];
      echo $err_message;
      OCIFreeCursor($cursor1);
      OCIFreeCursor($cursor2);
      OCIFreeStatement($stmt);
      OCILogoff($conn);
      exit;
   }
   while (OCIFetchInto($cursor1,&$data1)) {
      $p_array[] = $data1[1];
   }
   while (OCIFetchInto($cursor2,&$data2)) {
      $a_array[] = $data2[1]."|".$data2[0];
   }
   OCIFreeCursor($cursor1);
   OCIFreeCursor($cursor2);
   OCIFreeStatement($stmt);
   OCILogoff($conn);
   // ASSEMBLE THE DOWNLOAD
   $init_p_str = implode("\t", $p_array);
   $p_str = str_replace("CATEGORY_ID", $cat_id_in, $init_p_str);
   if (count($a_array) > 0) {
      $a_str = implode("\t", $a_array);
   }
   $full_header = implode("\t", array($p_str, $a_str));

   // SEND THE FILE
   $header_file = 'header.xls.Z';
   $zp = gzopen($header_file, "w+");
   gzwrite($zp, $full_header);
   gzclose($fp);
   header("Location:  header.xls.Z");
   // For IE5.x, this is the correct way to trigger a file download
   // -- by simply directing the browser to download a file type
   // that the browser cannot open
}


// -----------------
// CHOOSE A CATEGORY
// -----------------
elseif (!isSet($_POST['submit'])) {
   // Call stored procedure get_categories
   $request = "begin DEV.get_categories(:OUT1); end;";
   $cursor1 = OCINewCursor($conn);
   $stmt = OCIParse($conn, $request);
   OCIBindByName($stmt, ":OUT1", &$cursor1, -1, OCI_B_CURSOR);
   OCIExecute($stmt);
   OCIExecute($cursor1);
   $err_array = OCIError($conn);
   if ($err_array) {
      $err_message = $err_array['message'];
      echo $err_message;
      OCIFreeCursor($cursor1);
      OCIFreeStatement($stmt);
      OCILogoff($conn);
      exit;
   }
   while (OCIFetchInto($cursor1, &$cat_array)) {
      $opt_str .= "<OPTION VALUE=\"".$cat_array[0]."\">".$cat_array[1]."</OPTION>\n";
   }
   OCIFreeCursor($cursor1);
   OCIFreeStatement($stmt);
   OCILogoff($conn);


   // CHOOSE CATEGORY FORM
   $php_self = $_SERVER['PHP_SELF']; // Superglobals don't work with heredoc
   $form_str = <<< EOFORMSTR
<HTML>
<HEAD>
<TITLE>Batch Editor New: Download</TITLE>
<STYLE>
<!--
.header    {font-family: verdana, arial, sans-serif; font-size: 14pt; font-weight: bold; color: #000000; text-align: left}
.subheader    {font-family: verdana, arial, sans-serif; font-size: 12pt; font-weight: bold; color: #000000; background: #ebeef1; text-align: left}
.ftrnote    {font-family: verdana, arial, sans-serif; font-size: 8pt; color: #000000; text-align: left}
LI     {line-height:200%}
-->
</STYLE>
</HEAD>

<BODY BGCOLOR="#FFFFFF">
<P class="header">Batch editor new:  download</P>

<P>The database is <B>$thisDB</B></P>

<FORM ACTION="$php_self" METHOD="POST">
<SELECT NAME="cat_id" SIZE=1>
<OPTION VALUE="-1" SELECTED>Choose one</OPTION>
$opt_str
</SELECT><BR>
<INPUT TYPE=SUBMIT NAME="submit" VALUE="Add">
</FORM>
</BODY>
</HTML>
EOFORMSTR;

   echo $form_str;
}
?>