CREATE TABLE markers (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  familyid INT NULL ,
  name VARCHAR( 60 ) NULL ,
  postalcode VARCHAR( 6 ) NULL ,
  address VARCHAR( 100 ) NULL ,
  lat FLOAT( 12,8 ) NULL ,
  lng FLOAT( 12, 8 ) NULL ,
  type VARCHAR( 30 ) NULL
)