load data
local infile "keywordphrases.txt"
replace into table KeywordSuggest
fields terminated by '\n' (SuggestPhrase);