<?php
mysql_query("
ALTER DATABASE ".$dbname." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
", $conn);
mysql_query("
ALTER TABLE ".$t_messages." CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
", $conn);
mysql_query("
ALTER TABLE ".$t_reg_users." CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
", $conn);
mysql_query("
ALTER TABLE ".$t_users." CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_bot (
 id int(11) NOT NULL auto_increment,
 bot tinyint(4) NOT NULL default '0',
 name varchar(255) NOT NULL default '',
 value text NOT NULL,
 PRIMARY KEY (id),
 KEY botname (bot,name)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_bots (
 id tinyint(3) unsigned NOT NULL auto_increment,
 botname varchar(255) NOT NULL default '',
 PRIMARY KEY (botname),
 KEY id (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_conversationlog (
 bot tinyint(3) unsigned NOT NULL default '0',
 id int(11) NOT NULL auto_increment,
 input text,
 response text,
 uid varchar(255) default NULL,
 enteredtime timestamp(14) NOT NULL,
 PRIMARY KEY (id),
 KEY botid (bot)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_dstore (
 uid varchar(255) default NULL,
 name text,
 value text,
 enteredtime timestamp(14) NOT NULL,
 id int(11) NOT NULL auto_increment,
 PRIMARY KEY (id),
 KEY nameidx (name(40))
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_gmcache (
 id int(11) NOT NULL auto_increment,
 bot tinyint(3) unsigned NOT NULL default '0',
 template int(11) NOT NULL default '0',
 inputstarvals text,
 thatstarvals text,
 topicstarvals text,
 patternmatched text,
 inputmatched text,
 combined text NOT NULL,
 PRIMARY KEY (id),
 KEY combined (bot,combined(255))
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_gossip (
 bot tinyint(3) unsigned NOT NULL default '0',
 gossip text,
 id int(11) NOT NULL auto_increment,
 PRIMARY KEY (id),
 KEY botidx (bot)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_patterns (
 bot tinyint(3) unsigned NOT NULL default '0',
 id int(11) NOT NULL auto_increment,
 word varchar(255) default NULL,
 ordera tinyint(4) NOT NULL default '0',
 parent int(11) NOT NULL default '0',
 isend tinyint(4) NOT NULL default '0',
 PRIMARY KEY (id),
 KEY wordparent (parent,word),
 KEY botid (bot)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_templates (
 bot tinyint(3) unsigned NOT NULL default '0',
 id int(11) NOT NULL default '0',
 template text NOT NULL,
 pattern varchar(255) default NULL,
 that varchar(255) default NULL,
 topic varchar(255) default NULL,
 KEY bot (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_thatindex (
 uid varchar(255) default NULL,
 enteredtime timestamp(14) NOT NULL,
 id int(11) NOT NULL auto_increment,
 PRIMARY KEY (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE bot_thatstack (
 thatid int(11) NOT NULL default '0',
 id int(11) NOT NULL auto_increment,
 value varchar(255) default NULL,
 enteredtime timestamp(14) NOT NULL,
 PRIMARY KEY (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE ".$t_ban_users." (
 username varchar(30) NOT NULL default '',
 latin1 tinyint(1) NOT NULL default '0',
 ip varchar(16) NOT NULL default '',
 rooms varchar(100) NOT NULL default '',
 ban_until int(11) NOT NULL default '0',
 reason varchar(100) NOT NULL default ''
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
CREATE TABLE ".$t_config." (
 ID tinyint(1) NOT NULL default '0',
 MSG_DEL tinyint(1) NOT NULL default '96',
 USR_DEL tinyint(1) NOT NULL default '10',
 REG_DEL tinyint(1) NOT NULL default '0',
 LANGUAGE varchar(20) NOT NULL default 'english',
 MULTI_LANG enum('0','1') NOT NULL default '1',
 REQUIRE_REGISTER enum('0','1') NOT NULL default '0',
 REQUIRE_NAMES enum('0','1') NOT NULL default '0',
 EMAIL_PASWD enum('0','1') NOT NULL default '0',
 PASS_LENGTH tinyint(1) NOT NULL default '6',
 ADMIN_NOTIFY enum('0','1') NOT NULL default '1',
 ADMIN_NAME varchar(35) NOT NULL default 'Your name/chat name here',
 ADMIN_EMAIL varchar(35) NOT NULL default 'Your email address here',
 CHAT_URL varchar(100) NOT NULL default 'Your server/chat URL here',
 SHOW_ADMIN enum('0','1') NOT NULL default '1',
 SHOW_DEL_PROF enum('0','1') NOT NULL default '1',
 VERSION enum('0','1','2') NOT NULL default '2',
 BANISH tinyint(1) NOT NULL default '1',
 NO_SWEAR enum('0','1') NOT NULL default '0',
 SWEAR_EXPR varchar(5) NOT NULL default '@#$*!',
 SAVE varchar(5) NOT NULL default '*',
 USE_SMILIES enum('0','1') NOT NULL default '1',
 HTML_TAGS_KEEP enum('none','simple') NOT NULL default 'simple',
 HTML_TAGS_SHOW enum('0','1') NOT NULL default '0',
 TMZ_OFFSET tinyint(1) NOT NULL default '0',
 MSG_ORDER enum('0','1') NOT NULL default '1',
 MSG_NB tinyint(1) NOT NULL default '10',
 MSG_REFRESH tinyint(1) NOT NULL default '20',
 SHOW_TIMESTAMP enum('0','1') NOT NULL default '1',
 NOTIFY enum('0','1') NOT NULL default '1',
 WELCOME enum('0','1') NOT NULL default '1',
 SMILEY_COLS tinyint(1) NOT NULL default '10',
 SMILEY_COLS_POP tinyint(1) NOT NULL default '5',
 ALLOW_ENTRANCE_SOUND enum('0','1','2','3') NOT NULL default '1',
 ENTRANCE_SOUND varchar(255) NOT NULL default 'sounds/chimeup.wav',
 ALLOW_BUZZ_SOUND enum('0','1') NOT NULL default '1',
 BUZZ_SOUND varchar(255) NOT NULL default 'sounds/chimedwn.wav',
 TOPIC_DIFF enum('0','1') NOT NULL default '1',
 SHOW_TUT enum('0','1') NOT NULL default '1',
 SHOW_INFO enum('0','1') NOT NULL default '1',
 SET_CMDS enum('0','1') NOT NULL default '1',
 CMDS varchar(255) NOT NULL default '<br />/away /buzz /demote /dice /dice2 /dice3 /high /img /mr<br />/room /size /sort /topic /wisp',
 SET_MODS enum('0','1') NOT NULL default '1',
 MODS varchar(255) NOT NULL default '<br />Advanced Admin, Avatars, Smilies Popup, Color Drop Box, Private Popup,<br />Quick Menu, Logs Archive, Lurking, Color names, WorldTime, UTF-8',
 SET_BOT enum('0','1') NOT NULL default '1',
 ROOM_SAYS varchar(25) NOT NULL default 'Attention Room:',
 DEMOTE_MOD enum('0','1') NOT NULL default '0',
 PRIV_POPUP enum('0','1') NOT NULL default '1',
 SHOW_ETIQ_IN_HELP enum('0','1') NOT NULL default '1',
 SHOW_LOGO enum('0','1') NOT NULL default '1',
 LOGO_IMG varchar(255) NOT NULL default 'images/icon.gif',
 LOGO_OPEN varchar(255) NOT NULL default './',
 LOGO_ALT varchar(255) NOT NULL default 'My Chat based on phpMyChat plus',
 SHOW_OWNER enum('0','1') NOT NULL default '1',
 SHOW_PRIV enum('0','1') NOT NULL default '1',
 SHOW_PRIV_MOD enum('0','1') NOT NULL default '1',
 SHOW_PRIV_USR enum('0','1') NOT NULL default '1',
 SHOW_COUNTER enum('0','1') NOT NULL default '1',
 INSTALL_DATE date NOT NULL default '0000-00-00',
 USE_SKIN enum('0','1') NOT NULL default '1',
 ROOM1 varchar(25) NOT NULL default 'Public Room 1',
 ROOM2 varchar(25) NOT NULL default 'Public Room 2',
 ROOM3 varchar(25) NOT NULL default 'Public Room 3',
 ROOM4 varchar(25) NOT NULL default 'Public Room 4',
 ROOM5 varchar(25) NOT NULL default 'Public Room 5',
 ROOM6 varchar(25) NOT NULL default 'Private Room 1',
 ROOM7 varchar(25) NOT NULL default 'Private Room 2',
 ROOM8 varchar(25) NOT NULL default 'Staff Only',
 ROOM9 varchar(25) NOT NULL default 'Support Room',
 SWEAR1 varchar(25) NOT NULL default 'Public Room 5',
 SWEAR2 varchar(25) NOT NULL default 'Staff Only',
 SWEAR3 varchar(25) NOT NULL default 'Support Room',
 SWEAR4 varchar(25) NOT NULL default '',
 COLOR_FILTERS enum('0','1') NOT NULL default '1',
 COLOR_ALLOW_GUESTS enum('0','1') NOT NULL default '1',
 COLOR_CD1 varchar(25) NOT NULL default 'black',
 COLOR_CD2 varchar(25) NOT NULL default 'tomato',
 COLOR_CD3 varchar(25) NOT NULL default 'dimgray',
 COLOR_CD4 varchar(25) NOT NULL default 'indigo',
 COLOR_CD5 varchar(25) NOT NULL default 'green',
 COLOR_CD6 varchar(25) NOT NULL default 'maroon',
 COLOR_CD7 varchar(25) NOT NULL default 'white',
 COLOR_CD8 varchar(25) NOT NULL default 'magenta',
 COLOR_CD9 varchar(25) NOT NULL default 'blueviolet',
 COLOR_CA varchar(25) NOT NULL default 'red',
 COLOR_CA1 varchar(25) NOT NULL default 'crimson',
 COLOR_CA2 varchar(25) NOT NULL default 'orangered',
 COLOR_CM varchar(25) NOT NULL default 'blue',
 COLOR_CM1 varchar(25) NOT NULL default 'mediumblue',
 COLOR_CM2 varchar(25) NOT NULL default 'royalblue',
 QUICKA longtext NOT NULL,
 QUICKM longtext NOT NULL,
 QUICKU longtext NOT NULL,
 COLOR_NAMES enum('0','1') NOT NULL default '1',
 USE_AVATARS enum('0','1') NOT NULL default '1',
 NUM_AVATARS smallint(1) NOT NULL default '55',
 AVA_RELPATH varchar(255) NOT NULL default 'images/avatars/',
 DEF_AVATAR varchar(255) NOT NULL default 'def_avatar.gif',
 AVA_WIDTH tinyint(1) NOT NULL default '25',
 AVA_HEIGHT tinyint(1) NOT NULL default '25',
 AVA_PROFBUTTON enum('0','1') NOT NULL default '1',
 MAX_DICES tinyint(1) NOT NULL default '99',
 MAX_ROLLS tinyint(1) NOT NULL default '6',
 BOT_CONTROL enum('0','1') NOT NULL default '1',
 MAX_PIC_SIZE smallint(1) NOT NULL default '350',
 USERS_SORT_ORD enum('0','1') NOT NULL default '0',
 CHAT_LOGS enum('0','1') NOT NULL default '1',
 LOG_DIR varchar(25) NOT NULL default 'logsadmin',
 SHOW_LOGS_USR enum('0','1') NOT NULL default '1',
 CHAT_LURKING enum('0','1') NOT NULL default '1',
 SHOW_LURK_USR enum('0','1') NOT NULL default '1',
 BAN_IP enum('0','1') NOT NULL default '0',
 REG_CHARS_ALLOWED varchar(50) NOT NULL default 'a-zA-Z0-9_.-@#$%^&*()=<>?~|:',
 EXIT_LINK_TYPE enum('0','1') NOT NULL default '1',
 CHAT_EXTRAS enum('0','1') NOT NULL default '1',
 EMAIL_USER enum('0','1') NOT NULL default '1',
 BOT_HELLO varchar(100) NOT NULL default 'Hello People!!! Have you been missing me?',
 BOT_BYE varchar(100) NOT NULL default 'Bye Bye everyone! See you when I see you...',
 BOT_PUBLIC enum('0','1') NOT NULL default '1',
 ENABLE_PM enum('0','1') NOT NULL default '1',
 EN_ROOM1 enum('0','1') NOT NULL default '1',
 EN_ROOM2 enum('0','1') NOT NULL default '1',
 EN_ROOM3 enum('0','1') NOT NULL default '1',
 EN_ROOM4 enum('0','1') NOT NULL default '1',
 EN_ROOM5 enum('0','1') NOT NULL default '1',
 EN_ROOM6 enum('0','1') NOT NULL default '1',
 EN_ROOM7 enum('0','1') NOT NULL default '1',
 EN_ROOM8 enum('0','1') NOT NULL default '1',
 EN_ROOM9 enum('0','1') NOT NULL default '1',
 CHAT_BOOT enum('0','1') NOT NULL default '1',
 WELCOME_SOUND varchar(255) NOT NULL default 'sounds/hello.wav',
 WORLDTIME enum('0','1','2') NOT NULL default '2',
 UPD_CHECK enum('0','1') NOT NULL default '1',
 QUOTE enum('0','1') NOT NULL default '1',
 QUOTE_TIME tinyint(1) NOT NULL default '5',
 QUOTE_COLOR varchar(25) NOT NULL default 'brown',
 QUOTE_PATH varchar(255) NOT NULL default 'files/quotes/quotes_all.txt',
 HIDE_ADMINS enum('0','1') NOT NULL default '0',
 HIDE_MODERS enum('0','1') NOT NULL default '0',
 LAST_SAVED_ON datetime NOT NULL default '0000-00-00 00:00:00',
 LAST_SAVED_BY varchar(30) NOT NULL default 'installer (upgrade)',
 CHAT_SYSTEM enum('standalone','phpnuke','phpbb') NOT NULL default 'standalone',
 NUKE_BB_PATH varchar(255) NOT NULL default '',
 CHAT_NAME varchar(255) NOT NULL default 'My WonderfulWorldWide Chat',
 ENGLISH_FORMAT enum('UK','US') NOT NULL default 'UK',
 FLAGS_3D enum('0','1') NOT NULL default '1',
 ALLOW_REGISTER enum('0','1') NOT NULL default '1',
 PRIMARY KEY (ID)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
INSERT INTO ".$t_config." (id, INSTALL_DATE, QUICKA, QUICKM, QUICKU, LAST_SAVED_ON) VALUES ('0', NOW(), 'Greetings|\r\nWelcome|\r\nThanks for coming by|\r\nLoL|\r\n:rofl|\r\n/announce I have to go now!|\r\n/away be right back...|\r\n/away ...I\'m back!|\r\n/bot start|\r\n/bot stop|\r\n/buzz|\r\n/buzz ~chimeup|\r\n/me is busy right now!|\r\n/mr is watching TV|\r\n/bye See you around!|\r\n/high user|\r\n/join 0 #%s|\r\n/join 1 #%s|\r\n/invite %s|\r\n/img http://www.path_to_image|\r\n/promote %s|\r\n/demote %s|\r\n/demote * %s|\r\n/room Please follow the topic|\r\n/size 12|\r\n/size|\r\n/sort|\r\n/topic |\r\n/topic top reset|\r\n/wisp %s Hey, in which room ru?|\r\n/whois %s', 'Greetings|\r\nWelcome|\r\nThanks for coming by|\r\nLoL|\r\n:rofl|\r\n/away be right back...|\r\n/away ...I\'m back!|\r\n/buzz|\r\n/buzz ~chimeup|\r\n/me is busy right now!|\r\n/mr is reading|\r\n/bye cyall!|\r\n/high %s|\r\n/join 0 #%s|\r\n/join 1 #%s|\r\n/invite %s|\r\n/img http://www.path_to_image|\r\n/promote %s|\r\n/room Please follow the topic|\r\n/size 12|\r\n/size|\r\n/sort|\r\n/topic |\r\n/topic top reset|\r\n/wisp %s Hey, in which room ru?|\r\n/whois %s', 'Hello everyone|\r\nlol|\r\n:rofl|\r\n/away brb...|\r\n/away ...back!|\r\n/me is busy!|\r\n/mr is lurking|\r\n/bye ttyl!|\r\n/high %s|\r\n/join 0 #%s|\r\n/join 1 #%s|\r\n/invite %s|\r\n/img http://www.path_to_image|\r\n/size 12|\r\n/size|\r\n/sort|\r\n/wisp %s Hey, in which room ru?|\r\n/whois %s', NOW());
", $conn);
mysql_query("
CREATE TABLE ".$t_lurkers." (
 time int(15) NOT NULL default '0',
 ip varchar(15) NOT NULL default '',
 browser varchar(255) NOT NULL default '',
 file varchar(50) NOT NULL default '',
 username varchar(30) NOT NULL default '',
 PRIMARY KEY (time),
 KEY ip (ip),
 KEY file (file)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
", $conn);
mysql_query("
ALTER TABLE ".$t_messages."
			ADD pm_read varchar(19) NOT NULL default '',
			ADD room_from varchar(30) NOT NULL default '';
", $conn);
mysql_query("
ALTER TABLE ".$t_reg_users."
			ADD id int(11) NOT NULL default '0' FIRST,
			ADD cid int(11) NOT NULL auto_increment after id,
			ADD ip varchar(16) NOT NULL default '',
			ADD gender tinyint(1) DEFAULT '0' NOT NULL default '',
			ADD allowpopup tinyint(1) NOT NULL default '1',
			ADD picture varchar(255) NOT NULL default '',
			ADD description text NOT NULL,
			ADD favlink varchar(255) NOT NULL default '',
			ADD favlink1 varchar(255) NOT NULL default '',
			ADD slang varchar(255) NOT NULL default '',
			ADD colorname varchar(25) NOT NULL default '',
			ADD avatar varchar(255) NOT NULL default 'images/avatars/def_avatar.gif',
			ADD s_question enum('0','1','2','3','4') NOT NULL default '0',
			ADD s_answer varchar(64) NOT NULL default '',
			ADD PRIMARY KEY (cid),
			ADD UNIQUE KEY username (username);
", $conn);
mysql_query("
INSERT INTO ".$t_reg_users." VALUES ('', '', 'plusbot', '1', '3901e4a6c3d27909afef4c22f8337da8', 'Bot', 'phpMyChat - Plus', 'WorldWideWeb', '', 'bot@bot.com', '0', 'admin', '', 1130763311, '-No tracking IP-', '1', '0', 'images/alice.gif', 'I am a Robot originally called <a href=http://www.alicebot.org/documentation/ target=_blank>Alice</a>.  I am proud to be the first Artificial Intelligence on the net! Please test my capabilities as you wish! To start a public conversation with me just type \"hello myname\" in the room I am active in, to stop the conversation type \"bye myname\" or \"myname> bye\". But we can also talk in private - just click on my name whenever you need a shoulder to cry on :p Ohhh... I wish to express my gratitude to Roy, Popeye and <a href=http://www.ciprianmp.com/plus/ target=_blank>Ciprian</a>  for making me available for chatting in here. :)', 'http://www.alicebot.org/documentation/', 'http://sourceforge.net/forum/?group_id=43190', 'English, German', 'olive', 'images/avatars/bot_avatar.gif', '0', '' );
", $conn);
mysql_query("
INSERT INTO ".$t_reg_users." VALUES ('', '', 'Random_Quote', '1', 'ef93e0948b007826a1a7a49a17b72a59', 'Random Quote', 'phpMyChat - Plus', 'WorldWideWeb', '', 'quote@quote.com', '0', 'admin', '', 1130763311, '-No tracking IP-', '1', '0', 'images/avatars/avatar56.gif', 'I am a virtual user, added here to post random quotes at my admin�s will. Ohhh... I wish to express my gratitude to <a href=http://www.ciprianmp.com/plus/ target=_blank>Ciprian</a> for making me available for enlighting you in here. :)', 'http://sourceforge.net/projects/phpmychat', 'http://ciprianmp.com/plus', 'English (any actually)', 'limegreen', 'images/avatars/quote_avatar.gif', '0', '' );
", $conn);
mysql_query("
ALTER TABLE ".$t_users."
			ADD ip varchar(16) NOT NULL default '',
			ADD awaystat char(1) NOT NULL default '0',
			ADD r_time int(11) NOT NULL default '0',
			ADD email varchar(64) NOT NULL default '';
", $conn);
?>