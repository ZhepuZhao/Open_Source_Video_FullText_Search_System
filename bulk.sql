load data
local infile "p2records.txt"
replace into table p2records
fields terminated by '|'
(videoid, title, description, keywords, creationyear, sound,
color, duration, durationsec, sponsorname, contribname, language, genre, keyframeurl);