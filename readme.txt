=== IP2Location Country Blocker ===
Contributors: IP2Location
Donate link: http://www.ip2location.com
Tags: country blocker, targeted content, geolocation
Requires at least: 2.0
Tested up to: 4.2
Stable tag: 2.3.0

Description: IP2Location Country Blocker allows user to block visitors from accessing your frontend (the blog pages) or backend (the admin area) based on their country. Also log blocked access for statistic purpose.

== Description ==

IP2Location Country Blocker allows user to block visitors from accessing your frontend (the blog pages) or backend (the admin area) based on their country.

Key Features
* Allow you to redirect the users to a predefined page based on countries.
* Allow you to block multiple countries.
* Built with default 403 error page.
* Allow you to customize the 403 error page for each frontend and backend page.
* Support email notification if an user from blocked countries list was trying to access your admin page.
* Line chart for blocked pages and countries.

This plugin uses IP2Location BIN file for location queries that free your hassle from setting up the relational database. Moreover, IP2Location provides monthly BIN update for your download, so that you could have the latest and accurate query results.

BIN file download: [IP2Location Commercial database](http://ip2location.com "IP2Location commercial database") | [IP2Location LITE database](http://lite.ip2location.com "IP2Location LITE database")

= More Information =
Please visit us at [http://www.ip2location.com](http://www.ip2location.com "http://www.ip2location.com")

== Frequently Asked Questions ==
= Do I need to download the BIN file after the plugin installation? =
Yes, the plugin only provide you an outdated sample BIN file.

= Where can I download the BIN file? =
You can download the free LITE edition at [http://lite.ip2location.com](http://lite.ip2location.com "http://lite.ip2location.com") or commercial edition at [http://www.ip2location.com](http://www.ip2location.com "http://www.ip2location.com").

= Do I need to update the BIN file? =
We encourage you to update your BIN file every month so that your plugin works with the latest IP geolocation result. The update usually be ready on the 1st week of every calendar month.

= What is the frontend? =
The frontend means your blog pages.

= What is the backend? =
The backend means the wordpress admin pages.

= Can I select multiple countries for blocking? =
Yes, you can.

= Can I send an 403 page on blocked IP? =
Yes, you can use the default 403 provided in this plugin.

= Can I custom my own error page? =
Yes, you can create a new page on wordpress and design your own error display. Once completed, you can mark your error page as "private" and configure the error redirection at the setting page.

= Can I configure email notification if user was trying to access my admin page? =
Yes, you can configure email notification if an user from blocked countries list was trying to access your admin page.

= Unable to find your answer here? =
Send us email at support@ip2location.com

== Screenshots ==

1. **Country lookup by ip address** - Allow you to perform country lookup by entering a IP address.
2. **Frontend blocking** - Select countries that you would like to block from accessing your blog pages. Page redirection supported.
3. **Backend blocking** - Select countries that you would like to block the visitors from accessing your admin area (wp-login) page. Page redirection supported.
4. **Custom error page** - Custom your own error page to suit your wordpress theme.
5. **Email Alert** - Notify you with details when an user was trying to access your admin page.
6. **Statistic Page** - View blocked traffics and countries.


== Changelog ==

* 1.1.0 Added dropdown selection for product code.
* 1.2.0 Allow user to custom their own error page.
* 1.3.0 Move the configuration page to settings, to alleviate the confusion of setting page location.
* 1.4.0 Send email notification if an user from blocked countries was trying to access your backend page.
* 1.5.0 Support secret code to bypass backend validation.
* 1.6.0 Added user details in the email alert message.
* 1.7.0 Fixed download script errors.
* 1.8.0 Fixed the country display issue: South Georgia And The South Sandwich Islands
* 1.9.0 Added logic to verify if the default old sample bin used for checking.
* 1.9.1 Fixed performance issues.
* 1.9.2 Emergency bug fix.
* 2.0.0 Added IPv6 supports.
* 2.0.1 Fixed crash issue with other IP2Location plugins.
* 2.0.2 Updated redirection using javascript to rectify the not working issues reported under certain circumstances
* 2.0.3 Fixed redirection issue that may not work if additional header information defined by other plugins.
* 2.1.0 Added statistic to log blocked traffics.
* 2.2.0 Added IP2Location web service support. Minor layout changes, and code behind rewrote.
* 2.2.2 Fixed session issues.
* 2.2.2 Fixed blocking failed in backend area.
* 2.2.4 Fixed issue with Query IP. Prevent admin from blocking themselves in admin area.
* 2.2.5 Fixed issue with secret code to by pass blocking.
* 2.3.0 Fixed layout issue. Added warning if blocking own country.


== Installation ==

1. Create `ip2location-country-blocker` folder in the `/wp-content/plugins/` directory.
1. Upload `database.bin` to `/wp-content/ip2location-country-blocker/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. You can now start using IP2Location Country Blocker to block visitors.