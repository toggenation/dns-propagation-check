# PHP DNS Propagation Check

1. Clone this repo
2. run `composer dumpautoload`
2. Add the hosts you want to check to `hosts.php`

```php

<?php
// fill this array with the hosts to check
return  ['lisaspallete.com', 'toggen.com.au'];

```

4. Run it

```sh

composer -d /home/ja/dev/dns-propagation-check check
> Toggenation\DnsPropagationCheck\DnsPropagationCheck::execute
NS for lisaspalette.com NOT found
A for lisaspalette.com NOT found
AAAA for lisaspalette.com NOT found
NS for toggen.com.au found
A for toggen.com.au found
AAAA for toggen.com.au found

```

