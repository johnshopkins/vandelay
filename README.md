Vandelay
========

An [Advanced Custom Fields](http://www.advancedcustomfields.com/) field groups importer/exporter plugin for WordPress.

## Setup

1. Install and activate the plugin on all environments whose settings need to be synced.
1. Set the file in which settings are saved on each environment (often the same location). Example:

```php
define('VANDELAY_CONFIG_FILE', '/var/www/html/config/acf.json');
```


## Usage

### Export

```bash
wp vandelay export
```

### Import

```bash
wp vandelay import
```
