#News.sql

#sp17_Feeds table
#
DROP TABLE IF EXISTS sp17_Feeds;

create table sp17_Feeds(
FeedID int unsigned not null auto_increment primary key,
FeedTitle varchar(120),
FeedCategoryID int DEFAULT 0,
FeedDescription text,
FeedRating float(1,1),
FeedLink text,
FeedDateTime DATETIME
)ENGINE=INNODB;

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'CNN US News', 1, 'Our mission is to create the finest possible news product and to present hard-breaking, national, and international news, as it unfolds. We deliver unparalleled perspectives across multiple categories, including political, medical, financial, technology, entertainment, and more.',4.1, 'http://rss.cnn.com/rss/cnn_us.rss',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'Yahoo News',1,'Yahoo is a guide to digital information discovery, focused
on informing, connecting, and entertaining through its
search, communications, and digital content products.',4.1, 'https://www.yahoo.com/news/rss',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'Reuters Domestic News',1,'Whether we are serving broadcasters, publishers, brands, agencies, or direct to consumers, Reuters provides award-winning coverage of the day’s most important topics, including: business, finance, politics, sports, entertainment, technology, health, environment, and much more.',4.1, 'http://feeds.reuters.com/Reuters/domesticNews',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'Reuters Sports',2,'Since 1850, we have experimented, invented, and created content and news solutions to become the world’s leading international news agency. Always at the forefront of real-time breaking news and high-impact global multimedia content, we are constantly innovating our products and services to meet your business needs.',4.2, 'http://feeds.reuters.com/reuters/sportsNews',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'Yahoo Sports',2,'a sports news website launched by Yahoo! on December 8, 1997. It receives a majority of its information from STATS, Inc. It employs numerous writers, and has team pages for teams in almost every North American sport.',4.2, 'https://sports.yahoo.com/top/rss.xml',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'CNN Sports',2,'Latest sports news from around the world with in-depth analysis, features, photos and videos covering football, tennis, motorsport, golf, rugby, etc.',4.2, 'http://rss.cnn.com/rss/edition_sport.rss',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'Music Industry News Network',3,'Mi2N (Music Industry News Network) is the largest online daily newswire serving the music industry. Since 1998, Mi2N has kept professionals worldwide informed on the latest developments shaping their sector by covering nearly every facet of the industry, from new business models and technological innovations to up-&-coming artists and emerging trends. Simultaneously, it has become a leading PR resource for major and independent music companies around the world.',4.3, 'http://feeds.feedburner.com/mi2nheadlines',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'Music-News.com',3,'a leading independent publisher featuring news, reviews, interviews, competitions, the latest releases and all the gossip from the worldwide music scene.',4.3, 'http://www.music-news.com/rss/UK/news',NOW());

insert into sp17_Feeds(
FeedID,
FeedTitle,
FeedCategoryID,
FeedDescription,
FeedRating,
FeedLink,
FeedDateTime
)
values(NULL, 'Rolling Stone Music News',3,'Rolling Stone is an American biweekly magazine that focuses on popular culture. It was founded in San Francisco in 1967 by Jann Wenner, who is still the magazine\'s publisher, and the music critic Ralph J. Gleason.',4.3, 'http://www.rollingstone.com/music/rss',NOW());


#sp17_FeedCategories table
#
DROP TABLE IF EXISTS sp17_FeedCategories;

create table sp17_FeedCategories(
FeedCategoryID int unsigned not null auto_increment primary key,
FeedCategoryName varchar(120),
FeedCategoryDescription text
)ENGINE=INNODB;

insert into sp17_FeedCategories(
FeedCategoryID,
FeedCategoryName,
FeedCategoryDescription
)
values(NULL, 'News','Newly received or noteworthy information, especially about recent or important events.');

insert into sp17_FeedCategories(
FeedCategoryID,
FeedCategoryName,
FeedCategoryDescription
)
values(NULL, 'Sports','An activity involving physical exertion and skill in which an individual or team competes against another or others for entertainment.');

insert into sp17_FeedCategories(
FeedCategoryID,
FeedCategoryName,
FeedCategoryDescription
)
values(NULL, 'Music','Music is an art form and cultural activity whose medium is sound organized in time.');
