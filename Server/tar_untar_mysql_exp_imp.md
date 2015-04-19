Create tar archive:
```
$ tar -cvf file.tar home/
// or compressed:
$ tar -cvzf fileName.tar.gz folderName/
```

Extract:
```
$ tar -xvf myFile.tar.gz
$ tar -C folderName -xvf myFile<span class="skimwords-unlinked">.tar</span>
```
Arguments:

u = update
x = extract or restore
r = replace
t = Table of contents

c = create file
v = verbose (no dialog)
f = file
z = compress
j = filter archive through bzip2
o = Ownership. Assign to extracted files the user and group identifiers of the user running the program, rather than those on tarfile.
h = Follow symbolic links as if they were normal files or directories. Normally, tar does not follow symbolic links.

MySQL:
```
mysql -uUSERNAME -pPASSWORD
CREATE DATABASE dbname CHARACTER SET utf8 COLLATE utf8_general_ci;
use DATABASENAME
show databases;

mysqldump --opt -u USERNAME -pPASSWORD DATABASENAME > DUMP_FILE.sql
mysql -u USERNAME -pPASSWORD DATABASENAME < DUMP_FILE.sql



Show largest tables via MySQL:
SELECT CONCAT(table_schema, '.', table_name),
  CONCAT(ROUND(table_rows / 1000000, 2), 'M')                                    rows,
  CONCAT(ROUND(data_length / ( 1024 * 1024 * 1024 ), 2), 'G')                    DATA,
  CONCAT(ROUND(index_length / ( 1024 * 1024 * 1024 ), 2), 'G')                   idx,
  CONCAT(ROUND(( data_length + index_length ) / ( 1024 * 1024 * 1024 ), 2), 'G') total_size,
  ROUND(index_length / data_length, 2)                                           idxfrac
FROM   information_schema.TABLES
ORDER  BY data_length + index_length DESC
LIMIT  10;
```