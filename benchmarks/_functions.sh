benchmark ()
{
    fw="$1"
    url="$2"
    concurrency="$3"
    ab_log="output/$fw.ab.log"
    output="output/$fw.output"

    # get rpm
    echo "ab -c $concurrency -t 3 $url"
    ab -c $concurrency -t 3 "$url" > "$ab_log"
    rps=`grep "Requests per second:" "$ab_log" | cut -f 7 -d " "`

    # get time
    count=10
    total=0
    i=0
    while [  $i -lt $count ]; do
        curl "$url" > "$output"
        t=`tail -1 "$output" | cut -f 2 -d ':'`
        total=`php ./benchmarks/sum_ms.php $t $total`
        echo The counter is $i
        i=$(( $i + 1 ))
    done
    time=`php ./benchmarks/avg_ms.php $total $count`

    # get memory and file
    memory=`tail -1 "$output" | cut -f 1 -d ':'`
    file=`tail -1 "$output" | cut -f 3 -d ':'`

	#get dbQueries
	dbCounts=`php ./benchmarks/db_queries.php clear`
	queries_before=`echo "$dbCounts" | cut -f 1 -d ':'`
	rows_before=`echo "$dbCounts" | cut -f 2 -d ':'`
	curl "$url"
	dbCounts=`php ./benchmarks/db_queries.php`
	queries_after=`echo "$dbCounts" | cut -f 1 -d ':'`
	rows_after=`echo "$dbCounts" | cut -f 2 -d ':'`
	
    queries=$(( $queries_after-$queries_before-1 ))
    rows=$(( $rows_after-$rows_before ))
    
    echo "$fw: $rps: $memory: $time: $file: $queries: $rows" >> "$results_file"

    echo "$fw" >> "$check_file"
    grep "Document Length:" "$ab_log" >> "$check_file"
    grep "Failed requests:" "$ab_log" >> "$check_file"
    grep 'Hello World!' "$output" >> "$check_file"
    echo "---" >> "$check_file"

    # check errors
    touch "$error_file"
    error=''
    x=`grep 'Failed requests:        0' "$ab_log"`
    if [ "$x" = "" ]; then
        tmp=`grep "Failed requests:" "$ab_log"`
        error="$error$tmp"
    fi
    x=`grep 'Hello World!' "$output"`
    if [ "$x" = "" ]; then
        tmp=`cat "$output"`
        error="$error$tmp"
    fi
    if [ "$error" != "" ]; then
        echo -e "$fw\n$error" >> "$error_file"
        echo "---" >> "$error_file"
    fi

    echo "$url" >> "$url_file"

    echo
}
