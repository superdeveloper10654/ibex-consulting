## Server config:

max_input_vars=25000
memory_limit=512M
opcache.memory_consumption=256

## Cront tasks (optional)
- `* * * * * php {path_to_project}/artisan schedule:run >> /dev/null 2>&1`;