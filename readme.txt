=== Content Reveal ===
Contributors: dartiss
Tags: accordion, concertina, hide, reveal, show, slide, toggle, collapse, visibility, menu
Requires at least: 4.6
Tested up to: 4.9
Requires PHP: 5.3
Stable tag: 2.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Content Reveal allows you to easily hide and reveal WordPress content, whether it's in the sidebar or in a post or page.

== Description ==

Content Reveal allows you to easily hide and reveal WordPress content, whether it's in the sidebar or in a post or page.

After searching for a method to hide content on our own site's sidebar we found that most of the solutions involved using widgets (which often provide less functionality compared to their direct function call equivalents). As well, they often make use of Scriptaculous, jQuery or mooTools to provide effects, but often add complexity and bloat.

We therefore wrote Content Reveal - it doesn't use any fancy effects, just some simple JavaScript. And it doesn't use widgets. A click on a heading causes content below to hide or reveal itself. You can add a button image too to indicate what state it is in (collapsed or revealed).

Key features include...

* Individual content states are saved via cookies (switchable via an options screen)
* URL and parameter options to override cookie options
* Ability to specify own icons for collapsing/revealing content
* Title can change too depending on current content state
* Graceful "fallback" if the visitor doesn't have JavaScript switched on - all text is revealed and any button images are removed
* Option to show title separately
* Additional shortcode to output cookie storage length - useful for adding to a cookie policy document
* Support for Do Not Track
* And much, much more!

Technical specification...

