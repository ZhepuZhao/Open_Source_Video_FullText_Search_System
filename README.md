# PHP_FullText_Search_Implementation: User login implementation and FULLTEXT search function

## Reference website: https://opal.ils.unc.edu/~zhepu/zhepu_p2/results.php
<b>login username: rob</b><br>
<b>login password: rob</b><br>
<b>This website is only used for academic things. So it doesn't include any registration function and only one user is stored in the database. But it's a kind of real-life functional website which is connected the database installed on the server pearl.ils.unc.edu. </b>

## Login Interface
<b>This is connected to the database server pearl.ils.unc.edu. And the password stored is not rob, but sha1('rob') to protect the database.</b>
<img width="1440" alt="login_interface" src="https://user-images.githubusercontent.com/33140156/39091367-a2afc5c0-45c0-11e8-995f-b8986cd0ea30.png">

## Search Interface
<b>1. You can search the video you want by the search box. There are 198 videos in total stored in the database. Instead of simply storing video files, I just stored the metadata of videos and reconstruct the url of video linking the user to the targeted website.</b>
<img width="1440" alt="search1" src="https://user-images.githubusercontent.com/33140156/39091422-97b9b77e-45c1-11e8-925a-5f931fff7453.png">
<img width="1440" alt="search2" src="https://user-images.githubusercontent.com/33140156/39091423-97c753ca-45c1-11e8-9bdd-27dee7822aae.png">
<b>2. When you type in the search box, suggestions are given below the search box. These information is also stored in the database</b>
<img width="1440" alt="suggestions" src="https://user-images.githubusercontent.com/33140156/39091424-97d53184-45c1-11e8-9c21-800405432ec8.png">
<b>3. When the mouse moves over the picture or the title, the meta data information of the video is shown on the right side of the website. 
<img width="1440" alt="info" src="https://user-images.githubusercontent.com/33140156/39091430-cfcdefa4-45c1-11e8-8458-2587c4eb5fcb.png">
  
## Logout
<b>When user clicks logout, it returns to the login interface. The webiste used session and cookie. So if one user open two tabs at the same time. If the user logs out on one tab, when he/she reloads the other one, it jumps back to the login interface. Also, when the user logs in, his/her name is shown in the middle of the top of the website.</b>



