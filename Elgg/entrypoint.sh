#!/bin/sh


CONTAINER_INITIALISATION_COMPLETE="CONTAINER_INITIALISATION_COMPLETE_PLACEHOLDER"
if [ ! -e $CONTAINER_INITIALISATION_COMPLETE ]; then
    touch $CONTAINER_INITIALISATION_COMPLETE
    echo "-- First container startup --"
    echo "-- Copy Elgg --"
    cp -ar /elgg-install/elgg-${ELGG_VERSION}/. ${ELGG_PATH}
    chown -R www-data:www-data ${ELGG_PATH}
    chown -R www-data:www-data ${ELGG_DATA_ROOT}
    # Create Symlink for simplecache
    ln -s ${ELGG_PATH}cache/ ${ELGG_DATA_ROOT}caches/views_simplecache/
    echo "-- Wait for DB-Server (30 seconds) --"
    sleep 30
    cd ${ELGG_PATH}
    echo "-- Execute Elgg-Init --"
    php	/elgg-install.php
else
    echo "-- Container already initialized --"
    echo "-- If you want to start setup again, delete the File: CONTAINER_INITIALISATION_COMPLETE_PLACEHOLDER --"
    echo "-- And restart the Conatainer --"
fi

exec "$@"
