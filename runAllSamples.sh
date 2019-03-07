find Samples -print | grep -i -e "\.php"    > list.txt
while IFS="" read -r p || [ -n "$p" ]
do
  printf '\nRUNNING - %s\n ' "$p"
  php "$p"
done < list.txt