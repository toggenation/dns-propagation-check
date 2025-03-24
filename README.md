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


## Check for name server change

If you are migrating domains to a new provider or changing nameservers run `composer ns domain-to-check new-nameserver` e.g.

```sh
composer ns toggen.com.au ns1.namesever.net.au

#output
> Toggenation\DnsPropagationCheck\DnsPropagationCheck::dnsPropagationCheck
DNS still heather.ns.cloudflare.com & rayden.ns.cloudflare.com for toggen.com.au


composer ns toggen.com.au ns1.namesever.net.au
#output
> Toggenation\DnsPropagationCheck\DnsPropagationCheck::dnsPropagationCheck
DNS has changed to ns1.namesever.net.au for toggen.com.au

```
Add to crontab.  Check at 9AM and 4PM
```sh
# no email STDERR & STDOUT piped to null
0 9,16 * * * composer -d /path/to/dns-propagation-check ns > /dev/null 2>&1

# with email only good output STDOUT
0 9,16 * * * composer -d /path/to/dns-propagation-check ns 2> /dev/null

# with email STDERR and STDOUT
0 9,16 * * * composer -d /path/to/dns-propagation-check ns 
```