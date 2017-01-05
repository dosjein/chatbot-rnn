
if ! screen -list | grep -q "expected"; then
    screen -d -m -S expected bash -c './inout.sh'
else
    echo "expected is active"
fi


if ! screen -list | grep -q "chuck"; then
    screen -d -m -S chuck bash -c 'while true; do  php input.php ; sleep 45 ; done'
else
    echo "chuck is active"
fi

if ! screen -list | grep -q "slackinform"; then
    screen -d -m -S slackinform bash -c 'while true; do  ./slacksend.sh ; sleep 5 ; done'
else
    echo "slackinform is active"
fi