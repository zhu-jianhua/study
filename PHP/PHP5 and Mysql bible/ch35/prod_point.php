<?php

/*****************************************************
 * This is the product point editor.                 *
 * The purpose of this tool is to edit all the data  *
 * associated with a single product.  It will mostly *
 * be used for trivial fixes (e.g., spelling errors) *
 *****************************************************/

include("oci8_funcs.php"); //common functions for Oracle-based tools
$thisDB = "dev";
$thisDBuser = "oci_user";
$thisDBpassword = "sesame";

// -----------------
// EDIT PRODUCT DATA
// -----------------
if($_POST['submit'] == "Submit") {
   // Get a timestamp
   $begin_time = time();
   // Open the pipe
   $conn = OCILogon($thisDBuser, $thisDBpassword, $thisDB) or die("Can't get a database connection.");

   // UPDATE PRODUCT TABLE
   $product_id = $_POST['product_id'];
   $product_name = escape_sq($_POST['product_name']);
   $sku = escape_sq($_POST['sku']);
   $itemurl = escape_sq($_POST['itemurl']);
   $itemimage = escape_sq($_POST['itemimage']);
   $desc_text = escape_sq($_POST['desc_text']);

   $query = "UPDATE product 
             SET product_name = '$product_name',
                 sku = '$sku',
                 itemurl = '$itemurl',
                 itemimage = '$itemimage',
                 desc_text = '$desc_text',
                 modified = SYSDATE
             WHERE product_id = $product_id";
   $stmt = parse_exec_free($conn, $query, &$error_str);
   if (!$stmt) {
      die_silently($conn, $error_str);
   }

   // UPDATE PRODUCT_ATTRIB_VAL TABLE
   // First blow away all existing rows for this product
   $query = "DELETE FROM product_attrib_val
             WHERE product_id = $product_id";
   $stmt = parse_exec_free($conn, $query, &$error_str);
   if (!$stmt) {
      die_silently($conn, $error_str);
   }
   if (is_array($_POST['attrib']) && count($_POST['attrib']) > 0) {
      foreach ($_POST['attrib'] as $attrib_id=>$av_id_array) {
         if (is_array($av_id_array) && count($av_id_array) > 0) {
            foreach ($av_id_array as $attrib_val_id) {
	              // If attrib value is not Delete All, add new rows
               if ($attrib_val_id != -1) {
                  $query = "INSERT INTO product_attrib_val (attrib_val_id, product_id, modified, created)
                            VALUES($attrib_val_id, $product_id, SYSDATE, SYSDATE)";
                  $stmt = parse_exec_free($conn, $query, &$error_str);
		                if (!$stmt) {
                     die_silently($conn, $error_str);
		                }
	              }
	           }
         }
      }
   }

   OCICommit($conn);
   OCILogoff($conn);
   
   /*
   // Uncomment this block for debugging
   // Get a second timestamp, and do the math
   $end_time = time();
   echo "DONE!  This operation took ".($end_time - $begin_time) ." seconds to complete.";
   exit;
   */

   // Redisplay the form
   header("Location:  $PHP_SELF?url=$prod_url");
}


