#!/bin/bash

if [ $1 == 'production' ]; then

    ZONE_ID=a4a750a1869ae63e6b5f90e89de7a37f
    AUTH_EMAIL="juliver.galleto@gmail.com"
    API_KEY=j6714EQgylMVTOdDgarGB6sUtX1IjO5xeonRjJGj
    DATA='{"files":[{"url":"https://rblmarketing.pixzeldigital.app"}]}'
    
    curl --request POST \
        --url "https://api.cloudflare.com/client/v4/zones/${ZONE_ID}/purge_cache" \
        --header "Content-Type: application/json" \
        --header "X-Auth-Email: ${AUTH_EMAIL}" \
        --header "Authorization: Bearer ${API_KEY}" \
        --data ${DATA}

fi
