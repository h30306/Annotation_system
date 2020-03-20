import mysql.connector
import pandas as pd
import mysql
import json
from random import sample 
import os
os.listdir()

mydb = mysql.connector.connect(
        host="localhost",       
        user="root",   
        passwd="",
        database="VAI",
      )

mycursor = mydb.cursor()


def list_col(table_name):
    mycursor.execute("SHOW columns FROM {}".format(table_name))
    col_name_list = [column[0] for column in mycursor.fetchall()]
    return col_name_list

def list_table(mycursor):
    mycursor.execute("show tables")
    table_list = [tuple[0] for tuple in mycursor.fetchall()]
    return table_list


list_table(mycursor)
list_col('user')
    

#sql = "CREATE TABLE customers (name VARCHAR(255), address VARCHAR(255))"
#sql2 = "INSERT INTO customers VALUES('楊繼勝','台北市')"
#sql3 = "select * from customers"

##### Create article #####
sql = "CREATE TABLE article (a_id INT NOT NULL AUTO_INCREMENT , a_title TEXT(2000) NOT NULL, a_content TEXT(40000) NOT NULL , PRIMARY KEY (a_id))"
mycursor.execute(sql)

##### Create content #####
sql2 = "CREATE TABLE content ( c_id INT NOT NULL AUTO_INCREMENT , c_content TEXT(65520) NOT NULL , a_id INT NOT NULL , PRIMARY KEY (c_id))"
mycursor.execute(sql2)

##### Create score #####
sql3 = "CREATE TABLE score ( c_id INT NOT NULL , u_id INT NOT NULL , v_grade INT NOT NULL , a_grade INT NOT NULL , i_sentence INT NOT NULL , incomplete INT NOT NULL )"
mycursor.execute(sql3)

##### Create tag #####
sql4 = "CREATE TABLE tag ( u_id INT NOT NULL , a_id INT NOT NULL , tagged INT NOT NULL )"
mycursor.execute(sql4)

##### Create user #####
sql5 = "CREATE TABLE user ( u_id INT NOT NULL AUTO_INCREMENT , u_number INT NOT NULL , u_password TEXT(20) NOT NULL , PRIMARY KEY (u_id))"
mycursor.execute(sql5)

# Create user1
#sql5 = "CREATE TABLE user1 ( u_id INT NOT NULL AUTO_INCREMENT , u_number INT NOT NULL , PRIMARY KEY (u_id))"
#mycursor.execute(sql5)

##### foreign key S.c_id #####
sql6 = "ALTER TABLE score ADD FOREIGN KEY (c_id) REFERENCES content(c_id) ON DELETE CASCADE ON UPDATE CASCADE"
mycursor.execute(sql6)

##### foreign key C.a_id #####
sql7 = "ALTER TABLE content ADD FOREIGN KEY (a_id) REFERENCES article(a_id) ON DELETE CASCADE ON UPDATE CASCADE"
mycursor.execute(sql7)

##### foreign key T.u_id #####
sql8 = "ALTER TABLE tag ADD FOREIGN KEY (u_id) REFERENCES user(u_id) ON DELETE CASCADE ON UPDATE CASCADE"
mycursor.execute(sql8)

##### foreign key t.u_id #####
sql9 = "ALTER TABLE tag ADD FOREIGN KEY (a_id) REFERENCES article(a_id) ON DELETE CASCADE ON UPDATE CASCADE"
mycursor.execute(sql9)

##### foreign key A.u_id #####
sql10 = "ALTER TABLE score ADD FOREIGN KEY (u_id) REFERENCES user(u_id) ON DELETE CASCADE ON UPDATE CASCADE"
mycursor.execute(sql10)


##### Insert User u_PK u_number #####
df = pd.read_csv("./data/user.csv", header=None)
var = [(t[1][1],t[1][2]) for t in df.iterrows()]

sql11 = "INSERT INTO user (u_number, u_password) VALUES (%s, %s)"
mycursor.executemany(sql11,var)
mydb.commit()

##### Insert Article a_PK a_title a_content #####
f = open("./data/HatePolitics_pool_test.json")
article = [json.loads(line) for line in f]
var1=[]
for i in article:
    var1.append((i['標題'],i['內文']))
sql12 = "INSERT INTO article (a_title, a_content) VALUES (%s, %s)"
mycursor.executemany(sql12,var1)
mydb.commit()
len(var1)

##### Insert Content c_PK c_content a_fk #####
var2 = []
len(var2)
for i,v in enumerate(article):
    for k in v['評論內容']:
        var2.append((k,int(i+1)))
sql13 = "INSERT INTO content (c_content, a_id) VALUES (%s, %s)"
mycursor.executemany(sql13,var2[:10000])
mydb.commit()

mycursor.executemany(sql13,var2[10000:20000])
mydb.commit()

mycursor.executemany(sql13,var2[20000:])
mydb.commit()

amount = 40
##### Insert Tag u_FK a_FK tagge #####
a_id = list(range(1,int((amount*11)+1)))#19801
u_id = list(range(1,56))

df = pd.DataFrame({'u_id':[],'a_id':[]})
        
for i in range(11):
    a = sample(a_id, 40)
    u = sample(u_id , 5)*40
    u.sort()
    temp = [u,a*5]
    df_temp = pd.DataFrame(temp).transpose()
    df_temp.columns = ['u_id', 'a_id']
    df = df.append(df_temp)
    a_id = [x for x in a_id if x not in a]
    u_id = [x for x in u_id if x not in u]

var3 = [(int(row[0]),int(row[1]), 0) for index, row in df.iterrows()]
sql14 = "INSERT INTO tag (u_id, a_id, tagged) VALUES (%s, %s, %s)"
mycursor.executemany(sql14,var3)
mydb.commit()
 
