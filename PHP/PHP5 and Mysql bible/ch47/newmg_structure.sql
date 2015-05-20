# Listing 47-1: Database definition file (newmg_structure.sql) -->
# MySQL dump file
# MysteryGuide SQL structure only

#
# Table structure for table 'author'
#
CREATE TABLE author (
  A_id int(11) DEFAULT '0' NOT NULL auto_increment,
  A_firstname tinytext,
  A_lastname tinytext, 
  A_gender tinyint(4),
  A_nationality tinytext,
  A_interview tinytext,
  PRIMARY KEY (A_id)
);

#
# Table structure for table 'book'
#
CREATE TABLE book (
  B_id int(11) DEFAULT '0' NOT NULL auto_increment,
  B_title tinytext,
  B_year year(4),
  B_rating tinyint(4),
  B_action tinyint(4),
  B_humor tinyint(4),
  B_romance tinyint(4),
  B_sex tinyint(4),
  B_violence tinyint(4),
  B_reviewer tinytext,
  B_pages smallint(6),
  B_reviewdate date,
  B_ISBN tinytext,
  B_movie text,
  B_awards text,
  B_review text,
  B_blurb text,
  PRIMARY KEY (B_id)
);

#
# Table structure for table 'book_author'
#
CREATE TABLE book_author (
  BA_id int(11) DEFAULT '0' NOT NULL auto_increment,
  B_id int(11), 
  A_id int(11),
  PRIMARY KEY (BA_id)
);

#
# Table structure for table 'subgenre'
#
CREATE TABLE subgenre (
  Sub_id int(11) DEFAULT '0' NOT NULL auto_increment,
  Sub_name tinytext,
  PRIMARY KEY (Sub_id)
);
#
# Table structure for table 'book_subgenre'
#
CREATE TABLE book_subgenre (
  BSub_id int(11) DEFAULT '0' NOT NULL auto_increment,
  B_id int(11),
  Sub_id int(11),
  PRIMARY KEY (BSub_id)
); 


