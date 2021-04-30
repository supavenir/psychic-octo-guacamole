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

testSuite(){
    sections=()
    props $1
    echo "=================================================================================="
    echo "                         Suite $1"
    echo "=================================================================================="
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
}

if [[ $# -eq 0 ]] ; then
  for f in ./suites/*; do
    testSuite $f
  done
else
  if [[ -f "$1" ]]; then
      testSuite $1
  fi
fi
