[program:queue-work]
process_name=%(program_name)s_%(process_num)02d
command=php {path_to_project}/artisan queue:work --sleep=3 --tries=3 --backoff=10 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user={user}
numprocs=1
redirect_stderr=true
stdout_logfile={path_to_project}/storage/logs/supervisor-queue-work.log
stopwaitsecs=3600

[program:soketi]
environment=HOME="{path_to_accessible_folder}/soketi"
process_name=%(program_name)s_%(process_num)02d
command=soketi start
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user={user}
numprocs=1
redirect_stderr=true
stdout_logfile={path_to_project}/storage/logs/supervisor-soketi.log
stopwaitsecs=60