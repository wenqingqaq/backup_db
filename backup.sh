#!/bin/bash
echo '开始备份数据库！';
send=`date +%Y-%m-%d`;
mysqldump -uroot -phaotoufa2016*we product_fafu > /home/mysql_backup/product_fafu_$send.sql;
mysqldump -uroot -phaotoufa2016*we fafu_platform > /home/mysql_backup/pre_fafu_$send.sql;