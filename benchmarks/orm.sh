cd `dirname $0`
. ./benchmarks/_functions.sh

base="$1"
bm_name="orm"
concurrency="$2"

results_file="output/results.$bm_name.log"
check_file="output/check.$bm_name.log"
error_file="output/error.$bm_name.log"
url_file="output/urls.log"

mv "$results_file" "$results_file.old" 2>/dev/null; true
mv "$check_file" "$check_file.old" 2>/dev/null; true
mv "$error_file" "$error_file.old" 2>/dev/null; true
mv "$url_file" "$url_file.old" 2>/dev/null; true

for fw in $(eval echo $\{'!'properties_$sec[@]\}); do
    if [ -d "fw/$fw" ]; then
        echo "----------------------------------------------------------------------------------"
        echo "                                  $fw"
        echo "----------------------------------------------------------------------------------"
        . "fw/$fw/_benchmark/hello_world.sh"
        params=$(eval echo $\{properties_$sec[$fw]\})
        url="${url}?${params}"
        benchmark "$fw" "$url" "$concurrency"
    fi
done

cat "$error_file"

suitename=`basename $f .ini`
php ./bin/show_results_table.php "$bm_name"
mkdir -p "output/$suitename/$sec" && cp "output/results.$bm_name.log" "output/$suitename/$sec/"

