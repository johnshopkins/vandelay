Vandelay
========

A simple options importer/exporter plugin for WordPress.

## Why?

When you're developing WordPress across multiple environments, it's important to manage the options. This is an attempt to keep options in sync across environments.

## Usage

Settings available for export/import are:

* [WordPress options](http://codex.wordpress.org/Options_API)
* [Advanced Custom Fields](http://www.advancedcustomfields.com/) field groups

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