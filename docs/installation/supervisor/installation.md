# Supervisor description
Supervisor helps to manage processes required for stable project work in production. This installation is optional and not required for development environment.


## Docs:
https://supervisord.org/introduction.html


## Installation

 - `sudo apt-get install supervisor`;
 - in folder `/etc/supervisor/conf.d` create file (any name with .conf extension) using content from file `conf.md` (replace `{path_to_project}` and `{user}`) and:
   - remove section `[program:soketi]` if you haven't install soketi package. Otherwice:
      - replace `{path_to_accessible_folder}` with path to folder that van be accessible by `{user}` and where can be stored all the soketi stuff;

 - enable supervisor by commands:
    - `sudo supervisorctl reread` (check if all is correct in config);
    - `sudo supervisorctl update`;
    - `sudo supervisorctl start queue-work:*` (start laravel queues worker);
    - `sudo supervisorctl start soketi:*` (start soketi);