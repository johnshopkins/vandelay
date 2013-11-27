Vandelay
========

A simple options importer/exporter plugin for WordPress. Settings currently available for import/export are:

* [WordPress options](http://codex.wordpress.org/Options_API)
* [Advanced Custom Fields](http://www.advancedcustomfields.com/) field groups

## Why?

When you're developing WordPress across multiple environments, it's important to manage the options. This is an attempt to keep options in sync across environments.

## Setup

1. Install and activate the plugin on all environments whose settings need to be synced.
1. Go to Settings > Vandelay on each environment and make sure the directory in which to keep configuration files is the same. This is the directory in which Vandelay saves exported options and looks for options to import.
1. Go to Settings > Vandelay on whichever environment you will be exporting settings from (probably your development environment) and check which settings you want to export.


## Usage

### Export

Data is exported to the directory set in the admin as JSON.

```bash
# Export WordPress options selected in admin
wp vandelay export options

# Export Advanced Custom Fields field groups
wp vandelay export acf
```

### Import

Data is imported from JSON files into the database.

```bash
# Import WordPress options selected in admin
wp vandelay import options

# Import Advanced Custom Fields field groups
wp vandelay import acf
```
