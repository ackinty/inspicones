# Get the icons package, thx to games-icons.net
wget http://game-icons.net/archives/svg/zip/ffffff/000000/game-icons.net.svg.zip
unzip game-icons.net.svg.zip

# Create firstlevel dirs (readability)
for i in `ls -d icons/*` ; do mkdir `basename $i` ; done

# Move svg icons in firstlevel directory
for i in `find . -name "*.svg"`; do mv $i `echo $i | sed -e "s#\./icons/\([^/]*\).*/\([^/]*\.svg\)#./\1/\2#"` ; done

# Delete temporary files
# rm -rf game-icons.net.svg.zip icons/
