# Description
Soketi required if you want to setup websokets connection with server. This package allow to get information like activities, notifications, etc in real time without page refreshing. This installation is not required for development environment.

## Installation
 - if you're using Ubuntu - install required packages `apt install -y git python3 gcc build-essential`;
 - add this section to nginx server config (replace `{website_name.local}`, `{path_to_repo}`, `{path_to_cert}`, `{path_to_cert_key}`):
 
 ```
server {
    listen 6002 ssl http2;
    listen [::]:6002 ssl http2;
    server_name *.{website_name.local};
    server_tokens off;
    root "{path_to_repo}/public";

    # FORGE SSL (DO NOT REMOVE!)
    ssl_certificate {path_to_cert}.crt;
    ssl_certificate_key {path_to_cert_key}.key;

    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers TLS13-AES-256-GCM-SHA384:TLS13-CHACHA20-POLY1305-SHA256:TLS_AES_256_GCM_SHA384:TLS-AES-256-GCM-SHA384:TLS_CHACHA20_POLY1305_SHA256:TLS-CHACHA20-POLY1305-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-ECDSA-AES256-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-CHACHA20-POLY1305:ECDHE-RSA-AES256-SHA384:ECDHE-ECDSA-AES256-SHA:ECDHE-RSA-AES256-SHA;
    ssl_prefer_server_ciphers on;
    ssl_dhparam /etc/nginx/dhparams.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        proxy_pass             http://127.0.0.1:6001;
        proxy_read_timeout     60;
        proxy_connect_timeout  60;
        proxy_redirect         off;

        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }

    access_log off;
    error_log  /var/log/nginx/socket.example.com.log error;
}
 ```
 - `sudo service nginx restart`;
 - open server ports:
    - `sudo ufw allow 6002` (for ws);
    - `sudo ufw allow 6002/tcp` (for wss);
    - `sudo ufw restart`;
 - `npm install -g @soketi/soketi`;
 - `soketi start`;
 - ensure you have this variables in your .env (no need to change PUSHER_APP_KEY / ID / SECRET):
 ```
  APP_ENV=staging
  BROADCAST_DRIVER=pusher

  PUSHER_APP_KEY=app-key
  PUSHER_APP_ID=app-id
  PUSHER_APP_SECRET=app-secret
  PUSHER_APP_CLUSTER=eu
  PUSHER_SCHEME=http # no need https for 127.0.0.1
  PUSHER_HOST="${APP_DOMAIN}"
  PUSHER_PORT=6002

  MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
  MIX_PUSHER_HOST="${PUSHER_HOST}"
  MIX_PUSHER_PORT="${PUSHER_PORT}"
  MIX_PUSHER_SCHEME=https
  MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
 ```
 - `php artisan cache:clear`;
 - `php artisan config:clear`;
 - 
 
You can also configure `supervisor` to keep this comman running on background (check appropriate docs).