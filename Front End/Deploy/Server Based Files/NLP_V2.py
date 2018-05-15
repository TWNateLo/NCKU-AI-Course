# coding=utf-8
import jieba
import matplotlib as mpl
from sklearn.feature_extraction import DictVectorizer
from sklearn.feature_extraction.text import TfidfTransformer
from collections import defaultdict
import pickle
from time import sleep
import sys  # Get argument from php
import pymysql  # python MYSQL
#zhfont1 = mpl.font_manager.FontProperties(fname='DejaVuSans.ttf')

with open('ppt.pkl', 'rb') as f:
    c_words = pickle.load(f)

with open('c_svc.pickle', 'rb') as f:
    c_svc = pickle.load(f)

    # convert to vectors
c_dvec = DictVectorizer()
c_tfidf = TfidfTransformer()
c_vector = c_dvec.fit_transform(c_words)
c_X = c_tfidf.fit_transform(c_vector)

# 分類留言的情緒


def comment_sentiment_classifier(model, dvec, tfidf, text):
    l = text.strip()  # 去頭去尾換行之類的字符
    d = defaultdict(int)

    for w in jieba.cut(l):  # w 是針對 l 中的文字斷詞後所得之詞語
        d[w] += 1

    comment_vec = dvec.transform(d)
    comment_X = tfidf.transform(comment_vec)
    result = model.predict(comment_X)

    return result


email = sys.argv[1]  # get value from php
s = sys.argv[2]
mood = comment_sentiment_classifier(c_svc, c_dvec,
                                    c_tfidf, s)  # get sentiment result
print(mood[0])
# print(email)

# =============================================================================
#                          Connect to Database
# =============================================================================
#%% Database information
hostname = 'localhost'
username = 'aicourse'
password = ''
database = 'aicourse'

myConnection = pymysql.connect(
    host=hostname, user=username, passwd=password, db=database, autocommit=True)
cur = myConnection.cursor()
# Load Current Status
cur.execute("SELECT `Score`,`Lv` FROM `users` WHERE `Email`=%s", (email))
status = cur.fetchone()
score = status[0]
lv = status[1]
# Update score
score = score+mood[0]

#turn to int type critical procedure
score = int(score) 
cur.execute("UPDATE users SET `Score` = %s WHERE `Email`= %s", (score, email))
# print(score)
myConnection.close()
