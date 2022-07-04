PORT=$1
SUBDOMAIN=$2

if [ -z $PORT ]
then
    echo "You need to specify a port and a URL: $0 PORT URL"
    exit 1
fi
if [ -z $SUBDOMAIN ]
then
    echo "You need to specify a URL: $0 PORT URL"
    exit 1
fi

tee -a /etc/nginx/sites-enabled/$SUBDOMAIN << EOF
server {
        server_name $SUBDOMAIN;

        location / {
            proxy_set_header Host \$host;
            proxy_set_header X-Real-IP \$remote_addr;
            proxy_pass http://localhost:$PORT;
        }
}
EOF
certbot
