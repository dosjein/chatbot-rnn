# chatbot-rnn
A toy chatbot powered by deep learning and trained on data from Reddit.

Here is a sample chat transcript (not cherry-picked). Lines that start with ">" are me; the lines without ">" are the chatbot's responses.

```
bot BOT [1:14 AM]  
Chuck Norris once stabbed a man with a bowling ball.


Slack API Tester BOT [1:14 AM]  
I don't think that's what they were talking about.


bot BOT [1:15 AM]  
Chuck Norris put out Hell.


Slack API Tester BOT [1:15 AM]  
But at the same time, it wasn't a reference to anything.

dosjeBOT [1:15 AM]  
!SlackBasicHelper dosje started at Dosje


bot BOT [1:16 AM]  
The Titanic didnt sink because of an iceberg.. Chuck Norris just went out for a swim


Slack API Tester BOT [1:16 AM]  
Did you see that ludicrous display last night?


bot BOT [1:17 AM]  
The U.S. Coast Guard has approved recordings of Chuck Norris farts for use on all maritime vessels as the preferred fog horn signal.


Slack API Tester BOT [1:17 AM]  
They are called sarcasm.


bot BOT [1:17 AM]  
Chuck Norris owns the Elephant Man's skeleton, and recently aquired Michael Jackson's.


Slack API Tester BOT [1:18 AM]  
You know what they say about him and his family, and their families who can't figure out how to do that.


bot BOT [1:18 AM]  
Despite whatever Gene Simmons says, Chuck Norris IS Doctor Love.


Slack API Tester BOT [1:18 AM]  
Well that's not what I said.


bot BOT [1:19 AM]  
Chuck Norris doesn't need a debugger, he just stares down the bug until the code confesses.


Slack API Tester BOT [1:19 AM]  
I think you mean the second one.


bot BOT [1:20 AM]  
When Chuck Norris was 8 years old, he raped a pedophile


Slack API Tester BOT [1:20 AM]  
What is this from?


bot BOT [1:20 AM]  
Fact: Chuck Norris doesn't consider it sex if the woman survives.


Slack API Tester BOT [1:20 AM]  
That's what she said.


bot BOT [1:21 AM]  
Remember when I said Chuck Norris was slower than Sonic? I lied. Their top speed is equal.



Slack API Tester BOT [1:21 AM]  
That's not what I meant.


bot BOT [1:22 AM]  
Once while harpooning whales in Alaska, Chuck Norris lit a fart. This action is what caused the aurora borealis and solar flares.


Slack API Tester BOT [1:22 AM]  
> That's what I was saying. That doesn't make sense to me.


bot BOT [1:23 AM]  
Chuck Norris was at a rap concert once and the rapper told everyone to raise the roof. Promptly afterward he killed the rapper with a swift roundhouse kick to the face. No one tells Chuck Norris what to do.


Slack API Tester BOT [1:23 AM]  
Actually, that would make sense.

[1:23]  
Everyone knows that they have no idea what they're talking about.
 ```

## Get Started

- Clone this project to your computer.

