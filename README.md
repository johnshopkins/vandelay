Vandelay
========

A simple options importer/exporter plugin for WordPress. Settings currently available for import/export are:

* [WordPress options](http://codex.wordpress.org/Options_API)
* [Advanced Custom Fields](http://www.advancedcustomfields.com/) field groups

## Why?

When you're developing WordPress across multiple environments, it's important to manage the options. This is an attempt to keep options in sync across environments.

## Setup

1. Install and activate the plugin on all environments whose settings need to be synced.
1. Go to Settings > Vandelay on each environment and enter the directory in which to keep configuration (should be the same in all environments). This is the directory in which Vandelay saves exported options and looks for options to import.
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

## Which option?

Below is a table explaining which WordPress options make up the categories in Vandelay.


| Category       | WordPress Options  |
| ---------------|--------------------|
| __General__    |
| Date/Time      | gmt_offset<br>date_format<br>start_of_week<br>timezone_string<br>time_format |
| Environment    | home<br>site_url |
| Site Settings  | admin_email<br>blogdescription<br>blogname<br>blog_charset<br>html_type |
| Users          | default_role<br>users_can_register<br>wp_user_roles |
| Cron           | cron |
| __Widgets__    |
| General        | sidebars_widgets |
| WordPress      | widget_archives<br>widget_categories<br>widget_meta<br>widget_recent-comments<br>widget_recent-posts<br>widget_rss<br>widget_search<br>widget_text |
| Dashboard      | dashboard_widget_options |
| __Discussion__ |
| Comments       | blacklist_keys<br>close_comments_days_old<br>close_comments_for_old_posts<br>comments_notify<br>comments_per_page<br>comment_max_links<br>comment_moderation<br>comment_order<br>comment_registration<br>comment_whitelist<br>default_comments_page<br>default_comment_status<br>default_ping_status<br>moderation_keys<br>moderation_notify<br>page_comments<br>require_name_email<br>thread_comments<br>thread_comments_depth<br>use_trackback |
| Avatars        | avatar_default<br>avatar_rating<br>show_avatars |
| __Writing__    |
| General        | default_category<br>ping_sites<br>use_balanceTags<br>use_smilies<br>sticky_posts |
| Post via Email | mailserver_login<br>mailserver_pass<br>mailserver_port<br>mailserver_url<br>default_email_category |
| __Other__      |
| Permalinks     | category_base<br>permalink_structure<br>tag_base |
| Plugins        | active_plugins<br>uninstall_plugins |
| Themes         | stylesheet<br>template<br>default_post_format |
| Blogroll       | links_recently_updated_append<br>links_recently_updated_prepend<br>links_recently_updated_time<br>links_updated_date_format<br>link_manager_enabled |
| Media          | large_size_h<br>large_size_w<br>medium_size_h<br>medium_size_w<br>thumbnail_crop<br>thumbnail_size_h<br>thumbnail_size_w<br>uploads_use_yearmonth_folders<br>upload_path<br>upload_url_path<br>image_default_align<br>image_default_link_type<br>image_default_size |
| Reading        | blog_public<br>default_pingback_flag<br>posts_per_page<br>posts_per_rss<br>rss_use_excerpt<br>show_on_front<br>page_on_front<br>page_for_posts |
