IrcBotBundle
============

[![Build Status](https://secure.travis-ci.org/whisller/IrcBotBundle.png)](http://travis-ci.org/whisller/IrcBotBundle)

## Installation

1. Download IrcBotBundle
2. Enable the bundle
3. Configure server, user
4. Launch the IrcBot!

### Step 1: Download IrcBotBundle

```js
{
    "require": {
        "whisller/irc-bot-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update whisller/irc-bot-bundle
```

Composer will install the bundle to your project's `vendor/whisller` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Whisnet\IrcBotBundle\WhisnetIrcBotBundle(),
    );
}
```

### Step 3: Configure server, user

Basic configuration:
```yaml
whisnet_irc_bot:
  user: ~
  channels: ["#test-irc"]
```

Advanced configuration:
```yaml
whisnet_irc_bot:
    host: irc.freenode.net
    port: 6667
    command_prefix: !bot
    user:
        username: IrcBotBundle
        hostname: example.com
        realname: IrcBotBundle
        servername: IrcBotBundle
    channels: ["#test-irc", "#test-other-irc"]
```

### Step 4: Launch the IrcBot!
``` bash
$ php app/console irc:launch
```

## Write your own bot's command.

1. Write listener
2. Register your listener
3. Use your command

When you want to write your own command it is really simple, because IrcBotBundle is working on Event Dispatcher.

So one thing you need to do is catch command event, and handle it.

Best way to learn something is to see how does it work. So lets write simple command, which will be saying "Hi {user}!"

### Step 1: Write listener

```php
<?php
namespace Acme\EventListener;

use Whisnet\IrcBotBundle\EventListener\Plugins\BasePluginListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Annotations as ircbot;

/**
 * @ircbot\CommandInfo(name="hello", help="Say hello to user", arguments={"<username>"})
 */
class HelloListener extends BasePluginListener
{
    public function onCommand(BotCommandFoundEvent $event)
    {
        // get list of arguments passed after command
        $args = $event->getArguments();

        $msg = 'Hi, '.(isset($args[0]) ? $args[0] : 'nobody').' !';

        // write to the current channel
        $this->sendMessage($event, array($event->getChannel()), $msg);
    }
}
```

### Step 2: Register your listener
In this example we're using xml format, but you can do it in your yaml file instead.

```xml
<service id="whisnet_irc_bot.bot_command_hello_listener" class="Acme\EventListener\HelloListener">
    <tag name="whisnet_irc_bot.bot_command"/>
    <tag name="kernel.event_listener" event="whisnet_irc_bot.bot_command_hello" method="onCommand"/>
</service>
```

As you can see event name is "whisnet_irc_bot.bot_command_hello", bundle is listening on PRIVMSG message from server, then
searching in it for string defined in "whisnet_irc_bot.command_prefix".

If the "whisnet_irc_bot.command_prefix" string gonna by found, then bundle is trying to parse everything after it to read command name and arguments for pass to "BotCommandFoundEvent".

E.g. "!bot hello whisller" will be parsed as:

- command: "hello"
- arg_0: "whisller"

And then it trigger an event "whisnet_irc_bot.bot_command_hello".

### Step 3: Use your command

```bash
!bot hello whisller
```