* Licensed under [GPLv2 (or later)](http://wordpress.org/about/gpl/ "GNU General Public License")
* Designed for both single and multi-site installations
* PHP7 compatible
* Fully internationalized, ready for translations. **If you would like to add a translation to this plugin then please head to our [Translating WordPress](https://translate.wordpress.org/projects/wp-plugins/simple-content-reveal "Translating WordPress") page**

Please visit the [Github page](https://github.com/dartiss/content-reveal "Github") for the latest code development, planned enhancements and known issues.

== Using the Short Code ==

The short code is `[reveal]` and it can be used in one of two ways - either using the shortcode twice or by closing it, as usual. For example...

`[reveal heading="<h2>%image% Some Blah Content Below</h2>" id="id1"]Blah, blah, blah content here[reveal]`

Or you can specify it as...

`[reveal heading="<h2>%image% Some Blah Content Below</h2>" id="id1"]Blah, blah, blah content here[/reveal]`

The following parameters are valid...

* *heading* - This is the heading that you click on to hide/reveal the content below. It can contain HTML. If you wish a button image to appear within the heading then you need to add `%image%` within the heading, where you wish it to appear. A default button is included with the plugin, but this can be overridden using further parameters. Additionally, if you wish the heading text to change as the content is hidden or revealed then you can specify the title text as `%title%`. There are 2 further parameters where you then specify the 2 pieces of text.
* *id* - You can have multiple reveals on the same page but each needs its own unique ID - keep this short.
* *default* - Do you want the content to be hidden or shown by default? Specify `hide` or `show` to indicate (default is `hide`, although you can change this in the options screen).
* *folder* - If you wish to supply your own images you can specify your own folder here - see the appropriate section below for more details. The old parameter of `img_url` can still be used.
* *ext* - Use this to specify whether you wish to use PNG or GIF images.
* *cookie* - How many hours to retain the cookie for - see the instructions on cookies for further assistance.
* *title1* - If you wish to switch the title text, dependent on states, then this is the text that appears when the text is hidden.
* *title2* - This is the text that will appear when the text is shown.

Important: Make sure you add this using the html/code editor in WordPress, not the visual editor. If you use the visual editor it will not work, as the actual code you entered will be seen on the page, instead of being processed by the script.

== Embedding content reveal within another ==

It is possible to add one content reveal section within another. Here is an example of how to do this - note the use of the end tags to achieve this.

`[reveal heading="<h2>%image% Some Blah Content Below</h2>" id="id1"]Blah, blah, blah content here[reveal heading="<h3>%image% Some More Blah Content Below</h2>" id="id2"]Blah, blah, blah more content here[reveal][/reveal]`

== Change the default icons ==

The parameter `folder` may be used to specify a different folder in which you can add your icons. The icons must be named image1 and image2 and can be either .gif or .png images.

You can either specify a full URL or a folder name. In the latter case, it will be assumed the folder is within `wp-content/uploads/content-reveal/`. The advantage of the latter is that images in this folder will be omitted from Jetpack's Photon function - please see the next section for details on this.

== Use of Photon ==

If you use Photon, which is part of Jetpack, to cache your images then you may find it breaks the images used by this plugin - this is because of the way we use JavaScript to dynamically modify the URL.

The default icons are automatically omitted from Photon and also any icons added to `wp-content/uploads/content-reveal/`. If you provide icons from any other folder and use Photon then you may find they don't display correctly.

== Show title separately ==

If you wish to show the title separately from the hidden/reveal text then an alternative shortcode is available, named `reveal_link`. It uses the same parameters as before.

To get this to work you must specify your text as usual BUT give it a heading of "noheading". For example...

`[reveal heading="noheading" id="id1"]Blah, blah, blah content here[/reveal]
[reveal_link heading="<h2>%image% Some Blah Content Below</h2>" id="id1"]`

This is the same example as previously uses BUT the text to hide/reveal appears BEFORE the title.

In previous use the ID does not need to be specified - if it isn't, one will be generated automatically. However, for this method to use both IDs must match and, hence, you must specify them.

**Note:** WordPress does not support square brackets in shortcode parameters so you cannot, for instance, use square brackets in the title when using the shortcode option. This is [a limitation of WordPress](http://codex.wordpress.org/Shortcode_API#Square_Brackets "Square Brackets") and not this plugin.

== URL parameter to change the default state ==

A URL parameter named `acr_state` can be used to override all content on the page which uses this plugin. There are 3 possible values - `show`, `hide` or `off`. The latter will cause the plugin to output as if it wasn't active - all content will be shown and toggle images will be suppressed.

== Cookies ==

A JavaScript cookie can be used to remember the last state a user had some content in. This option is switched off by default.

In the Administration menu you should find an option under "Settings" named "Content Reveal". Within here you can switch the cookies on and state how long they should be stored for.

Additionally, you can control cookies on a case-by-case basis via a new parameter named `cookie`. The value should be set to the number of hours you wish the state to be stored for. To switch cookies off, specify this as zero. For example, with the shortcode you may put...

`[reveal heading="<h2>%image% Some Blah Content Below</h2>" id="id1" cookie="3"]Blah, blah, blah content here[reveal]`

This would save the cookie for 3 hours.

To assist with [recent ICO regulation](http://www.ico.gov.uk/for_organisations/privacy_and_electronic_communications/~/media/documents/library/Privacy_and_electronic/Practical_application/advice_on_the_new_cookies_regulations.pdf "Advice on the new cookies Regulations") in the UK with regard to cookies a number of additional features exist...

1. Setting the cookie time to zero will cause any existing cookies to be deleted and no cookies will be created
2. All cookies for this plugin can be overridden for a page via the URL. Simply append a parameter of `acr_cookies=` to the URL, followed by the number of hours (0 to switch off). e.g. for my site a URL of `artiss.blog?acr_cookies=0` would cause all the current user's cookies for this plugin to be deleted
3. So that you can display how long cookies are stored for, say on a cookie policy page, a new shortcode of `[acr_cookies]` exists. An example of output may be `7 days`

The cookie is named `content_reveal_x`, where `x` is the ID of the given content section.

== Other Settings ==

As previously mentioned in the Administration menu there is an option under "Settings" named "Content Reveal". Apart from the cookie settings, you can also set the default state for showing or hiding content. You can also decide whether to switch on or off the editor button - this is an additional button that appears in the visual editor and, when pressed, creates a default example of the shortcode.

== Reviews & Mentions ==

[Using Simple Content Reveal to report changes to the factual content of articles](http://caramboo.com/2011/02/post-reporting-i/ "Post Reporting I")

[Example usage on the Beat Struggles website](http://beatstruggles.com/scripture-of-the-week/ "Scriptures Of The Week")

== Installation ==

Content Reveal can be found and installed via the Plugin menu within WordPress administration (Plugins -> Add New). Alternatively, it can be downloaded from WordPress.org and installed manually...

1. Upload the entire `simple-content-reveal` folder to your `wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress administration.

Voila! It's ready to go.

== Frequently Asked Questions ==

= I can't get a shortcode within the Content Reveal shortcode to work =

Sorry, shortcodes within the hide/show text cannot be processed.

= The output doesn't validate correctly =

This will probably be if you are generating your output using the shortcode.

Usually, JavaScript generating HTML will cause errors, so you can use CDATA instead to suppress this. However, WordPress (for fuzzy reasons) modifies the CDATA command so that it no longer works.

However, [this is under investigation](http://core.trac.wordpress.org/ticket/3670 "Removing CDATA close tag unbalances the CDATA block") and, it is hoped, will be fixed in WordPress in the future. When this happens I'll be able to update this plugin to use CDATA and to play nicely with validators.

= The links to click on are appearing but clicking on them doesn't do anything =

Check in your Writing settings in Administration that you don't have "WordPress should correct invalidly nested XHTML automatically" ticked, otherwise WordPress may incorrectly attempt to "fix" the output of the plugin.

= How can I get all the content to display so that it can be printed? =

Using the URL parameter `acr_state` you can re-display your page with all content hidden, revealed or with the plugin switched off. See Other Notes for further details.

= How do I add quotes to the heading? =

Because quotes (single or double) are used to specify the shortcode parameter - in this case the heading - you can't then use them use them for the heading text. Well, you can - whichever one you use for your shortcode parameter, you can use the other within your heading. So, this is fine...

`[reveal heading="<h2>%image% Some 'Blah' Content Below</h2>" id="id1"]Blah, blah, blah content here[reveal]`

As is this...

`[reveal heading='<h2>%image% Some "Blah" Content Below</h2>' id="id1"]Blah, blah, blah content here[reveal]`

Alternatively, particularly if you want to use both quote types within your heading, you can use ASCII instead. For example...

`[reveal heading="<h2>%image% \x27Single quotes\x27 \x22double quotes\x22</h2>" id="id1"]Blah, blah, blah content here[reveal]`

See a [full list of available ASCII codes](http://defindit.com/ascii.html "ascii Chart").

== Screenshots ==

1. This demonstrates the plugin in use on my own site's sidebar - the second of the three sections has been revealed, whereas the other two are still hidden. Note the use of the icon to show its status.

== Changelog ==

[Learn more about my version numbering methodology](https://artiss.blog/2016/09/wordpress-plugin-versioning/ "WordPress Plugin Versioning") 

= 2.3.3 =
* Bug: Restored the script I accidentally removed from 2.3.2

= 2.3.2 =
* Maintenance: Updated the README to reflect changes in the plugin repository
* Maintenance: Minimum required version of WordPress is now 4.6, which means various bits of code could be removed, including the languages folder
* Maintenance: I now load shortcodes in all instances, even when in admin, because it makes no difference to performance to do otherwise
* Maintenance: All links to my site have been updated

= 2.3.1 =
* Maintenance: Updated branding, inc. adding donation links

= 2.3 =
* Enhancement: Suppressed Jetpack's Photon from trying to handle the images from this plugin
* Enhancement: Added a new user image folder option
* Enhancement: You can now specify from the options screen whether you want content to default to being hidden or shown
* Maintenance: Updated branding - we're now Coded Art!
* Maintenance: Added a domain path
* Maintenance: Removed function calls. Did anybody ever use these?
* Maintenance: Reduced the number of included files by concatenating the existing ones
* Maintenance: Updated the various path functions to reduce hard coding and to drop deprecated functions
* Maintenance: Brought the options screen up to WordPress standard
* Maintenance: Added validation to the options screen

= 2.2.1 =
* Maintenance: Correct ENQUEUE of script so that it works with SSL sites
* Maintenance: Admin screen headings compatible with WP 4.3
* Maintenance: Added text domain to plugin meta and corrected text domain name across the plugin

= 2.2 =
* Bug: Editor button now works again!
* Maintenance: Corrected support forum link
* Maintenance: Removed sub-menu and moved options to Settings menu
* Maintenance: Corrected plugin meta links because of above changes
* Maintenance: Removed feature pointer
* Maintenance: Removed deprecated functions

= 2.1.1 =
* Bug: Fixed incorrect include

= 2.1 =
* Enhancement: Will now work in Administration screens, allowing other plugins to access it
* Enhancement: Now appears in Administration as own main menu option, rather than under "settings". Both options and support sub-pages exist
* Enhancement: If you have the [Plugin README Parser plugin](http://wordpress.org/extend/plugins/wp-readme-parser/ "Plugin README Parser") installed then a new sub-menu will display the README instructions
* Enhancement: Brought menu and help screen code up-to-date including adding feature pointer
* Enhancement: Now supports Do Not Track. If a browser has this switched on you can force the plugin to not use cookies
* Enhancement: Added shortcode to output cookie storage length
* Enhancement: Nested shortcode now allowed so a shortcode can be used with the Content Reveal shortcode
* Enhancement: Complete re-write of cookie functionality to combine all saved information into one cookie per saved section (it was previously four!). However, I've not added backwards compatibility to keep code size to a minimum and to reduce the risk of the extra code causing issues.
* Enhancement: Converted spaces to underscores in IDs
* Enhancement: Improved the JavaScript code compression
* Enhancement: Added internationalization
* Bug: Fix JavaScript error when image tag not used
* Bug: Fix issue where initial state of title, if alternative titles are being used, was not being set
* Maintenance: Add suffix to files and improve code quality (including resolution of any known debug errors)

= 2.0.4 =
* Maintenance: Removed the dashboard widget

= 2.0.3 =
* Maintenance: Removed the sponsorship

= 2.0.2 =
* Enhancement: Made a number of small improvements to the JavaScript
* Enhancement: Updated dashboard widget & added sponsorship to options page
* Enhancement: Improved editor button icon
* Bug: Fixed parameter passing bug in function call
* Bug: Corrected URL in HTML comment
* Bug: Fixed incorrect function name call in JavaScript

= 2.0.1 =
* Bug: Fixed a bug in the JavaScript that meant that not all cookie data was saved in some circumstances

= 2.0 =
* Enhancement: Modified default icons - now black & white to suit more sites
* Enhancement: Added button to editor which can be toggled in new option screen
* Enhancement: JavaScript cookies will now store the state of each section - again, can be switched via option screen
* Enhancement: Added parameters and URL to allow overriding of cookie option
* Enhancement: User can now specify the title separately, allowing option to hide/reveal to be placed elsewhere
* Enhancement: Improved shortcode method
* Enhancement: New URL parameter which allows all sections to be shown/hidden en-masse. Can also switch off plugin operation using the same
* Enhancement: If user doesn't specify an ID one will be generated for them
* Maintenance: Renamed from Simple Content Reveal to Artiss Content Reveal
* Maintenance: Brought all code up to current standards and checked via WP_DEBUG

= 1.2.1 =
* Enhancement: Improved number of CLASS' used to assist with CSS styling
* Bug: Fixed bug where users own image folder was not working
* Bug: Fixed version number reporting

= 1.2 =
* Bug: Fixed critical bug that prevented image from  working with Internet Explorer

= 1.1 =
* Enhancement: Now using `wp_enqueue_script` to handle script in header

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.3.2 =
* Important fix to 2.3.1. Sorry.