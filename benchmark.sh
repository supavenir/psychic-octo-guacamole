base="https://db-benchmarks.sts-sio-caen.info/fw"

declare -A sections
props(){
i=0
while IFS='=' read -d $'\n' -r k v; do
    if [[ $k == \[*] ]]
    then
        section=${k#*[}
        section=${section%]*}
        sections+=section
        array_name="properties_${section}"
        declare -g -A ${array_name}
    elif [[ $k ]]
    then
      # Skip comments or empty lines
      [[ "$k" =~ ^([[:space:]]*|[[:space:]]*#.*)$ ]] && continue
      eval $array_name["$k"]=\"$v\"
    fi
done < $1
 }




cd benchmarks

for f in ./../suites/*; do
  sections=()
  props $f
  for sec in $sections
  do
    echo "**********************************************************************************"
    echo "                         Start Benchmarks pour $sec                               "
    echo "**********************************************************************************"
    export targets="$(eval echo $\{'!'properties_${sec}[@]\})"
    sh orm.sh "$base" 10
    suitename="$(basename $f)"
    php ../bin/show_results_table.php
    mkdir -p "output/$suitename/$sec" && cp output/results.orm.log "output/$suitename/$sec/"
  done
done

