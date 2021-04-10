#!/bin/sh

base="https://orm-benchmarks.kobject.net/fw"

cd `dirname $0`

if [ $# -eq 0 ]; then
    # include framework list
    . ./list.sh
    export targets="$list"
else
    export targets="${@%/}"
fi

cd benchmarks

sh orm.sh "$base"

php ../bin/show_results_table.php
