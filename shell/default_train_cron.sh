#!/bin/bash
cd "$(dirname "$0")"

echo $(pwd)

eval $(cat ../.env | sed 's/^/export /')

#dev instance up screen  http://colah.github.io/posts/2015-08-Understanding-LSTMs/
if ! screen -list | grep -q "train"; then
    screen -d -m -S train bash -c "python ../train.py --data_dir ../data/$DEFAULT_TRAIN_DATA --save_dir ../models/$DEFAULT_TRAIN_MODEL --save_every 5000"
else
    echo "train is active"
fi