##### Insert Score c_FK u_FK #####
df['a_id'] = df['a_id'].astype(int)
df['u_id'] = df['u_id'].astype(int)
var4 = [i[1] for i in var2]*1 #a_FK
var5 = list(range(1,len(var4)+1))*1 #c_FK
var4.sort()
var5.sort()
score = pd.DataFrame({'a_id':var4,'c_FK':var5})
score['a_id'] = score['a_id'].astype(int)
score['c_FK'] = score['c_FK'].astype(int)
score = pd.merge(df,score, how='left',on='a_id')
score[score.isnull().any(axis=1)]
len(score)
var6 = [(int(row[0]),int(row[2]),0, 0, 0, 0) for index, row in score.iterrows()]
len(var6)
sql15 = "INSERT INTO score (u_id, c_id, v_grade, a_grade, i_sentence, incomplete) VALUES (%s, %s, %s, %s, %s, %s)"
s=0
for i in range(10000,int(round(len(var6))+10000),10000):
    print(s,i)
    mycursor.executemany(sql15,var6[s:i])
    mydb.commit()
    s = i

##### Drop Table #####
# mycursor.execute('SET foreign_key_checks = 0')
# mycursor.execute('DROP TABLE user')
# mycursor.execute('DROP TABLE article')
# mycursor.execute('DROP TABLE score')
# mycursor.execute('DROP TABLE tag')
# mycursor.execute('DROP TABLE content')
# mycursor.execute('SET foreign_key_checks = 1')
# mydb.commit()

# ##### Trucate and Delete Table #####
# mycursor.execute('TRUNCATE TABLE score')
# mycursor.execute('DELETE FROM article')

# ##### Print #####

# #### Print Score ####
# mycursor.execute("select * from score")
# customers = mycursor.fetchall() 
# customers
# customers = pd.DataFrame(customers,columns=['c_id(FK)','u_id(FK)','v','a','i','incomplete'])
# customers

# #### Print Ariticle ####
# mycursor.execute("select * from article")
# customers = mycursor.fetchall() 
# customers
# customers = pd.DataFrame(customers,columns=['a_id(PK)', 'a_title', 'a_content'])
# customers

# #### Print user ####
# mycursor.execute("select * from user")
# customers = mycursor.fetchall() 
# customers
# customers = pd.DataFrame(customers,columns=['u_id(PK)','u_number'])
# customers

# #### Print content ####
# mycursor.execute("select * from content")
# customers = mycursor.fetchall() 
# customers
# customers = pd.DataFrame(customers,columns=['c_id(PK)','c_content','a_id(FK)'])
# customers

# #### Print Score ####
# mycursor.execute("select * from tag")
# customers = mycursor.fetchall() 
# customers
# customers = pd.DataFrame(customers,columns=['u_id(FK)','a_id(FK)','tagged'])
# customers

# #### Print Score ####
# mycursor.execute("select * from score")
# customers = mycursor.fetchall() 
# customers
# customers = pd.DataFrame(customers,columns=['i','u_id','u_number','s','s','ds'])
# customers

# ##### Other execute commend ##### 
# sql4 = "ALTER TABLE article ADD a_title INT NOT NULL AFTER a_id"
# mycursor.execute(sql4)
# sql = "ALTER TABLE article DROP a_title"
# mycursor.execute(sql)
# sql = "ALTER TABLE article ADD a_title VARCHAR(2000) NOT NULL AFTER a_id"
# mycursor.execute(sql)
# sql = "ALTER TABLE article ADD a_content TEXT(21800) NOT NULL AFTER a_title"
# mycursor.execute(sql)
# sql = "ALTER TABLE content CHANGE c_content c_content TEXT(21800) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL"
# mycursor.execute(sql)
# sql = "ALTER TABLE article CHANGE a_content a_content TEXT(21800) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL"
# mycursor.execute(sql)
# sql = "ALTER TABLE article CHANGE a_title a_content TEXT(21800) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL"
# mycursor.execute(sql)
# sql = "select * From INFORMATION_SCHEMA.KEY_COLUMN_USAGE"
# mycursor.execute(sql)
# customers = mycursor.fetchall() 


# 建article表 CREATE TABLE `VAI`.`article` ( `a_id` INT NOT NULL AUTO_INCREMENT , `a_content` VARCHAR(65520) NOT NULL , PRIMARY KEY (`a_id`)) ENGINE = InnoDB;
# 建content表 CREATE TABLE `VAI`.`content` ( `c_id` INT NOT NULL AUTO_INCREMENT , `c_content` VARCHAR(65520) NOT NULL , `a_id` INT NOT NULL , PRIMARY KEY (`c_id`)) ENGINE = InnoDB;
# 建 score表 CREATE TABLE `VAI`.`score` ( `c_id` INT NOT NULL , `u_id` INT NOT NULL , `v_grade` INT NOT NULL , `a_grade` INT NOT NULL , `i_sentence` INT NOT NULL , `incomplete` INT NOT NULL ) ENGINE = InnoDB;
# 建 tag表 CREATE TABLE `VAI`.`tag` ( `u_id` INT NOT NULL , `a_id` INT NOT NULL , `tagge` INT NOT NULL ) ENGINE = InnoDB;
# 建 user表 CREATE TABLE `VAI`.`user` ( `u_id` INT NOT NULL AUTO_INCREMENT , `u_number` INT NOT NULL , PRIMARY KEY (`u_id`)) ENGINE = InnoDB;
# 外鍵 S.c_id C.c_id -> ALTER TABLE `score` ADD FOREIGN KEY (`c_id`) REFERENCES `content`(`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;















