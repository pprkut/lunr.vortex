#!/bin/bash

# environment setup
CWD=$(pwd)
DESTDIR=${DESTDIR:-$CWD/src}
TMP=${TMP:-$CWD/tmp}

if ! [ -e "$TMP" ]; then
  mkdir "$TMP"
fi

# interactions download locations
PSRLOG="https://github.com/php-fig/log/archive/1.0.0.tar.gz"
APNSPHP="https://github.com/M2Mobi/ApnsPHP/archive/b9c04fdfdf63da714fbb06e4151d939e0e9fdccb.tar.gz"

if ! [ -e "$DESTDIR/Psr/Log" ]; then
  cd "$TMP"
    wget --content-disposition "$PSRLOG"
    tar xvf log-1.0.0.tar.gz

    mv log-1.0.0/Psr "$DESTDIR/"
  cd -
fi

# remove old version of ApnsPHP
if [ -f "$DESTDIR/ApnsPHP/Log/Interface.php" ]; then
  rm -rf "$DESTDIR/ApnsPHP"
fi

if ! [ -e "$DESTDIR/ApnsPHP" ]; then
  cd "$TMP"
    wget --content-disposition "$APNSPHP"
    tar xvf ApnsPHP-b9c04fdfdf63da714fbb06e4151d939e0e9fdccb.tar.gz

    mv ApnsPHP-b9c04fdfdf63da714fbb06e4151d939e0e9fdccb/ApnsPHP "$DESTDIR/ApnsPHP"
  cd -
fi

# cleanup
rm -rf "$TMP"/*

echo "All interactions setup!"
