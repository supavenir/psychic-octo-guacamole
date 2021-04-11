#!/bin/sh

base="https://db-benchmarks.sts-sio-caen.info/fw"

cd `dirname $0`

if [ $# -eq 0 ]; then
    # include framework list
    . ./list.sh
    export targets="$list"
else
    export targets="${@%/}"
fi

cd benchmarks

sh orm.sh "$base" 10

php ../bin/show_results_table.php
