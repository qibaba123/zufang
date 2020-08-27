#!/bin/sh
#
# An example hook script for the "post-receive" event.
#
# The "post-receive" script is run after receive-pack has accepted a pack
# and the repository has been updated.  It is passed arguments in through
# stdin in the form
#  <oldrev> <newrev> <refname>
# For example:
#  aa453216d1b3e49e7f6f98441fa56946ddcd6a20 68f7abf4e6f922807889f52bc043ecd31b79f814 refs/heads/master
#
# see contrib/hooks/ for a sample, or uncomment the next line and
# rename the file to "post-receive".

#. /usr/share/git-core/contrib/hooks/post-receive-email
NowPath=`pwd`
echo "now path is :"$NowPath

DeployPath="$1"
echo "deploy path is :"$DeployPath
cd $DeployPath
echo "cd deploy path"
git fetch origin
git pull
echo "deploy done"
cd $NowPath
echo "fine"

exit 0