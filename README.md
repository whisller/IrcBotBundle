IrcBotBundle
============

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