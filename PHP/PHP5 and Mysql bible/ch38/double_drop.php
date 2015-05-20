<!-- Listing 38-4: A two-dimensional dynamic dropdown (double_drop.html) -->
<HTML>
<HEAD>
<META NAME="save" CONTENT="history">
<STYLE>
  .saveHistory {behavior:url(#default#savehistory);}
</STYLE>

<SCRIPT LANGUAGE="JavaScript">
<!--
v=false;
//-->
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript1.1">
<!--
if (typeof(Option)+"" != "undefined") v=true;
//-->
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript">
<!--
// Universal Related Select Menus - cascading popdown menus
// by Andrew King. v1.34 19990720
// Copyright (c) 1999 internet.com LLC. All Rights Reserved.
// Modified by Joyce Park 20000703
//
// This program is free software; you can redistribute it
// and/or modify it under the terms of the GNU General Public
// License as published by the Free Software Foundation; either
// version 2 of the License, or (at your option) any later
// version.
//
// This program is distributed in the hope that it will be
// useful, but WITHOUT ANY WARRANTY; without even the implied
// warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
// PURPOSE.  See the GNU General Public License for more
// details. 
//
// You should have received a copy of the GNU General Public
// License along with this program; if not, write to the Free
// Software Foundation, Inc., 59 Temple Place, Suite 330,
// Boston, MA  02111-1307  USA
//
// Originally published and documented at www.webreference.com
// see www.webreference.com/dev/menus/intro2.html for changelog

if(v){a=new Array(22);}

function getFormNum (formName) {
  var formNum =-1;
  for (i=0;i<document.forms.length;i++){
    tempForm = document.forms[i];
    if (formName == tempForm) {
      formNum = i;
      break;
    }
  }
  return formNum;
}

function jmp(form, elt) {
// The first parameter is a reference to the form.
  if (form != null) {
    with (form.elements[elt]) {
      if (0 <= selectedIndex)
        location = options[selectedIndex].value;
    }
  }
}

var catsIndex = -1;
var itemsIndex;

if (v) { // ns 2 fix
function newCat(){
  catsIndex++;
  a[catsIndex] = new Array();
  itemsIndex = 0;
}

// Andrew chose to name this function "O", presumably standing
// for "Option".  It's not a zero, here or in the array below!
function O(txt,url) {
  a[catsIndex][itemsIndex]=new myOptions(txt,url);
  itemsIndex++;
}

function myOptions(text,value){
  this.text = text;
  this.value = value;
}

// fill array
<?php
mysql_connect("localhost", "db_user");
mysql_select_db("auto_db");
// Get the makes
$i = 0;
$make_query = "SELECT DISTINCT make FROM cars";
$make_result = mysql_query($make_query);
while ($make_row = mysql_fetch_array($make_result)) {

  $make[$i] = $make_row[0];
  // Now fill the array with models for each make
  echo "newCat();\n";
  $model_query = "SELECT model FROM cars WHERE make = '$make[$i]' ORDER BY model";
  $model_result = mysql_query($model_query);
  while(list($model) = mysql_fetch_array($model_result)) {
    echo "O(\"$model\", \"/$model.php\")\n";
  }
  echo "\n";
  $i++;
}
?>
} // close if (v)

function relate(formName,elementNum,j) {
if(v){
var formNum = getFormNum(formName);
  if (formNum>=0) {
    formNum++; // reference next form, assume it follows in HTML
    with (document.forms[formNum].elements[elementNum]) {
      for(i=options.length-1;i>0;i--) options[i] = null; // null out in reverse order (bug workarnd)
      for(i=0;i<a[j].length;i++){
        options[i] = new Option(a[j][i].text,a[j][i].value); 
      }
      options[0].selected = true;
    }
  }
} else {
  jmp(formName,elementNum);
}
}

// BACK BUTTON FIX for ie4+- or
// MEMORY-CACHE-STORING-ONLY-INDEX-AND-NOT-CONTENT
// see www.webreference.com for full comments
function IEsetup(){
  if(!document.all) return;
  IE5 = navigator.appVersion.indexOf("5.")!=-1;
  if(!IE5) {
    for (i=0;i<document.forms.length;i++) {
      document.forms[i].reset();
    }
  }
}

window.onload = IEsetup;
//-->
</SCRIPT>
</HEAD>
<BODY BGCOLOR="#ffffff">

<CENTER>
<TABLE BGCOLOR="#DDCCFF" BORDER="0" CELLPADDING="8" CELLSPACING="0">
<TR VALIGN="TOP">
<TD>Choose a make:<BR>
<FORM NAME="f1" METHOD="POST" ACTION="redirect.php" onSubmit="return false;">
<SELECT NAME="m1" ID="m1" CLASS=saveHistory onChange="relate(this.form,0,this.selectedIndex)">
<?php
while (list($key, $val) = each($make)) {
  echo "<OPTION VALUE=\"/$val.php\">$val</OPTION>\n";
}
?>
</SELECT>
<INPUT TYPE=SUBMIT VALUE="Go" onClick="jmp(this.form,0);">
</FORM>
</TD>

<TD BGCOLOR="#FFFFFF" VALIGN=MIDDLE><B>---&gt;</B></TD>

<TD>Choose a model:<BR>
<FORM NAME="f2" METHOD="POST" ACTION="redirect.php" onSubmit="return false;"> 
<SELECT NAME="m2" ID="m2" CLASS=saveHistory onChange="jmp(this.form,0)">
// These are placeholder values for the first time the page is
// loaded.  They will not change when the form values change.
// If you delete them, the forms will still work, but the
// second select menu would come up empty until changed.
// These values could be generated dynamically, but we wanted
// to show them in place.
<OPTION VALUE="/A4.php">A4</OPTION>
<OPTION VALUE="/A6.php">A6</OPTION>
<OPTION VALUE="/A8.php">A8</OPTION>
<OPTION VALUE="/Quattro">Quattro</OPTION>
</SELECT>
<INPUT TYPE=SUBMIT VALUE="Go" onClick="jmp(this.form,0);">
<INPUT TYPE="hidden" NAME="baseurl" VALUE="http://localhost">
</FORM>
</TD>
</TR>
</TABLE></CENTER>

</BODY>
</HTML>