// ---------
// SHOW FORM
// ---------
elseif (!isSet($_POST['submit']) || $_POST['submit'] != "Submit") {
   set_time_limit(0);
   // Get a timestamp
   $begin_time = time();
   // Open the pipe
   $conn = OCILogon($thisDBuser, $thisDBpassword, $thisDB) or die("Can't get a database connection.");

   // Get the product data based on a unique URL passed in the GET vars
   $url = $_GET['url'];
   if ($url == "") {
      // If a URL isn't passed, spit out a message and quit
      echo "<HTML>\n<BODY>";
      echo '<P>You need to designate a product to edit by passing a url like this:  http://localhost/tools/prod_point.php?url=book_PHP4_Bible.</P>';
      echo "</BODY>\n</HTML>";
      exit;
   }
   $query = "SELECT product_id, name, sku, itemurl, itemimage, desc_text, category_id
             FROM product
             WHERE url = '$url'";
   $stmt = parse_exec_fetch($conn, $query, &$error_str, &$res);
   if (!$stmt) {
      die_silently($conn, $error_str);
   } else {
      OCIFreeStatement($stmt);
      $product_id = $res['PRODUCT_ID'][0];
      $product_name = $res['PRODUCT_NAME'][0];
      $sku = $res['SKU'][0];
      $itemurl = $res['ITEMURL'][0];
      $itemimage = $res['ITEMIMAGE'][0];
      $desc_text = $res['DESC_TEXT'][0];
      $category_id = $res['CATEGORY_ID'][0];
   }


   // Get attributes for all products in this category
   $query = "SELECT attribute_id, attribute_name
             FROM attribute
             WHERE category_id = $category_id";
   $stmt = parse_exec_fetch($conn, $query, &$error_str, &$res1);
   if (!$stmt) {
      die_silently($conn, $error_str);
      exit;
   } else {
      OCIFreeStatement($stmt);
   }
   if (is_array($res1['ATTRIBUTE_ID']) && count($res1['ATTRIBUTE_ID']) > 0) {
      foreach ($res1['ATTRIBUTE_ID'] as $key=>$attrib_id) {
	        $attrib_name = $res1['ATTRIBUTE_NAME'][$key];
	        // Get attrib values for this product
	        $query = "SELECT product_attrib_val.attrib_val_id
                   FROM product_attrib_val, attrib_val
                   WHERE product_attrib_val.attrib_val_id = attrib_val.attrib_val_id
                   AND attrib_val.attrib_id = $attrib_id
                   AND product_attrib_val.product_id = $product_id";
	        $stmt = parse_exec_fetch($conn, $query, &$error_str, &$res2);
	        if (!$stmt) {
            die_silently($conn, $error_str);
	        } else {
	           OCIFreeStatement($stmt);
	           // Get all possible attribute values for this attribute
	           // and construct nice pulldown lists
	           $query = "SELECT attrib_val_id, name
                      FROM attrib_val
                      WHERE attrib_id = $attrib_id
                      ORDER BY name";
	           $stmt = parse_exec_fetch($conn, $query, &$error_str, &$res3);
	           if (!$stmt) {
               die_silently($conn, $error_str);
	           } else {
	              OCIFreeStatement($stmt);
	              // This stuff is for Case 2 below
	              $is_vals = $res2['ATTRIB_VAL_ID'];
	              $num_is_vals = count($is_vals);
	              $poss_vals = $res3['ATTRIB_VAL_ID'];
	              $num_poss_vals = count($poss_vals);
	              $nonmatching = array_diff($poss_vals, $is_vals);

	              if ($num_poss_vals > 0) {
		                foreach ($poss_vals as $av_key=>$avalue_id) {
		                   $av_name = $res3['NAME'][$av_key];
		                   // Existing values are selected in this list.
		                   // Case 0:  if no existing value than don't highlight any
		                   if (!is_array($is_vals) || $num_is_vals == 0) {
			                     $av_str .= "<OPTION VALUE=\"$avalue_id\">$av_name</OPTION>\n";
		                   }
		                   // Case 1:  single attrib value
		                   elseif ($num_is_vals == 1) {
		                      if ($is_vals[0] == $avalue_id) {
			                        $av_str .= "<OPTION VALUE=\"$avalue_id\" SELECTED>$av_name</OPTION>\n";
			                     } else {
			                        $av_str .= "<OPTION VALUE=\"$avalue_id\">$av_name</OPTION>\n";
		                      }
		                   }
		                   // Case 2:  multiple attrib values
		                   // A bit messy because I have to avoid multiple
		                   // nonmatching options.
		                   elseif ($num_is_vals > 1) {
		              	     foreach ($is_vals as $avid) {
			                       if ($avid == $avalue_id) {
			                          $av_array[] = "<OPTION VALUE=\"$avalue_id\" SELECTED>$av_name</OPTION>";
			                       }
			                    }
			                    if (count($nonmatching) > 0) {
			                       foreach ($nonmatching as $avid){
			                          if ($avid == $avalue_id) {
				                            $av_array[] = "<OPTION VALUE=\"$avalue_id\">$av_name</OPTION>";
			                          }
			                       }
			                    }
		                     $av_str = implode("\n", $av_array);
		                  }
		               }
	             }
           }
	          $attrib_str .= "$attrib_name ($num_is_vals):  <SELECT NAME=\"attrib[$attrib_id][]\" SIZE=5 MULTIPLE>\n<OPTION VALUE='-1'>Delete All</OPTION>\n$av_str</SELECT><BR><BR>\n";
	          unset($av_array);
	          unset($av_str);
	        }
      }
   }
   OCILogoff($conn);


   // ------------
   // DISPLAY FORM
   // ------------
   $php_self = $_SERVER['PHP_SELF']; // Superglobals don't work with heredoc
$form_str = <<< EOFORMSTR
<HTML>
<HEAD>
<TITLE>Product Point Editor</TITLE>
<STYLE>
<!--
.header    {font-family: verdana, arial, sans-serif; font-size: 14pt; font-weight: bold; color: #000000; text-align: left}
.subheader    {font-family: verdana, arial, sans-serif; font-size: 12pt; font-weight: bold; color: #000000; background: #ebeef1; text-align: left}
-->
</STYLE>
</HEAD>

<BODY BGCOLOR="#FFFFFF">
<P class="header">Product point editor</P>

<P>The database is <B>$thisDB</B></P>

<P><B>PRODUCT DATA</B></P>
<FORM ACTION="$php_self" METHOD="post">
<INPUT TYPE=HIDDEN NAME="product_id" VALUE="$product_id">
Name:  <INPUT TYPE=TEXT NAME="product_name" SIZE=30 VALUE="$product_name"><BR><BR>
SKU #:  <INPUT TYPE=TEXT NAME="sku" SIZE=70 VALUE="$sku"><BR><BR>
Item URL:  <INPUT TYPE=TEXT NAME="itemurl" SIZE=70 VALUE="$itemurl"><BR><BR>
Item Image:  <INPUT TYPE=TEXT NAME="itemimage" SIZE=70 VALUE="$itemimage"><BR><BR>
Description:  <TEXTAREA NAME="desc_text" COLS=50 ROWS=5>$desc_text</TEXTAREA><BR><BR>

<P><B>ATTRIBUTES</B></P>
$attrib_str
<INPUT TYPE=SUBMIT NAME="submit" VALUE="Submit">
</FORM>
</BODY>
</HTML>
EOFORMSTR;
   echo $form_str;

   // Get a second timestamp, and do the math
   $end_time = time();
   echo "DONE!  This operation took ".($end_time - $begin_time) ." seconds to complete.<BR>\n";
}

?>