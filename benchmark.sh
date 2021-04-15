base="http://172.17.15.4/fw"

declare -a sections
props(){
  i=0
  while IFS='=' read -d $'\n' -r k v; do
      if [[ $k == \[*] ]]
      then
          section=${k#*[}
          section=${section%]*}
          sections+=($section)
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





for f in ./suites/*; do
  sections=()
  props $f
  for s in "${!sections[@]}"; do
    sec=${sections[$s]}
    echo "**********************************************************************************"
    echo "                         Start Benchmarks for $sec"
    echo "**********************************************************************************"
    source ./benchmarks/orm.sh "$base" 10
    echo "**********************************************************************************"
    echo "                         End of Benchmarks for $sec, re-init"
    echo "**********************************************************************************"
    bash ./warmdown.sh
  done
done
