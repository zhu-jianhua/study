# MySQL dump 7.1
#
# Host: [host deleted]    Database: certainty
#--------------------------------------------------------
# Server version	3.22.32

#
# Table structure for table 'high_scores'
#
CREATE TABLE high_scores (
  id int(11) DEFAULT '0' NOT NULL auto_increment,
  name varchar(30),
  answer_count int(11),
  credit double(16,4),
  PRIMARY KEY (id)
);

#
# Dumping data for table 'high_scores'
#

INSERT INTO high_scores VALUES (8,'Ben Stein',15,-3.0000);

#
# Table structure for table 'question'
#
CREATE TABLE question (
  ID int(11) DEFAULT '0' NOT NULL auto_increment,
  answer double(16,4),
  unitID int(11),
  level int(11),
  subjectID int(11),
  include tinyint(4),
  upper_limit double(16,4),
  lower_limit double(16,4),
  scaling_type tinyint(4),
  question varchar(255),
  attribution varchar(255),
  PRIMARY KEY (ID)
);

#
# Dumping data for table 'question'
#

INSERT INTO question VALUES (1,5283755345.0000,1,1,1,1,200000000000.0000,1000000.0000,2,
'What was the human population of the world in the middle of 1990?', 'http://www.census.gov/ipc/www/worldpop.html');
INSERT INTO question VALUES (2,70.0000,1,1,1,1,95.0000,5.0000,1,
'What percentage of the Earth\'s surface is covered by water?', 'http:/www.sciencenet.org.uk/database/Geography/Original/g00057d.html');
INSERT INTO question VALUES (4,1969.0000,NULL,1,2,NULL,2000.0000,1950.0000,1,
'In what year did human beings first walk on the moon?','');

#
# Table structure for table 'subject'
#
CREATE TABLE subject (
  id int(11) DEFAULT '0' NOT NULL auto_increment,
  subject varchar(255),
  PRIMARY KEY (id)
);

#
# Dumping data for table 'subject'
#

INSERT INTO subject VALUES (1,'Geography');
INSERT INTO subject VALUES (2,'History');
INSERT INTO subject VALUES (3,'Science');
INSERT INTO subject VALUES (4,'Mathematics');
INSERT INTO subject VALUES (5,'Miscellaneous');
