# WA-Plan 1.3
Planning Organisation based on Walker Andersen Recruitment scheduling system.

## Setup
1. Configure settings commented at the top of `index.php`
2. Upload all files to server or locally (must be running PHP v5.3 or later)
3. Launch the root folder in the browser window and you are ready to begin

#### How it works
* Every session is stored as a time-stamp generated five-digit string and added to a `$_SESSION` cookie
* The details of that session is stored as serialised JSON data in a `txt` file with the name of the session (for example, if the session is `ab123`, the data for that session is stored as `/session/ab123.txt`
* This negates the need to access databases and can therefore be theoretically optimised on any domain

####Frameworks/libraries
* jQuery 2.1.4 (CDN)
* Bootstrap 3.3.4 (CDN)
* FontAwesome 4.3.0 (CDN)
* Sugar (Local)
* HTML5shiv 3.7.2 (CDN)
* Respond 1.4.2 (CDN)
* jQuery Title Alert 0.7 (Local)

#### Shortcuts/Hotkeys
* Create a new task by typing in the name of the objective in the top Input box
* If there is a preexisting task with that name, the LiveSearch feature will find it
* Press "Go" or hit Return to submit it
* Tasks can be changed by clicking the name
* Add a date for the task by putting "D/M" into the input box, eg 12/5 for 12 May, 6/10 for 6 Oct etc
  * The date will be shown in the box separately, and will turn green if it matches today's date
* Click any button in the row above the first task to filter by result

#### Commands
* Save - updates the corresponding `.txt` file with the session details
* Open - enter a session key and it will be loaded as the current session
* Import - enter raw exported details to override the current session
* Export - raw data of the current session
* Refresh - refreshes current session
* New Session - starts a fresh session

#### Changelog
Moved to `CHANGELOG.md`