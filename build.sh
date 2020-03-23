#!/usr/bin/env bash

echo "";

if [ "$1" == "" ] ; then
    echo " - [ ERROR ] First argument MUST be the application version";
    echo "";
    exit;
fi

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
APP_VERSION="$1"
IMAGE="jobsity/challenge-site:${APP_VERSION}"

echo "";
echo "===============================================";
echo " Building image...";
echo "===============================================";
echo "";

docker build -t "${IMAGE}" "${DIR}";