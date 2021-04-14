cd `dirname $0`
. ./_functions.sh

base="$1"
bm_name=`basename $0 .sh`
concurrency="$2"

results_file="output/results.$bm_name.log"
check_file="output/check.$bm_name.log"
error_file="output/error.$bm_name.log"
url_file="output/urls.log"

cd ..

mv "$results_file" "$results_file.old"
mv "$check_file" "$check_file.old"
mv "$error_file" "$error_file.old"
mv "$url_file" "$url_file.old"

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

suitename="$(basename $f .ini)"
php ./bin/show_results_table.php "$bm_name"
mkdir -p "output/$suitename/$sec" && cp "output/results.$bm_name.log" "output/$suitename/$sec/"

