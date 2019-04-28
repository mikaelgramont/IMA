# IMA

## Installation
Install php composer globally, and from the `php` directory, run `composer install`.

Copy `php/config.php.template` to `php/config.php` and give all constants a value.

Copy your Google API client secret into `php/client_secret.json`.

The following folders need to be writable by the server, and by other manual process run from `bin` or through cron jobs:
* `php/.credentials/` - OAuth information. Necessary to connect to the Google APIs.
* `php/cache` - Filesystem-based cache location (using Stash)
* `pages/generated` - Machine-generated HTML chunks (results and events).
* `logs` - server log files.
* The newsletter cache file (see the `NEWSLETTER_CONTENT_CACHE_PATH` constant).


On top of that, should cron jobs execute the shell scripts in `bin`, the `logs` folder will need to be writable by the cron user as well.

Go to `bin`. Make `initial-setup.php` executable and run it or do `php initial-setup.php`. This will generate and save the necessary OAuth tokens.
Further token updates will be managed directly by the Google client code.

## Generating the data
Until there is a web-based interface for generating results and events HTML, from the `binz directory, you can run `./parse-results.php` and `./parse-events.php`


## Registration form Translations
Run `npm run extract-translations` to extract calls to translation functions from js and jsx files.
Those calls get compiled into `./translations/template.pot`

Perform translations through POEdit or some other means, so that finished translation files are in the same folder (`./translations/[lang].po)

Run `npm run parse-translations` to generate JSON files which can then be loaded into the app during server-side rendering.