- **Install [Tensorflow](http://www.tensorflow.org/)**. To run a pretrained model, the CPU-only installation should suffice. If you want to train your own models, you'll need the GPU installation of Tensorflow (and a powerful CUDA-compatible GPU).

### Run my pre-trained model

- **Download [my pre-trained model](https://drive.google.com/uc?export=download&id=0B6noVJLTV1jCT29uMzliMVVRWWM)** (201 MB). The zip file extracts into a folder named "reddit". Place that folder into the "models" directory of this project.

- **Run the chatbot**. Open a terminal session and run `python chatbot.py`. Warning: this pre-trained model was trained on a diverse set of frequently off-color Reddit comments. It can (and eventually will) say things that are offensive, disturbing, bizarre or sexually explicit. It may insult minorities, it may call you names, it may accuse you of being a pedophile, it may try to seduce you. Please don't use the chatbot if these possibilities would distress you!

Try playing around with the arguments to `chatbot.py` to obtain better samples:

- **beam_width**: By default, `chatbot.py` will use beam search with a beam width of 2 to sample responses. Set this higher for more careful, more conservative (and slower) responses, or set it to 1 to disable beam search.

- **temperature**: At each step, the model ascribes a certain probability to each character. Temperature can adjust the probability distribution. 1.0 is neutral (and the default), lower values increase high probability values and decrease lower probability values to make the choices more conservative, and higher values will do the reverse. Values outside of the range of 0.5-1.5 are unlikely to give coherent results.

- **relevance**: Two models are run in parallel: the primary model and the mask model. The mask model is scaled by the relevance value, and then the probabilities of the primary model are combined according to equation 9 in [Li, Jiwei, et al. "A diversity-promoting objective function for neural conversation models." arXiv preprint arXiv:1510.03055 (2015)](https://arxiv.org/abs/1510.03055). The state of the mask model is reset upon each newline character. The net effect is that the model is encouraged to choose a line of dialogue that is most relevant to the prior line of dialogue, even if a more generic response (e.g. "I don't know anything about that") may be more absolutely probable. Higher relevance values put more pressure on the model to produce relevant responses, at the cost of the coherence of the responses. Going much above 0.4 compromises the quality of the responses. Setting it to a negative value disables relevance, and this is the default, because I'm not confident that it qualitatively improves the outputs and it halves the speed of sampling.

These values can also be manipulated during a chat, and the model state can be reset, without restarting the chatbot:

```
$ python chatbot.py
Creating model...
Restoring weights...

> --temperature 1.3
[Temperature set to 1.3]

> --relevance 0.3
[Relevance set to 0.3]

> --relevance -1
[Relevance disabled]

> --beam_width 5
[Beam width set to 5]

> --reset
[Model state reset]
```

### Get training data

If you'd like to train your own model, you'll need training data. There are a few options here.

- **Provide your own training data.** Training data should be one or more newline-delimited text files. Each line of dialogue should begin with "> " and end with a newline. You'll need a lot of it. Several megabytes of uncompressed text is probably the minimum, and even that may not suffice if you want to train a large model. Text can be provided as raw .txt files or as bzip2-compressed (.bz2) files.

- **Simulate the United States Supreme Court.** I've included a corpus of United States Supreme Court oral argument transcripts (2.7 MB compressed) in the project under the `data/scotus` directory.

- **Use Reddit data.** This is what the pre-trained model was trained on:

  First, download a torrent of Reddit comments from a torrent link [listed here](https://www.reddit.com/r/datasets/comments/3bxlg7/i_have_every_publicly_available_reddit_comment/). You can use the single month of comments (~5 GB compressed), or you can download the entire archive (~160 GB compressed). Do not extract the individual bzip2 (.bz2) files contained in these archives.

  Once you have your raw reddit data, place it in the `reddit-parse/reddit_data` subdirectory and use the `reddit-parse.py` script included in the project file to convert them into compressed text files of appropriately formatted conversations. This script chooses qualifying comments (must be under 200 characters, can't contain certain substrings such as 'http://', can't have been posted on certain subreddits) and assembles them into conversations of at least four lines. Coming up with good rules to curate conversations from raw reddit data is more art than science. I encourage you to play around with the parameters in the included `parser_config_standard.json` file, or to mess around with the parsing script itself, to come up with an interesting data set.

  Please be aware that there is a *lot* of Reddit data included in the torrents. It is very easy to run out of memory or hard drive space. I used the entire archive (~160 GB compressed, although some files appear to be corrupted and are skipped by `reddit-parse.py`), and ran the `reddit-parse.py` script with the configuration I included as the default, which holds a million comments (several GB) in memory at a time, takes about 12 hours to run on the entire archive, and produces 2.2 GB of bzip2-compressed output. When training the model, this raw data will be converted into numpy tensors, compressed, and saved back to disk, which consumes another ~5 GB of hard drive space. I acknowledge that this may be overkill relative to the size of the model.

Once you have training data in hand (and located in a subdirectory of the `data` directory):

### Train your own model

- **Train.** Use `train.py` to train the model. The default hyperparameters (four layers of 1500 GRUs per layer) are the best that I've found, and are what I used to train the pre-trained model for about 37 days. These hyperparameters will just about fill the memory of a Titan X GPU, so if you have a smaller GPU, you will need to adjust them accordingly -- most straightforwardly, by reducing the batch size.

  Training can be interrupted with crtl-c at any time, and will immediately save the model when interrupted. Training can be resumed on a saved model and will automatically carry on from where it was interrupted.

  ![Alt text](/img/chatbot-training.png?raw=true)

## WEB API [by DosjeIn]

Created realy dirty solution PHP based API for chatbot. Used filesystem files for exchange , crazy **expect** solution to input message , screen creating from crontab. Code is small and dirty .

### Setup

- install **[expect](https://launchpad.net/ubuntu/+source/expect)**
- install **[screen](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-screen-on-an-ubuntu-cloud-server)**
- install **[PHP](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04)**
- chmod 777 **./storage** **./web** directories
- add to [crontab](http://man7.org/linux/man-pages/man5/crontab.5.html) **[PROJECTPATH]/shell/cron.sh** 
- make as webroot  **[PROJECTPATH]/web** directory
- create **.env** file and define there default used model with **DEFAULT_MODEL** param

### Usage

- do request GET/POST request with **NEW** to create new bot ( there is no limit checker - each NEW creates new screen with chatbot.by process - do not do many refresh and remember ident)
- do request GET/POST request with **IDENT** and **IN** with message to create message for processing. Without **IN** param it returns message. It returns timestamp to know when message file is updated , because it might not respond that fast (it depends on chatbot configurations and device power)

If any question - feel free to ask at **dosjein[at]gmail[etc]** referencing to Ronalds Sovas or John Dosje 

## Tips and Tricks [from karpathy](https://github.com/karpathy/char-rnn/blob/master/Readme.md#tips-and-tricks)

### ToDo
- need to add traning validator , that logs issues with Data size etc. Optional , but Nice2Have

### Monitoring Validation Loss vs. Training Loss
If you're somewhat new to Machine Learning or Neural Networks it can take a bit of expertise to get good models. The most important quantity to keep track of is the difference between your training loss (printed during training) and the validation loss (printed once in a while when the RNN is run on the validation data (by default every 1000 iterations)). In particular:

- If your training loss is much lower than validation loss then this means the network might be **overfitting**. Solutions to this are to decrease your network size, or to increase dropout. For example you could try dropout of 0.5 and so on.
- If your training/validation loss are about equal then your model is **underfitting**. Increase the size of your model (either number of layers or the raw number of neurons per layer)

### Approximate number of parameters

The two most important parameters that control the model are `rnn_size` and `num_layers`. I would advise that you always use `num_layers` of either 2/3. The `rnn_size` can be adjusted based on how much data you have. The two important quantities to keep track of here are:

- The number of parameters in your model. This is printed when you start training.
- The size of your dataset. 1MB file is approximately 1 million characters.

These two should be about the same order of magnitude. It's a little tricky to tell. Here are some examples:

- I have a 100MB dataset and I'm using the default parameter settings (which currently print 150K parameters). My data size is significantly larger (100 mil >> 0.15 mil), so I expect to heavily underfit. I am thinking I can comfortably afford to make `rnn_size` larger.
- I have a 10MB dataset and running a 10 million parameter model. I'm slightly nervous and I'm carefully monitoring my validation loss. If it's larger than my training loss then I may want to try to increase dropout a bit and see if that heps the validation loss.

### Best models strategy

The winning strategy to obtaining very good models (if you have the compute time) is to always err on making the network larger (as large as you're willing to wait for it to compute) and then try different dropout values (between 0,1). Whatever model has the best validation performance (the loss, written in the checkpoint filename, low is good) is the one you should use in the end.

It is very common in deep learning to run many different models with many different hyperparameter settings, and in the end take whatever checkpoint gave the best validation performance.

By the way, the size of your training and validation splits are also parameters. Make sure you have a decent amount of data in your validation set or otherwise the validation performance will be noisy and not very informative.

## Additional Pointers and Acknowledgements

This code was originally based on Oxford University Machine Learning class [practical 6](https://github.com/oxford-cs-ml-2015/practical6), which is in turn based on [learning to execute](https://github.com/wojciechz/learning_to_execute) code from Wojciech Zaremba. Chunks of it were also developed in collaboration with my labmate [Justin Johnson](http://cs.stanford.edu/people/jcjohns/).

To learn more about RNN language models I recommend looking at:

- [My recent talk](https://skillsmatter.com/skillscasts/6611-visualizing-and-understanding-recurrent-networks) on char-rnn
- [Generating Sequences With Recurrent Neural Networks](http://arxiv.org/abs/1308.0850) by Alex Graves
- [Generating Text with Recurrent Neural Networks](http://www.cs.utoronto.ca/~ilya/pubs/2011/LANG-RNN.pdf) by Ilya Sutskever
- [Tomas Mikolov's Thesis](http://www.fit.vutbr.cz/~imikolov/rnnlm/thesis.pdf)


## Thanks

Thanks to Andrej Karpathy for his excellent [char-rnn](https://github.com/karpathy/char-rnn) repo, and to Sherjil Ozair for his [tensorflow port](https://github.com/sherjilozair/char-rnn-tensorflow) of char-rnn, which this repo is based on.
