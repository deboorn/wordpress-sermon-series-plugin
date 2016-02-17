
WordPress Sermon Series Plugin
==============

A audio/video sermon series plugin for WordPress designed to allow church staff to easily add sermon series and sermon media to their websites. Plug-n-play with easy shortcodes for embeding series index, current series and more. Designed from the need to have a SEO friendly, super simple sermon series plugin with a dedicated watch video page and JSON feed output.

Need Support? Drop me a line at daniel.boorn@gmail.com

### Plugin Features
---
- Responsive & Searchable Sermon Series Index
- Responsive Watch Sermon Page
- Shortcodes to current series
- Manage sermon series via control panel
- Upload series information
- Upload sermon MP3 & embed sermon video
- JSON sermon feed output
- License: Creative Commons Attribution-NonCommercial 3.0 Unported (CC BY-NC 3.0)
- Need a different license? Drop me a line at daniel.boorn@gmail.com



### Getting Started
---

> Requires knowledge of how to use shortcodes in WordPress.

> Installation -- Download plugin zip file > WP Admin > Plugins > Add New > Upload > Activate

> Adding Sermons/Series -- WP Admin > Sermon Series

### How to Use Plugin & Shortcodes
---

#### Step 1 of 2: 
> Place this shortcode on page to display searchable list of series.

> Attribute `sermonpageurl` should contain a the page URL to the sermon page (required).

> Attribute `columns` should contain number of columns. A value of 1 or 2 or 3 is supported.

> Attribute `limit` should contain the max amount of series to display (newest displayed first).

```
[sermonplugin_series_index sermonpageurl="url-to-sermon-page" columns="1|2|3" limit="100"] 
```
#### Step 2 of 2: 

> Place this shortcode on page to load sermon when linked from series index short code above
```
[sermonplugin_watch_sermon] 
```

#### Optional Shortcode: Current Series:
> Place this shortcode on any page to display current series linked to watch sermon page.

> Attribute `sermonpageurl` should contain a the page URL to the sermon page (required).

```
[sermonplugin_current_series sermonpageurl="url-to-sermon-page"]
```

#### Optional Link: Current Series:
> Optional: Link to Current Series url-to-sermon-page/?series=current

>  Add `series=current` to watch sermon page URL.

> Where url-to-sermon-page is the URL to your WP sermon page.

### Plugin Development
---
This plugin uses a Object Oriented Model View Controller design. Knowledge of OO PHP is required for modification. This plugin is designed for modern PHP 5.3+. However, it may function on older versions. We have no intention of supporting older (less secure) versions of PHP.

Sermon Series WordPress Plugin MVC Layout:
```
     - /assets/* (public css, fonts, js and install SQL)
     - /views/admin/* (administration template files used by controllers)
     - /views/* (front end template files used by controllers)
     - /classes/controllers/* (front controllers)
     - /classes/controllers/admin/* (admin controllers)
     - /classes/models/* (database table models)
     - /classes/tables/* (admin panel table classes)
     - /classes/input.php (handles all input sanitizing for plugin)
     - /classes/model.php (base model class, extended by plugin models)
     - /classes/router.php (handles application MVC routing)
     - /classes/table.php (base table class, extended by plugin tables)
```

Need Support? Drop me a line at daniel.boorn@gmail.com
