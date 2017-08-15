# IMA

## Installation
Copy `php/config.php.template` to `php/config.php` and give all constants a value.

Copy your Google API client secret into `php/client_secret.json`.

The following folders need to be writable by the server, and by other manual process run from `bin` or through cron jobs:
* `php/.credentials/` - OAuth information. Necessary to connect to the Google APIs.
* `php/cache` - Filesystem-based cache location (using Stash)
* `pages/generated` - Machine-generated HTML chunks (results and events).
* `logs` - server log files.

Go to `bin`. Make `initial-setup.php` executable and run it or do `php initial-setup.php`. This will generate and save the necessary OAuth tokens.
Further token updates will be managed directly by the Google client code.