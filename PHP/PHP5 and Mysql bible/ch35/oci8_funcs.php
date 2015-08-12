<?php

/************************************
 * Functions for Oracle-based tools *
 ************************************/

putenv("ORACLE_HOME=/tools/oracle");


// Use when fetching data from the db
function unescape_quotes($str
{
   $esc_str = str_replace("''", "'", $str);
   $esc2_str = str_replace("\"\"", "\"", $esc_str);
   return $esc2_str;
}


// Use when inserting data into the db
function escape_sq($str)
{
   $esc_str = str_replace("'", "''", $str);
   return $esc_str;
}


function escape_html($str)
{
   $gt_str = str_replace("&gt;", ">;", $str);
   $lt_str = str_replace("&lt;", "<", $gt_str);
   $dq_str = str_replace("&quot;", "\"", $lt_str);
   $esc_str = str_replace("&amp;", "&", $dq_str);
   return $esc_str;
}


// Use this one for INSERTs, UPDATEs, and DELETEs
function parse_exec_free($conn, $query, &$error_str)
{
   $stmt = OCIParse($conn, $query);
   OCIExecute($stmt, OCI_DEFAULT);
   $err_array = OCIError($stmt);
   if ($err_array) {
      $err_message = $err_array['message'];
      $$error_str = $err_message;
      OCIFreeStatement($stmt);
      $stmt = FALSE;
   } else {
       OCIFreeStatement($stmt);
      $stmt = TRUE;
   }
   return $stmt;
}


// Use this one for SELECTs
function parse_exec_fetch($conn, $query, &$error_str, &$res, $nulls=0)
{
   $stmt = OCIParse($conn, $query);
   OCIExecute($stmt, OCI_DEFAULT);
   $err_array = OCIError($stmt);
   if ($err_array) {
      $err_message = $err_array['message'];
      $$error_str = $err_message;
      OCIFreeStatement($stmt);
      $stmt = FALSE;
   } else {
      if ($nulls == 1) {
         OCIFetchStatement($stmt, $res, OCI_RETURN_NULLS);
      } else {
         OCIFetchStatement($stmt, $res);
      }
   }
   return $stmt;
}


// For batch_upload.php, which writes a separate error log
function choke_and_die($conn, $fp, $error_str)
{
   OCIRollback($conn);
   OCILogoff($conn);
   $error_line = $error_str."<BR>\n";
   echo $error_line;
   fwrite($fp, $error_line);
   fwrite($fp, "</HTML>\n");
   fclose($fp);
   exit;
}


// For all non-logwriting uses (which is most of them)
function die_silently($conn, $error_str)
{
   OCIRollback($conn);
   OCILogoff($conn);
   // You can uncomment these when debugging
   //$error_line = $error_str."<BR>\n";
   //echo $error_line;
   exit;
}


// Excel sometimes adds random quotes around field contents
function unquote($str)
{
   $pos = strpos($str, "\"");
   if ($pos === 0) {
      $qstr = substr($str, 1, -1);
      return trim($qstr);
   } else {
      return trim($str);
   }
}


// Excel sometimes doubles double-quotes in an attempt to close them
function strip_db($str)
{
   $esc_str = str_replace("\"\"", "\"", $str);
   return $esc_str;
}

?>