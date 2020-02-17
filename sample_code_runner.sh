#!/bin/bash
FILECOUNT=0
find Samples -print | grep -i -e "\.php$"    > list.txt

echo > output.log

set -e 
while IFS="" read -r p || [ -n "$p" ]
do
  if [[ "$p" =~ $(echo ^\($(sed 's/[[:blank:]]//g' sample_code_ignore_list.txt | paste -sd '|' /dev/stdin)\)$) ]]; then
    printf '\n\n#### SKIPPED - %s ####\n' "$p"
	printf '\n\n#### SKIPPED - %s ####\n' "$p" >> output.log
  else
    printf '\n\n**** RUNNING - %s ****\n' "$p"
	printf '\n\n**** RUNNING - %s ****\n' "$p" >> output.log
    php "$p"	>> output.log
    printf '\n\n**** END RUNNING - %s ****\n' "$p" >> output.log
	FILECOUNT=$((FILECOUNT+1))
  fi
done < list.txt
printf '\n\n**** %s Sample Codes ran successfully ****\n' "$FILECOUNT"
printf '\n\n**** %s Sample Codes ran successfully ****\n' "$FILECOUNT" >> output.log
rm -f list.txt