=== Keyword Landing Page Generator (Free) ===
Contributors: citywanderer, stubgo
Tags: WPSOS,landing page,landing pages,ads,google ads,landing page customization,keyword,keywords,shortcodes,adwords,bing,targeted landing page,targeted landing pages,conversion,conversions,conversion optimization,optimization
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: 1.01
License: GPL2 or later

Allows you to have one landing page, with different versions depending on the keyword -- so you can show each visitor a customized version of it!

== Description ==

It's a common problem of marketers that you'd like to show different versions of a landing page to a user according to what they are looking for -- one for people looking for a "cheap" product, one for people looking for the product delivered "fast," and one for people looking for a "high quality" version of the product, for example. Or if you want to have separate pages for people searching for red, green, or blue versions of your product. The possibilities are endless!

Until now, the only solution was to create hundreds of different landing pages -- not only is this very time-consuming but, if you want to update them, it turns into a nightmare!

The solution? The Keyword Landing Page Generator. This premium plugin lets you have one landing page, but actually have three (or three-thousand!) unique pages on WordPress to drive traffic to, each one customized for that target market.

Each page has a unique URL that is SEO friendly -- and very easy to modify, individually or all at once. You could have Google-friendly URLs such as: /intro/cheap/ and /intro/fast/ and /intro/high-quality/ in the above example -- and an unlimited number. The pages displayed would be the same to all -- except at the points in which you define, where the headline text or image or any other component or components (as few or as many as you like) would change according to the rules, definitions, and text you've defined in the easy-to-use plugin configuration.

Free plugin options include:

*   Getting started in one click
*	2 HTML sections on your Landing Page to configure
*	3 variations of your Landing Page (Default + 2 custom)
*	Detailed instructions with examples for configuring the Landing Page
*	Instructions about actions/filters for developers

Premium plugin options:

*	Getting started in one click
*   Unlimited HTML sections on your Landing Page to configure
*	Unlimited variations of your Landing Page
*	Detailed instructions with examples for configuring the Landing Page
*	Instructions about actions/filters for developers
*	Premium Support

For more information and support, check out: http://www.wpsos.io/wordpress-plugin-keyword-landing-page-generator/

== Installation ==

The installation is very straightforward. You should:

1. Upload the folder 'keyword-landing-page-generator' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the WordPress admin UI, there will be a new menu link created, called 'LP Generator'

== Which options do you modify? ==

You can choose between the following options.

= General Settings tab =
1. Landing Page Template page. This is the page that displays the varying Landing Page contents according to the keyword. It can be content from the WordPress page editor, custom HTML content, or custom WordPress template content.
2. Templating system. You can choose either 1.) to display custom HTML (which you'll have to fill in in the next field) or 2,) To use WordPress templating system.
3. Custom HTML. This is the custom HTML that will be displayed in case you chose that option.

= Keywords tab =
1. Manage landing page shortcodes. Here are the existing Shortcode Keys with the shortcodes you can use. You can remove the shortcodes, or add a new one (explained in the next point).

2. Add a new Shortcode Key. Here, you should can a new Shortcode Key for each unit of text that you would like to change on the landing page for visitors who come to the triggered version. For example, for anyone who comes to one of the pages, if you want the headline to be different, the sub-headline, and and the main image shown to be different -- then, define three shortcode variables here. You can call them anything you like (using the standard alphanumeric characters), for example 'headline', 'sub-headline', and 'main-image'.

3. Add a new Triggering Keyword. The Triggering Keyword will be the phrase in the URL itself. There are a few sample ones created by default with the plugin installation, but you can create one yourself. If you create a Triggering Keyword called "Blue" just for people searching for your product in blue, then, this will automatically create a page on the site: /your-landing-page/blue/, using the template that you set under General Settings tab. Do the same for each Triggering Keyword you would like to have a unique landing page created for.

4. Change existing Triggering Keywords. For each Triggering Keyword, you will see in this section the Shortcode Keys corresponding to that Triggering Keyword. You can fill them in with the appropriate content you want. So, for example, if you have a Shortcode Key called "headline", and you have a Triggering Keyword "blue", then -- for anyone who goes to /your-landing-page/blue/, write in here the text they will see for the headline. That's it.

= For Developers tab =

Here are the instructions and guidelines for those who want to create their own WordPress template in PHP.

= Filters and Actions =
You can use the following filters:
1. 'wpsos_klpg_shortcode_text' - filters the shortcode text value right before displaying.
2. 'wpsos_klpg_custom_content' - filters the custom HTML text configured from General Settings right before displaying to the user.

You can use the following actions:
1. 'wpsos_klpg_before_custom_content' - before displaying the custom HTML text configured from General Settings for the user.
2. 'wpsos_klpg_after_custom_content' - after displaying the custom HTML text configured from General Settings for the user.
3. 'wpsos_klpg_before_settings_page' - before displaying the settings page in admin UI.
4.	'wpsos_klpg_after_settings_page' - after displaying the settings page in admin UI.

= Using your custom PHP template =
If you prefer using a custom WordPress template for using the Triggering Keywords and their values, here is the way to go:

1. Create a WordPress template file under your theme.
2. Load the existing Shortcode Keys and their values into a array. For that, you can use the global object $WPSOS_KLPG and it's class method 'get_keyword_values'. The class method takes one parameter, the keyword. The keyword is accessible via the query_var called 'wpsos_mkey'.
3. Using the received array, you can display the values of the Triggering Keyword from the URL, with the Shortcode Keys as the array keys, configured under the Shortcodes Settings.
4. Create a page and choose the new template for the created page.
5. Flush the permalinks by going to the Permalinks settings and clicking 'Save'

== Frequently Asked Questions ==

= I chose a Landing Page from the General Settings, but it's not working. What should I do? =

Make sure that you:
- added the shortcodes to the page content.
- added a Triggering Keyword to the URL when testing. For example if you have a keyword 'blue', then try http://your-example-website.com/your-landing-page/blue
- have chosen the option 'Post Name' under Common Settings of the Permalinks settings

If this is all done, flush the permalinks by going to the Permalinks settings and clicking 'Save'.

= The shortcodes worked, but after I changed the Landing Page's name and slug, they stopped working. =

Please flush the permalinks by going to WordPress Settings -> Permalinks and clicking 'Save'.

= Where can I get some support? =

Check out our site, at: http://www.wpsos.io/plugin-support/

= I have some suggestions for other options I want edited =

Let us know, via: http://www.wpsos.io/plugin-support/

== Screenshots ==

1. General Settings page
2. Shortcode Settings page
3. Triggering Keywords Settings page (collapsed table)
4. Triggering Keywords Settings page (expanded table)
5. Sample content for a landing page
6. Sample Landing Page

== Changelog ==

= 1.01 =
* Initial version.
